<?
session_start();
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);
mysqli_query($conn, "set autocommit=0");
mysqli_query($conn, "set session transaction isolation level serializable");
mysqli_query($conn, "start transaction");
$action = "user_modify_ok.php";

$id = $_SESSION['id'];
$query = "select * from user where id = '$id'";
$res_user = mysqli_query($conn, $query);
if(!$res_user){
	mysqli_query($conn, "rollback");
	s_msg ('오류가 발생했습니다.');
	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
}
$user_info = mysqli_fetch_array($res_user);


$position = array();
$query = "select * from position";
$res_pos = mysqli_query($conn, $query);
if(!$res_pos){
	mysqli_query($conn, "rollback");
	s_msg ('오류가 발생했습니다.');
	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
}
else{
	mysqli_query($conn, "commit");
}
while($row = mysqli_fetch_array($res_pos)) {
    $position[$row['position_id']] = $row['position_name'];
}
?>

<div class="container" align="center">
    <h2>회원 정보 수정</h2>
    <div id='signform'>
    <form class='form_margin' action="<?=$action?>" method='post'>
    <table align='center' border='0' width='400px' cellspacing='0' cellpadding='0'>
        <tr>
        	<td width='20%' colspan='1'> 
                <label width='100%'>ID</label>
            </td>
            <td width='50%' colspan='1'> 
                <input type='text' id='id' name='id' class='inph' value="<?=$id?>" disabled>
            </td>
        </tr>
        <tr>
        	<td width='20%' colspan='1'> 
                <label width='100%'>Password</label>
            </td>
            <td width='50%' colspan='1'> 
               	<input type='password' id='pwd' name='pwd' class='inph'>
            </td>
        </tr>
        <tr>
        	<td width='20%' colspan='1'> 
                <label width='100%'>이름</label>
            </td>
            <td width='50%' colspan='1'> 
                <input type='text' id='username' name='username' class='inph' value="<?=$user_info['username']?>">
            </td>
        </tr>
        <tr>
        	<td width='20%' colspan='1'> 
                <label width='100%'>신분</label>
            </td>
            <td width='50%' colspan='1'> 
                <select id='position' name='position' class='selectbox'>
                	<option value="-1">선택해 주십시오.</option>
                    <?
                        foreach($position as $id => $name) {
                            if($id == $user_info['position']){
                                echo "<option value='{$id}' selected>{$name}</option>";
                            } else {
                                echo "<option value='{$id}'>{$name}</option>";
                            }
                        }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
        	<td colspan='2' align='center' padding='0'> 
                <button class='button signin' width='100%' onclick="javascript:return validate();">수정 완료</button>
            </td>
        </tr>
    </table>
    </form>
    </div>
    <script>
        function validate() {
            if(document.getElementById("position").value == "-1") {
                alert ("회원 유형을 선택해 주십시오"); return false;
            }
            else if(document.getElementById("id").value == "") {
                alert ("아이디를 입력해 주십시오"); return false;
            }
            else if(document.getElementById("username").value == "") {
                alert ("이름을 입력해 주십시오"); return false;
            }
            else if(document.getElementById("pwd").value == "") {
                alert ("비밀번호를 입력해 주십시오"); return false;
            }
           return true;
        }
    </script>
</div>
<? include("footer.php") ?>