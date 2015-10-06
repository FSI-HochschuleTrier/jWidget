/**
 * Dies ist die Core-Javascript Datei. Alle notwendigen JavaScripts der Widgets und ihre Stylesheets werden hier geladen.
 * Die Widgets werden hier initialisiert, d.h. wenn ein Widget im Ordner "widgets" hinzugefügt wurde, muss es auch hier
 * bekannt gemacht werden.
 *
 * @autor Michael Ochmann (INF | INF-SMS)
 * @version 2.0
 *
 * (C) 2014, Massive Dynamic - Michael Ochmann
 */
$('document').ready(function () {
	jWidget.init();

	jWidget.registerWidget('Mensa', '#079300', 1, 3, 1, 1, 60);
	jWidget.registerWidget('Homepage', 'rgb(39, 131, 175)', 2, 2, 2, 1, 60);
	//jWidget.registerWidget('Niv', '#000000', 2, 2, 2, 1, 60);
	jWidget.registerWidget('Wetterstation', '#004080', 1, 1, 4, 3, 1);
	jWidget.registerWidget('Bus', '#800080', 1, 2, 4, 1, 5);
	jWidget.registerWidget('xkcd', '#FFFFFF', 2, 1, 2, 3, 6);
	//jWidget.registerWidget('xkcd', '#FFFFFF', 2, 2, 2, 1, 6);
	//jWidget.registerWidget('Console', '#000000', 2, 1, 2, 3, 30);
});

var jWidget = jWidget || {
	margin: 5,
	maxCols: 4,
	maxRows: 3,
	background: '',
	gridster: '',
	refreshTime: 1,
	listOfItems: [],
	jsMaxInt: Math.pow(2, 32) - 2,
	registerWidget: function (name, color, width, height, row, col, refreshTime) {
		widget = new Widget(name, color, width, height, row, col, refreshTime);
		widget.refresh();
	},
	refresh: function () {
		jWidget.listOfItems.forEach(function (widget) {
			if (widget.refreshTime != 0 && jWidget.refreshTime % widget.refreshTime === 0)
				widget.refresh();
			if (jWidget.refreshTime >= jWidget.jsMaxInt)
				jWidget.refreshTime = 0;
			});
		jWidget.refreshTime += 1;
	},
	init: function () {
		jWidget.gridster = $(".gridster ul").gridster({
			widget_margins: [jWidget.margin, jWidget.margin],
			widget_base_dimensions: [$(window).width() / 4 - (jWidget.margin * 2), $(window).height() / 3 - (jWidget.margin * 2)],
			max_cols: jWidget.maxCols,
			max_size_x: jWidget.maxRows
		}).data('gridster');
		setInterval(jWidget.refresh, 60000);
	}
};

var Widget = function (name, color, width, height, row, col, refreshTime) {
	this.name			= name;
	this.color			= color;
	this.width			= width;
	this.height			= height;
	this.row			= row;
	this.col			= col;
	this.DOM			= null;
	this.banner			= null;
	this.refreshTime	= refreshTime;

	$.getScript("widgets/" + this.name + "/java.js");
	$("<link/>", {
		rel: "stylesheet",
		type: "text/css",
		href: "widgets/" + this.name + "/style.css"
	}).appendTo("head");
	jWidget.listOfItems.push(this);

	jWidget.gridster.add_widget(
		"<li id='" + this.name + "' style='background: " + this.color + ";'></li>",
		this.width,
		this.height,
		this.row,
		this.col
	);
	this.DOM = $('#' + this.name);
	this.banner = '#' + this.name + ' > h2.widgetTitle';
};
Widget.prototype.refresh = function () {
	var $this = this;
	this.DOM.load("widgets/" + this.name, function (data) {
		$($this.banner).css({background: $this.color, width: $this.DOM.width() - 40 + 'px'});
	});
};