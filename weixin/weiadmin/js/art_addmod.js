$(document).ready(function(){
	/*
	 * 1. 得到所有的错误信息，循环遍历之。调用一个方法来确定是否显示错误信息！
	 */
	$(".errorClass").each(function() {
		showError($(this));//遍历每个元素，使用每个元素来调用showError方法
	});
	
	/*
	 * 3. 输入框得到焦点隐藏错误信息
	 */
	$(".inputClass").focus(function() {
		var labelId = $(this).attr("id") + "Error";//通过输入框找到对应的label的id
		$("#" + labelId).text("");//把label的内容清空！
		showError($("#" + labelId));//隐藏没有信息的label
	});
	
	/*
	 * 4. 输入框失去焦点进行校验
	 */
	$(".inputClass").blur(function() {
		var id = $(this).attr("id");//获取当前输入框的id
		var funName = "validate" + id.substring(0,1).toUpperCase() + id.substring(1) + "()";//得到对应的校验函数名
		eval(funName);//执行函数调用
	});
	
	/*
	 * 5. 表单提交时进行校验
	 */
	$("#art_form").submit(function() {
		var bool = true;//表示校验通过
		if(!validateTitle()) {
			bool = false;
		}
		if(!validateAuthor()) {
			bool = false;
		}
		if(!validateSort()) {
			bool = false;
		}
		if(!validateArt_class()) {
			bool = false;
		}
//		if(!validateState()) {
//			bool = false;
//		}
//		if(!validateThumbnail()) {
//			bool = false;
//		}
		if(!validateBrief()) {
			bool = false;
		}
		return bool;
	});
});


/*
 * 判断当前元素是否存在内容，如果存在显示，不存在不显示！
 */
function showError(ele) {
	var text = ele.text();//获取元素的内容
	if(!text) {//如果没有内容
		ele.css("display", "none");//隐藏元素
	} else {//如果有内容
		ele.css("display", "");//显示元素
	}
}

/*
 * 校验标题
 */
function validateTitle(){
	var id = "title";
	var value = $("#" + id).val();//获取输入框内容
	/*
	 * 1. 非空校验
	 */
	if(!value) {
		$("#" + id + "Error").text("标题不能为空");
		showError($("#" + id + "Error"));
		return false;
	}
	return true;
}

/*
 * 校验作者
 */
function validateAuthor(){
	var id = "author";
	var value = $("#" + id).val();//获取输入框内容
	/*
	 * 1. 非空校验
	 */
	if(!value) {
		$("#" + id + "Error").text("作者不能为空");
		showError($("#" + id + "Error"));
		return false;
	}
	return true;
}

/*
 * 校验排序
 */
function validateSort(){
	var id = "sort";
	var value = $("#" + id).val();//获取输入框内容
	/*
	 * 1. 非空校验
	 */
	if(!value) {
		$("#" + id + "Error").text("标题不能为空");
		showError($("#" + id + "Error"));
		return false;
	}
	return true;
}

/*
 * 校验类别
 */
function validateArt_class(){
	var id = "art_class";
	var value = $("#" + id).val();//获取输入框内容
	/*
	 * 1. 非空校验
	 */
	if(!value) {
		$("#" + id + "Error").text("标题不能为空");
		showError($("#" + id + "Error"));
		return false;
	}
	return true;
}

/*
 * 校验状态
 */
//function validateState(){
//	var id = "state";
//	var value = $("#" + id).val();//获取输入框内容
//	/*
//	 * 1. 非空校验
//	 */
//	if(!value) {
//		$("#" + id + "Error").text("标题不能为空");
//		showError($("#" + id + "Error"));
//		return false;
//	}
//	return true;
//}

/*
 * 校验缩略图
 */
//function validateThumbnail(){
//	var id = "thumbnail";
//	var value = $("#" + id).val();//获取输入框内容
//	/*
//	 * 1. 非空校验
//	 */
//	if(!value) {
//		$("#" + id + "Error").text("缩略图不能为空");
//		showError($("#" + id + "Error"));
//		return false;
//	}
//	return true;
//}

/*
 * 校验简介
 */
function validateBrief(){
	var id = "brief";
	var value = $("#" + id).val();//获取输入框内容
	/*
	 * 1. 非空校验
	 */
	if(!value) {
		$("#" + id + "Error").text("简介不能为空");
		showError($("#" + id + "Error"));
		return false;
	}
	return true;
}
