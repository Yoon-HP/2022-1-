<!DOCTYPE html>
<html lang='ko'>
<head>
    <title>Peace-animal hospital</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<form action="pet_list.php" method="post">
    <div class='navbar fixed'>
        <div class='container'>
            <a class='pull-left title' href="index.php">Peace-animal hospital</a>
            <ul class='pull-right'>
                <li>
                    <input type="text" name="search_keyword" placeholder="반려동물 통합검색">
                </li>
                <li><a href='pet_list.php'>반려동물목록</a></li>
                <li><a href='pet_form.php'>반려동물정보등록</a></li>
                <li><a href='abandoned_animal_form.php'>유기동물정보등록</a></li>
                <li><a href='abandoned_animal_list.php'>유기동물목록</a></li>
                <li><a href='ahcustomer_list.php'>고객정보조회</a></li>
                <li><a href='treatment_list.php'>진료목록</a></li>
                <li><a href='appointment_list.php'>예약목록</a></li>
                <li><a href='appointment_form.php'>예약신청</a></li>
                <li><a href='adoption_form.php'>입양 신청</a></li>
                <li><a href='adoption_list.php'>입양 목록</a></li>
                <li><a href='room_list.php'>보호실 조회</a></li>
                <li><a href='doctor_list.php'>수의사 조회</a></li>
                <li><a href='peace_ah_db.php'>Peace-ah DB</a></li>
            </ul>
        </div>
    </div>
</form>