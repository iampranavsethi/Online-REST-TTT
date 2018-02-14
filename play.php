<?php

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

$response = array('winner' => " ", 'grid' => array(" ", " ", " "," ", " ", " "," ", " ", " " ));

$file = fopen("log.txt" ,"a");
fputs($file, "POST\n" . print_r($_POST, true) . "\n");
fputs($file, "GET\n" . print_r($_GET, true) . "\n\n");
fclose($file);

if (isset($_POST['grid'])){
	$response['grid'] = $_POST['grid'];
	if (get_winner($response['grid']) == false){
		$empty = 0;
		for ($i = 0; $i < 9; $i++){
			if ($response['grid'][$i] == " "){
				$empty++;
				if ($empty == 1)
					$response['grid'][$i] = "O";
			}
		}
		if (get_winner($response['grid']) == true)
				$response['winner'] = "O";
	} else 
		$response['winner'] = "X";
}

echo json_encode($response, JSON_PRETTY_PRINT);

?>