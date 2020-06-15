<!DOCTYPE html>
<html lang="en">

<head>
	<title>Izradi novu lozinku</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="" href="css/create.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto|Courgette|Pacifico:400,700" rel="stylesheet">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
	<link rel="icon" href="img/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

</head>

<body>
	<div class="container">
		<div class="row">

			<div class="signin-form col-md-4">
				<form action="" method="post">
					<div class="form-header">
						<h2>Izradi novu lozinku</h2>
					</div>
					<div class="form-group">
						<label>E-mail</label>
						<input type="text" class="form-control" placeholder="Potvrdi svoj e-mail" name="email" autocomplete="off" required="required">
					</div>
					<div class="form-group">

						<label>Unesi lozinku</label>
						<div class="input-group">
							<input type="password" name="pass1" class="form-control pwd" value="" autocomplete="off" required="required">
							<span class="input-group-btn">
								<button class="btn btn-default reveal" type="button"><i class="fa fa-eye" aria-hidden="true"></i></button>

						</div>
					</div>

					<div class="form-group">
					<label>Potvrdi lozinku</label>
						<div class="input-group">
							<input type="password" name="pass2" class="form-control pwd" value="" autocomplete="off" required="required">
							<span class="input-group-btn">
								<button class="btn btn-default reveal" type="button"><i class="fa fa-eye" aria-hidden="true"></i></button>

						</div>
						
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-info btn-block btn-lg" name="change">Promijeni</button>
					</div>
					<div class="text-center large" style="color: #67428B;"> <a href="login.php">Ulogiraj se</a></div>
				</form>
			</div>

		</div>

	</div>
	<script>
		$(".reveal").on('click', function() {
			var $pwd = $(".pwd");
			if ($pwd.attr('type') === 'password') {
				$pwd.attr('type', 'text');
			} else {
				$pwd.attr('type', 'password');
			}
		});
	</script>


</body>

</html>


<?php
session_start();

include("connection.php");

$check = '';



if (isset($_POST['change'])) {
	$usermail = $_POST['email'];

	$query = "
			SELECT * FROM login 
			WHERE usermail = '" . $_POST['email'] . "' 
			";

	$email = null;
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach ($result as $row) {
		$email = get_user_mail($row['user_id'], $connect);
	}


	if (strlen(trim($email)) !== strlen(trim($usermail))) {
		echo "
	          <div class='alert alert-danger'>
	            <strong>Provjeri e-mail!</strong> 
	          </div>
	        ";
	}

	$pass1 = $_POST['pass1'];
	$pass2 = $_POST['pass2'];

	if ($pass1 != $pass2) {
		$check = "1";
		echo "
	          <div class='alert alert-danger'>
	            <strong>Lozinke se ne podudaraju</strong> 
	          </div>
	        ";
	}
	if ($pass1 < 8 && $pass2 < 8) {
		$check = "1";
		echo "
	          <div class='alert alert-danger'>
	            <strong>Lozinka mora imati 9 ili više znakova!</strong> 
	          </div>
	        ";
	}

	if ($check == "") {


		$data = array(
			':usermail' => $usermail,
			':new_password' => password_hash($pass1, PASSWORD_DEFAULT)
		);

		$query     = "
			 UPDATE login SET password = :new_password
			   where usermail = :usermail
				";
		$statement = $connect->prepare($query);
		if ($statement->execute($data)) {

			echo "
            	<script>alert('Možeš se ulogirati!')</script>
            	<script>window.open('login.php','_self')</script>
				";
		}
	}
}

?>