<?php session_start(); include ("header.php"); ?>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <style>
        .background-video {
            background-position: top center;
            background-repeat: no-repeat;
            bottom: 0;
            left: 0;
            overflow: hidden;
            position: fixed;
            right: 0;
            top: 0;
        }
        .navbar {
            z-index:999;
        }
        h1, p {
            padding: 0px 30px 0px 30px;
            text-align:center;
        }
        h1 {
            font-weight:800;
        }
        .container {
            position: relative;
            background: rgba(255, 255, 255, .9);
        }
        .ref {
            font-weight:200;
            font-size:0.5em;
        }
    </style>
    <div class='container'>
        <p align="center"><img src="images/banner.PNG" width="100%"></p>
        <p>'마음 먹은 지 삼일이 못간다는 뜻으로, 결심이 얼마 되지 않아 흐지부지 된다는 말'</p>
        <p><b>작심삼일이 열 번이면 작심한달</b></p>
        <p><b>오늘부터 삼일마다 '작심삼일' 하세요!</b></p>
    </div>
<?php include ("footer.php"); ?>