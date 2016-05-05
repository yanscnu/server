$(document).ready(function(){
	
	$(".loginbox").animate({opacity:'0.79'},"slow");
	$("button").mousemove(function(){
	    $("button").animate({});
	});
	//此处改成$('button[type=submit]').submit会造成死循环
	$('button[type=submit]').click(function(){
	    var username = $('input[name=username]').val();
	    var password = $('input[name=password]').val();
        if(username==""){
            alert("账户名为空!");
            return false;
        }
        else if(password==""){
            alert("密码为空！");
            return false;
        }
        var encode_pass = hex_md5(password);
        $('input[name=password]').val(encode_pass);
        $('#loginForm').submit();
	});
});