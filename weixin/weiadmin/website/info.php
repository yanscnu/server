<?php
	require ('../common/init.php');
?>
<?php
	
	$config_explain = require(ROOT_PATH.'config/config_explain.php');
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../css/basic.css"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>基本信息</title>
</head>

<body class="bg">
	
	<?php include ROOT_PATH.'weiadmin/common/content-header.html';?>

	<table class="table" cellpadding="0" cellspacing="0">
		<caption><h2>服务器信息</h2></caption>
		<thead>
			<tr>
			    <th>参数</th>
			    <th>值</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>服务器域名</td>
				<td><?php echo $_SERVER['SERVER_NAME']; ?></td>
			</tr>
			<tr>
				<td>服务器操作系统</td>
				<td><?php echo PHP_OS; ?></td>
			</tr>
			<tr>
				<td>服务器解释引擎</td>
				<td><?php echo $_SERVER['SERVER_SOFTWARE']; ?></td>
			</tr>
			<tr>
				<td>PHP版本</td>
				<td><?php echo PHP_VERSION; ?></td>
			</tr>
			<tr>
				<td>数据库</td>
				<td><?php echo 'mysql'.mysql_get_server_info(); ?></td>
			</tr>
			<tr>
				<td>网站根目录</td>
				<td><?php echo $_SERVER['DOCUMENT_ROOT']; ?></td>
			</tr>
		</tbody>
	</table>
	<table class="table" cellpadding="0" cellspacing="0">
		<caption><h2>项目配置信息</h2></caption>
		<thead>
			<tr>
			    <th>参数名</th>
			    <th>说明</th>
			    <th>参数值</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>-----</td>
				<td>站点前台主页</td>
				<td><a target="_blank" href="<?php echo __ROOT__.'index.php'; ?>"><?php echo __ROOT__.'index.php'; ?></a></td>
			</tr>
			<tr>
				<td>-----</td>
				<td>站点后台主页</td>
				<td><a target="_blank" href="<?php echo __ROOT__.'weiadmin/index.php'; ?>"><?php echo __ROOT__.'weiadmin/index.php'; ?></a></td>
			</tr>
			<?php
				unset($config['DB_PASS']);
				foreach ($config as $key => $value) {
					echo '<tr>';
					echo "<td>$key</td>";
					echo "<td>$config_explain[$key]</td>";
					echo "<td>$value</td>";
					echo '</tr>';
				}
			?>
		</tbody>
	</table>
</body>
</html>
