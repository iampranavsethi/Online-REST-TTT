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

function get_current_game($user_id){
start:
	$stmt = $conn->prepare("SELECT * FROM games WHERE user_id = ? AND game_state = '0' LIMIT 1");
	$stmt->bind_param("d", $uid);
	$uid = $user_id;
	$stmt -> execute();
	$res = $stmt->get_result();

	if ($res -> num_rows == 0){
		$stmt = $conn->prepare("INSERT INTO games (user_id, board_state, game_state, start_date) VALUES (?,?,?,?));
		$stmt->bind_param("ssss", $uid, $bs, $gs, $sd);
		$uid = $user_id;
		$bs = urlencode(serialize(array(" ", " ", " "," ", " ", " "," ", " ", " ")));
		$gs = 0;
		$stmt -> execute();
		goto start;
	}

	while ($row = $res->fetch_assoc()){
		setcookie('ttt-game', json_encode($row), (time() + 86400) , "/");
		return json_encode($row);
	}	
}

function terminate_game($game_id, $winner){
	$stmt = $conn->prepare("UPDATE game SET game_state = '1' AND winner = ?  WHERE id = ?");
	$stmt->bind_param("sd", $w, $gid);
	$gid = $game_id;
	$w = $winner;
	$stmt -> execute();
	setcookie('ttt-game', "", (time() - 86400), "/");
}

?>