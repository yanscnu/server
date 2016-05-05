<?php
	require_once('./Control/MemberControl.php');
	if(isLogin() == false){
		toLoginPage();
	}
	header('Content-Type:text/html;charset=utf-8');	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>微学习分析调查问卷</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<link rel="stylesheet" type="text/css" href="./css/basic.css" />
<link rel="stylesheet" type="text/css" href="./css/questionnaire.css" />
<script src="../include/js/jquery-1.5.2.min.js"></script>
<script src="./js/common.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="UTF-8">
    function gd() {  
        var value = document.getElementById("otherradio").checked;  
        if (!value) {  
            document.getElementById("otherdegree").disabled = true;  
        } else {  
            document.getElementById("otherdegree").disabled = false;  
        }  
    }
    $(function() {
		$(".select span").click(function(){
			$(this).find('input').attr('checked','true');
			gd();
		});
	});
</script>
</head>


<body>
<div class="question_content">
    <form action="Control/MemberControl.php?action=questionnaire" method="post">
    <ul>
        <li>
            <p class="title">
                <span>1</span>你的性别是？
            </p>
            <p class="select">
                <span><input type="radio" name="sex" value="f" />女</span>
                <span><input type="radio" name="sex" value="m" />男</span>
            </p>   
        </li>
        <hr/>
        <li>
            <p class="title">
                <span>2</span>你的学历是？
            </p>
            <p class="select">
                <span><input type="radio" name="degree"  onclick="gd()" value="highschool" />高中</span>
                <span><input type="radio" name="degree"  onclick="gd()" value="university" />大学</span>
            </p>
            <p class="select">
                <span>
                    <input type="radio" name="degree" id="otherradio" value="other" onclick="gd()" />&nbsp;&nbsp;
                                                            其它&nbsp;<input type="text" name="otherdegree" id="otherdegree" disabled="true" />
                </span>
            </p>
        </li>
        <hr/>
        <li>
            <p class="title">
                <span>3</span>你的年龄是？
            </p>
            <p class="select">
                <span><input type="text" name="age" /></span>
            </p>
        </li>
        <hr/>
        <li>
            <p class="title">
                <span>4</span>当你在平台学习时，你喜欢怎样的学习形式？
            </p>
            <p class="select"><span><input type="radio" name="q4" value="A" />喜欢有质量的学习，注重思考</span></p>
            <p class="select"><span><input type="radio" name="q4" value="B" /> 喜欢有目的的学习，讲究效率</span></p>
            <p class="select"><span><input type="radio" name="q4" value="C" /> 喜欢随心所欲的学习，追随心情</span></p>
        </li>
        <hr/>
        <li>
            <p class="title">
                <span>5</span>你希望通过平台的提问与评价得到什么？
            </p>
            <p class="select"><span><input type="radio" name="q5" value="A" />希望得到及时的帮助和指导</span></p>
            <p class="select"><span><input type="radio" name="q5" value="B" /> 希望从他人的评价中体验到成功的喜悦</span></p>
        </li>
        <hr/>
        <li>
            <p class="title">
                <span>6</span>当你完成练习后，发现自己的答案与参考答案有偏差，你会质疑参考答案吗？
            </p>
            <p class="select"><span><input type="radio" name="q6" value="A" />会</span></p>
            <p class="select"><span><input type="radio" name="q6" value="B" />不会</span></p>
        </li>
        <hr/>
        <li>
            <p class="title">
                <span>7</span>当你在学习中遇到困难的时候，你会？
            </p>
            <p class="select"><span><input type="radio" name="q7" value="A" />主动搜索信息辅助学习</span></p>
            <p class="select"><span><input type="radio" name="q7" value="B" />遇到难点内容就放弃学习</span></p>
        </li>
        <hr/>
    </ul>
    <div class="submit">
	   <input class="submitbtn" type="submit" value="提交" />
	</div>
    </form>
</div>
</body>
</html>
