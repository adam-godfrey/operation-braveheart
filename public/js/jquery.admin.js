function nl2br (str, is_xhtml) {
	var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
	return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
}

$(document).ready(function() {
	// used for clearing cache
	$("input[name=clear_cache]").change(function() {
		var test = $(this).val();
		$(".desc").hide();
		$("#"+test).show();
	});
	
	$('input[name="is_clothing"]').bind('change',function(){
		var showOrHide = ($(this).val() == 1) ? true : false;
		$('#choices').slideToggle(showOrHide);
	});
	
	$('[data-toggle="popover"]').popover({trigger: 'hover', 'placement': 'right', 'container':'body'});
	
	$(document).on('change', '.btn-file :file', function() {
		var input = $(this),
			numFiles = input.get(0).files ? input.get(0).files.length : 1,
			label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
		input.trigger('fileselect', [numFiles, label]);
	});

	$('.btn-file :file').on('fileselect', function(event, numFiles, label) {
        
        var input = $(this).parents('.input-group').find(':text'),
            log = numFiles > 1 ? numFiles + ' files selected' : label;
        
        if( input.length ) {
            input.val(log);
			$('#imgname').val(log);
        } else {
            if( log ) alert(log);
        }
    });
		
	$('#checkAll').on('click', function () {
		$(this).closest('table').find(':checkbox').prop('checked', this.checked);
	});

	//elements
	var progressbar 	= $('#progressbar');
	var statustxt 		= $('#statustxt');
	var submitbutton 	= $("#SubmitButton");
	var myform 			= $("#uploadform");
	var output 			= $("#output");
	var completed 		= '0% Complete';

	$("#uploadform").ajaxForm({
		beforeSend: function() { //brfore sending form
			submitbutton.attr('disabled', ''); // disable upload button
			output.empty();
			statustxt.empty();
			progressbar.width(completed); //initial value 0% of progressbar
			statustxt.html(completed); //set status text
			statustxt.css('color','#000'); //initial color of status text
		},
		uploadProgress: function(event, position, total, percentComplete) { //on progress
			progressbar.width(percentComplete + '%'); //update progressbar percent complete
			statustxt.html(percentComplete + '% Complete'); //update status text
		},
		complete: function(response) { // on complete
			$("#imagename").val($("#filepc").val());
			$("#uploadform").resetForm();  // reset form
			submitbutton.removeAttr('disabled'); //enable submit button
			output.html(response.responseText); //update element with received data
		}
	});
	
	$('#back-button').click(function() {
		$('#action').val('back');
        $('#adminForm').submit();
    });
	
    $('#save-button').click(function() {
		$('#action').val('save');
        $('#adminForm').submit(); 
    });
	
	$('#add-button').click(function() {
		$('#action').val('add');
        $('#adminForm').submit(); 
    });
	
	$('#preview-button').click(function() {
		$('#preview-heading').html($('#field_title').val());
		$('#preview-content').html(nl2br($('#field_content').val()));
        $('#myModal').modal('show'); 
    });
	
	 $('#thumbsup-button').click(function() {
		$('#action').val('publish');
        $('#adminForm').submit(); 
    });
	
	$('#thumbsdown-button').click(function() {
		$('#action').val('delete');
        $('#adminForm').submit(); 
    });
	
	$('#edit-button').click(function() {
	
		var total = $("input:checkbox:checked").length;
	
		if(total > 1) {
			alert("You can only edit one record at a time");
		}
		else if(total === 0) {
			bootbox.alert("You didn't select a record");
		}
		else {
			$('#action').val('edit');
			$('#adminForm').submit(); 
		}
    });
	
    $('#delete-button').click(function() {
		
		var total = $("input:checkbox:checked").length;

		if(total === 0) {
			bootbox.alert("You didn't select a record");
		}
		else {
			bootbox.confirm("Are you sure?", function(result) {
				if(result) {
					//put eh confirm dialogue here
					$('#action').val('delete');
					$('#adminForm').submit();
				}
			});
		}
    });
	
	$('#archive-button').click(function() {
	
		var total = $("input:checkbox:checked").length;
	
		if(total === 0) {
			bootbox.alert("You didn't select a record");
		}
		else {
			$('#action').val('archive');
			$('#adminForm').submit(); 
		}
	});

	
	//custom validation rule - alphanumerics and punctuation only
	$.validator.addMethod("alphnumpunc", 
		function(value, element) {
			return /[a-zA-Z0-9 -?!,.]*/.test(value);
		}, 
		"Alphas, Numerics and Punctuation characters only."
	);
	
	//custom validation rule - alphanumerics and punctuation only
	$.validator.addMethod("keywords", 
		function(value, element) {
			return /[a-zA-Z -,]*/.test(value);
		}, 
		"Alpha characters, Spaces, Dashes and Commas only."
	);
	
	// validate the comment form when it is submitted
	$("#adminForm").validate({
		errorClass: "authError",
		errorElement: "div",
		rules: {
			content_title: {
				required: true,
				alphnumpunc: true
			},
			content: {
				required: true,
				alphnumpunc: true
			},
			keywords: {
				required: false,
				keywords: true
			}
		},
		messages: {
			content_title: {
				required: "You forgot to enter the title for the content",
			},
			content: {
				required: "You forgot to enter the content",
			}
		},
		errorPlacement: function (error, element) {
			error.insertBefore(element);   
		},
		highlight: function(element, errorClass) {
			$(element).removeClass(errorClass);
		}
	});
});
	