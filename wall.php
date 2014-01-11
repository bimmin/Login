<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css" rel="stylesheet">

<?php

require("connection.php");
session_start();

if(!isset($_SESSION['logged_in']))
{
header("Location: index.php");
}
?>
<div class="wrapper">
	<div class="container">
		<div class="jumbotron">
		<h1 style="display: inline;">Welcome</h1> <?= $_SESSION['user']['first_name'] ." " . $_SESSION['user']['last_name'] ?>!

		<a href="process.php">Log Off</a>
		</div>
	<h1>My friends</h1>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Name</th>
					<th>Email</th>
				</tr>
				</thead>
				<tbody>
			<?php
			//Get users
			$users = new Database();
			$user_list = $users -> fetch_all($query="SELECT first_name, last_name, email, id FROM users");
			// var_dump($user_list);

			$friends = new Database();
			$friends_list = $friends -> fetch_all($query="SELECT * FROM friends WHERE user_id = '{$_SESSION['user']['id']}'");

			foreach($user_list as $user){

			foreach ($friends_list as $friend) {
			if ($user['id'] ==  $friend['friend_id']){
			echo "<tr><td>" .$user['first_name'] ." ". $user['last_name'] . "</td><td>" . $user['email'] ."</td></tr>";
			}
			}


			}

			?>
			</tbody>
		</table>

	<h1>List of Users on Friend Finder</h1>

	<table class="table table-striped">
		<thead>
			<tr>
			<th>Name</th>
			<th>Email</th>
			<th>Action</th>
			</tr>
		</thead>
		<tbody>

	<?php

	foreach ($user_list as $user){

	$action_string ='<form action="process.php" method="POST">' .
	'<input type="hidden" name="action" value="addFriend">' .
	'<input type="hidden" name="friend_id" value="'. $user['id']  .'">' .
	'<input class="btn btn-primary btn-lg" type="submit" value="Add as Friend"></form>';

	foreach ($friends_list as $friend){

	if ($user['id'] ==  $friend['friend_id']){
	$action_string = "Friends";
	}
	elseif ($user['id'] == $_SESSION['user']['id']){
	$action_string = "Its me";
	}
	}
	echo "<tr><td>" .$user['first_name'] ." ". $user['last_name'] . "</td><td>" . $user['email'] . "</td><td>" . $action_string . "</td></tr>";

	}


	?>
	</tbody>
	</table>
	<footer class="panel-footer">
	<p>By: David Ethier, 2013, OOP, PHP, MySQL</p>
	</footer>
	</div>
</div>