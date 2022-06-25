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
    
    $query = "select * from pet";
    if (array_key_exists("search_keyword", $_POST)) {  // array_key_exists() : Checks if the specified key exists in the array
        $search_keyword = $_POST["search_keyword"];
        $query .= " where pet_name like '%$search_keyword%'";
    }
    $result = mysqli_query($conn, $query);
    
    if (!$result) {
    	 mysqli_query($connect, "rollback");
         die('Query Error : ' . mysqli_error());
    }else{
    	mysqli_query($connect, "commit");
    }
    ?>

    <table class="table table-striped table-bordered">
        <tr>
            <th>No.</th>
            <th>고객번호</th>
            <th>반려동물이름</th>
            <th>종</th>
            <th>반려동물성별</th>
            <th>기능</th>
        </tr>
        <?
        $row_index = 1;
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>{$row_index}</td>";
            echo "<td>{$row['ahcustomer_id']}</td>";
            echo "<td><a href='pet_view.php?pet_id={$row['pet_id']}'>{$row['pet_name']}</a></td>";
            echo "<td>{$row['pet_specie']}</td>";
            echo "<td>{$row['pet_sex']}</td>";
            echo "<td width='17%'>
                <a href='pet_form.php?pet_id={$row['pet_id']}'><button class='button primary small'>수정</button></a>
                 <button onclick='javascript:deleteConfirm({$row['pet_id']})' class='button danger small'>삭제</button>
                </td>";
            echo "</tr>";
            $row_index++;
        }
        ?>
    </table>
    <script>
        function deleteConfirm(pet_id) {
            if (confirm("정말 삭제하시겠습니까?") == true)
            {window.location = "pet_delete.php?pet_id=" + pet_id;}
            else{   //취소
                return;
            }
        }
    </script>
</div>
<? include("footer.php") ?>
