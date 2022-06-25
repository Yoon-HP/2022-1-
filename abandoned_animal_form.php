<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수



$conn = dbconnect($host, $dbid, $dbpass, $dbname);

mysqli_query( $connect, 'set autocommit = 0');
mysqli_query( $connect, 'set session transaction isolation level serializable');
mysqli_query( $connect, "start transaction");

$mode = "입력";
$action = "abandoned_animal_insert.php";


$doctor = array();

$query = "select * from doctor";
$result = mysqli_query($conn, $query);

if ($result){
	mysqli_query($connect, "commit");
}else{
	mysqli_query($connect, "rollback");
}
while($row = mysqli_fetch_array($result)) {
	 $doctor[$row['doctor_id']] = $row['doctor_id'];
}


?>
    <div class="container">
        <form name="abandoned_animal_form" action="<?=$action?>" method="post" class="fullwidth">
            <input type="hidden" name="abandoned_animal_id" value="<?=$abandoned_animal['abandoned_animal_id']?>"/>
            <h3> 유기동물 정보 <?=$mode?></h3>
            <p>
                <label for="doctor_id">수의사번호</label>
                <select name="doctor_id" id="doctor_id">
                    <option value="-1">선택해 주십시오.</option>
                    <?
                        foreach($doctor as $id => $name) {
                            if($id == $abandoned_animal['doctor_id']){
                                echo "<option value='{$id}' selected>{$name}</option>";
                            } else {
                                echo "<option value='{$id}'>{$name}</option>";
                            }
                        }
                    ?>
                </select>
            </p>
            <p>
                <label for="abandoned_animal_name">유기동물이름</label>
                <input type="text" placeholder="유기동물이름 입력" id="abandoned_animal_name" name="abandoned_animal_name" value="<?=$abandoned_animal['abandoned_animal_name']?>"/>
            </p>
            <p>
                <label for="abandoned_animal_age">유기동물나이</label>
                <input type="text" placeholder="유기동물나이 입력" id="abandoned_animal_age" name="abandoned_animal_age" value="<?=$abandoned_animal['abandoned_animal_age']?>"/>
            </p>
            <p>
                <label for="abandoned_animal_weight">유기동물무게</label>
                <input type="text" placeholder="유기동물무게 입력" id="abandoned_animal_weight" name="abandoned_animal_weight" value="<?=$abandoned_animal['abandoned_animal_weight']?>"/>
            </p>
            <p>
                <label for="abandoned_animal_specie">유기동물종</label>
                <input type="text" placeholder="유기동물종 입력" id="abandoned_animal_specie" name="abandoned_animal_specie" value="<?=$abandoned_animal['abandoned_animal_specie']?>"/>
            </p>
            <p>
                <label for="abandoned_animal_sex">유기동물성별</label>
                <input type="text" placeholder="유기동물성별 입력" id="abandoned_animal_sex" name="abandoned_animal_sex" value="<?=$abandoned_animal['abandoned_animal_sex']?>"/>
            </p>

            <p align="center"><button class="button primary large" onclick="javascript:return validate3();"><?=$mode?></button></p>
            <script>
                function validate3() {
                    if(document.getElementById("doctor_id").value == "-1") {
                        alert ("수의사번호를 선택해 주십시오"); return false;
                    }
                    else if(document.getElementById("abandoned_animal_name").value == "") {
                        alert ("유기동물 이름을 입력해 주십시오"); return false;
                    }
                    else if(document.getElementById("abandoned_animal_age").value == "") {
                        alert ("유기동물 나이를 입력해 주십시오"); return false;
                    }
                    else if(document.getElementById("abandoned_animal_weight").value == "") {
                        alert ("유기동물 무게를 입력해 주십시오"); return false;
                    }
                    else if(document.getElementById("abandoned_animal_specie").value == "") {
                        alert ("유기동물 종을 입력해 주십시오"); return false;
                    }
                    else if(document.getElementById("abandoned_animal_sex").value == "") {
                        alert ("유기동물 성별을 입력해 주십시오"); return false;
                    }
                    return true;
                }
            </script>

        </form>
    </div>
<? include("footer.php") ?>