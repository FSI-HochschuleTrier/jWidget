function AnalogClock(objCanvas){
  // Neues Datumsobjekt
  var objDate = new Date();
  var intSek = objDate.getSeconds();     // Sekunden 0..59
  var intMin = objDate.getMinutes();     // Minuten 0..59
  var intHours = objDate.getHours()%12;  // Stunden 0..11
  // Kontext-Objekt
  var objContext = objCanvas.getContext("2d");

  var objWidth = objCanvas.width;
  var objHeight = objCanvas.height;

 centerX = objWidth / 2;
 centerY = objHeight / 2;

  objContext.clearRect(0, 0, objWidth, objHeight);  // Anzeigebereich leeren
  /*
  //  objContext.drawImage(objImg, 0, 0);    // Ziffernblatt zeichnen
      objContext.beginPath();
      objContext.arc(centerX, centerY, centerY - 7.5 - 10, 0, 2 * Math.PI, false);
      objContext.lineWidth = 15;
      objContext.strokeStyle = '#fff';
      objContext.stroke();
      objContext.closePath();

  objContext.save();                     // Ausgangszustand speichern
  objContext.translate(centerX, centerY);          // Koordinatensystem in Mittelpkt des Ziffernblatts verschieben
  // Stunden
  objContext.save();
  // Aktuelle Stunde zzgl. Minutenanteil über Drehung des Koordinatensystems
  // (kontinuierlicher Übergang zwischen zwei Stunden gewünscht, keine Sprung)
  objContext.rotate(intHours*Math.PI/6+intMin*Math.PI/360);
  objContext.beginPath();                // Neuen Pfad anlegen
  objContext.moveTo(0, 10);              // Zeiger über Mitte hinaus zeichnen
  objContext.lineTo(0, -centerY + 70);             // Stundenzeiger im gedrehten Koord-Sys. um 38 Einheiten nach oben zeichnen
  // Linienstyle festlegen und zeichnen
  objContext.lineWidth = 6;
  objContext.strokeStyle = "#fff";
  objContext.stroke();
  objContext.restore();

  // Minuten
  objContext.save();
  objContext.rotate(intMin*Math.PI/30);
  objContext.beginPath();
  objContext.moveTo(0, 10);
  objContext.lineTo(0, -centerY + 40);
  objContext.lineWidth = 6;
  objContext.strokeStyle = "#fff";
  objContext.stroke();
  objContext.restore();

  // Sekunden
  objContext.save();
  objContext.rotate(intSek*Math.PI/30);
  objContext.beginPath();
  objContext.moveTo(0, 10);
  objContext.lineTo(0, -centerY + 30);
  objContext.lineWidth = 3;
  objContext.strokeStyle = "#a00";
  objContext.stroke();
  objContext.restore();

  objContext.restore();
 */
  intHours = objDate.getHours();
  digitHours = intHours < 10 ? "0" + intHours : intHours;
  digitMin = intMin < 10 ? "0" + intMin : intMin;
  $('.digit').html(digitHours + ":" + digitMin);

  digitMonths = Array('Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember');
  $('.date').html(objDate.getDate() + ". " + digitMonths[objDate.getMonth()] + " " + objDate.getFullYear());

  hTimer = window.setTimeout(function(){ AnalogClock(objCanvas);}, 1000);
}