<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);

mysqli_query( $connect, 'set autocommit = 0');
mysqli_query( $connect, 'set session transaction isolation level serializable');
mysqli_query( $connect, "start transaction");

$mode = "입력";
$action = "pet_insert.php";

if (array_key_exists("pet_id", $_GET)) {
    $pet_id = $_GET["pet_id"];
    $query =  "select * from pet where pet_id = $pet_id";
    $result = mysqli_query($conn, $query);
    
    if(!$result){
    	mysqli_query($connect, "rollback");
    }
    
    $pet = mysqli_fetch_array($result);
    if(!$pet) {
        msg("반려동물이 존재하지 않습니다.");
    }
    $mode = "수정";
    $action = "pet_modify.php";
}

$ahcustomer = array();

$query = "select * from ahcustomer";
$result = mysqli_query($conn, $query);

if(!$result){
	mysqli_query($connect, "rollback");
}

while($row = mysqli_fetch_array($result)) {
    $ahcustomer[$row['ahcustomer_id']] = $row['ahcustomer_id'];
}

mysqli_query($connect, "commit");
?>
    <div class="container">
        <form name="pet_form" action="<?=$action?>" method="post" class="fullwidth">
            <input type="hidden" name="pet_id" value="<?=$pet['pet_id']?>"/>
            <h3> 반려동물 정보 <?=$mode?></h3>
            <p>
                <label for="ahcustomer_id">고객번호</label>
                <select name="ahcustomer_id" id="ahcustomer_id">
                    <option value="-1">선택해 주십시오.</option>
                    <?
                        foreach($ahcustomer as $id => $name) {
                            if($id == $pet['ahcustomer_id']){
                                echo "<option value='{$id}' selected>{$name}</option>";
                            } else {
                                echo "<option value='{$id}'>{$name}</option>";
                            }
                        }
                    ?>
                </select>
            </p>
            <p>
                <label for="pet_name">반려동물이름</label>
                <input type="text" placeholder="반려동물이름 입력" id="pet_name" name="pet_name" value="<?=$pet['pet_name']?>"/>
            </p>
            <p>
                <label for="pet_age">반려동물나이</label>
                <input type="text" placeholder="반려동물나이 입력" id="pet_age" name="pet_age" value="<?=$pet['pet_age']?>"/>
            </p>
            <p>
                <label for="pet_weight">반려동물무게</label>
                <input type="text" placeholder="반려동물무게 입력" id="pet_weight" name="pet_weight" value="<?=$pet['pet_weight']?>"/>
            </p>
            <p>
                <label for="pet_specie">반려동물종</label>
                <input type="text" placeholder="반려동물종 입력" id="pet_specie" name="pet_specie" value="<?=$pet['pet_specie']?>"/>
            </p>
            <p>
                <label for="pet_sex">반려동물성별</label>
                <input type="text" placeholder="반려동물성별 입력" id="pet_sex" name="pet_sex" value="<?=$pet['pet_sex']?>"/>
            </p>

            <p align="center"><button class="button primary large" onclick="javascript:return validate();"><?=$mode?></button></p>

            <script>
                function validate() {
                    if(document.getElementById("ahcustomer_id").value == "-1") {
                        alert ("고객번호를 선택해 주십시오"); return false;
                    }
                    else if(document.getElementById("pet_name").value == "") {
                        alert ("반려동물 이름을 입력해 주십시오"); return false;
                    }
                    else if(document.getElementById("pet_age").value == "") {
                        alert ("반려동물 나이를 입력해 주십시오"); return false;
                    }
                    else if(document.getElementById("pet_weight").value == "") {
                        alert ("반려동물 무게를 입력해 주십시오"); return false;
                    }
                    else if(document.getElementById("pet_specie").value == "") {
                        alert ("반려동물 종을 입력해 주십시오"); return false;
                    }
                    else if(document.getElementById("pet_sex").value == "") {
                        alert ("반려동물 성별을 입력해 주십시오"); return false;
                    }
                    return true;
                }
            </script>

        </form>
    </div>
<? include("footer.php") ?>