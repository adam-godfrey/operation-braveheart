$(document).ready(function() {
	
	$.validator.setDefaults({
		highlight: function(element) {
			$(element).closest('.form-group').addClass('has-error');
		},
		unhighlight: function(element) {
			$(element).closest('.form-group').removeClass('has-error');
		},
		errorElement: 'span',
		errorClass: 'help-block',
		errorPlacement: function(error, element) {
			if(element.parent('.input-group').length) {
				error.insertAfter(element.parent());
			} else {
				error.insertAfter(element);
			}
		}
	});
	
	// validate the comment form when it is submitted
	$("#registerForm").validate({
		errorClass: "authError",
		errorElement: "div",
		rules: {
			first_name: "required",
			last_name: "required",
			email: {
				required: true,
				email: true,
				remote: "/app/util/EmailCheck.php"
			},
			confemail: {
				equalTo: "#email",
				email: true
			},
			username: {
				required: true,
				minlength: 4,
				maxlength: 30,
				remote: "/app/util/UsernameCheck.php"
			},
			passwordInput: {
				required: true,
				minlength: 6
			},
			confirmPasswordInput: {
				minlength: 6,
				equalTo: "#passwordInput"
			},
			termscheck: "required",
			captchaimg: "required"
		},
		messages: {
			first_name: "You forgot to enter your forename",
			last_name: "You forgot to enter your surname",
			email: {
				required: "We need your email address to send you the activation email",
				email: "Your email address must be in the format of name@example.com",
				remote: "Email address already registerd!"
			},
			confemail: "Your email address needs to match",
			username: {
				required: "You need a username to log in",
				remote: "Username already in use! Please choose another."
			},
			passwordInput: "You need a password to log in",
			confirmPasswordInput: "Your passwords need to match",
			termscheck: "You need to accept the Terms & Condtions",
			captchaimg: "You need to enter the security text to prove you are a human"
		}
	});
});