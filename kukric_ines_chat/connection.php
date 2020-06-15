<?php


$connect = new PDO("mysql:host=localhost;dbname=mchat", "root", "");

date_default_timezone_set('Europe/Zagreb');

function fetch_user_last_activity($user_id, $connect)
{
 $query = "
 SELECT * FROM login_details 
 WHERE user_id = '$user_id' 
 ORDER BY last_activity DESC 
 LIMIT 1
 ";
 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 foreach($result as $row)
 {
  return $row['last_activity'];
 }
}

function update_user_status($status, $user_id, $connect) {
    $query = "
        UPDATE login SET status='".$status."' WHERE user_id = '".$user_id."';";

    $statement = $connect->prepare($query);
    $statement->execute();

}

function fetch_user_chat_history($from_user_id, $to_user_id, $connect) {
    
    $query = "
              SELECT * FROM chat_message 
              WHERE (from_user_id = '".$from_user_id."' AND to_user_id = '".$to_user_id."') 
              OR (from_user_id = '".$to_user_id."' AND to_user_id = '".$from_user_id."') 
              ORDER BY timestamp ASC ";
    
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    return $result;
}

function update_status_message($from_user_id, $to_user_id, $connect){
    $query = "
    UPDATE chat_message 
    SET status = '0' 
    WHERE from_user_id = '".$to_user_id."' 
    AND to_user_id = '".$from_user_id."' 
    AND status = '1'
    ";
    $statement = $connect->prepare($query);
    $statement->execute();
 
    
}

function get_user_name($user_id, $connect)
{
 $query = "SELECT username FROM login WHERE user_id = '$user_id'";
 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 foreach($result as $row)
 {
  return $row['username'];
 }
}
function get_user_field($user_id, $connect)
{
 $query = "SELECT field_of_study FROM login WHERE user_id = '$user_id'";
 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 foreach($result as $row)
 {
  return $row['field_of_study'];
 }
}
function get_user_year($user_id, $connect)
{
 $query = "SELECT year_of_study FROM login WHERE user_id = '$user_id'";
 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 foreach($result as $row)
 {
  return $row['year_of_study'];
 }
}
function get_user_gender($user_id, $connect)
{
 $query = "SELECT gender FROM login WHERE user_id = '$user_id'";
 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 foreach($result as $row)
 {
  return $row['gender'];
 }
}
function get_user_mail($user_id, $connect)
{
 $query = "SELECT usermail FROM login WHERE user_id = '$user_id'";
 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 foreach($result as $row)
 {
  return $row['usermail'];
 }
}
function get_user_answer($user_id, $connect)
{
 $query = "SELECT forgotten_answer FROM login WHERE user_id = '$user_id'";
 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 foreach($result as $row)
 {
  return $row['forgotten_answer'];
 }
}


function count_unseen_message($from_user_id, $to_user_id, $connect)
{
 $query = "
 SELECT * FROM chat_message 
 WHERE from_user_id = '$from_user_id' 
 AND to_user_id = '$to_user_id' 
 AND status = '1'
 ";
 $statement = $connect->prepare($query);
 $statement->execute();
 $count = $statement->rowCount();
 $output = '';
 if($count > 0)
 {
  $output = '<span class="badge badge-danger">'.$count.'</span>';
 }
 return $output;
}



?>
