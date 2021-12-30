<?
session_start();
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);
mysqli_query($conn, "set autocommit=0");
mysqli_query($conn, "set session transaction isolation level serializable");
mysqli_query($conn, "start transaction");
$mode = "입력";
$action = "suggestion_insert.php";

if (array_key_exists("post_id", $_GET)) {
    $post_id = $_GET["post_id"];
    $query = "select * from suggestion where post_id = $post_id";
    $res = mysqli_query($conn, $query);
    if(!$res){
		mysqli_query($conn, "rollback");
		s_msg ('오류가 발생했습니다.');
		echo "<meta http-equiv='refresh' content='0;url=suggestion_list.php'>";
	}
	else{
		mysqli_query($conn, "commit");
	}
    $post = mysqli_fetch_array($res);
    if(!$post) {
        msg("글이 존재하지 않습니다.");
    }
    $mode = "수정";
    $action = "suggestion_modify.php";
    
    //echo json_encode($product);
}

?>
    <div class="container">
        <form name="product_form" action="<?=$action?>" method="post" class="fullwidth">
            <input type="hidden" name="post_id" value="<?=$post['post_id']?>"/>
            <h3>건의사항 <?php echo $mode; ?></h3>
            <p>
                <label for="title">제목</label>
                <input type="text" placeholder="제목 입력" name="title" value="<?=$post['title']?>"/>
            </p>
            <p>
                <label for="price">작성자</label>
                <input disabled type="text" id="username" name="username" value="<?=$_SESSION['username']?>" />
            </p>
            <p>
                <label for="detail">내용</label>
                <textarea placeholder="내용 입력" id="detail" name="detail" rows="10"><?=$post['detail']?></textarea>
            </p>

            <p align="center"><button class="button primary large" onclick="javascript:return validate();"><?=$mode?></button></p>

            <script>
                function validate() {
                    if(document.getElementById("title").value == "") {
                        alert ("제목을 입력해 주십시오"); return false;
                    }
                    else if(document.getElementById("detail").value == "") {
                        alert ("내용을 입력해 주십시오"); return false;
                    }
                    return true;
                }
            </script>

        </form>
    </div>
<? include("footer.php") ?>