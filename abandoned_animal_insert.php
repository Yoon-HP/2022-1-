<?
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수


$conn = dbconnect($host,$dbid,$dbpass,$dbname);

mysqli_query( $connect, 'set autocommit = 0');
mysqli_query( $connect, 'set session transaction isolation level serializable');
mysqli_query( $connect, "start transaction");

$abandoned_animal_name = $_POST['abandoned_animal_name'];
$abandoned_animal_age = $_POST['abandoned_animal_age'];
$abandoned_animal_weight = $_POST['abandoned_animal_weight'];
$abandoned_animal_specie = $_POST['abandoned_animal_specie'];
$abandoned_animal_sex = $_POST['abandoned_animal_sex'];
$doctor_id = $_POST['doctor_id'];

if ($abandoned_animal_weight>=10){
	$room_id=1;
}else if ($abandoned_animal_weight>=5){
	$room_id=2;
}else{
	$room_id=3;
}


$query1 = "select room_capacity from room where room_id={$room_id}";
$result1 = mysqli_query($conn, $query1);

if ($result1){
	$row=mysqli_fetch_array($result1);
	$room_capacity=$row['room_capacity'];
	
	if ($room_capacity>0){

		$result = mysqli_query($conn, "insert into abandoned_animal (doctor_id, room_id, protection_start_day,abandoned_animal_name,abandoned_animal_age,
	abandoned_animal_weight,abandoned_animal_specie,abandoned_animal_sex) values($doctor_id, $room_id, now(), '$abandoned_animal_name',
	$abandoned_animal_age, $abandoned_animal_weight,'$abandoned_animal_specie', '$abandoned_animal_sex')");
	
		if (!$result){
			mysqli_query($connect, "rollback");
			s_msg ('등록에 실패하였습니다.');
			echo "<script>location.replace('abandoned_animal_list.php');</script>";
		}
		
		$query2 = "update room set room_capacity=room_capacity-1 where room_id={$room_id}";
		$result2 = mysqli_query($conn, $query2);
		
		if (!$result){
			mysqli_query($connect, "rollback");
			s_msg ('등록에 실패하였습니다.');
			echo "<script>location.replace('abandoned_animal_list.php');</script>";
		}
		
		mysqli_query($connect, "commit");
		s_msg ('성공적으로 등록 되었습니다');
	    echo "<script>location.replace('abandoned_animal_list.php');</script>";
	}else{
		msg('해당 무게가 나가는 유기동물을 수용할 보호실이 없습니다'.mysqli_error($conn));
		mysqli_query($connect, "rollback");
		echo "<script>location.replace('abandoned_animal_list.php');</script>";
	}
}else{
	mysqli_query($connect, "rollback");
	s_msg ('등록에 실패하였습니다.');
	echo "<script>location.replace('abandoned_animal_list.php');</script>";
}

?>

