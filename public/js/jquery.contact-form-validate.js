$(document).ready(function() {

	/*$.validator.setDefaults({
		submitHandler: function() { 
			$.ajax({
				type:'POST', 
				url: 'php/secure-email.php', 
				data:$('#contactForm').serialize(), 
				success: function(response) {
					$('#form-submit').show();
				},
				complete:function() {
					$('#contactForm').each(function() {
						this.reset();
					});
				}
			});
		}
	});*/
						
	// validate the comment form when it is submitted
	$("#contactForm").validate({
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
			comment: "required",
			captcha: "required"
		},
		messages: {
			fullname: "You forgot to enter your name",
			email: {
				required: "We need your email address to contact you",
				email: "Your email address must be in the format of name@example.com"
			},
			web: "Your website address must be in the format of http://www .example.com",
			comment: "We need to know what your enquiry is about",
			captcha: "Please enter the security image text"
		},
		errorPlacement: function (error, element) {
			error.insertBefore(element);   
		},
		highlight: function(element, errorClass) {
			$(element).removeClass(errorClass);
		}
	});
	
	$('#my-email').html(function() {
		var e = "david";
		var a = "@";
		var d = "operationbraveheart";
		var c = ".org.uk";
		var h = 'mailto:' + e + a + d + c;
		$(this).parent('a').attr('href', h);
		return e + a + d + c;
	});
});