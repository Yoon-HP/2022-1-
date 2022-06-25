<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);

mysqli_query( $connect, 'set autocommit = 0');
mysqli_query( $connect, 'set session transaction isolation level serializable');
mysqli_query( $connect, "start transaction");

if (array_key_exists("pet_id", $_GET)) {
    $pet_id = $_GET["pet_id"];
    $query = "select * from pet where pet_id = $pet_id";
    $result = mysqli_query($conn, $query);
    
    if(!$result){
    	mysqli_query($connect, "rollback");
    }else{
    	mysqli_query($connect, "commit");
    }
    
    $pet = mysqli_fetch_assoc($result);
    if (!$pet) {
        msg("반려동물이 존재하지 않습니다.");
    }
}
?>
    <div class="container fullwidth">

        <h3>반려동물 정보 상세 보기</h3>

        <p>
            <label for="pet_id">반려동물 번호</label>
            <input readonly type="text" id="pet_id" name="pet_id" value="<?= $pet['pet_id'] ?>"/>
        </p>

        <p>
            <label for="ahcustomer_id">고객 번호</label>
            <input readonly type="text" id="ahcustomer_id" name="ahcustomer_id" value="<?= $pet['ahcustomer_id'] ?>"/>
        </p>

        <p>
            <label for="pet_name">반려동물 이름</label>
            <input readonly type="text" id="pet_name" name="pet_name" value="<?= $pet['pet_name'] ?>"/>
        </p>
		
		<p>
            <label for="pet_age">반려동물 나이</label>
            <input readonly type="text" id="pet_age" name="pet_age" value="<?= $pet['pet_age'] ?>"/>
        </p>
        
        <p>
            <label for="pet_weight">반려동물 무게</label>
            <input readonly type="text" id="pet_weight" name="pet_weight" value="<?= $pet['pet_weight'] ?>"/>
        </p>
        
        <p>
            <label for="pet_specie">반려동물 종</label>
            <input readonly type="text" id="pet_specie" name="pet_specie" value="<?= $pet['pet_specie'] ?>"/>
        </p>
        
        <p>
            <label for="pet_sex">반려동물 성별</label>
            <input readonly type="text" id="pet_sex" name="pet_sex" value="<?= $pet['pet_sex'] ?>"/>
        </p>

    </div>
<? include "footer.php" ?>