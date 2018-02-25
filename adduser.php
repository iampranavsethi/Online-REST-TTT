<?php
require_once('config.php');

header('Content-Type: application/json');

$data = file_get_contents("php://input");
$data = json_decode($data, true);

if (!empty($data) && isset($data['username']) && isset($data['password']) && isset($data['email']) ){

	$stmt = $conn->prepare("INSERT INTO users (username, password, email, key__) VALUES (?, ?, ?, ?)");
	$stmt->bind_param("sss", $username, $password, $email, $key);

	$username = $data['username'];
	$password = $data['password'];
	$email = $data['email'];
	$key = uniqid('', true);

	if (!$stmt -> execute())
		error();
	else {
		send_email($data['email'],$key);
		success();
	}

} else error();



?>