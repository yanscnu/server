<?php
    require('../common/init.php');
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<link rel="stylesheet" type="text/css" href="../css/basic.css"/>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>用户列表</title>
	<style type="text/css">
        table .second-tr td{
	       border-bottom: 2px solid #DDDDDD;
            border-right: 2px solid #FFF;
        	background-color: #47CCFB;
        }
        table .second-tr td:last-child{
        	border: none;
        	border-bottom: 2px solid #DDDDDD;
        }
        table .first-tr th{
	       background-color: #47CCFB;
        }
    </style>
    
    <link rel="stylesheet" type="text/css" href="../../include/js/elFinder-2.1.11/jquery-ui-1.11.4/jquery-ui.min.css">
		<script src="../../include/js/elFinder-2.1.11/jquery-1.12.3.js"></script>
		<script src="../../include/js/elFinder-2.1.11/jquery-ui-1.11.4/jquery-ui.min.js"></script>


		<!-- elFinder CSS (REQUIRED) -->
		<link rel="stylesheet" type="text/css" href="../../include/js/elFinder-2.1.11/css/elfinder.min.css">
		<link rel="stylesheet" type="text/css" href="../../include/js/elFinder-2.1.11/css/theme.css">

		<!-- elFinder JS (REQUIRED) -->
		<script src="../../include/js/elFinder-2.1.11/js/elfinder.min.js"></script>

		<!-- GoogleDocs Quicklook plugin for GoogleDrive Volume (OPTIONAL) -->
		<!--<script src="js/extras/quicklook.googledocs.js"></script>-->

		<!-- elFinder translation (OPTIONAL) -->
		<!--<script src="js/i18n/elfinder.ru.js"></script>-->

		<!-- elFinder initialization (REQUIRED) -->
		<script type="text/javascript" charset="utf-8">
			// Documentation for client options:
			// https://github.com/Studio-42/elFinder/wiki/Client-configuration-options
			$(document).ready(function() {
				$('#elfinder').elfinder({
					url : '../../include/js/elFinder-2.1.11/php/connector.minimal.php',  // connector URL (REQUIRED)
					lang: 'zh_CN',                    // language (OPTIONAL)
					height:600
				}).elfinder('instance');
			});
		</script>
    
</head>

<body class="bg">

<?php include ROOT_PATH.'weiadmin/common/content-header.html';?>

<div class="container">
	<div id="elfinder"></div>
</div>
</body>
</html>
