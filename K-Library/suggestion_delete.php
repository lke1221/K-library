<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);
mysqli_query($conn, "set autocommit=0");
mysqli_query($conn, "set session transaction isolation level serializable");
mysqli_query($conn, "start transaction");

$post_id = $_GET['post_id'];

$ret = mysqli_query($conn, "delete from suggestion where post_id = $post_id");

if(!$ret)
{
	mysqli_query($conn, "rollback");
	s_msg ('오류가 발생했습니다.');
	echo "<meta http-equiv='refresh' content='0;url=suggestion_list.php'>";
}
else
{
	mysqli_query($conn, "commit");
    s_msg ('성공적으로 삭제 되었습니다');
    echo "<meta http-equiv='refresh' content='0;url=suggestion_list.php'>";
}

?>

