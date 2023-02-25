<?php
require_once './User.php';

$user = new User();

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Users</title>
	<link rel="stylesheet" href="style.css">
</head>

<body>

	<table class="table">
		<thead>
			<tr>
				<th>id</th>
				<th>E-mail</th>
				<th>Name</th>
				<th>Last name</th>
				<th>Age</th>
				<th>Date time</th>
				<th>Records management</th>
			</tr>
		</thead>

		<tbody>
			<?php
			array_map('makeRow', $user->list());
			?>
		</tbody>
	</table>

	<form action="./index.php" method="post">
		<input class="input" type="text" name="first_name" placeholder="Name" required>
		<input class="input" type="text" name="last_name" placeholder="Last name" required>
		<input class="input" type="text" name="email" placeholder="E-mail" required>
		<input class="input" type="number" name="age" placeholder="Age" required>
		<button class="btn" type="submit">Create user</button>
	</form>

</body>

</html>

<?php

if (isset($_POST['first_name']) && !isset($_POST['edit'])) {
	$newUser = [
		'first_name' => htmlspecialchars(trim($_POST["first_name"])),
		'last_name' => htmlspecialchars(trim($_POST["last_name"])),
		'email' => htmlspecialchars(trim($_POST["email"])),
		'age' => htmlspecialchars(trim($_POST["age"])),
		'date_created' => date('Y-m-d H:i:s')
	];

	$user->create($newUser);
	// header('Location: ./index.php');
	echo "<script>location.replace('./index.php');</script>";
	

} else if (isset($_POST['edit'])) {
	$editUser = [
		'first_name' => htmlspecialchars(trim($_POST["first_name"])),
		'last_name' => htmlspecialchars(trim($_POST["last_name"])),
		'email' => htmlspecialchars(trim($_POST["email"])),
		'age' => htmlspecialchars(trim($_POST["age"])),
		'date_created' => htmlspecialchars(trim($_POST["date_created"]))
	];

	$user->update($editUser, $_POST["id"]);
	// header('Refresh: 0');
	echo "<script>location.replace('./index.php');</script>";


} else if (isset($_GET['act'])) {
	$user->delete($_GET["id"]);
	// header('Location: ./index.php');
	echo "<script>location.replace('./index.php');</script>";

}


function makeRow($arr)
{
	$id = $arr[0];
	echo "<tr><form action='./index.php' method='post'>";
	foreach ($arr as $key => $value) {
		if (gettype($key) == 'integer') {
			continue;
		}
		if ($key == 'id') {
			echo "<td><input type='text' name='$key' value='$value' readonly></td>";
			continue;
		}
		echo "<td><input type='text' name='$key' value='$value'></td>";
	}
	echo "<td class='td-btns'><input type='submit' class='btn edit' name='edit' value='edit'> <a href='./index.php?act=delete&id=$id' class='btn del'>Delete</a></td></form></tr>";
}
