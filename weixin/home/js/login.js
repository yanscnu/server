$(document).ready(function(){
	$('#subForm').click(function(){
		var password = $('#student_psw').val();
		var encode_pass = hex_md5(password);
		$('#student_psw').val(encode_pass);
		$('#loginForm').submit();
	});
	
	$('.input').focus(function() {
        var p = $(this).parent('div').find('.error');
        p.remove();
    });
});