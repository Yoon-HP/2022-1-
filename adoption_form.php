<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";  
?>
<div class="container">
    <?
    
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);
    
    mysqli_query( $connect, 'set autocommit = 0');
	mysqli_query( $connect, 'set session transaction isolation level serializable');
	mysqli_query( $connect, "start transaction");
    
    $query = "select * from abandoned_animal where abandoned_animal_id not in (select abandoned_animal_id from abandoned_animal natural join adoption)";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        die('Query Error : ' . mysqli_error());
        mysqli_query($connect, "rollback");
    }
    ?>
    <form name='adoption' action='adoption.php' method='POST'>
        <p align='right'> 사용자 ID 입력: <input type='text' name='ahcustomer_id'></p>
        <table class="table table-striped table-bordered">
            <tr>
                <th>No.</th> 
                <th>주치의</th>
                <th>이름</th>
                <th>나이</th>
                <th>보호시작일</th>
                <th>종</th>
                <th>성별</th>
                <th>보호실타입</th>
                <th>선택</th>
            </tr>
            <?
            $row_index = 1;
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr>";
                echo "<td>{$row_index}</td>";
    			$query = "select doctor_name from doctor where doctor_id={$row['doctor_id']}";
    			$result1 = mysqli_query($conn, $query);
    			
    			if(!$result1){
    				mysqli_query($connect, "rollback");
    			}
    			$row1=mysqli_fetch_array($result1);
                echo "<td>{$row1['doctor_name']}</td>";
                echo "<td>{$row['abandoned_animal_name']}</td>";
                echo "<td>{$row['abandoned_animal_age']}</td>";
                echo "<td>{$row['protection_start_day']}</td>";
                echo "<td>{$row['abandoned_animal_specie']}</td>";
                echo "<td>{$row['abandoned_animal_sex']}</td>";
                $query = "select room_type from room where room_id={$row['room_id']}";
    			$result2 = mysqli_query($conn, $query);
    			
    			if(!$result2){
    				mysqli_query($connect, "rollback");
    			}
    			
    			$row2=mysqli_fetch_array($result2);
                echo "<td>{$row2['room_type']}</td>";
                echo "<td width='17%'>
                    <input type='checkbox' name=abandoned_animal_id[] value='{$row['abandoned_animal_id']}'>
                    </td>";
                echo "</tr>";
                $row_index++;
            }
            mysqli_query($connect, "commit");
            ?>
            
        </table>
        <div align='center'>
            <input type='submit' class='button primary small' value=입양>
        </div>
    </form>
</div>
<? include("footer.php") ?>