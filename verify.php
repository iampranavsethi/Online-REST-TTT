<?php
require_once('config.php');

header('Content-Type: application/json');
$email = "";
$key = "";

if (isset($_GET) && !empty($_GET['email'])){
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

// if ($key == "abracadabra"){
	$stmt = $conn->prepare("UPDATE users SET email_verified = '1' WHERE email = ? AND key =  ? ");
	$stmt->bind_param("ss", $_email, $_key);

	$_email = $email;
	$_key = $key;

	$res = $stmt -> execute();
	
	if (!$res || $res->num_rows == 0)
		error();

	success();
// } else error();



?>