<?php
header("Content-type:text/json; charset=utf-8");//字符编码设置
error_reporting(E_ALL || ~E_NOTICE);
require ('fun/DB_config.php'); 

// 创建连接
try{
    $conn=new PDO($dsn,$db_user,$db_pass);
}catch(PDOException $e){
    echo 'DB connection failed'.$e->getMessage();
}
$conn->exec("set names 'utf8'"); 
$conn->exec("set character_set_server = utf8;"); 

function over_exit($over)
{
	$done = ['is_success' => $over];
	$done = json_encode($done,JSON_UNESCAPED_UNICODE);
	echo $done;
	$conn = null;
	exit();
}

$by_follower= $_POST['by_follower'];
$fans = $_POST['uid'];
if ($by_follower == $fans) {
	over_exit('failed');
}

$sql = "delete from follow where by_follower=$by_follower and fans=$fans";

$ins = $conn->exec($sql);
if ($ins == 0) {
	over_exit('failed');
}elseif ($ins == 1) {
	over_exit('success');
}