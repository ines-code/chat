<?php


include('connection.php');

session_start();

$query = "
SELECT * FROM login 
WHERE user_id = '" . $_SESSION['user_id'] . "' 
";

$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();


foreach ($result as $row) {
  $ime = get_user_name($row['user_id'], $connect);
  $smjer = get_user_field($row['user_id'], $connect);
  $godina = get_user_year($row['user_id'], $connect);
  $spol = get_user_gender($row['user_id'], $connect);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://fonts.googleapis.com/css?family=Roboto|Courgette|Pacifico:400,700" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" type="" href="css/fetch.css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>

  <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">


</head>

<body>


  <div id="particles-js">
    <script type="text/javascript" src="particles.js"></script>
    <script type="text/javascript" src="app.js"></script>

  </div>



  <div class="container-fluid">
    <div class="row">
      <section class="col-md-12 col-sm-12">
        <table class="table">
          <tr>
            <th>Korisničko ime</th>
            <th>Smjer</th>
            <th>Godina</th>
            <th>Spol</th>
          </tr>
          <tr>
            <td><?php echo "$ime"; ?></td>
            <td><?php echo "$smjer"; ?></td>
            <td><?php echo "$godina"; ?></td>
            <td><?php echo "$spol"; ?></td>
          </tr>

        </table>
      </section>
    </div>

    <div class="row">
      <section class="col-md-12 col-sm-12">
        <form action="" method="post" enctype="multipart/form-data">
          <table class="table table-bordered table-hover">
            <tr>
              <td colspan="6" class="active">
                <h2>Promijeni postavke računa</h2>
              </td>
            </tr>
            <tr>
              <td style="font-weight: bold;">Promijeni korisničko ime</td>
              <td><input class="form-control" type="text" name="new_name" required="required" value="<?php echo $ime; ?>" /></td>
            </tr>

            <tr>
              <td style="font-weight: bold;">Godina studija</td>
              <td><select class="form-control" name="new_year">
                  <option><?php echo $godina; ?></option>
                  <option>1.</option>
                  <option>2.</option>
                  <option>3.</option>
                </select></td>
            </tr>

            <tr>
              <td style="font-weight: bold;">Zaboravljena lozinka</td>
              <td><a class="btn btn-outline-secondary" style="text-decoration: none;font-size: 15px;" href="create_password.php"><i class="fa fa-key fa-fw" aria-hidden="true"></i> Promijeni lozinku</a></td>
            </tr>

            <tr>
              <td colspan="4"><input class="btn btn-info" style="width: 250px;" type="submit" name="update" value="Ažuriraj" /></td>
            </tr>

          </table>
        </form>
      </section>
    </div>

    <div class="row">
      <section class="col-md-12">
        <a class="btn btn-dark" href="index.php" role="button">TVZ chat</a>
      </section>
    </div>

  </div>
</body>

</html>


<?php
//include('connection.php');

//session_start();

//$query = "
//SELECT * FROM login 
//WHERE user_id = '".$_SESSION['user_id']."' 
//";



if (isset($_POST['update'])) {

  //$usermail = $_POST['email'];	

  $name = $_POST['new_name'];
  $year = $_POST['new_year'];

  $statement = $connect->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll();


  $data = array(
    ':new_name' => $name,
    ':new_year' => $year
  );

  $query     = "
   UPDATE login SET username = :new_name, year_of_study = :new_year
      WHERE user_id = '" . $_SESSION['user_id'] . "' 
    ";
  $statement = $connect->prepare($query);
  if ($statement->execute($data)) {

    echo "<script>alert('Podatci uspješno ažurirani.')</script>";
    echo "<script>window.open('fetch_me.php','_self')</script>";
  }
}

?>