<?php
session_start();
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);
mysqli_query($conn, "set autocommit=0");
mysqli_query($conn, "set session transaction isolation level serializable");
mysqli_query($conn, "start transaction");

$id = $_POST['id'];
$pwd = $_POST['pwd'];

$ret = mysqli_query($conn, "select * from user where id = '$id'");

if(!$ret)
{
	mysqli_query($conn, "rollback");
    s_msg('존재하지 않는 아이디입니다');
    echo "<meta http-equiv='refresh' content='0;url=signin_form.php'>";
}
else
{
	mysqli_query($conn, "commit");
    $row = mysqli_fetch_array($ret);
    if(password_verify($pwd,$row['pwd'])){
        //로그인 처리 필요
        s_msg('로그인성공!');
        $_SESSION['id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['position'] = $row['position'];
        echo "<meta http-equiv='refresh' content='0;url=index.php'>";
        
    }
    else{
    	if($row['pwd']){
    		s_msg ('비밀번호가 일치하지 않습니다');
        	echo "<meta http-equiv='refresh' content='0;url=signin_form.php'>";
    	}
    	else{
        	s_msg ('존재하지 않는 아이디입니다');
        	echo "<meta http-equiv='refresh' content='0;url=signin_form.php'>";
    	}
    }
}

?>