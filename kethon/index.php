<?php
/**
 * @author success.ddt@gmail.com
 */
require_once('config.php');
require_once('facebook.php');
$facebook = new Facebook(array(
	'appId' => FACEBOOK_APP_ID,
	'secret' => FACEBOOK_APP_SECRET,
));

$user = $facebook->getUser();

$loginUrl = $facebook->getLoginUrl(array(
	'scope' => 'publish_stream, photo_upload'  
));

if(!$user) {
	header( 'Location: ' . $loginUrl) ;
}

?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf8" />
	<meta name="author" content="WILLXTA" />

	<title>Giấy chứng nhận kết hôn <3 :.</title>
	<style type="text/css"> 
		body {
			background: #FF69B4 url(bg.jpg);
		    font-family: Verdana, Arial, Helvetica, Sans-serif;
		    font-size: 15px;
		    text-align: center;
		}
		#form-input form {
			text-align: center;
			background: rgba(255, 255, 255, 0.9);
			padding: 10px;
			text-align: center;
			margin: 0 auto;
			width: 500px;
		}
		#form-input form input {
			padding: 2px;
		}
	</style> 
</head>
<body>
	<div id="form-input">
		<form action="checker.php" method="get">
			<table>
				<tr>
					<td></td>
					<td>Chồng</td>
					<td>Vợ</td>
				</tr>
				<tr>
					<td>Họ tên</td>
					<td><input type="text" required="required" name="htck" /></td>
					<td><input type="text" name="htvk" /></td>
				</tr>
				<tr>
					<td>Ngày sinh</td>
					<td><input type="text" required="required" name="nsck" /></td>
					<td><input type="text" required="required" name="nsvk" /></td>
				</tr>
				<tr>
					<td>Nơi cư trú</td>
					<td><input type="text" required="required" name="hkck" /></td>
					<td><input type="text" required="required" name="hkvk" /></td>
				</tr>
				<tr>
					<td>Số CMND</td>
					<td><input type="text" required="required" name="cmck" /></td>
					<td><input type="text" required="required" name="cmvk" /></td>
				</tr>
				<tr>
					<td>Chữ ký</td>
					<td><input type="text" required="required" name="ktck" /></td>
					<td><input type="text" required="required" name="ktvk" /></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" value="Tạo giấy ngay" /></td>
					<td></td>
				</tr>
			</table>
		</form>
		<br/>
		Chúc các bạn có những giây phút thư giãn
	</div>

</body>

</html>
