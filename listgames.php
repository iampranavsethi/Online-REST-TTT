<?php
require_once('config.php');

header('Content-Type: application/json');


if (isset($_COOKIE['ttt-session'])){

	$user = json_decode($_COOKIE['ttt-session'],true);

	$stmt = $conn->prepare("SELECT id, start_date FROM games WHERE user_id = ?");
	$stmt->bind_param("d", $user_id);

	$user_id = $user['id'];

	$stmt -> execute();

	$res = $stmt->get_result();

	$response = array('status' => "OK", 'games' => array());

	while ($row = $res -> fetch_assoc()){
		array_push($response['games'], $row);
	}

	echo json_encode($response, JSON_PRETTY_PRINT);

} else error();



?>