/**
 *  * Created by PhpStorm.
 * User: Philipp Dippel Inf | DMS - M
 * For Project: jWidget
 * Date: 15.06.17
 * Copyright: Philipp Dippel
 */

!function MPD()
{

	$(document).ready(function ()
	{
		let data   = "";
		let canvas = null;
		let ctx    = null;

		let artist    = null;
		let album     = null;
		let title     = null;
		let filetitle = null;

		let infosArtistAndTitle = null;
		let infosAlbum          = null;

		clearInterval(window.mpdtimer);
		window.mpdtimer =  setInterval(upDate, 500);

		function upDate()
		{
			if (canvas === null)
			{
				canvas = document.getElementById("can");
				ctx    = canvas.getContext("2d");
			}

			$.get('widgets/MPD/getInfos.php', (resolvedData) =>
			{
				data = JSON.parse(resolvedData);

				artist = data.artist ? data.artist : 'Unbekannter Artist';

				album = data.album ? data.album : 'Unbekanntes Album';

				if (data.file)
				{
					title = data.title ? data.title : data.file.substring(data.file.lastIndexOf('/') + 1, data.file.search(('/?i:wav|mp3|avi|mp4|ogg|avm/')));
				}
				else
				{
					title = 'Kein Titel'
				}

				if (artist !== 'Unbekannter Artist')
				{
					$('#MPDMusicText').html(title + "&emsp; &mdash; &emsp;" + artist);
				}
				else
				{
					$('#MPDMusicText').html(title);
				}

				$('#AlbumText').html(album);

				if (ctx !== null && data.state === 'play')
				{
					let playtime = parseInt(data.time.substring(0, data.time.indexOf(':')));
					let duration = parseInt(data.time.substring(data.time.indexOf(':') + 1, data.time.length));
					let player   = (playtime / duration) * 1000;

					ctx.clearRect(0, 0, canvas.width, canvas.height);
					ctx.fillStyle = 'orange';
					ctx.fillRect(0, 0, player, 5000)
				}

			}).then(() =>
			{
				$.getJSON('https://itunes.apple.com/search?term=' + artist + '+' + album + "&limit=1", (albumArtworkData) =>
				{
					if (albumArtworkData.results[0] && albumArtworkData.results[0].artworkUrl100 && album !== 'Unbekanntes Album')
					{
						let imageUrl = (albumArtworkData.results[0].artworkUrl100);
						imageUrl     = imageUrl.replace('100x100', '600x600');
						$('#albumArtwork').css('background-image', 'url(' + imageUrl + ')');
					}
					else
					{
						$('#albumArtwork').css('background-image', 'url(widgets/MPD/defaultAlbumArtwork.jpg)');
					}

				});

			});
		}
	});

}();