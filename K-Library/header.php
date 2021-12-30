<!DOCTYPE html>
<?php session_start()?>
<html lang='ko'>
<head>
    <title>작심삼일 독서실</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<form action="product_list.php" method="post">
    <div class='navbar fixed'>
        <div class='container'>
            <a class='pull-left title' href="index.php">작심삼일 독서실</a>
            <ul class='pull-right'>
                <li><a href='seat_list.php'>좌석</a></li>
                <li><a href='suggestion_list.php'>건의사항</a></li>
                <?
                if(!isset($_SESSION['id'])){
                	echo "<li><a href='signin_form.php'>로그인</a></li>";
                }
                else{
                	echo "<li><a href='mypage.php'>마이페이지</a></li>";
                	echo "<li><a href='signout.php'>로그아웃</a></li>";
                }
				//<li><a href='signin_form.php'>로그인</a></li>
				?>
            </ul>
        </div>
    </div>

</form>