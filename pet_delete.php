<?
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

mysqli_query( $connect, 'set autocommit = 0');
mysqli_query( $connect, 'set session transaction isolation level serializable');
mysqli_query( $connect, "start transaction");

$pet_id = $_GET['pet_id'];

$result = mysqli_query($conn, "select pet_id from pet where pet_id = $pet_id");

if(mysqli_fetch_array($result)){
	$ret = mysqli_query($conn, "delete from pet where pet_id = $pet_id");

	if(!$ret)
	{
		mysqli_query($connect, "rollback");
		s_msg ('삭제에 실패하였습니다.');
	    echo "<meta http-equiv='refresh' content='0;url=pet_list.php'>";
	}
	else
	{
		mysqli_query($connect, "commit");
	    s_msg ('성공적으로 삭제 되었습니다');
	    echo "<meta http-equiv='refresh' content='0;url=pet_list.php'>";
	}	
}
else{
	mysqli_query($connect, "rollback");
	s_msg ('존재하지 않는 반려동물이므로 삭제할 수 없습니다.');
    echo "<meta http-equiv='refresh' content='0;url=pet_list.php'>";
}

?>

