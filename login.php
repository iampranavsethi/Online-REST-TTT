<?php
require_once('config.php');

header('Content-Type: application/json');

$data = file_get_contents("php://input");
$data = json_decode($data, true);

if (!empty($data) && isset($data['username']) && isset($data['password'])){

	$stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ? AND email_verified = '1' LIMIT 1");
	$stmt->bind_param("ss", $username, $password);

	$username = $data['username'];
	$password = $data['password'];

	$s = $stmt -> execute();

	if ($s->rowCount() == 0){
		error();
	}

	$res = $stmt->get_result();

	while ($row = $res -> fetch_assoc()){
		setcookie("ttt-session", json_encode($row), time() + 86400);
	}

	success();

} else error();



?>