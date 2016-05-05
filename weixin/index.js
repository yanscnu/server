$(document).ready(function(){
	$('.unit a').click(function(){
		var url = "<?php echo __ROOT__;?>";
		var art_class_id = $(this).attr("art_class_id");
		$.ajax({
			type:"post",
			url: url + "home/Control/BehaviorControl.php?action=course_access",
			data: {'art_class_id':art_class_id},
			dataType: "json",
			success:function(){
			}
		});
		return true;
	});
});
