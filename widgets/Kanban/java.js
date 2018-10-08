/**
 * Created by Philipp Dippel on 13.06.17.
 */

function evaluateData(dataOpen, dataClosed)
{
	let openIssuesArr = dataOpen;
	let closedIssuesArr = dataClosed;

	//Get all containers
	let listAlle = $('#listAlle');
	let listSprecher = $('#listSprecher');
	let listKasse = $('#listKasse');
	let listAdmin = $('#listAdmin');
	let listWeb = $('#listWeb');
	let listEvents = $('#listEvents');
	let listRaumwart = $('#listRaumwart');
	let listClosed = $('#listClosed');

	//Add all open issues to DOM

	if(openIssuesArr !== null && openIssuesArr !== undefined && Array.isArray(openIssuesArr))
	openIssuesArr.forEach(function (item)
	{
		let title = item.title;
		let labels = null;
		let avatar = "";

		if (item.labels)
		{
			labels = item.labels;
		}
		if (item.assignee)
		{
			if (item.assignee.avatar_url)
			{
				avatar = item.assignee.avatar_url;
			}
		}

		if (labels !== null)
		{
			labels.forEach(function (label)
			{
				switch (label)
				{
					case 'ALLE':
						listAlle.append("<li><div class='leftContainer'><div class='itemTitle'>" + title + "</div></div><div class='avatar' style='background-image: url(" + avatar + ")' </div></div></li>");
						break;

					case 'Sprecher':
						listSprecher.append("<li><div class='leftContainer'><div class='itemTitle'>" + title + "</div></div><div class='avatar' style='background-image: url(" + avatar + ")' </div></div></li>");
						break;

					case 'Kasse':
						listKasse.append("<li><div class='leftContainer'><div class='itemTitle'>" + title + "</div></div><div class='avatar' style='background-image: url(" + avatar + ")' </div></div></li>");
						break;

					case 'Webmaster':
						listWeb.append("<li><div class='leftContainer'><div class='itemTitle'>" + title + "</div></div><div class='avatar' style='background-image: url(" + avatar + ")' </div></div></li>");
						break;

					case 'Admin':
						listAdmin.append("<li><div class='leftContainer'><div class='itemTitle'>" + title + "</div></div><div class='avatar' style='background-image: url(" + avatar + ")' </div></div></li>");
						break;

					case 'Events':
						listEvents.append("<li><div class='leftContainer'><div class='itemTitle'>" + title + "</div></div><div class='avatar' style='background-image: url(" + avatar + ")' </div></div></li>");
						break;

					case 'Raumwart':
						listRaumwart.append("<li><div class='leftContainer'><div class='itemTitle'>" + title + "</div></div><div class='avatar' style='background-image: url(" + avatar + ")' </div></div></li>");
						break;

				}
			});

		}

	});

	//Add all closed issues to DOM
    if(closedIssuesArr !== null && closedIssuesArr !== undefined && Array.isArray(closedIssuesArr) )
	closedIssuesArr.forEach(function (item)
	{
		let title = item.title;
		let avatar = "";

		if (item.assignee)
		{
			if (item.assignee.avatar_url)
			{
				avatar = item.assignee.avatar_url;
			}
		}

		listClosed.append("<li><div class='leftContainer'><div class='itemTitle'>" + title + "</div></div><div class='avatar' style='background-image: url(" + avatar + ")' </div></div></li>");

	});

	/**
	 * Setup for auto Scroll if the content is to big for container
	 * Important: scrollDuration < interValduration
	 */
	let scrollDuration = 20000;
	let intervalDuration = 24000;

	clearInterval(window.scrollKanbanTimer);
	window.scrollKanbanTimer = setInterval(function ()
	{

		if (listAlle.outerHeight() < listAlle.prop('scrollHeight'))
		{
			if (listAlle.scrollTop() === 0)
			{
				listAlle.animate({scrollTop: listAlle.height()}, scrollDuration);
			}
			else if (listAlle.scrollTop() > 0)
			{
				listAlle.animate({scrollTop: 0}, scrollDuration);
			}
		}

		if (listSprecher.outerHeight() < listSprecher.prop('scrollHeight'))
		{
			if (listSprecher.scrollTop() === 0)
			{
				listSprecher.animate({scrollTop: listSprecher.height()}, scrollDuration);
			}
			else if (listSprecher.scrollTop() > 0)
			{
				listSprecher.animate({scrollTop: 0}, scrollDuration);
			}
		}

		if (listEvents.outerHeight() < listEvents.prop('scrollHeight'))
		{
			if (listEvents.scrollTop() === 0)
			{
				listEvents.animate({scrollTop: listEvents.height()}, scrollDuration);
			}
			else if (listEvents.scrollTop() > 0)
			{
				listEvents.animate({scrollTop: 0}, scrollDuration);
			}
		}

		if (listAdmin.outerHeight() < listAdmin.prop('scrollHeight'))
		{
			if (listAdmin.scrollTop() === 0)
			{
				listAdmin.animate({scrollTop: listAdmin.height()}, scrollDuration);
			}
			else if (listAdmin.scrollTop() > 0)
			{
				listAdmin.animate({scrollTop: 0}, scrollDuration);
			}
		}

		if (listKasse.outerHeight() < listKasse.prop('scrollHeight'))
		{
			if (listKasse.scrollTop() === 0)
			{
				listKasse.animate({scrollTop: listKasse.height()}, scrollDuration);
			}
			else if (listKasse.scrollTop() > 0)
			{
				listKasse.animate({scrollTop: 0}, scrollDuration);
			}
		}

		if (listWeb.outerHeight() < listWeb.prop('scrollHeight'))
		{
			if (listWeb.scrollTop() === 0)
			{
				listWeb.animate({scrollTop: listWeb.height()}, scrollDuration);
			}
			else if (listWeb.scrollTop() > 0)
			{
				listWeb.animate({scrollTop: 0}, scrollDuration);
			}
		}

		if (listRaumwart.outerHeight() < listRaumwart.prop('scrollHeight'))
		{
			if (listRaumwart.scrollTop() === 0)
			{
				listRaumwart.animate({scrollTop: listWeb.height()}, scrollDuration);
			}
			else if (listWeb.scrollTop() > 0)
			{
				listRaumwart.animate({scrollTop: 0}, scrollDuration);
			}
		}

		if (listClosed.outerHeight() < listClosed.prop('scrollHeight'))
		{
			if (listClosed.scrollTop() === 0)
			{
				listClosed.animate({scrollTop: listClosed.height()}, scrollDuration);
			}
			else if (listClosed.scrollTop() > 0)
			{
				listClosed.animate({scrollTop: 0}, scrollDuration);
			}
		}

	}, intervalDuration);

}