<?php
session_start();
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);
mysqli_query($conn, "set autocommit=0");
mysqli_query($conn, "set session transaction isolation level serializable");
mysqli_query($conn, "start transaction");

$id = $_SESSION['id'];
$pwd = $_POST['pwd'];
$username = $_POST['username'];
$position = $_POST['position'];
$encrypted_pwd = password_hash($pwd, PASSWORD_DEFAULT);

$ret = mysqli_query($conn, "update user set id = '$id', pwd = '$encrypted_pwd', username = '$username', position = $position where id = '$id'");

if(!$ret)
{
	mysqli_query($conn, "rollback");
	s_msg ('오류가 발생했습니다.');
    echo "<meta http-equiv='refresh' content='0;url=mypage.php'>";
}
else
{
	mysqli_query($conn, "commit");
    s_msg ('성공적으로 수정 되었습니다');
    $_SESSION['username'] = $username;
    echo "<meta http-equiv='refresh' content='0;url=mypage.php'>";
}

?>

