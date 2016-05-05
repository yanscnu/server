$(document).ready(function(){
//	setInterval(function(){
//		if(rb_id == null){
//			$.ajax({
//				url: "http://localhost/weixin/home/Control/BehaviorControl.php?action=readtime",
//				type: "post",
//				dataType: "json",
//				data: {'begin_time':begin, 'art_id':art_id},
//				success:function(data){
//					rb_id = data.rb_id;
//				}
//			});	
//		}else{
//			$.ajax({
//				url: "http://localhost/weixin/home/Control/BehaviorControl.php?action=readtime",
//				type: "post",
//				dataType: "json",
//				data: {'begin_time':begin, 'rb_id':rb_id},
//				success:function(data){
//				}
//			});	
//		}
//	} , 1000*60*5);
	
	
//	window.onunload = onunload_handler;
//	function onunload_handler(){ 
//		var end = (Date.parse(new Date()))/1000;
//		var read_time = end-begin;
//		$.ajax({
//			url: "http://localhost/weixin/home/Control/BehaviorControl.php?action=readtime",
//			type: "post",
//			dataType: "json",
//			data: {'begin_time':begin, 'read_time':read_time, 'art_id':art_id},
//			success:function(data){
//			}
//		});	
//	}
	
    var begin = (Date.parse(new Date()))/1000;
   
    window.onunload = function (){
        var end = (Date.parse(new Date()))/1000;
        update_online_time();
		read_time(begin, end);
//		if (is_last_art == true) {
//			var warning = "本单元学习已完毕，是否进入单元评价???";
//			if(confirm(warning)){
//				var url = project_root+"home/artend.php?curriculum_id="+curriculum_id;
//				window.location.href = url;
//			} 
//		}
	}
	
});

function read_time(begin, end){
	var read_time = end-begin;
	if (read_time < min_read_time) {
	    return false;
	};
	$.ajax({
	    async:false,
		url: project_root + "home/Control/BehaviorControl.php?action=readtime",
		type: "post",
		dataType: "json",
		data: {'read_time':read_time, 'art_id':art_id, 'curriculum_id':curriculum_id,'unit_id':unit_id},
		success:function(data){
		}
	});	
}
