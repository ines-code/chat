<?php


include('connection.php');

session_start();

$data = array(
 ':to_user_id'  => $_POST['to_user_id'],
 ':from_user_id'  => $_SESSION['user_id'],
 ':chat_message'  => $_POST['chat_message'],
 ':status'   => '1'
);

$query = "
INSERT INTO chat_message 
(to_user_id, from_user_id, chat_message, status) 
VALUES (:to_user_id, :from_user_id, :chat_message, :status)
";

$statement = $connect->prepare($query);

if($statement->execute($data)){
    $poruke = fetch_user_chat_history($_SESSION['user_id'], $_POST['to_user_id'], $connect);

    

    
        // iteracija kroz poruke 
        $output = '<ul class="list-unstyled">';
        foreach($poruke as $poruka) {
            $user_name = '';
            $vrsta = 'poslano';
            $polozaj = 'right';
            if($poruka["from_user_id"] == $_SESSION['user_id']) {
               // $user_name = '<b class="text-success" align="right">Ja</b>';
            } else {
                //$user_name = '<b class="text-danger">'.get_user_name($poruka['from_user_id'], $connect).'</b>';
                $vrsta = 'primljeno';
                $polozaj = 'right';
            }
            
            $output .= '
                    <li class="'.$vrsta.'">
                        <span>'.$user_name.'</span>
                        <p>'.$poruka["chat_message"].'<small><em>'.date("G:i", strtotime($poruka['timestamp'])).'</em></small></p>
                        
                    </li>';
        }
 
        $output .= '</ul>';
    

    echo $output;

}

?>