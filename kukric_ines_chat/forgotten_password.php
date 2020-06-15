<!DOCTYPE html>
<html lang="en">

<head>
    <title>Forgotten Password</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="" href="css/forgotten.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto|Courgette|Pacifico:400,700" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">

</head>

<body>

    <div class="container">
        <div class="section">
            <div class="row">
            

                <div class="signin-form col-md-4 col-sm-4">
                    <form action="" method="post">
                        <div class="header">
                            <h2>Zaboravljena lozinka</h2>

                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" placeholder="ime.prezime@tvz.hr" name="email" autocomplete="off" required="required">
                        </div>
                        <div class="form-group">
                            <label>Ime najboljeg prijatelja/ice</label>
                            <input type="text" class="form-control" placeholder="" name="bestfriend" autocomplete="off" required="required">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-info btn-block btn-lg" name="submitted">Potvrdi</button>
                        </div>
                    </form>
                    <div class="text-center small" style='color:#67428B;'><a href="login.php">Natrag</a></div>
                </div>



            </div>

        </div>
    </div>
    

</body>

</html>



<?php

include('connection.php');
session_start();


//$email= get_user_mail($row['user_id'], $connect);
//$email = $row['usermail'];
//$recovery = get_user_answer($row['forgotten_answer'], $connect);

if (isset($_POST['submitted'])) {


    $usermail = $_POST['email'];
    $answer = $_POST['bestfriend'];


    $query = "
        SELECT * FROM login 
        WHERE usermail = '$usermail' AND forgotten_answer = '$answer' 
        ";
    $email = null;
    $odgovor = null;
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();


    foreach ($result as $row) {
        $email = $row['usermail'];
        $odgovor = $row['forgotten_answer'];
    }



    if ($odgovor === $answer) {

        //$_SESSION['user_id']=$user_id;
        header("location:create_password.php", "_self");
    } else {
        echo " <div class='alert alert-danger'>
        <strong>Unešeni krivi podatci!</strong> 
      </div>";
        //echo "<script>window.open('forgotten_password.php','_self')</script>";
    }
}


?>