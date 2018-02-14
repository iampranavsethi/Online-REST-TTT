var winner = " ";
var ttt = [" ", " ", " ", 
			" ", " ", " ",
			" ", " ", " "];

			// x o x o o x o x o 

$(document).ready(function() {
	if ($('.my-table').html() != undefined)
    	console.log( "ready!" );
});


function print_board(board){
	if (board !== null && board !== undefined && board.length == 9){
		var count = 0;
		for (var i = 0; i < 9; i++){
			$("#box-" + (i + 1)).html(ttt[i]);
			if (ttt[i] == "X" || ttt[i] == "O" || winner != " "){
				count++;
				$('#box-' + (i+1)).removeClass("cell-hover");
				$('#box-' + (i+1)).removeAttr("onclick");
			}
		}

		if (count == 9 && winner == " "){
			$(".winner").first().html("It was a Draw!");
		
		} else if (winner != " "){
			$(".winner").first().html( winner + " Won!");	
		}

	} else 
		console.log("Invalid Board Config!");
}

function make_x_move(position){
	if (position > 0 && position < 10 && winner == " "){
		if (ttt[position-1] == " "){
			ttt[position-1] = "X";
			
			$.post("play.php", {grid: ttt}, function(data, err){
				ttt = data.grid
				winner = data.winner;
				print_board(ttt);
			}, "json");
		}
	}
}