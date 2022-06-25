<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

?>
<div class="container">
    <table class="table table-striped table-bordered">
        <tr>
            <th>No.</th>
            <th>입양자번호</th>
            <th>입양자명</th>
            <th>입양 동물 수</th>
        </tr>
    <?
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);
    
    mysqli_query( $connect, 'set autocommit = 0');
	mysqli_query( $connect, 'set session transaction isolation level serializable');
	mysqli_query( $connect, "start transaction");
	
    $query = "select ahcustomer_id, ahcustomer_name,count(ahcustomer_id) from adoption natural join ahcustomer group by ahcustomer_id order by ahcustomer_id";
    $result = mysqli_query($conn, $query);
    
    if(!$result){
    	mysqli_query($connect, "rollback");
    }else{
    	mysqli_query($connect, "commit");
    }
    
	$row_index = 1;
    while($row=mysqli_fetch_array($result)){
    	echo "<tr><td>{$row_index}</td>";
        echo "<td><a href='adoption_detail.php?ahcustomer_id={$row['ahcustomer_id']}'>{$row['ahcustomer_id']}</a></td>";
        echo "<td>{$row['ahcustomer_name']}</td>";
        echo "<td>$row[2]</td></tr>";
        $row_index++;
    }
    ?>
    </table>
</div>
    
<?
include "footer.php"
?>
