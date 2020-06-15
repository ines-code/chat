$(function() {

    const users = document.querySelector('#users-ps');
    const chat_box = document.querySelector('#chat-box-ps');
    const ps_users = new PerfectScrollbar(users);

    const ps_chat_box = new PerfectScrollbar(chat_box, {
        suppressScrollX: true,
    });

    dohvati_korisnika();

    setInterval(function(){
        console.log("OSVJEŽAVAM")
        // zadnja aktivnost korisnika
        zadnja_aktivnost();
        osvjezi_chat();

    },5000);


    /**
     * Interakcija s korisnikom 
     */

    $(document).on('click', '.contact', function(){
        var to_user_id = $(this).data('touserid');
        var to_user_name = $(this).data('tousername');
        // console.log("Korisnik: " + to_user_name + " kliknut!");
        $('#chat_message').data('touserid', to_user_id);
        $( this ).parent().find('li.active').removeClass('active');
        $( this ).addClass('active');
        popuni_chat_box(to_user_id, to_user_name);
    });

    $(document).on('focus', '#chat_message', function(){
        var is_type = 'yes';
        $.ajax({
            url:"update_is_type_status.php",
            method:"POST",
            data:{is_type:is_type},
            success:function(){
                //console.log("polje u fokusu")
            }
        })
    });
    
    $(document).on('click', '#send_chat', function(event){
       // event.preventDefault();
        // console.log('pošalji stisnut')
        var to_user_id =  $('#chat_message').data('touserid');
        var chat_message = $('#chat_message').val();
        
        

        if(chat_message.length > 0) {
        
            $.ajax({
                url:"insert_chat.php",
                method:"POST",
                data:{to_user_id:to_user_id, chat_message:chat_message},
                success:function(data) {
                    $('#chat_message').val('');
                    // $('#chat-box-ps').html(data);
                    osvjezi_chat();
                }
            });
        }
        // scroll na kraj poruka 
        var chat_height = $('#chat-box-ps ul').prop('scrollHeight');
        
        

        ps_chat_box.update();

    });


    function update_height() {
        var chat_height = $('#chat-box-ps ul').prop('scrollHeight');
        $("#chat-box-ps").animate({ scrollTop: chat_height }, 'fast');
        
       // $('#chat-box-ps').perf

       ps_chat_box.update();
    }




});


/**
 * Funkcije za chat 
 */

function dohvati_korisnika(){
    $.ajax({
        url:"fetch_user.php",
        method:"POST",
        success:function(data){
            $('#users-ps').html(data);
        }
    });
}

function zadnja_aktivnost(){
    $.ajax({
        url:"update_last_activity.php",
        success:function()
        {
            console.log("Korisnička aktivnost ažurirana");
        }
    }); 
}

function osvjezi_chat(){
    $('#chat-box-ps ul').each(function(){
        var to_user_id = $('#chat_message').data('touserid');
        dohvati_povijest_chat(to_user_id);
    });

    // scroll na kraj poruka 
    var chat_height = $('#chat-box-ps ul').prop('scrollHeight');
    $('#chat-box-ps').scrollTop(chat_height);
}

function dohvati_povijest_chat(to_user_id){
    $.ajax({
        url:"fetch_user_chat_history.php",
        method:"POST",
        data:{to_user_id:to_user_id},
        success:function(data){
            $('#chat-box-ps').html(data);
            var chat_height = $('#chat-box-ps ul').prop('scrollHeight');
            $('#chat-box-ps').scrollTop(chat_height);
        }
    });

    dohvati_korisnika();
}



function popuni_chat_box(to_user_id, to_user_name){
    var chat_content = dohvati_povijest_chat(to_user_id);

    $('#chat_message').data('touserid', to_user_id);
    

}

