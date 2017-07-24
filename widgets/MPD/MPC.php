<?php

namespace massive_dynamic\mpc;

class FileType {
	const ANY = 0;
	const FILE = 1;
	const BASE = 2;
	const MODIFIED = 3;
}

class Sort {
	const ARTIST = 0;
	const ALBUM = 1;
	const BOTH = 2;
}

class MPC {
	private $socket;
	private $host;
	private $port;
	private $refreshInterval;
	private $password;
	private $imageCache = [];
	private $imageHashes = [];

	public function __construct($host = "127.0.0.1", $port = 6600, $refreshInterval = 0, $password = null) {
		$this->host = (string)$host;
		$this->port = (int)$port;
		$this->refreshInterval = (int)$refreshInterval;
		$this->password = $password == null ? null : (string)$password;

		$this->connect();
	}

	private function connect() {
		$errorCode = 0;
		$error = "";
		$response = [];
		$data = "";

		@$this->socket = fsockopen($this->host, $this->port, $errorCode, $error, 5);
		if (!$this->socket)
			throw new \ErrorException("Error $errorCode: $error");

		while (!feof($this->socket)) {
			$data = (string)fgets($this->socket, 1024);

			if (preg_match("/^OK/", $data))
				break;
			array_push($response, $data);
			if (preg_match("/^ACK/", $data))
				break;
		}

		if ($this->password == "" || $response == "")
			return null;

		fputs($this->socket, "password \"$this->password\"\n");

		while (!feof($this->socket)) {
			$data = fgets($this->socket, 1024);
			if (preg_match("/^OK/", $data))
				break;
			array_push($response, $data);
			if (preg_match("/^ACK/", $data))
				throw new \ErrorException("MPD Authentication failed");
		}

		return $response;
	}

	public function disconnect() {
		if ($this->socket !== null)
			fclose($this->socket);
	}

	private static function HashmapToArray($array) {
		$result = [];

		foreach (array_values($array) as $value) {
			if (is_scalar($value))
				array_push($result, $value);
			elseif (is_array($value))
				$result = array_merge($result, self::HashmapToArray($value));
			elseif (is_object($value))
				$result = array_merge($result, self::HashmapToArray((array)$value));
			else
				throw new \Exception("Unrecognized object type");
		}

		return $result;
	}

	public static function ITunesArtwork($album, $artist, $big = false) {
		if ($album == "")
			return "";
		$url = "http://ws.audioscrobbler.com/2.0/?method=album.getinfo&api_key=28f1a74497fe222211fa5012249750dd&artist=".urlencode($artist)."&album=".urlencode($album)."&format=json";
		$data = json_decode(file_get_contents($url));
		if (isset($data->error) || !is_array($data->album->image) || empty($data->album->image))
			return "";

		if (!$big)
			return $data->album->image[1]->{"#text"};
		else
			return $data->album->image[3]->{"#text"};
	}

	public static function SecondsToString($totalSeconds) {
		$hours = floor($totalSeconds / 3600);
		$totalSeconds %= 3600;
		$minutes = floor($totalSeconds / 60);
		$seconds = $totalSeconds % 60;
		$secondsPadding = $seconds < 10 ? '0' : '';

		if ($hours != 0)
			return $hours . ':' . $minutes . ':' . $secondsPadding . '' . $seconds;
		else
			return $minutes . ':' . $secondsPadding . '' . $seconds;
	}

	private static function ArrayToHashMap($array) {
		$response = new \stdClass();
		foreach ($array as $element) {
			$element = explode(": ", $element);
			$response->{strtolower(trim($element[0]))} = trim($element[1]);
		}

		return $response;
	}

	public function send() {
		$response = [];
		$data = "";

		$args = func_get_args();
		$method = array_shift($args);
		$args = self::HashmapToArray($args);

		array_walk($args, function (&$value, $key) {
			$value = str_replace('"', '\"', $value);
			$value = str_replace("'", "\\'", $value);
			$value = '"' . $value . '"';
		});
		$command = trim($method . ' ' . implode(' ', $args));

		fputs($this->socket, "$command\n");

		$return = [];
		while (!feof($this->socket)) {
			$data = fgets($this->socket, 1024);

			if (preg_match("/^OK/", $data))
				break;
			if (preg_match("/^ACK/", $data)) {
				array_push($response, $data);
				break;
			}

			array_push($return, $data);
		}
		$sentResponse = [
			"response" => $response,
			"status" => trim($data),
			"values" => $return,
		];

		return $sentResponse;
	}

	public function status() {
		$status = $this->send("status");

		return self::ArrayToHashMap($status["values"]);
	}

	public function current() {
		$current = $this->send("currentsong");

		return self::ArrayToHashMap($current["values"]);
	}

	public function volume($value = null) {
		if ($value === null)
			return $this->status()->volume;
		else
			$this->send("setvol $value");
	}

	public function stop() {
		$this->send("stop");
	}

	public function playPause() {
		if ($this->status()->state == "play")
			$this->send("pause 1");
		else
			$this->send("pause 0");
	}

	public function next() {
		$this->send("next");
	}

	public function prev() {
		$this->send("previous");
	}

	public function find($type, $keywords, $sort = Sort::ARTIST, $sensitive = false) {
		$response = [];

		switch ($sort) {
			case Sort::ARTIST:
				$sort = "ArtistSort";
				break;
			case Sort::ALBUM:
				$sort = "AlbumSort";
				break;
			case Sort::BOTH:
				$sort = "AlbumArtistSort";
		}


		if ($sensitive)
			$data = $this->send("find \"$type\" \"".str_replace('"', "\\\"", $keywords)."\"");
		else
			$data = $this->send("search \"$type\" \"".str_replace('"', "\\\"", $keywords)."\"");

		foreach ($data["values"] as $song) {
			if (preg_match("/^file/", $song)) {
				if (isset($object))
					array_push($response, $object);
				$object = new \stdClass();
			}
			$pair = explode(": ", $song);
			$object->{strtolower(trim($pair[0]))} = trim($pair[1]);
		}

		if (isset($object))
			array_push($response, $object);

		return $response;
	}

	public function albums() {
		$albums = $this->send("list album group albumartist");
		if (!isset($albums["values"]) || !is_array($albums["values"]))
			return [];
		$result = [];
		$object = null;
		foreach ($albums["values"] as $line) {
			$expr  = explode(": ", $line);
			$isNew = preg_match("/^Album:/", $line);
			if ($object === null || $isNew) {
				$object = new \stdClass();
				$object->album = trim($expr[1]);
			}
			else {
				$object->artist = trim($expr[1]);
				array_push($result, $object);
			}
		}

		return $result;
	}

	public function artists() {
		$artists = $this->send("list \"artist\"");
		if (!is_array($artists["values"]))
			return [];
		$artists = array_map(function($item) {
			return trim(explode(": ", $item)[1]);
		}, $artists["values"]);
		return $artists;
	}

	public function toggleRepeat() {
		$status = $this->status();

		if ($status->repeat == 1)
			$this->send("repeat 0");
		else
			$this->send("repeat 1");
	}

	public function toggleRandom() {
		$status = $this->status();

		if ($status->random == 1)
			$this->send("random 0");
		else
			$this->send("random 1");
	}

	public function scrub($time) {
		$this->send("seekcur $time");
	}

}

