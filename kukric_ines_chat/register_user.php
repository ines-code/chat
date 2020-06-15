<?php

include('connection.php');

session_start();

$message = '';

if (isset($_SESSION['user_id'])) {
    header('location:index.php');
}

if (isset($_POST["register"])) {
    $usermail = ($_POST["usermail"]);
    $password = ($_POST["password"]);
    $recovery = ($_POST["forgotten_answer"]);
    $username = ($_POST["username"]);
    $field    = ($_REQUEST["field_of_study"]);
    $year     = ($_REQUEST["year_of_study"]);
    $gender   = ($_REQUEST["gender"]);


    $check_query = "
        SELECT * FROM login
        WHERE usermail = :usermail
        ";
    $statement   = $connect->prepare($check_query);
    $check_data  = array(
        ':usermail' => $usermail
    );
    if ($statement->execute($check_data)) {
        if ($statement->rowCount() > 0) {
            $message .= '.';
            echo "<script>alert('E-mail već postoji')</script>";
        } else {
            if (empty($username)) {
                $message .= '.';
                echo "<script>alert('Korisničko ime je obavezno!')</script>";
            }
            if (empty($recovery)) {
                $message .= '.';
                echo "<script>alert('Ime najboljeg prijatelja je obavezno')</script>";
            }
            if (empty($password)) {
                $message .= '.';
                echo "<script>alert('Lozinka je obavezna')</script>";
            }


                if (strlen($password) < 8) {
                    $message .= '.';
                    echo "<script>alert('Lozinka treba imati minimalno 8 znakova!')</script>";
                }
                $tvz = "tvz.hr";
                if (strpos($usermail, $tvz) == false) {
                    $message .= '.';
                    echo "<script>alert('Niste student TVZ-a!')</script>";
                }
            


        

            if ($message == '') {
                $data = array(
                    ':usermail' => $usermail,
                    ':password'  => password_hash($password, PASSWORD_DEFAULT),
                    ':forgotten_answer' => $recovery,
                    ':username' => $username,
                    ':field_of_study' => $field,
                    ':year_of_study' => $year,
                    ':gender' => $gender


                );

                $query     = "
                 INSERT INTO login
                  (usermail, password, username, field_of_study, year_of_study, gender, forgotten_answer)
                   VALUES (:usermail, :password, :username, :field_of_study, :year_of_study, :gender, :forgotten_answer)
                    ";
                $statement = $connect->prepare($query);
                if ($statement->execute($data)) {
                    $message = "Registracija uspješna!";
                    echo "<script>alert('$message')</script>";
                    
                }
            }
        }
    }
}

?>






<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="" href="css/register.css">
    
    <link href="https://fonts.googleapis.com/css?family=Roboto|Courgette|Pacifico:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">

    
</head>

<body>


    <div class="container-fluid">
        <div class="row">
            <section class="col-md-4">

                <div id="particles-js">
                    <script type="text/javascript" src="particles.js"></script>
                    <script type="text/javascript" src="app.js"></script>

                </div>
            </section>

            <section class="col-md-8">
                <div class="signup-form">

                    <form method="post">


                        <div class="form-header">

                            <h2>Ispuni formu</h2>

                        </div>
                        <div class="form-group">
                            <label>Korisničko ime</label>
                            <input type="text" name="username" class="form-control" placeholder="primjer: inesK " autocomplete="off" requried="required">
                        </div>

                        <div class="form-group">
                            <label>Lozinka</label>
                            <input type="password" name="password" class="form-control" placeholder="Lozinka mora imati minimalno 8 znakova" autocomplete="off" requried="required">
                        </div>
                        <div class="form-group">
                            <label>Ime najboljeg prijatelja</label>
                            <input type="text" name="forgotten_answer" class="form-control" placeholder="Matija" autocomplete="off" requried="required">
                        </div>
                        <div class="form-group">
                            <label>E-mail adresa</label>
                            <input type="email" name="usermail" class="form-control" placeholder="ime.prezime@tvz.hr" autocomplete="off" requried="required">
                        </div>
                        <div class="form-group">
                            <label>Smjer</label>
                            <select class="form-control" name="field_of_study" required>
                                <option disabled="">Izaberi smjer studija</option>
                                <option>Redovni elektrotehnika</option>
                                <option>Redovni graditeljstvo</option>
                                <option>Redovni informatika</option>
                                <option>Redovni mehatronika</option>
                                <option>Redovni računarstvo</option>
                                <option>Izvanredni elektrotehnika</option>
                                <option>Izvanredni graditeljstvo</option>
                                <option>Izvanredni informatika</option>
                                <option>Izvanredni mehatronika</option>
                                <option>Izvanredni računarstvo</option>


                            </select>
                        </div>
                        <div class="form-group">
                            <label>Godina</label>
                            <select class="form-control" name="year_of_study" required="required">
                                <option disabled="">Izaberi godinu studija</option>
                                <option>1.</option>
                                <option>2.</option>
                                <option>3.</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Spol</label>
                            <select class="form-control" name="gender" required="required">
                                <option disabled="disabled">Izaberi spol</option>
                                <option>Muško</option>
                                <option>Žensko</option>
                            </select>
                        </div>



                        <div class="form-group">
                            <input type="submit" name="register" class="btn btn-info" value="Registriraj me" />
                        </div>

                    </form>
                    <div class="text " style="color: #67428B;"> <a href="login.php">Ulogiraj se ovdje</a></div>
                </div>
            </section>

        </div>

    </div>
    

</body>

</html>
