$(document).ready(function(){	
	window.onunload = function(){
        update_online_time();
    }
});

/**
 * 使用到的 project_root变量必须在引用次js文件的页面中进行定义
 * project_root就是项目的根目录
 */
function update_online_time(){
	var login_time = getCookie('login_time');
	var online_time = getCookie('online_time');
	var now = (Date.parse(new Date()))/1000;
	if(login_time!=""){
		if((now-login_time-online_time)>=online_time_cha){
			$.ajax({
			    async:false,
				url: project_root + "home/Control/MemberControl.php?action=update_onlinetime",
				type: "post",
				dataType: "json",
				success:function(data){
				}
			});
		}
	}
}


function getCookie(c_name)
{
	if (document.cookie.length>0)
	{
		c_start = document.cookie.indexOf(c_name + "=");
		if (c_start!=-1)
		{
			c_start=c_start + c_name.length+1 ;
			c_end=document.cookie.indexOf(";",c_start);
			if (c_end==-1) c_end=document.cookie.length;
			return unescape(document.cookie.substring(c_start,c_end));
    	} 
	}
	return "";
}
