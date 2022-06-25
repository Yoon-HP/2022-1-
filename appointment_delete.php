<?
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

mysqli_query( $connect, 'set autocommit = 0');
mysqli_query( $connect, 'set session transaction isolation level serializable');
mysqli_query( $connect, "start transaction");

$app_id = $_GET['app_id'];

$result = mysqli_query($conn, "select app_id from appointment where app_id = $app_id");

if(mysqli_fetch_array($result)){
	$ret = mysqli_query($conn, "delete from appointment where app_id = $app_id");

	if(!$ret)
	{
		mysqli_query($connect, "rollback");
		s_msg ('삭제에 실패했습니다. 다시 시도해주세요');
	    echo "<meta http-equiv='refresh' content='0;url=appointment_list.php'>";
	}
	else
	{	
		mysqli_query($connect, "commit");
	    s_msg ('성공적으로 삭제 되었습니다');
	    echo "<meta http-equiv='refresh' content='0;url=appointment_list.php'>";
	}	
}
else{
	mysqli_query($connect, "rollback");
	s_msg ('존재하지 않는 예약이므로 삭제할 수 없습니다.');
    echo "<meta http-equiv='refresh' content='0;url=appointment_list.php'>";
}

?>
