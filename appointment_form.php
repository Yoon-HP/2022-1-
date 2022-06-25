<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);

mysqli_query( $connect, 'set autocommit = 0');
mysqli_query( $connect, 'set session transaction isolation level serializable');
mysqli_query( $connect, "start transaction");

$mode = "신청";
$action = "appointment_insert.php";

if (array_key_exists("app_id", $_GET)) {
    $app_id = $_GET["app_id"];
    $query =  "select * from appointment where app_id = $app_id";
    $result = mysqli_query($conn, $query);
    
    if(!$result){
    	mysqli_query($connect, "rollback");	
    }
    
    $appointment = mysqli_fetch_array($result);
    if(!$appointment) {
        msg("예약이 존재하지 않습니다.");
    }
    $mode = "수정";
    $action = "appointment_modify.php";
}

$ahcustomer = array();
$doctor = array();


$query = "select * from ahcustomer";
$result = mysqli_query($conn, $query);

if (!$result){
	mysqli_query($connect, "rollback");
}

while($row = mysqli_fetch_array($result)) {
    $ahcustomer[$row['ahcustomer_id']] = $row['ahcustomer_id'];
}
$query1 = "select * from doctor";
$result1 = mysqli_query($conn, $query1);

if (!$result1){
	mysqli_query($connect, "rollback");
}

while($row = mysqli_fetch_array($result1)) {
    $doctor[$row['doctor_id']] = $row['doctor_id'];
}

mysqli_query($connect, "commit");

?>
    <div class="container">
        <form name="appointment_form" action="<?=$action?>" method="post" class="fullwidth">
            <input type="hidden" name="app_id" value="<?=$appointment['app_id']?>"/>
            <h3> 예약 <?=$mode?></h3>
            <p>
                <label for="ahcustomer_id">고객번호</label>
                <select name="ahcustomer_id" id="ahcustomer_id">
                    <option value="-1">선택해 주십시오.</option>
                    <?
                        foreach($ahcustomer as $id => $name) {
                            if($id == $appointment['ahcustomer_id']){
                                echo "<option value='{$id}' selected>{$name}</option>";
                            } else {
                                echo "<option value='{$id}'>{$name}</option>";
                            }
                        }
                    ?>
                </select>
            </p>
            <p>
                <label for="doctor_id">수의사번호</label>
                <select name="doctor_id" id="doctor_id">
                    <option value="-1">선택해 주십시오.</option>
                    <?
                        foreach($doctor as $id => $name) {
                            if($id == $appointment['doctor_id']){
                                echo "<option value='{$id}' selected>{$name}</option>";
                            } else {
                                echo "<option value='{$id}'>{$name}</option>";
                            }
                        }
                    ?>
                </select>
            </p>
            <p>
                <label for="appointment_daytime">예약날짜 및 시간</label>
                <input type="text" placeholder="예약날짜 및 시간" id="appointment_daytime" name="appointment_daytime" value="<?=$appointment['appointment_daytime']?>"/>

            <p align="center"><button class="button primary large" onclick="javascript:return validate1();"><?=$mode?></button></p>

            <script>
            	var datetime = /([0-2][0-9]{3})-([0-1][0-9])-([0-3][0-9]) ([0-5][0-9]):([0-5][0-9]):([0-5][0-9])(([\-\+]([0-1][0-9])\:00))?/;
                function validate1() {
                    if(document.getElementById("ahcustomer_id").value == "-1") {
                        alert ("고객번호를 선택해 주십시오"); return false;
                    }
                    else if(document.getElementById("doctor_id").value == "-1") {
                        alert ("수의사번호를 선택해 주십시오"); return false;
                    }
   
                    else if (!datetime.test((document.getElementById("appointment_daytime").value))){
                        alert ("yyyy-mm-dd hh:mm:ss 형식으로 입력해주세요."); return false;
                    }
                    else{
                    	var now=new Date();
                    	var appointment_time=new Date((document.getElementById("appointment_daytime").value));
                    	if (now>=appointment_time){
                    		alert ("미래의 시간을 입력해주세요."); return false;
                    	}
                    }
                    return true;
                }
            </script>

        </form>
    </div>
<? include("footer.php") ?>