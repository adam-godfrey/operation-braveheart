$(document).ready(function() {
	// validate the comment form when it is submitted
	$("#replyForm").validate({
		errorClass: "authError",
		errorElement: "div",
		rules: {
			fullname: "required",
			email: {
				required: true,
				email: true
			},
			web: {
				required: false,
				url: true
			},
			message: "required",
			captcha: "required"
		},
		messages: {
			fullname: "You forgot to enter your name",
			email: {
				required: "You forgot to enter your email address",
				email: "Your email address must be in the format of name@example.com"
			},
			web: "Your website address must be in the format of http://www.example.com",
			message: "You forgot to enter your comment",
			captcha: "Please enter the security image text"
		},
		errorPlacement: function (error, element) {
			error.insertBefore(element);   
		},
		highlight: function(element, errorClass) {
			$(element).removeClass(errorClass);
		}
	});
});