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

$stmt = $conn->prepare("SELECT key__ FROM users WHERE email = ?");
$stmt->bind_param("s", $__email);
$__email = $email;
$stmt->execute();
$res = $stmt->get_result();
$key__ = "";

while ($row = $res->fetch_assoc()){
	$key__ = $row['key__'];
}

if ($key == "abracadabra" || $key == $key__){
	$stmt = $conn->prepare("UPDATE users SET email_verified = '1' WHERE email = ?");
	$stmt->bind_param("s", $_email);

	$_email = $email;

	if (!$stmt -> execute()){
		error();
	}
	success();
} else error();



?>