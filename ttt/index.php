<?php 
date_default_timezone_set('America/New_York');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Tic Tac Toe</title>
		<link rel="stylesheet" href="./styles.css">
		<script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
		<script src="script.js"></script>
	</head>
	<body>
		<div class="container">
			<?php if (!isset($_POST) || empty($_POST['name'])){ ?>
				<div class="main m-text">
					<form action="index.php" method="POST" onsubmit=" return login()">
						<input type="text" name="username" id="uname" required placeholder="Username" class="my-input"><br> 
						<input type="password" name="password" id="pwd" required placeholder="Password" class="my-input"><br> <br>
						<input type="hidden" name="name" value="test">
						<input type="submit" value="SIGN IN" class="my-button">
					</form>
					<br><br><hr> <br>
					<form action="index.php" method="POST" onsubmit="return signup()">
						<input type="email" name="email_" id="email_" required placeholder="Email" class="my-input"><br> 
						<input type="text" name="username_" id="uname_" required placeholder="Username" class="my-input"><br> 
						<input type="password" name="password_" id="pwd_" required placeholder="Password" class="my-input"><br> <br>
						<input type="submit" value="SIGN UP" class="my-button">
					</form>
				</div>
			<?php } else { ?>
			<div class="main ">
				<?php 
					$time = getdate(time());
					@unlink("log.txt");
				?>
				Hello <?php echo trim(ucwords(strtolower($_POST['name']))). ". It's " . $time['month'] . " " . $time['mday'] . "<sup>th</sup>, " . $time['year'] ?> 
	
				<?php #echo $_POST['name']. ", " . $time['mon'] . "/" . $time['mday'] . "/" . $time['year'] ?>

				<br> <br> <br>
				
				<div class="ttt">
					<center>
						<table class="my-table">
							<tr>
								<td class="cell-hover" onclick="make_x_move(1)" id="box-1"></td>
								<td class="cell-hover" onclick="make_x_move(2)" id="box-2"></td>
								<td class="cell-hover" onclick="make_x_move(3)" id="box-3"></td>
							</tr>
							<tr>
								<td class="cell-hover" onclick="make_x_move(4)" id="box-4"></td>
								<td class="cell-hover" onclick="make_x_move(5)" id="box-5"></td>
								<td class="cell-hover" onclick="make_x_move(6)" id="box-6"></td>
							</tr>
							<tr>
								<td class="cell-hover" onclick="make_x_move(7)" id="box-7"></td>
								<td class="cell-hover" onclick="make_x_move(8)" id="box-8"></td>
								<td class="cell-hover" onclick="make_x_move(9)" id="box-9"></td>
							</tr>
						</table>
					</center>
				</div>
				<br><br>
				<div class="winner"></div>

			<div id="past-games">
				
			</div>
			<script type="text/javascript">
				load_board();
				load_past_games();
			</script>
			</div>
			
			<?php } ?> 
		</div>
		<div class="footer">
			psethi@cs.stonybrook.edu
		</div>
	</body>
</html>