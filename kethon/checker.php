<?php
/**
 * @author success.ddt@gmail.com
 */	
session_start();
$validate = array(
	'htck' => 'Họ tên chồng',
	'htvk' => 'Họ tên vợ',
	'nsck' => 'Ngày sinh của chồng',
	'nsvk' => 'Ngày sinh của vợ',
	'hkck' => 'Hộ khẩu chồng',
	'hkvk' => 'Hộ khẩu vợ',
	'ktck' => 'Chữ ký chồng',
	'ktvk' => 'Chữ ký vợ',
	'cmck' => 'CMND của chồng',
	'cmvk' => 'CMND của vợ'
);
$errors = array();
$args = array();
foreach($validate as $key => $value){
	if(!isset($_GET[$key]) || empty($_GET[$key])){
		$errors[] = 'Vẫn còn thiếu ' . $value;
		
	}
	$args[$key] = $_GET[$key];
};

if(empty($errors)) {
	 header( 'Location: giaychungnhankethon.png?' . http_build_query($args) ) ;
}
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf8" />
	<meta name="author" content="LiveLong" />

	<title>Lỗi</title>
</head>

<body>

<?php foreach($errors as $error): ?>
	<h2><?php echo $error ?></h2>
	<br />
<?php endforeach; ?>


</body>
</html>