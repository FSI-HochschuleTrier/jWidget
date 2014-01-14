/**
* xkcd Widget
*
* @author Christopher Kaster(INF)
*/

margin_left = 0;
margin_top = 0;

panel_width = 0;
panel_height = 0;

function setup() {
	panel_width = $("#xkcd").width();
	panel_height = $("#xkcd").height();

	$("#xkcd-image").attr("src", "http://imgs.xkcd.com/comics/inexplicable.png");
	
	setInterval(scroll_comic, 100);
}

function scroll_comic() {
	var image_width = $("#xkcd-image").width();
	var image_height = $("#xkcd-image").height();
	
	if(image_width + margin_left <= panel_width) {
		margin_left = 0;
		margin_top -= 25;
		
		console.log(image_height + margin_top <= panel_height);
		if(image_height + margin_top <= panel_height) {
			margin_top = 0;
		}
	} else {
		margin_left -= 1;
	}

	$("#xkcd-image").css({
		"margin-top": margin_top,
		"margin-left": margin_left
	});
}