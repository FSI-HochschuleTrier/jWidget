<?php
/**
* parst Daten vom der SWT Homepage und normalisiert diese.
* @param $stopData
*
* @author MikO (Michael Ochmann)
*/
class parseSWT {
    private $swtResponse;
    private $normResponse;
    private $responseDetails;

  public function __construct($stopData) {
    $this->getDataBYcURL($stopData);
    $this->normalizeResponse();
  }

  private function getDataBYcURL($stopData) {
      $uri = "http://212.18.193.124/onlineinfo/onlineinfo/stopData";
      $body = "5|0|6|http://212.18.193.124/onlineinfo/onlineinfo/|7E201FB9D23B0EA0BDBDC82C554E92FE|com.initka.onlineinfo.".
              "client.services.StopDataService|getDepartureInformationForStop|java.lang.String/2004016611|".$stopData.
              "|1|2|3|4|1|5|6|";
      $connection = curl_init();

    curl_setopt($connection, CURLOPT_URL, $uri);
    curl_setopt($connection, CURLOPT_HTTPHEADER, array(
      "X-GWT-Module-Base: http://212.18.193.124/onlineinfo/onlineinfo/",
      "X-GWT-Permutation: D8AB656D349DD625FC1E4BA18B0A253C",
      "Content-Type: text/x-gwt-rpc; charset=UTF-8"
    ));
    curl_setopt($connection, CURLOPT_POSTFIELDS, $body);
    curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);
      $this->swtResponse = curl_exec($connection);
    curl_close($connection);
  }

  private function normalizeResponse() {
      $normResponse = substr($this->swtResponse, 4);
      $normResponse = json_decode($normResponse);
      $normResponse = array_chunk($normResponse, 11);

      $this->responseDetails = $normResponse[count($normResponse) - 1][2];
    array_unshift($this->responseDetails, "Details");
    array_pop($normResponse);
      $this->normResponse = $normResponse;
  }

  private function extractArrivalTime($busObject) {
      $time = round(($busObject[2] + $busObject[3]) / 1000);
      $time = date("H:i", $time);
    return $time;
  }

  private function extractLiveTime($busObject) {
      $time = round(($busObject[7] + $busObject[8]) / 1000);
      $time = date("H:i", $time);
    return $time;
  }

  private function msort($array, $key, $sort_flags = SORT_REGULAR) {
    if (is_array($array) && count($array) > 0) {
        if (!empty($key)) {
            $mapping = array();
            foreach ($array as $k => $v) {
                $sort_key = '';
                if (!is_array($key)) {
                    $sort_key = $v[$key];
                } else {
                    foreach ($key as $key_key) {
                        $sort_key .= $v[$key_key];
                    }
                    $sort_flags = SORT_STRING;
                }
                $mapping[$k] = $sort_key;
            }
            asort($mapping, $sort_flags);
            $sorted = array();
            foreach ($mapping as $k => $v) {
                $sorted[] = $array[$k];
            }
            return $sorted;
        }
    }
    return $array;
  }

  public function toArray() {
      $arrayOfBusses = Array();
    foreach($this->normResponse as $bus) {
      array_push($arrayOfBusses, Array("route" => $this->responseDetails[$bus[5]],
                                       "destination" => $this->responseDetails[$bus[6]],
                                       "arrival" => $this->extractArrivalTime($bus),
                                       "live" => $this->extractLiveTime($bus)
      ));
    }
    return $this->msort($arrayOfBusses, "live");
  }
}

?>