<?php session_start(); ?>
<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수
?>

<div class="container" align="center">
    <h2>로그인</h2>
    <div id='signform'>
    <form class='form_margin' action='signin.php' method='post'>
    <table align='center' border='0' width='500px' cellspacing='0' cellpadding='0'>
        <tr>
        	<td width='20%' colspan='1'> 
                <label width='100%'>ID</label>
            </td>
            <td width='50%' colspan='1'> 
                <input type='text' id='id' name='id' class='inph'>
            </td>
            <td rowspan='2' align='center' width='30%' padding='0'> 
                <button onclick="javascript:return validate();" class='button signin' width='100%'>로그인</button>
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
           	<td colspan='3' align='center'> 
               <p align='center'>아직 계정이 없으면 <a href='signup_form.php'>회원가입</a></p>
            </td>
        </tr>
    </table>
    </form>
    </div>
    <script>
        function validate() {
            if(document.getElementById("id").value == "") {
                alert ("아이디를 입력해 주십시오"); return false;
            }
            else if(document.getElementById("pwd").value == "") {
                alert ("비밀번호를 입력해 주십시오"); return false;
            }
           return true;
        }
    </script>
</div>
<? include("footer.php") ?>