<?php

$host = "localhost";
$username = "root";
$password = "root";
$database = "ttt";

$conn = new mysqli($host, $username, $password, $database);

if ($conn -> connect_error)
	die ("cannot connect!" . $conn->connect_error);

function error(){
	echo json_encode(array('status' => "ERROR"), JSON_PRETTY_PRINT);
	exit();
}

function success(){
	echo json_encode(array('status' => "OK"), JSON_PRETTY_PRINT);	
}

function send_email($to){
	$hs = gethostname();
    $subject = "[WP2] Verify TTT Account!";
    
    $link = "http://" . $hs . "/ttt/verify?email=" . $to . "&key=abracadabra";

    $message = "
    <html>
    <head>
    <title>Verify Account!</title>
    </head>
    <body>
    <p>Click here to verify <a href=\"".$link."\"> " . $link . " </a></p><br>
    </body>
    </html>
    ";

    // Always set content-type when sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    // More headers
    $headers .= 'From: <no-reply@'. $hs . '>' .  "\r\n";

    $r = mail($to,$subject,$message,$headers);
    return $r;
}


?>