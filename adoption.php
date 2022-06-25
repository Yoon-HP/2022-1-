<?
include "config.php";
include "util.php";
?>

<div class="container">

    <?
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);
    
    mysqli_query( $connect, 'set autocommit = 0');
	mysqli_query( $connect, 'set session transaction isolation level serializable');
	mysqli_query( $connect, "start transaction");
	
    $ahcustomer_id = $_POST['ahcustomer_id'];
    
    $available_insert = check_id($conn, $ahcustomer_id);
    if ($available_insert){
        foreach($_POST['abandoned_animal_id'] as $abid){
            $query = "update room set room_capacity=room_capacity+1 where room_id in (select room_id from abandoned_animal where abandoned_animal_id =$abid)";
            $result = mysqli_query($conn, $query);
            
            if (!$result){
            	mysqli_query($connect, "rollback");
		    	msg('입양이 실패했습니다. 다시 시도해주세요. ');
				echo "<script>location.replace('adoption_list.php');</script>";
            }
            // insert data into adoption table.
            $query1 = "insert into adoption (ahcustomer_id, abandoned_animal_id, adoption_day) values ($ahcustomer_id,$abid,now())";
        	$result3=mysqli_query($conn, $query1);
        	
        	if (!$result3){
        		mysqli_query($connect, "rollback");
		    	msg('입양이 실패했습니다. 다시 시도해주세요. ');
				echo "<script>location.replace('adoption_list.php');</script>";
        	}
    		// insert data into pet table.
        	$query2 = "select * from abandoned_animal where abandoned_animal_id=$abid";
    		$result1 = mysqli_query($conn, $query2);
    		
    		if(!$result1){
    			mysqli_query($connect, "rollback");
		    	msg('입양이 실패했습니다. 다시 시도해주세요. ');
				echo "<script>location.replace('adoption_list.php');</script>";
    		}
    		
    		$row=mysqli_fetch_array($result1);
            $query3 = "insert into pet (ahcustomer_id,pet_name,pet_age,pet_weight,pet_specie,pet_sex) values
            ($ahcustomer_id,'{$row['abandoned_animal_name']}',{$row['abandoned_animal_age']},{$row['abandoned_animal_weight']},
            '{$row['abandoned_animal_specie']}','{$row['abandoned_animal_sex']}')";
            $result4=mysqli_query($conn, $query3);
            
            if (!$result4){
            	mysqli_query($connect, "rollback");
		    	msg('입양이 실패했습니다. 다시 시도해주세요. ');
				echo "<script>location.replace('adoption_list.php');</script>";
            }
        }
        mysqli_query($connect, "commit");
        s_msg('입양이 완료되었습니다');
        echo "<script>location.replace('adoption_list.php');</script>";
    }
    else{
    	mysqli_query($connect, "rollback");
    	msg('등록되지 않은 고객입니다.');
		echo "<script>location.replace('adoption_list.php');</script>";
       
    }
    ?>

</div>

