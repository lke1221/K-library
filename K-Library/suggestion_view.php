<?
session_start();
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);
mysqli_query($conn, "set autocommit=0");
mysqli_query($conn, "set session transaction isolation level serializable");
mysqli_query($conn, "start transaction");

if (array_key_exists("post_id", $_GET)) {
    $post_id = $_GET["post_id"];
    $query = "select * from suggestion join user on suggestion.writer_id=user.id where post_id = $post_id";
    $res = mysqli_query($conn, $query);
    if(!$res)
	{
		mysqli_query($conn, "rollback");
    	s_msg ('오류가 발생했습니다.');
    	echo "<meta http-equiv='refresh' content='0;url=suggestion_list.php'>";
	}
	else
	{
		mysqli_query($conn, "commit");
	}
    $post = mysqli_fetch_assoc($res);
    if (!$post) {
        msg("글이 존재하지 않습니다.");
    }
}
?>
    <div class="container fullwidth">

        <h3>건의사항 상세 보기</h3>

        <p>
            <label for="title">제목</label>
            <input readonly type="text" id="title" name="title" value="<?= $post['title'] ?>"/>
        </p>

        <p>
            <label for="username">작성자</label>
            <input readonly type="text" id="username" name="username" value="<?= $post['username'] ?>"/>
        </p>

        <p>
            <label for="added_datetime">작성시간</label>
            <input readonly type="text" id="added_datetime" name="added_datetime" value="<?= $post['added_datetime'] ?>"/>
        </p>

        <p>
            <label for="detail">내용</label>
            <textarea readonly id="detail" name="detail" rows="10"><?= $post['detail'] ?></textarea>
        </p>
    </div>
<? include("footer.php") ?>