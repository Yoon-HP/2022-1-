<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수
?>
<div class="container">
    <?
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);
    
    mysqli_query( $connect, 'set autocommit = 0');
	mysqli_query( $connect, 'set session transaction isolation level serializable');
	mysqli_query( $connect, "start transaction");
	
    $query = "select * from appointment";
    $result = mysqli_query($conn, $query);
    if (!$result) {
         die('Query Error : ' . mysqli_error());
         mysqli_query($connect, "rollback");
    }
    ?>

    <table class="table table-striped table-bordered">
        <tr>
            <th>No.</th>
            <th>고객 번호</th>
            <th>수의사 이름</th>
            <th>예약 날짜</th>
            <th>기능</th>
        </tr>
        <?
        $row_index = 1;
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>{$row_index}</td>";
            echo "<td>{$row['ahcustomer_id']}</td>";
            $query = "select doctor_name from doctor where doctor_id={$row['doctor_id']}";
    		$result1 = mysqli_query($conn, $query);
    		
    		if(!$result1){
    			mysqli_query($connect, "rollback");
    		}
    		
    		$row1=mysqli_fetch_array($result1);
    		echo "<td>{$row1['doctor_name']}</td>";
            echo "<td>{$row['appointment_daytime']}</td>";
            echo "<td width='17%'>
                <a href='appointment_form.php?app_id={$row['app_id']}'><button class='button primary small'>수정</button></a>
                 <button onclick='javascript:deleteConfirm1({$row['app_id']})' class='button danger small'>삭제</button>
                </td>";
            echo "</tr>";
            $row_index++;
        }
        mysqli_query($connect, "commit");
        ?>
    </table>
    <script>
        function deleteConfirm1(app_id) {
            if (confirm("정말 삭제하시겠습니까?") == true)
            {window.location = "appointment_delete.php?app_id=" + app_id;}
            else{   //취소
                return;
            }
        }
    </script>
</div>
<? include("footer.php") ?>
