<?php

include('connection.php');

session_start();

$query = "
SELECT * FROM login 
WHERE user_id != '".$_SESSION['user_id']."' 
";




$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();


$output = '<ul>';

foreach($result as $row) {
    $status = 'offline';
 
    if ($row['status']) {
        $status = 'online';
    }
    
    $output .= '<li class="contact" data-touserid="'.$row['user_id'].'" data-tousername="'.$row['username'].'">
                    <div class="wrap">
                        <span class="contact-status '. $status .'"></span>
                        <img src="./img/user.png" alt="'.$row['username'].'">
                        <div class="meta">
                        
                            <p class="name">'. $row['username'] . '     <span>'.count_unseen_message($row['user_id'], $_SESSION['user_id'], $connect).' </span></p>
                            <p class="preview">'.$row['field_of_study'].' ('.$row['year_of_study'].' godina)</p>
                            
                        </div>
                    </div>
                </li>';
}


$output .= '</ul>';

echo $output;

?>



