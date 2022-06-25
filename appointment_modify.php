<?
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

mysqli_query( $connect, 'set autocommit = 0');
mysqli_query( $connect, 'set session transaction isolation level serializable');
mysqli_query( $connect, "start transaction");

$doctor_id = $_POST['doctor_id'];
$ahcustomer_id = $_POST['ahcustomer_id'];
$appointment_daytime = $_POST['appointment_daytime'];
$app_id=$_POST['app_id'];


$result = mysqli_query($conn, "update appointment set doctor_id = $doctor_id, ahcustomer_id = $ahcustomer_id, appointment_daytime = '$appointment_daytime' where app_id = $app_id");

if(!$result)
{
	mysqli_query($connect, "rollback");
    s_msg ('수정이 실패하였습니다.');
    echo "<script>location.replace('appointment_list.php');</script>";
}
else
{
	mysqli_query($connect, "commit");
    s_msg ('성공적으로 수정 되었습니다');
    echo "<script>location.replace('appointment_list.php');</script>";
}

?>