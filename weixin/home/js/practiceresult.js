$(document).ready(function(){
	for(var key in record_content){  
	   if(record_content[key] instanceof Array){
	   		var inputs = $(".practice_content input[name='"+key+"[]']");
	   		var len = inputs.length;
	   		inputs.each(function(){
		   		if(isInArray($(this).val(), record_content[key])){
		   			$(this).attr('checked' , 'true');
		   		}
		   	});
	   		if(answer_result[key] == true){
				inputs.last().parent().append("<p><span style='color:green;'>正确</span></p>");		
			}else if(answer_result[key][0] == false){
				inputs.last().parent().append("<p><span style='color:red;'>错误，正确答案为："+answer_result[key][1]+"</span></p>");		
			}
	   }else{
	   		/**
	   		 * 单选情况
	   		 */
	   		var inputs = $(".practice_content input[name='"+key+"']");
	   		var len = inputs.length;
	   		inputs.each(function(){
	   			if($(this).val() == record_content[key]){
	   				$(this).attr('checked' , 'true');
	   			}
	   		});
	   		if(answer_result[key] == true){
	   			inputs.last().parent().append("<p><span style='color:green;'>正确</span></p>");		
			}else if(answer_result[key][0] == false){
				inputs.last().parent().append("<p><span style='color:red;'>错误，正确答案为："+answer_result[key][1]+"</span></p>");		
			}
	   } 
	}
});
function isInArray(value,arr){
	for(var key in arr){
		if(arr[key] == value){
			return true;
		}
	}
	return false;
} 