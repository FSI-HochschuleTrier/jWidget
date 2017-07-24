/**
 *  * Created by PhpStorm.
 * User: Philipp Dippel Inf | DMS - M
 * For Project: jWidget
 * Date: 23.06.17
 * Copyright: Philipp Dippel
 */
!function Events()
{
	let eventsFSI       = [];
	let eventsKlausuren = [];
	let events          = [];

	let imgArr       = new Array(5);
	let timeArr      = new Array(5);
	let dayArr       = new Array(5);
	let locArr       = new Array(5);
	let titleArr     = new Array(5);
	let containerArr = new Array(5);
	let overlay      = null;
	let indicator    = false;

	$(document).ready(() =>
	{
		clearInterval(window.calendarTimer);
		getEvents();
		window.calendarTimer = setInterval(getEvents, 300000)

	});

	function getEvents()
	{
		$.when(
			$.get('widgets/CloudCalendar/getCalDavKlausur.php', (resolve) =>
			{

				let data = JSON.parse(resolve);
				data.forEach((entry, index) =>
				{
					data[index] = JSON.parse(entry);
				});

				eventsKlausuren = [];

				$.each(data, (index, value) =>
				{

					let location   = value.LOCATION ? value.LOCATION : '';
					let title      = value.SUMMARY ? value.SUMMARY : '';
					let descrition = value.DESCRIPTION ? value.DESCRIPTION : '';
					let eventStart = value['DTSTART;TZID=Europe/Berlin'] ? value['DTSTART;TZID=Europe/Berlin'] : null;
					let date       = null;

					if (eventStart !== null)
					{
						let year    = parseInt(eventStart.substring(0, 4));
						let month   = parseInt(eventStart.substring(4, 6)) - 1;
						let day     = parseInt(eventStart.substring(6, 8));
						let hour    = parseInt(eventStart.substring(9, 11));
						let minutes = parseInt(eventStart.substring(11, 13));

						date = new Date(year, month, day, hour, minutes);
					}

					eventsKlausuren.push({
						'title':       title,
						'location':    location,
						'description': descrition,
						'date':        date,
						'label':       "klausur"
					});

				});
			}),

			$.get('widgets/CloudCalendar/getCalDavFSI.php', (resolve) =>
			{

				let data = JSON.parse(resolve);
				data.forEach((entry, index) =>
				{
					data[index] = JSON.parse(entry);
				});

				eventsFSI = [];

				$.each(data, (index, value) =>
				{

					let location   = value.LOCATION ? value.LOCATION : '';
					let title      = value.SUMMARY ? value.SUMMARY : '';
					let descrition = value.DESCRIPTION ? value.DESCRIPTION : '';
					let eventStart = value['DTSTART;TZID=Europe/Berlin'] ? value['DTSTART;TZID=Europe/Berlin'] : null;
					let date       = null;

					if (eventStart !== null)
					{
						let year    = parseInt(eventStart.substring(0, 4));
						let month   = parseInt(eventStart.substring(4, 6)) - 1;
						let day     = parseInt(eventStart.substring(6, 8));
						let hour    = parseInt(eventStart.substring(9, 11));
						let minutes = parseInt(eventStart.substring(11, 13));

						date = new Date(year, month, day, hour, minutes);
					}

					eventsKlausuren.push({
						'title':       title,
						'location':    location,
						'description': descrition,
						'date':        date,
						'label':       "fsi"
					});

				});

			})
		).then(() =>
		{
			events = eventsKlausuren.concat(eventsFSI);

			events.sort((o1, o2) =>
			{
				return o1.date - o2.date;
			});

			if (indicator === false)
			{
				loadElements();
			}

			updateList();
		});

	}

	function updateList()
	{
		if (events.length === 0)
		{
			overlay.css('visibility', 'visible');
		}
		else
		{
			overlay.css('visibility', 'hidden');

			for (let i = 0; i < 6; i++)
			{
				if (events.length - 1 >= i)
				{
					containerArr[i].css('visibility', 'visible');

					let hours   = String(events[i].date.getHours()).length <= 1 ? '0' + String(events[i].date.getHours()) : String(events[i].date.getHours());
					let minutes = String(events[i].date.getMinutes()).length <= 1 ? '0' + String(events[i].date.getMinutes()) : String(events[i].date.getMinutes());
					let day     = String(events[i].date.getDate()).length <= 1 ? '0' + String(events[i].date.getDate()) : String(events[i].date.getDate());
					let month   = String(events[i].date.getMonth()).length <= 1 ? '0' + String(events[i].date.getMonth() + 1) : String(events[i].date.getMonth());

					imgArr[i].attr('src', events[i].label === "fsi" ? 'widgets/CloudCalendar/fsi.png' : 'widgets/CloudCalendar/logoKlausur.png');
					timeArr[i].text(hours + ":" + minutes + " Uhr");
					dayArr[i].text(day + '.' + month + '.' + events[i].date.getFullYear());
					locArr[i].text('Raum: ' + events[i].location);
					titleArr[i].text(events[i].title);

					if (events[i].label === 'fsi')
					{
						containerArr[i].css('background', '#005196');
					}
					else
					{
						containerArr[i].css('background', '#EB5800');
					}
				}
				else
				{
					containerArr[i].css('visibility', 'hidden');
				}
			}
		}
	}

	function loadElements()
	{
		//Needs to happen once after first AJAX call

		imgArr[0] = $('#img1');
		imgArr[1] = $('#img2');
		imgArr[2] = $('#img3');
		imgArr[3] = $('#img4');
		imgArr[4] = $('#img5');
		imgArr[5] = $('#img6');

		timeArr[0] = $('#t1t');
		timeArr[1] = $('#t2t');
		timeArr[2] = $('#t3t');
		timeArr[3] = $('#t4t');
		timeArr[4] = $('#t5t');
		timeArr[5] = $('#t6t');

		dayArr[0] = $('#t1d');
		dayArr[1] = $('#t2d');
		dayArr[2] = $('#t3d');
		dayArr[3] = $('#t4d');
		dayArr[4] = $('#t5d');
		dayArr[5] = $('#t6d');

		locArr[0] = $('#e1r');
		locArr[1] = $('#e2r');
		locArr[2] = $('#e3r');
		locArr[3] = $('#e4r');
		locArr[4] = $('#e5r');
		locArr[5] = $('#e6r');

		titleArr[0] = $('#e1t');
		titleArr[1] = $('#e2t');
		titleArr[2] = $('#e3t');
		titleArr[3] = $('#e4t');
		titleArr[4] = $('#e5t');
		titleArr[5] = $('#e6t');

		containerArr[0] = $('#firstElement');
		containerArr[1] = $('#secondElement');
		containerArr[2] = $('#thirdElement');
		containerArr[3] = $('#fourthElement');
		containerArr[4] = $('#fifthElement');
		containerArr[5] = $('#sixthElement');

		overlay   = $('#overlay');
		indicator = true;
	}

}();

