<?
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

mysqli_query( $connect, 'set autocommit = 0');
mysqli_query( $connect, 'set session transaction isolation level serializable');
mysqli_query( $connect, "start transaction");

$pet_id=$_POST['pet_id'];
$pet_name = $_POST['pet_name'];
$pet_age = $_POST['pet_age'];
$pet_weight = $_POST['pet_weight'];
$pet_specie = $_POST['pet_specie'];
$pet_sex = $_POST['pet_sex'];
$ahcustomer_id = $_POST['ahcustomer_id'];

$result = mysqli_query($conn, "update pet set pet_name = '$pet_name', pet_age = $pet_age, ahcustomer_id = $ahcustomer_id,
pet_weight= $pet_weight, pet_specie= '$pet_specie', pet_sex='$pet_sex' where pet_id = $pet_id");

if(!$result)
{
	mysqli_query($connect, "rollback");
    s_msg ('수정에 실패하였습니다.');
    echo "<script>location.replace('pet_list.php');</script>";
}
else
{
	mysqli_query($connect, "commit");
    s_msg ('성공적으로 수정 되었습니다');
    echo "<script>location.replace('pet_list.php');</script>";
}

?>

