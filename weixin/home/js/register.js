$(document).ready(function(){
	$('#subForm').click(function(){
		var password = $('#student_psw').val();
		var encode_pass = hex_md5(password);
		$('#student_psw').val(encode_pass);
		
		var repassword = $('#repassword').val();
		var reencode_pass = hex_md5(repassword);
		$('#repassword').val(reencode_pass);
		
		$('#registerForm').submit();
	});
	
	
	$('.input').focus(function() {
	    var p = $(this).parent('div').find('.error');
	    p.remove();
	});
	
	$('#changeCode').click(function(){
	    var url = $(this).attr('url');
		var src = url +'?time='+Math.random();
		$('#codeImg').attr('src',src);
	});
});