<?php
//error_reporting(0);
require_once('../config.php');

function get_winner($grid){
	// row 
	if ($grid[0] == $grid[1] && $grid[1] != " " && $grid[1] == $grid[2])
		return true;
	if ($grid[3] == $grid[4] && $grid[4] != " " && $grid[4] == $grid[5])
		return true;
	if ($grid[6] == $grid[7] && $grid[7] != " " && $grid[7] == $grid[8])
		return true;

	// col
	if ($grid[0] == $grid[3] && $grid[3] != " " && $grid[3] == $grid[6])
		return true;
	if ($grid[1] == $grid[4] && $grid[4] != " " && $grid[4] == $grid[7])
		return true;
	if ($grid[2] == $grid[5] && $grid[5] != " " && $grid[5] == $grid[8])
		return true;

	// main diag
	if ($grid[0] == $grid[4] && $grid[4] != " " && $grid[4] == $grid[8])
		return true;

	// anti diag
	if ($grid[2] == $grid[4] && $grid[4] != " " && $grid[4] == $grid[6])
		return true;

	return false;
}

// header('Content-Type: application/json');

$response = array('grid' => array(" ", " ", " "," ", " ", " "," ", " ", " " ), 'winner' => " ");

if (isset($_COOKIE['ttt-session'])){

	$session = json_decode($_COOKIE['ttt-session'], true);

	$data = file_get_contents("php://input");
	$data = json_decode($data, true);

	$move = -1;

	if (array_key_exists('move', $data)){
		$move = $data['move'];
	} else {
		error();
	}

	$game = array();
	if (isset($_COOKIE['ttt-game'])){
		$game = json_decode($_COOKIE['ttt-game'], true);

	} else {
		$stmt = $conn->prepare("SELECT * FROM games WHERE user_id = ? AND game_state = 0 LIMIT 1");
		$stmt->bind_param("d", $uid);
		$uid = $session['id'];
		$stmt -> execute();
		$res = $stmt->get_result();

		if ($res -> num_rows == 0){
			$stmt = $conn->prepare("INSERT INTO games (user_id, board_state, game_state, start_date) VALUES (?,?,?,?)");
			$stmt->bind_param("dsds", $uid, $bs, $gs, $sd);
			$uid = $session['id'];
			$bs = json_encode(array(" ", " ", " "," ", " ", " "," ", " ", " "));
			$gs = 0;
			$sd = date("Y-m-d H:i:s"); 
			$stmt -> execute();
		
			$stmt = $conn->prepare("SELECT * FROM games WHERE user_id = ? AND game_state = 0 LIMIT 1");
			$stmt->bind_param("d", $uid);
			$uid = $session['id'];
			$stmt -> execute();
			$res = $stmt->get_result();
		}
		
		while ($row = $res->fetch_assoc()){
			// setcookie('ttt-game', json_encode($row), (time() + 86400) , "/");
			$game = json_encode($row);
		}	
		
		$game = json_decode($game, true);
	}

	$grid = json_decode($game['board_state'], true) ;

	if (is_null($move)){
		$response['grid'] = $grid;
		$response['winner'] = is_null($game['winner'])? " " :  $game['winner'];
		echo json_encode($response, JSON_PRETTY_PRINT);
		exit();
	}

	// possible error prone zone
	if ($grid[$move] != " "){
		error();
	}

	$grid[$move] = "X";
	$response['grid'] = $grid;

	if (get_winner($response['grid']) == false){
		$i = -1;
		for ($i = 0; $i < 9; $i++){
			if ($response['grid'][$i] == " "){
				$response['grid'][$i] = "O";
				break;
			}
		}
		if (get_winner($response['grid']) == true){


				$response['winner'] = "O";
				$stmt = $conn->prepare("UPDATE games SET game_state = 1, winner = ?  WHERE id = ?");
				$stmt->bind_param("sd", $w, $gid);
				$gid = $game['id'];
				$w = $response['winner'];
				$stmt -> execute();
				// setcookie('ttt-game', "", (time() - 86400), "/");
		}

		else if ($i == 9 && $response['winner'] == " "){


			$stmt = $conn->prepare("UPDATE games SET game_state = 1, winner = ?  WHERE id = ?");
			$stmt->bind_param("sd", $w, $gid);
			$gid = $game['id'];
			$w = " ";
			$stmt -> execute();
			// setcookie('ttt-game', "", (time() - 86400), "/");
		}

		else {


			$stmt = $conn->prepare("UPDATE games SET board_state = ? WHERE id = ?" );
			$stmt->bind_param("sd", $board, $gid);
			// $board = ;
			$board = json_encode($response['grid']);
			// echo $board;
			$gid = $game['id'];
			$stmt -> execute();
		}

	} else {

		$response['winner'] = "X";
		$stmt = $conn->prepare("UPDATE games SET game_state = 1, board_state = ?,  winner = ?  WHERE id = ?");
		$stmt->bind_param("ssd", $board, $w, $gid);
		$board = json_encode($response['grid']);
		$w = $response['winner'];
		$gid = $game['id'];
		$stmt -> execute();
		// setcookie('ttt-game', "", (time() - 86400), "/");
	}


	echo json_encode($response, JSON_PRETTY_PRINT);

} else error();
?>