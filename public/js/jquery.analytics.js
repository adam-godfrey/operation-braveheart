$(document).ready(function() {
	// get the width of the percentage bar
	var parentWidth = Math.round($('#percentbar').width());
	// get the text file showing the active visitors/users
	$.getJSON('http://localhost/app/util/usersontxt.php', function(data) {
		// if the number of total visitors is less than 10
		if(data.online < 10) {
			//prepend the number of a 0 to me e.g. 09
			data.online = "0" + data.online;
		}
		// show the number of online users
		$('#online').html(data.online);
		//set the number of logged in users
		var logged_in_users = data.right;
		// if no one has logged in
		if(logged_in_users === 0) {
			// just show 100% for visitors
			$('#leftbar').css("width", parentWidth + "px").html(data.left + "%");
			$('#rightbar').css("width 0px");
		}
		// if only loggws in users and no visitora
		else if(logged_in_users == data.online) {
			// just show the percentage for the visitors
			$('#leftbar').css("width 0px");
			$('#rightbar').css("width", parentWidth + "px").html(data.left + "%");
			$('#usernames').html(data.users_online);
		}
		// if logged in users is less than 12%
		else if(logged_in_users < 12) {
			// just show the percentage for the visitors
			$('#leftbar').css({"width":(((parentWidth-2)/100)*data.left) + "px", "border-right":"2px solid #FFF"}).html(data.left + "%");
			$('#rightbar').css("width",(((parentWidth-1)/100)*data.right) + "px");
			$('#usernames').html(data.users_online);
		}
		else {
			// otherwise show the percentage for both visitors and logged in users
			$('#leftbar').css({"width":(((parentWidth-2)/100)*data.left) + "px", "border-right":"2px solid #FFF"}).html(data.left + "%");
			$('#rightbar').css("width",(((parentWidth-1)/100)*data.right) + "px").html(data.right + "%");
			$('#usernames').html(data.users_online);
		}
	});
	
	// repeat the same for every 'x' seconds (i.e 10 seconds)
	setInterval(function() {
		// get the text file showing the active visitors/users
		$.getJSON('http://localhost/app/util/usersontxt.php', function(data) {
			// if the number of total visitors is less than 10
			if(data.online < 10) {
				//prepend the number of a 0 to me e.g. 09
				data.online = "0" + data.online;
			}
			// show the number of online users
			$('#online').html(data.online);
			//set the number of logged in users
			var logged_in_users = data.right;
			// if no one has logged in
			if(logged_in_users === 0) {
				// just show 100% for visitors
				$('#leftbar').css("width", parentWidth + "px").html(data.left + "%");
				$('#rightbar').css("width 0px");
			}
			// if only loggws in users and no visitora
			else if(logged_in_users === data.online) {
				// just show the percentage for the visitors
				$('#leftbar').css("width 0px");
				$('#rightbar').css("width", parentWidth + "px").html(data.left + "%");
				$('#usernames').html(data.users_online);
			}
			// if logged in users is less than 12%
			else if(logged_in_users < 12) {
				// just show the percentage for the visitors
				$('#leftbar').css({"width":(((parentWidth-2)/100)*data.left) + "px", "border-right":"2px solid #FFF"}).html(data.left + "%");
				$('#rightbar').css("width",(((parentWidth-1)/100)*data.right) + "px");
				$('#usernames').html(data.users_online);
			}
			else {
				// otherwise show the percentage for both visitors and logged in users
				$('#leftbar').css({"width":(((parentWidth-2)/100)*data.left) + "px", "border-right":"2px solid #FFF"}).html(data.left + "%");
				$('#rightbar').css("width",(((parentWidth-1)/100)*data.right) + "px").html(data.right + "%");
				$('#usernames').html(data.users_online);
			}
		});
	}, 10000);//time in milliseconds
});