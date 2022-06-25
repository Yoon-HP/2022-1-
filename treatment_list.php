<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

?>
<div class="container">
    <table class="table table-striped table-bordered">
        <tr>
            <th>No.</th>
            <th>고객번호</th>
            <th>수의사 이름</th>
            <th>진료날짜</th>
        </tr>
    <?
    
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);
    
    mysqli_query( $connect, 'set autocommit = 0');
	mysqli_query( $connect, 'set session transaction isolation level serializable');
	mysqli_query( $connect, "start transaction");
    
    
    $query = "select * from appointment";
    $result = mysqli_query($conn, $query);
    
    if(!$result){
    	mysqli_query($connect, "rollback");
    }
    
    while($row=mysqli_fetch_array($result)){
    	$time=date("Y-m-d H:i:s");
    	$app_time=$row['appointment_daytime'];
    	if ($time>=$app_time){
    		$query1 = "insert into treatment (ahcustomer_id, doctor_id, treatmentday) values ({$row['ahcustomer_id']},{$row['doctor_id']},
    		'{$row['appointment_daytime']}')";
        	$result2=mysqli_query($conn, $query1);
        	
        	if(!$result2){
        		mysqli_query($connect, "rollback");
        	}
    	}
    }
    
    
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);
    $query = "select * from treatment";
    $result = mysqli_query($conn, $query);
    
    if(!$result){
    	mysqli_query($connect, "rollback");
    }
    
	$row_index = 1;
    while($row=mysqli_fetch_array($result)){
    	echo "<tr><td>{$row_index}</td>";
        echo "<td>{$row['ahcustomer_id']}</td>";
        $query2 = "select doctor_name from doctor where doctor_id={$row['doctor_id']}";
    	$result1 = mysqli_query($conn, $query2);
    	$row1=mysqli_fetch_array($result1);
    	echo "<td>{$row1['doctor_name']}</td>";
        echo "<td>{$row['treatmentday']}</td></tr>";
        $row_index++;
    mysqli_query($connect, "commit");
    }
    ?>
    </table>
</div>
    
<?
include "footer.php"
?>
