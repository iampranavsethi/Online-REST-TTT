<?php
error_reporting(0);

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

header('Content-Type: application/json');

$response = array('grid' => array(" ", " ", " "," ", " ", " "," ", " ", " " ), 'winner' => " ");

$data = file_get_contents("php://input");
$data = json_decode($data, true);
$response['grid'] = $data['grid'];

if ($data['grid']){
	if (get_winner($response['grid']) == false){
		for ($i = 0; $i < 9; $i++){
			if ($response['grid'][$i] == " "){
				$response['grid'][$i] = "O";
				break;
			}
		}
		if (get_winner($response['grid']) == true)
				$response['winner'] = "O";
	} else 
		$response['winner'] = "X";
}

echo json_encode($response, JSON_PRETTY_PRINT);

?>