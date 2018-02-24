<?php
require_once('config.php');

header('Content-Type: application/json');


if (isset($_COOKIE['ttt-session'])){

	$user = json_decode($_COOKIE['ttt-session'],true);

	$stmt = $conn->prepare("SELECT id, winner FROM games WHERE user_id = ? AND game_state = '1'");
	$stmt->bind_param("d", $user_id);

	$user_id = $user['id'];

	$stmt -> execute();

	$res = $stmt->get_result();

	$response = array('status' => "OK", 'human' => 0, 'wopr' => 0, 'tie' => 0);

	while ($row = $res -> fetch_assoc()){
		if (!is_null($row['winner'])){
			(empty($row['winner']) || $row['winner'] == " ") ? $response['tie']++ : ($row['winner'] == 'X' ? $response['human']++ : $response['wopr']++);
		}
	}

	echo json_encode($response, JSON_PRETTY_PRINT);

} else error();



?>