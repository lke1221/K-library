<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$area_id = $_GET['area_id'];
?>

<div class="container" align="center">
    <div>
    <table align='center' border='0' width='500px' cellspacing='20' cellpadding='20'>
    	<tr>
    		<h2>다음 중 선택하세요</h2>
    	</tr>
        <tr>
        	<td align='center'> 
                <a href='seat_add.php?area_id=<?echo $area_id?>'><button class='button primary large' width='100%'>좌석 추가</button>
            </td>
            <td align='center'> 
                <a href='seat_select.php?area_id=<?echo $area_id?>&mode=delete'><button class='button danger large' width='100%'>좌석 삭제</button>
            </td>
        </tr>
    </table>
    </div>
</div>
<? include("footer.php") ?>