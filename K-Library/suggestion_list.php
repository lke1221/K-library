<?
session_start();
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수
?>
<div class="container" align="center">
    <?
    //echo "{$_SESSION['id']}";
    //echo "{$_SESSION['position']}";
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);
    mysqli_query($conn, "set autocommit=0");
	mysqli_query($conn, "set session transaction isolation level serializable");
	mysqli_query($conn, "start transaction");
    $query = "select * from suggestion join user on suggestion.writer_id=user.id";
    if (array_key_exists("search_keyword", $_POST)) {  // array_key_exists() : Checks if the specified key exists in the array
        $search_keyword = $_POST["search_keyword"];
        $category = $_POST["category"];
        if($category == 'position'){
        	$query = "select * from user join position on user.position=position.position_id join suggestion on suggestion.writer_id=user.id";
        	$category = 'position_name';
        }
        $query =  $query . " where $category like '%$search_keyword%'";
        echo "<h3 style='margin:10px;'>\"{$search_keyword}\"(으)로 검색한 결과입니다.</h3>";
    
    }
    $res = mysqli_query($conn, $query);
    if (!$res) {
        mysqli_query($conn, "rollback");
    	s_msg ('오류가 발생했습니다.');
    	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
    }
    else{
    	mysqli_query($conn, "commit");	
    }
    ?>

    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>No.</th>
            <th>제목</th>
            <th>작성자</th>
            <th>등록일</th>
            <th>기능</th>
        </tr>
        </thead>
        <tbody>
        <?
        $row_index = 1;
        while ($row = mysqli_fetch_array($res)) {
            echo "<tr>";
            echo "<td>{$row_index}</td>";
            echo "<td><a href='suggestion_view.php?post_id={$row['post_id']}'>{$row['title']}</a></td>";
            echo "<td>{$row['username']}</td>";
            echo "<td>{$row['added_datetime']}</td>";
            echo "<td width='17%'>
                <button onclick='javascript:modifyConfirm({$row['post_id']}, \"{$row['writer_id']}\", \"{$_SESSION['id']}\")' class='button primary small'>수정</button>
                 <button onclick='javascript:deleteConfirm({$row['post_id']}, \"{$row['writer_id']}\", \"{$_SESSION['id']}\", {$_SESSION['position']})' class='button danger small'>삭제</button>
                </td>";
            echo "</tr>";
            $row_index++;
        }
        ?>
        </tbody>
    </table>
    <?echo "<button onclick='javascript:loginConfirm(\"{$_SESSION['id']}\")' class='button primary large'>새로 작성하기</button>" ?>
    <div id="search_box" style="text-align: center; margin:30px;">
    	<form action="suggestion_list.php" method="post" align="center" style="text=align:center">
    		<select name="category" style="width:100px">
    			<option value = "title">제목</option>
    			<option value = "username">작성자</option>
    			<option value = "position">회원 유형</option>
    		</select>
    		<input style="padding: 5px;" type="text" name="search_keyword" placeholder="검색어 입력">
    		<button class="button primary small">검색</button>
    	</form>
    </div>
    <script>
        function modifyConfirm(post_id, writer_id, user_id) {
           if(writer_id==user_id){
             window.location = "suggestion_form.php?post_id=" + post_id;
           }
           else{
              window.alert("작성자만 글을 수정할 수 있습니다.");
           }
        }
        
        function deleteConfirm(post_id, writer_id, user_id, position) {
            if (confirm("정말 삭제하시겠습니까?") == true){    //확인
                if(writer_id==user_id || position==4){
                	window.location = "suggestion_delete.php?post_id=" + post_id;
                }
                else{
                	window.alert("작성자와 관리자만 글을 삭제할 수 있습니다.");
                }
            }else{   //취소
                return;
            }
        }
        
        function loginConfirm(user_id){
        	if(user_id==""){
        		window.alert("회원만 글 작성이 가능합니다.");
        	}
        	else{
        		window.location = "suggestion_form.php";
        	}
        }
    </script>
</div>
<? include("footer.php") ?>