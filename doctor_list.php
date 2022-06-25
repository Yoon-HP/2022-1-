<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

?>
<div class="container">
    <table class="table table-striped table-bordered">
        <tr>
            <th>No.</th>
            <th>수의사번호</th>
            <th>수의사이름</th>
        </tr>
    <?
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);

    mysqli_query( $connect, 'set autocommit = 0');
	mysqli_query( $connect, 'set session transaction isolation level serializable');
	mysqli_query( $connect, "start transaction");

    $query = "select * from doctor";
    $result = mysqli_query($conn, $query);
    
    if(!$result){
    	mysqli_query($connect, "rollback");
    }else{
    	mysqli_query($connect, "commit");
    }
    
	$row_index = 1;
    while($row=mysqli_fetch_array($result)){
    	echo "<tr><td>{$row_index}</td>";
        echo "<td>{$row['doctor_id']}</td>";
        echo "<td>{$row['doctor_name']}</td>";
        $row_index++;
    }
    ?>
    </table>
</div>
    
<?
include "footer.php"
?>
