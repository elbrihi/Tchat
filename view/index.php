<?php
require('../app/classLoad.php');
include 'header.php';

session_start();

if ( isset($_SESSION['username']) )
{ 
?>

    <body>  
    <div class="container">
        <br />
        
        <h3 align="center"></h3><br />
        <br />
        <div class="row">
            <div class="col-md-8 col-sm-6">
                <h4>Online User</h4>
            </div>
            <div class="col-md-2 col-sm-3">
                <input type="hidden" id="is_active_group_chat_window" value="no" />
                <button type="button" name="group_chat" id="group_chat" class="btn btn-warning btn-xs">Group Chat</button>
            </div>
            <div class="col-md-2 col-sm-3">
                <p align="right">Hi - <?php echo $_SESSION['username']; ?> - <a href="logout.php">Logout</a></p>
            </div>
        </div>
        <div class="table-responsive">
            
            <div id="user_details"></div>
            <div id="user_model_details"></div>
        </div>
        <br />
        <br />
        
    </div>
    
    </body>  

<?php
}
else 
{

}

?>

<script>

$(document).ready(function(){

    fetch_user();
    update_last_activity();
    //update_last_activity();
   /*setInterval(function(){
		update_last_activity();
		fetch_user();
		//update_chat_history_data();
		//fetch_group_chat_history();
	}, 5000);*/

    function fetch_user()
	{
        var action = 'getUserBySession';
        var source = 'user';
		$.ajax({
			url:"../app/Dispatcher.php",
			method:"POST",
            data:{action:action,  source:source},
			success:function(data){
				$('#user_details').html(data);
                //console.log(data);
			}
		})
	}


	function update_last_activity()
	{
		var action = 'fetch_last_user_activity';
        var source = 'loginDetails';
        $.ajax({
			url:"../app/Dispatcher.php",
            method:"POST",
            data:{action:action,  source:source},
			success:function(data)
			{
                //console.log(data);
			}
		})
	}
    
    function make_chat_dialog_box(to_user_id, to_user_name)
	{
		var modal_content = '<div id="user_dialog_'+to_user_id+'" class="user_dialog" title="You have chat with '+to_user_name+'">';
		modal_content += '<div style="height:400px; border:1px solid #ccc; overflow-y: scroll; margin-bottom:24px; padding:16px;" class="chat_history" data-touserid="'+to_user_id+'" id="chat_history_'+to_user_id+'">';
		modal_content += fetch_user_chat_history(to_user_id);
		modal_content += '</div>';
		modal_content += '<div class="form-group">';
		modal_content += '<textarea name="chat_message_'+to_user_id+'" id="chat_message_'+to_user_id+'" class="form-control chat_message"></textarea>';
		modal_content += '</div><div class="form-group" align="right">';
		modal_content+= '<button type="button" name="send_chat" id="'+to_user_id+'" class="btn btn-info send_chat">Send</button></div></div>';
		$('#user_model_details').html(modal_content);
	}

    $(document).on('click', '.start_chat', function(){
		var to_user_id = $(this).data('touserid');
		var to_user_name = $(this).data('tousername');
		make_chat_dialog_box(to_user_id, to_user_name);
		$("#user_dialog_"+to_user_id).dialog({
			autoOpen:false,
			width:400
		});
		$('#user_dialog_'+to_user_id).dialog('open');
		$('#chat_message_'+to_user_id).emojioneArea({
			pickerPosition:"top",
			toneStyle: "bullet"
		});
	});

    $(document).on('click', '.send_chat', function(){
        
		var to_user_id = $(this).attr('id');
        var action = 'sentChat';
        var source = 'chatMessage';
		var chat_message = $.trim($('#chat_message_'+to_user_id).val());
		if(chat_message != '')
		{
			$.ajax({
                url:"../app/Dispatcher.php",
                method:"POST",
				data:{action:action,source:source, to_user_id:to_user_id, chat_message:chat_message},
				success:function(data)
				{
                    console.log(data);
					$('#chat_message_'+to_user_id).val('');
					//var element = $('#chat_message_'+to_user_id).emojioneArea();
					//element[0].emojioneArea.setText('');
					$('#chat_history_'+to_user_id).html(data);
				}
			})
		}
		else
		{
			alert('Type something');
		}
	});

    function fetch_user_chat_history(to_user_id)
	{
        var action = 'fetchUserChatHistory';
        var source = 'chatMessage';
		$.ajax({
			url:"../app/Dispatcher.php",
            method:"POST",
			data:{action:action,source:source,to_user_id:to_user_id},
			success:function(data){
				$('#chat_history_'+to_user_id).html(data);
                console.log(data);
			}
		})
	}



});  

</script>