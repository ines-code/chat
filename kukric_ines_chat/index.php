<?php
include('connection.php');
session_start();
if(!isset($_SESSION['user_id'])){
    header("location:login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>TVZ chat</title>
   
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="./js/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="./css/style.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="img/favicon.png" type="image/x-icon">



</head>
<body>
    <header>
        <nav class="navbar navbar-expand-sm navbar-light sticky-top "style="background-color: #e3f2fd;">
            <a class="navbar-brand" href="https://moj.tvz.hr/" target="_blank"> <img src="img/tvz-logo.svg" alt="" width="65px"></a>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="mr-auto">
                <a class="btn btn-info" href="fetch_me.php" role="button">Moj profil</a>
                    </ul>
                <ul class="navbar-nav">
                <a class="btn btn-secondary" href="logout.php" role="button">Odjava</a>
                </ul>
            </div>
        </nav>
    </header>
    <main role="main" class="container-fluid">
        <div class="row">
            
            <div class="col-lg-4">
                <div id="users-ps">
                    
                </div>
            </div>
            <div class="col-lg-8">
                <div class="chat-head">
                    <?php echo get_user_name($_SESSION['user_id'], $connect)?>
                </div>
                <section id="chat-box-ps">

                </section>
                <section id="chat-input">
                    <form class="chat-input-form">
                        <div class="form-row ">
                            
                            <div class="form-group col-lg-10">
                                <textarea name="chat_message" id="chat_message" class="form-control"></textarea>
                            </div>
                          
                         
                            <div class="form-group col-lg-2">
                                <button type="button" name="send_chat" class="btn btn-info" id="send_chat" >Pošalji</button>
                                
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </main>

    <footer class="footer">
      <div class="container">
        <span class="text-muted">&copy; ines.kukric@tvz.hr</span>
      </div>
    </footer>
     
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="js/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="js/tvz-chat.js"></script>


<script>

                      
    var input = document.getElementById("chat_message");
    
    input.addEventListener("keyup", function(event) {
       
        if (event.keyCode === 13) {
            event.preventDefault();
                if( $.trim( $(this).val() ) == "" ){
                    exit;
                }
                else{
                document.getElementById('send_chat').click();
                } 
        }
        });
</script>

    
  </body>
</html>


