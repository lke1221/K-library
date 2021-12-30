<?
session_start();
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수
?>
<div class="container" align="center">
    <?
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);
    mysqli_query($conn, "set autocommit=0");
	mysqli_query($conn, "set session transaction isolation level serializable");
	mysqli_query($conn, "start transaction");
    $query = "select * from area";
    $areas = mysqli_query($conn, $query);
    if (!$areas) {
    	mysqli_query($conn, "rollback");
        s_msg ('오류가 발생했습니다.');
    	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
    }
    
    if(isset($_SESSION['id'])){
    	$query = "select * from seat where user_id='{$_SESSION['id']}'";
    	$res = mysqli_query($conn, $query);
    	if(!$res){
    		mysqli_query($conn, "rollback");
    		s_msg ('오류가 발생했습니다.');
    		echo "<meta http-equiv='refresh' content='0;url=index.php'>";
    	}
    	else{
    		mysqli_query($conn, "commit");
    	}
    	if(mysqli_num_rows($res)){
    		$row = mysqli_fetch_array($res);
    		$reserved = $row['seat_id'];
    	}
    	else{
    		$reserved = 0;
    	}
    }
    else{
    	$reserved = -1;
    }
    ?>

    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>구역 이름</th>
            <th>설명</th>
            <th>잔여좌석</th>
            <th>기능</th>
        </tr>
        </thead>
        <tbody>
        <?
        $row_index = 1;
        while ($row = mysqli_fetch_array($areas)) {
        	//좌석 수 확인
    		$query = "select seat_id from seat where area_id={$row['area_id']}";
			$res = mysqli_query($conn, $query);
    		if (!$res) {
        		die('Query Error : ' . mysqli_error());
    		}
    		$total_seat = mysqli_num_rows($res);
    		
    		$query = "select seat_id from seat where area_id={$row['area_id']} and user_id is null";
    		$res = mysqli_query($conn, $query);
    		if(!$res){
    			die('Query Error : ' . mysqli_error());
    		}
    		$empty_seat = mysqli_num_rows($res);
    		
            echo "<tr>";
            echo "<td>{$row['area_name']}</td>";
            echo "<td>{$row['area_desc']}</td>";
            echo "<td><a href='seat_detail.php?area_id={$row['area_id']}'>{$empty_seat}/{$total_seat}</a></td>";
            echo "<td width='17%'>
                 <button onclick='javascript:reserveConfirm({$row['area_id']}, {$reserved}, $empty_seat)' class='button primary small'>예약</button></a>
                 <button onclick='javascript:authConfirm({$row['area_id']}, {$_SESSION['position']})' class='button danger small'>좌석 관리</button>
                </td>";
            echo "</tr>";
            $row_index++;
        }
        ?>
        </tbody>
    </table>
    <?echo "<button onclick='javascript:returnConfirm({$reserved})' class='button primary large'>좌석 반납하기</button>"?>
    <script>
        function reserveConfirm(area_id, reserved, empty_seat) {
            if (reserved>0){    //확인
            	if(confirm("이미 예약된 좌석이 있습니다. 기존 좌석을 반납하시겠습니까?")){
            		window.location = "seat_return.php?seat_id=" + reserved;
            	}
                else{
                	return;
                }
            }
            else if (reserved==0){
            	if(empty_seat>0){
                	window.location = "seat_select.php?area_id=" + area_id + "&mode=reserve";
            	}
            	else{
            		window.alert("잔여좌석이 없습니다.");
            	}
            }
            else{
            	window.alert("회원만 예약이 가능합니다. 먼저 로그인해주세요.");
            	window.location = "signin_form.php";
            }
        }
        
        function authConfirm(area_id, position){
        	if(position==4){
        		window.location = "seat_manage.php?area_id=" + area_id;
        	}
        	else{
        		window.alert("관리자만 접근 가능한 메뉴입니다.");
        	}
        }
        
        function returnConfirm(reserved){
        	if (reserved>0){
        		window.location = "seat_return.php?seat_id=" + reserved;
        	}
        	else{
        		window.alert("반납할 좌석이 없습니다.");
        	}
        }
    </script>
</div>
<? include("footer.php") ?>