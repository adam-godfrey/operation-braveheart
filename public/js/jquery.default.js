$(document).ready(function() {
	var selected_dates = [];
	// gets all the events from the database using AJAX
	selected_dates = getSelectedDates();
	
	$('#datepicker').datepicker({
		inline: true,
		dateFormat: 'dd-mm-yy',
		showOtherMonths: true,
		dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
		beforeShowDay: function (date)
		{
			// gets the current month, day and year
			// Attention: the month counting starts from 0 that's why you'll need to +1 to get the month right
			var mm = date.getMonth() + 1,
				dd = date.getDate(),
				yy = date.getFullYear();
			var dt = yy + "-" + mm + "-" + dd;

			if(typeof selected_dates[dt] != 'undefined')
			{
				// puts a special class to the dates in which you have events, so that you could distinguish it from the other ones
				// the "true" parameter is used to know which are the clickable dates
				return [true, " my_class"];
			}
			return [false, ""];
		},
		onSelect: function(date)
		{
			$(this).change();
		}
	})
	.change(function() {
		window.location.href = "http://localhost/app/events/date/" + this.value;
	});	
	
	$("#refresh").click(function() {
		$("#captcha").attr("src","http://localhost/app/util/visual-captcha.php?" + Math.random()); 
	});
		
	$('#loginform').submit(function(e)
	{
		var thisForm = $('#loginform');
		//Prevent the default form action
		e.preventDefault();
		
		//Post the form to the send script
		$.ajax({
			type: 'POST',
			url: thisForm.attr("action"),
			data: thisForm.serialize(),
			//Wait for a successful response
			success: function(data){
				//Hide the "loading" message
				$("#loginloading").fadeOut(function(){
					//Display the "success" message
					$("#loginsuccess").html(data).fadeIn();
				});
			},
			complete:function() {
				$('#addresform').each(function() {
					this.reset();
				});
			}
		});
	});

	$('#addressForm').validate({
		errorClass: "authError",
		errorElement: "div",
		rules: {
			signupname: "required",
			signupemail: {
				required: true,
				email: true
			}
		},
		messages: {
			signupname: "Please enter your name",
			signupemail: {
				required: "We need your email address to send the newsletter",
				email: "Your email address must be in the format of name@example.com"
			}
		},
		errorPlacement: function (error, element) {
			error.insertBefore(element);   
		},
		highlight: function(element, errorClass) {
			$(element).removeClass(errorClass);
		},
		submitHandler: function(form) {
			var thisForm = $('#addressForm');
		
			$("#signupsuccess").html("Signing you up...").fadeIn("slow");
			
			//Post the form to the send script
			$.ajax({
				type: 'POST',
				url: 'http://localhost/util/NewsletterSignup.php',
				data: thisForm.serialize(),
				//Wait for a successful response
				success: function(data) {
					//Hide the "loading" message
					$("#signupsuccess").fadeOut("slow", function() {
						//Display the "success" message
						$("#signupsuccess").html(data).fadeIn("slow");
					});
				},
				complete:function() {
					thisForm.each(function() {
						this.reset();
					});
				},
				error: function(xhr, textStatus, errorThrown) {
				   alert('request failed');
				}
			});
		}
	});

	$("#signupname").bind('focusin', function(e) {

		$(this).data('content', $(this).val()).val('');
	 })
	.bind('focusout', function(e) {

		if ( $(this).val() === '' ) {
			
			 $(this).val( $(this).data('content') );
		}
	 });

	$("#signupemail").bind('focusin', function(e) {

		$(this).data('content', $(this).val()).val('');
	 })
	.bind('focusout', function(e) {

		if ( $(this).val() === '' ){
		
			 $(this).val( $(this).data('content') );
		}
	 });
	 
	 $("#loginUsername").bind('focusin', function(e) {

		$(this).data('content', $(this).val()).val('');
	 })
	.bind('focusout', function(e) {

		if ( $(this).val() === '' ) {
			
			 $(this).val( $(this).data('content') );
		}
	 });

	$("#loginPassword").bind('focusin', function(e) {

		$(this).data('content', $(this).val()).val('');
	 })
	.bind('focusout', function(e) {

		if ( $(this).val() === '' ){
		
			 $(this).val( $(this).data('content') );
		}
	 });

	$(".text-input").focus(function(){
		$('#form_result').hide();
	});

	$('#form_result').hide();
	$('#sending').hide();
	
	$('#refresh').click(function() {
		$("#captchaimg").attr("src","/app/util/visual-captcha.php?" + Math.random());
	});
	
	$('#social-nav a').stop().animate({'marginLeft':'-60px'},1000);

	$('#social-nav > li').hover(
		function () {
			$('a',$(this)).stop().animate({'marginLeft':'-2px'},200);
		},
		function () {
			$('a',$(this)).stop().animate({'marginLeft':'-60px'},200);
		}
	);
});

function getSelectedDates() {
	var the_selected_dates = [];
	$.ajax(
	{
		url: 'http://localhost/app/util/events.php',
		dataType: 'json',
		async: false,
		success: function(data)
		{
			$.each(data, function(n, val)
			{
				the_selected_dates[val.eventdate] = val;
			});
		}
	});
	return the_selected_dates;
}

function forumFlag(ids) {

	var id = ids.substr(7);
 
	$.ajax({	
		type :'POST',
		url: 'http://localhost/mvc/util/report.php',
		data : 'messageid='+id,
		success : function() {
			$('p#reported_'+id).text('Post reported to moderator').show();
			$('a#report_'+id).hide();
		},
		error: function(){
			alert("Something went wrong. Please try again");
		}
	});
}