<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);
mysqli_query($conn, "set autocommit=0");
mysqli_query($conn, "set session transaction isolation level serializable");
mysqli_query($conn, "start transaction");

$area_id = $_GET['area_id'];
echo $area_id;
$ret = mysqli_query($conn, "insert into seat(area_id) values($area_id)");

if(!$ret)
{
	mysqli_query($conn, "rollback");
    s_msg ('오류가 발생했습니다.');
    echo "<meta http-equiv='refresh' content='0;url=seat_list.php'>";
}
else
{
	mysqli_query($conn, "commit");
    s_msg ('추가되었습니다');
    echo "<meta http-equiv='refresh' content='0;url=seat_list.php'>";
}

?>