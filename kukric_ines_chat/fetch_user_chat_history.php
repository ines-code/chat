
<?php

include('connection.php');
session_start();

$poruke = fetch_user_chat_history($_SESSION['user_id'], $_POST['to_user_id'], $connect);

    // iteracija kroz poruke 
    $output = '<ul class="list-unstyled">';
    foreach($poruke as $poruka) {
        $user_name = '';
        $vrsta = 'primljeno';
        $polozaj = 'right';
        if($poruka['from_user_id'] == $_SESSION['user_id']) {
           // $user_name = '<b class="text-success" align="right">Ja</b>';
            $polozaj = 'left';
        } else {
           // $user_name = '<b class="text-danger">'.get_user_name($poruka['from_user_id'], $connect).'</b>';
            $vrsta = 'poslano';
            
        }
        
        $output .= '
                <li class="'.$vrsta.'">
                    <div class="chat-wrapper">
                        <span class="user">'.$user_name.'</span>
                         <p>'.$poruka["chat_message"].' <br> <small><em>'.date("G:i", strtotime($poruka['timestamp'])).'</em></small></p>
                        </div>
                </li>';
    }
 
    $output .= '</ul>';

    


update_status_message($_SESSION['user_id'], $_POST['to_user_id'], $connect);

echo $output; 
?>