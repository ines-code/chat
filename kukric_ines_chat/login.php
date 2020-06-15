<?php

include('connection.php');

session_start();

$message = '';

if (isset($_SESSION['user_id'])) {

    header('location:index.php');
}

if (isset($_POST["login"])) {

    $query = "
   SELECT * FROM login 
    WHERE usermail = :usermail
 ";
    $statement = $connect->prepare($query);
    $statement->execute(
        array(
            ':usermail' => $_POST["usermail"]
        )
    );
    $count = $statement->rowCount();
    if ($count > 0) {

        $result = $statement->fetchAll();
        foreach ($result as $row) {


            if (password_verify($_POST["password"], $row["password"])) {

                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['usermail'] = $row['usermail'];
                $sub_query = "
                        INSERT INTO login_details 
                        (user_id) 
                        VALUES ('" . $row['user_id'] . "')
                        ";
                $statement = $connect->prepare($sub_query);
                $statement->execute();

                update_user_status(1, $row['user_id'], $connect);

                $_SESSION['login_details_id'] = $connect->lastInsertId();
                header("location:index.php");
            } else {
                $message = "Pogrešna lozinka";
                echo "<script>alert('$message')</script>";
            }
        }
    } else {
        $message = "Krivi e-mail";
        echo "<script>alert('$message')</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="" href="css/login.css">

    <link href="https://fonts.googleapis.com/css?family=Roboto|Courgette|Pacifico:400,700" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/jquery/1.12.4/jquery.min.js"></script>


    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

    <title>Ulogiraj se u svoj korisnički račun</title>
</head>

<body>


    <div id="particles-js">
        <script type="text/javascript" src="particles.js"></script>
        <script type="text/javascript" src="app.js"></script>

    </div>

    <div class="container">
        <div class="row">
            <section class="col-md-12">
                <div class="signin-form">
                    <form action="" name="prijava" method="post">
                        <div class="form-header">

                            <h2> <b>TVZ</b> chat</h2>


                        </div>
                        <div class="form-group">
                            <label>E-mail</label>
                            <input type="email" name="usermail" class="form-control" placeholder="ime.prezime@tvz.hr" autocomplete="on" requried="required">
                        </div>
                        <div class="form-group">
                            <label>Lozinka</label>
                            <input type="password" name="password" class="form-control pwd" placeholder="" autocomplete="off" requried="required" id="myInput">
                            <button class="btn btn-default reveal" type="button"><small><i class="fa fa-eye" aria-hidden="true" ></i></small></button>
                        </div>

                        <div class="form-group">
                            <div class="small" name="zab">Zaboravljena lozinka? <a href="forgotten_password.php">Klikni ovdje</a></div><br>
                            <input type="submit" name="login" class="btn btn-info" value="Ulogiraj me" />
                        </div>


                    </form>
                    <div class="register"><a href="register_user.php">Registriraj me</a></div>
            </section>
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