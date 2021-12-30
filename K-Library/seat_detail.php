<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$area_id = $_GET['area_id'];
$conn = dbconnect($host, $dbid, $dbpass, $dbname);
mysqli_query($conn, "set autocommit=0");
mysqli_query($conn, "set session transaction isolation level serializable");
mysqli_query($conn, "start transaction");
$query = "select seat_id from seat where area_id={$area_id} and user_id is null";
$res = mysqli_query($conn, $query);
if(!$res){
	mysqli_query($conn, "rollback");
    s_msg ('오류가 발생했습니다.');
    echo "<meta http-equiv='refresh' content='0;url=seat_list.php'>";
}
else{
	mysqli_query($conn, "commit");
}
?>

<div class = "container" align = "center">
	<table align='center' border='0' width='500px' cellspacing='20' cellpadding='20'>
	<?
		$empty_seat = mysqli_num_rows($res);
		if($empty_seat>0){
			echo "<tr><td align='center'><h3>잔여좌석 번호는 다음과 같습니다.</h3></td></tr>";
			while ($row = mysqli_fetch_array($res)) {
				echo "<tr><td align='center'><h4>{$row['seat_id']}</h4></td></tr>";
			}
		}
		else{
			echo "<p>잔여좌석이 없습니다.</p>";
		}
	?>
	</table>
</div>