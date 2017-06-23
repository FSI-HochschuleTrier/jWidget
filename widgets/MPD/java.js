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
		let data = "";
		let canvas = null;
		let ctx = null;


		setInterval(upDate, 500);

		function upDate()
		{
			if(canvas === null){
			canvas = document.getElementById("can");
			ctx = canvas.getContext("2d");
			}


			$.get('/widgets/MPD/functionsWrapper.php', {'action': 'getStatus'}, (resolveddata) =>
			{
				data = $.parseJSON(resolveddata);
				let infosArtistAndTitle = data.title + "&emsp; &mdash; &emsp;" + data.artist + data.album;
				let infosAlbum = data.album;

				$('#MPDMusicText').html(infosArtistAndTitle);
				$('#AlbumText').html(infosAlbum);



				if(ctx !== null)
				{
					let playtime = parseInt(data.time);
					let duration = parseInt(data.duration);

					let player = (playtime / duration) * 1000;

					ctx.clearRect(0,0, canvas.width, canvas.height);
					ctx.fillStyle = 'orange';
					ctx.fillRect(0,0, player, 5000)
				}

			}).then(() =>
			{
				$.getJSON('https://itunes.apple.com/search?term=' + data.artist + '+' + data.album + "&limit=1", (albumArtworkData) =>
				{
					if (albumArtworkData.results[0] && albumArtworkData.results[0].artworkUrl100)
					{

						let imageUrl = (albumArtworkData.results[0].artworkUrl100);
						imageUrl = imageUrl.replace('100x100', '600x600');
						$('#albumArtwork').css('background-image', 'url(' + imageUrl + ')');
					}
					else
					{
						$('#albumArtwork').css('background-image', 'url(/widgets/MPD/defaultAlbumArtwork.jpg)');
					}

				});
			});
		}
	});

}();