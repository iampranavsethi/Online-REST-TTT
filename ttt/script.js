var winner = " ";
var ttt = [" ", " ", " ", 
			" ", " ", " ",
			" ", " ", " "];

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
			$.ajax({
				'type': 'POST',
				'url': 'http://psethi.cse356.compas.cs.stonybrook.edu/ttt/play',
				'data': JSON.stringify({"move": (position-1)}),
				'contentType': 'application/json'
			}).done(function(data){
				ttt = data.grid;
				winner = data.winner;
				print_board(ttt);
			}).fail(function(err){
				console.log(err);
			});
		}
	}
}

function login(){

	var password = $('#pwd').val();
	var username = $('#uname').val();

	console.log (password + username);

	$.ajax({
		'type': 'POST',
		'url': 'http://psethi.cse356.compas.cs.stonybrook.edu/login',
		'data': JSON.stringify({"username": username, "password": password}),
		'contentType': 'application/json'
	}).done(function(data){
		console.log(data);
		if (data.status == "OK")
			return true;
		else {
			console.log(data);
			return false;
		}
	}).fail(function(err){

	});
}

function signup(){

	var password = $('#pwd_').val();
	var username = $('#uname_').val();;
	var email = $('#email').val();

	console.log (password + username + email);

	$.ajax({
		'type': 'POST',
		'url': 'http://psethi.cse356.compas.cs.stonybrook.edu/adduser',
		'data': JSON.stringify({"username": username, "password": password, "email": email}),
		'contentType': 'application/json'
	}).done(function(data){
		console.log(data);
		if (data.status == "OK")
			alert("Verify Email and login!");
		else{
			console.log(data);
			return false;
		}
	}).fail(function(err){

	});

	return false;
}

function load_board(){
	$.ajax({
		'type': 'POST',
		'url': 'http://psethi.cse356.compas.cs.stonybrook.edu/ttt/play',
		'data': JSON.stringify({"move": null}),
		'contentType': 'application/json'
	}).done(function(data){
		console.log(data);
		ttt = data.grid;
		winner = data.winner;
		print_board(ttt);
	}).fail(function(err){
		console.log(err);
	});
}

function load_past_games(){
	$.ajax({
		'type': 'POST',
		'url': 'http://psethi.cse356.compas.cs.stonybrook.edu/getscore',
		'contentType': 'application/json'
	}).done(function(data){
		if (data.status == "OK"){
			var t = $('#past-games').html();
			t += "[X: " + data.human;
			t += "/ Y: " + data.wopr + "]";
			$('#past-games').html(t);
		} else 
			console.log(data);
	}).fail(function(err){
		console.log(err);
	});
}