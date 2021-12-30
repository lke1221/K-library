<?php session_start(); ?>
<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수
?>

<?
$id = $_SESSION['id'];
$username = $_SESSION['username'];
$position = $_SESSION['position'];

$conn = dbconnect($host, $dbid, $dbpass, $dbname);
mysqli_query($conn, "set autocommit=0");
mysqli_query($conn, "set session transaction isolation level serializable");
mysqli_query($conn, "start transaction");

$query = "select * from position where position_id=$position";
$res = mysqli_query($conn, $query);
if(!$res){
	mysqli_query($conn, "rollback");
	s_msg ('오류가 발생했습니다.');
	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
}
else{
	mysqli_query($conn, "commit");
}
$ret = mysqli_fetch_array($res);
$position_name = $ret['position_name'];
?>

<div class="container" align="center">
	<h2>회원 정보</h2>
	<div id='signform'>
    <form class='form_margin'>
    <table align='center' border='0' width='500px' cellspacing='20' cellpadding='0'>
        <tr>
        	<td width='20%' colspan='1'> 
                <label width='100%'>ID</label>
            </td>
            <td width='50%' colspan='1'> 
                <? echo "$id"?>
            </td>
        </tr>
        <tr>
        	<td width='20%' colspan='1'> 
                <label width='100%'>이름</label>
            </td>
            <td width='50%' colspan='1'> 
               	<? echo "$username"?>
            </td>
        </tr>
        <tr>
        	<td width='20%' colspan='1'> 
                <label width='100%'>회원유형</label>
            </td>
            <td width='50%' colspan='1'> 
               	<? echo "$position_name"?>
            </td>
        </tr>
    </table>
    </form>
    <a href='user_modify.php'><button class='button primary small'>정보 수정</button></a>
    <? echo"<button onclick='javascript:deleteConfirm()' class='button danger small'>회원탈퇴</button>"?>
    </div>
    <script>
        function deleteConfirm() {
            if (confirm("정말 탈퇴하시겠습니까?") == true){
                window.location = "withdraw.php";
            }else{   //취소
                return;
            }
        }
    </script>
</div>