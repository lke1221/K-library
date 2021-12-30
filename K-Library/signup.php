<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);
mysqli_query($conn, "set autocommit=0");
mysqli_query($conn, "set session transaction isolation level serializable");
mysqli_query($conn, "start transaction");

$id = $_POST['id'];
$pwd = $_POST['pwd'];
$username = $_POST['username'];
$position = $_POST['position'];
$encrypted_pwd = password_hash($pwd, PASSWORD_DEFAULT);

$res = mysqli_query($conn, "select id from user where id='$id'");
if(!$res){
	mysqli_query($conn, "rollback");
	s_msg ('오류가 발생했습니다.');
	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
}

$exist = mysqli_num_rows($res);
if($exist>0){
	s_msg('이미 중복된 아이디가 존재합니다');
	echo "<meta http-equiv='refresh' content='0;url=signup_form.php'>";
}
	
$ret = mysqli_query($conn, "insert into user (id, pwd, username, position) values('$id', '$encrypted_pwd', '$username', $position)");
if(!$ret)
{
	mysqli_query($conn, "rollback");
	s_msg ('오류가 발생했습니다.');
	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
}
else
{
	mysqli_query($conn, "commit");
	s_msg ('성공적으로 입력 되었습니다');
	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
}


?>