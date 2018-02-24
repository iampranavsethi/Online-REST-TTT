<?php
require_once('config.php');

header('Content-Type: application/json');

$data = file_get_contents("php://input");
$data = json_decode($data, true);

if (isset($_COOKIE['ttt-session']) && !empty($data['id']) ){

	$user = json_decode($_COOKIE['ttt-session'],true);

	$stmt = $conn->prepare("SELECT id, winner, board_state FROM games WHERE user_id = ? AND id = ?");
	$stmt->bind_param("dd", $user_id, $game_id);

	$user_id = $user['id'];
	$game_id = $data['id'];

	$stmt -> execute();

	$res = $stmt->get_result();

	$response = array('status' => "OK", 'grid' => array(), 'winner' => " ");

	while ($row = $res -> fetch_assoc()){
		$response['grid'] = unserialize(($row['board_state']));
		$response['winner'] = $row['winner'];
	}

	echo json_encode($response, JSON_PRETTY_PRINT);

} else error();



?>