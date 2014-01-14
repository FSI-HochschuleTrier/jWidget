    var jWidget = new jWidgets;
/**
* Dies ist die Core-Javascript Datei. Alle notwendigen JavaScripts der Widgets und ihre Stylesheets werden hier geladen.
* Die Widgets werden hier initialisiert, d.h. wenn ein Widget im Ordner "widgets" hinzugefügt wurde, muss es auch hier
* bekannt gemacht werden.
*
* @autor Michael Ochmann (INF | INF-SMS)
*/

/**
* die Optionen für das jWidget Objekt.
*
* Defaultwerte:
*
* margin : 5
* maxCols: 4
* maxRows: 3
*/

    jWidget.margin = 5;
    jWidget.maxCols = 4;
    jWidget.maxRows = 3;

$('document').ready(function() {
  jWidget.init();
  setInterval(refreshWidgets, 5 * 60000);  // 60.000 Millisekunden = 1 Minute
/**
* Hier werden die Widgets registriert
*
* Format:
* jWidget.widgetRegister([Name des Widgets], [gewünschte Hintergrundfarbe], [breite in Spalten], [höhe in Spalten], [Position Spalte X], [Position Spalte Y]);
*/
  jWidget.widgetRegister('Mensa', '#079300', 1, 3, 1, 1);
  jWidget.widgetRegister('Homepage', '#DC5801', 2, 2, 2, 1);
  jWidget.widgetRegister('Wetterstation', '#004080', 1, 1, 4, 3);
  jWidget.widgetRegister('Bus', '#800080', 1, 2, 4, 1);
  //jWidget.widgetRegister('xkcd', '#ffffff', 2, 1, 2, 3);
});









/**
* Die jWidgets Klasse.
*/
function jWidgets() {
  var options =
  {
   margin  : 5,
   maxCols : 4,
   maxRows : 3,
   background: '',
   gridster: '',
   widgetRegister : function(name, color, width, height, row, col) {
     this.gridster.add_widget("<li id='"+name+"' style='background: "+color+";'></li>", width, height,row,col);
     $('#'+name).load("widgets/"+name, function(data) {
       $('#'+name+' > h2.widgetTitle').css({background: color, width: $('#'+name).width() - 40 +'px'});
     });
     $.getScript("widgets/"+name+"/java.js");
     $("<link/>", {
         rel: "stylesheet",
         type: "text/css",
         href: "widgets/"+name+"/style.css"
     }).appendTo("head");
     widgetsSummary.push(name);
   },
   init : function () {
            this.gridster = $(".gridster ul").gridster({
                widget_margins: [this.margin, this.margin],
                widget_base_dimensions: [$(window).width() / 4 - (this.margin*2),$(window).height() / 3 - (this.margin*2)],
                max_cols: this.maxCols,
                max_size_x: this.maxRows,
            }).data('gridster');
          }
  }
  return options;
}


/**
* Funktion zur Aktualisierung der Kacheln
*/
var widgetsSummary = new Array();
function refreshWidgets() {
  for (widgetsCount = 0; widgetsCount < widgetsSummary.length; widgetsCount++) {
    $('#'+widgetsSummary[widgetsCount]).load("widgets/"+widgetsSummary[widgetsCount], function(data) {
       color = $(this).css('background-color');
       $(this).children('h2.widgetTitle').css({background: color, width: $(this).width() - 40 +'px'});
     });
  }
}