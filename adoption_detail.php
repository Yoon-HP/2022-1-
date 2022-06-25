<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수


$conn = dbconnect($host, $dbid, $dbpass, $dbname);

mysqli_query( $connect, 'set autocommit = 0');
mysqli_query( $connect, 'set session transaction isolation level serializable');
mysqli_query( $connect, "start transaction");

if (array_key_exists("ahcustomer_id", $_GET)) {
    $ahcustomer_id = $_GET["ahcustomer_id"];
    $query = "select ahcustomer_id, ahcustomer_name,count(ahcustomer_id) as cnt from adoption natural join ahcustomer where ahcustomer_id = $ahcustomer_id group by ahcustomer_id";
    $result = mysqli_query($conn, $query);
    
    if(!$result){
    	mysqli_query($connect, "rollback");
    }
    
    $adoption = mysqli_fetch_assoc($result);
    if (!$adoption) {
        msg("입양이력이 없습니다.");
    }
}

?>
    <div class="container fullwidth">

        <h3>입양 정보 상세 보기</h3>

        <p>
            <label for="customer_id">입양자 번호</label>
            <input readonly type="text" name="ahcustomer_id" value="<?= $adoption['ahcustomer_id'] ?>"/>
        </p>

        <p>
            <label for="name">입양자명</label>
            <input readonly type="text"  name="ahcustomer_name" value="<?= $adoption['ahcustomer_name'] ?>"/>
        </p>
        <p>
            <label for="total_price">총 입양동물 수</label>
            <input readonly type="text"  name="cnt" value="<?= $adoption['cnt'] ?>"/>
        </p>
    </div>
    
    <div class="container">
    
    <table class="table table-striped table-bordered">
        <tr>
            <th>No.</th>
            <th>입양동물번호</th>
            <th>입양동물명</th>
            <th>입양날짜</th>
        </tr>
        <?
       
        $query = "select abandoned_animal_id, abandoned_animal_name, adoption_day from adoption natural join abandoned_animal where ahcustomer_id = $ahcustomer_id";
        $result = mysqli_query($conn, $query);
        
        if(!$result){
    		mysqli_query($connect, "rollback");
    	}
    	
        $row_num = mysqli_num_rows($result);
        for($row_index=1;$row_index<=$row_num;$row_index++){
            $row= mysqli_fetch_array($result);
            echo "<tr>";
            echo "<td>{$row_index}</td>";
            echo "<td>{$row['abandoned_animal_id']}</td>";
            echo "<td>{$row['abandoned_animal_name']}</td>";
            echo "<td>{$row['adoption_day']}</td>";
            echo "</tr>";
        }
        mysqli_query($connect, "commit");
        ?>
    </table>
</div>
    
<? include("footer.php") ?>