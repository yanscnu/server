<?php 
    require_once ('./Control/MemberControl.php');
    if (isLogin() == false) {
        toLoginPage();
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>信息显示</title>
    <link rel="stylesheet" type="text/css" href="<?php echo __ROOT__;?>home/css/message.css"/>
    <style>

    </style>
</head>
<body>
    <div class="header">
        <h2 style="display:none;"><?php echo WEBSITE_NAME;?></h2>
        <img src="img/showmbg.jpg" />
    </div>
    <div class="container">
        <div class="message">
            <p><?php echo urldecode($_GET['message']);?></p>
        </div>
        <div class="operation">
         <ul>
          <li><span>返回上一页</span><a href="javascript:history.go(-1);">返回</a></li>
          <div style="clear:both;"></div>
          <li><span>返回目录</span><a href='../index.php'>返回</a></li>
         </ul>
        </div>
    </div>
    <div class="footer">
        <h4>By Doers</h4>
        <span>更多咨询请关注iLearning</span>
    </div>
</body>
</html>