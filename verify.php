<?php
require_once('config.php');

header('Content-Type: application/json');
$email = "";
$key = "";

if (isset($_GET)){
	$email = $_GET['email'];
	$key = $_GET['key'];
} 
else {
	$data = file_get_contents("php://input");
	$data = json_decode($data, true);
	if (empty($data)) error();

	$email = $data['email'];
	$key = $data['key'];
}

if ($key == "abracadabra"){
	$stmt = $conn->prepare("UPDATE users SET email_verified = '1' WHERE email = ?");
	$stmt->bind_param("s", $_email);

	$_email = $email;

	if (!$stmt -> execute()){
		error();
	}
	success();
} else error();



?>