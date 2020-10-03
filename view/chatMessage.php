<?php
require('../app/classLoad.php');
session_start();
if ( isset($_SESSION['user']) ) {
    //create Controller
    $chatMessageActionController = new AppController('chatMessage');
    //get objects
    $chatMessages = $chatMessageActionController->getAll(); 
    /*$chatMessagesNumber = $chatMessageActionController->getAllNumber(); 
    $p = 1;
    if ( $chatMessagesNumber != 0 ) {
        $chatMessagePerPage = 20;
        $pageNumber = ceil($chatMessagesNumber/$chatMessagePerPage);
        if(isset($_GET['p']) and ($_GET['p']>0 and $_GET['p']<=$pageNumber)){
            $p = $_GET['p'];
        }
        else{
            $p = 1;
        }
        $begin = ($p - 1) * $chatMessagePerPage;
        $pagination = paginate('chatMessage.php', '?p=', $pageNumber, $p);
        $chatMessages = $chatMessageActionController->getAllByLimits($begin, $chatMessagePerPage);
    }*/ 
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
    <head>
        <?php include('../include/head.php') ?>
    </head>
    <body class="fixed-top">
        <div class="header navbar navbar-inverse navbar-fixed-top">
          <?php include("../include/top-menu.php"); ?>
        </div>
        <div class="page-container row-fluid sidebar-closed">
            <?php include("../include/sidebar.php"); ?>
            <div class="page-content">
                <div class="container-fluid">
                    <div class="row-fluid">
                        <div class="span12">
                            <ul class="breadcrumb">
                                <li><i class="icon-home"></i><a href="dashboard.php">Accueil</a><i class="icon-angle-right"></i></li>
                            </ul>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span12">
                            <?php if(isset($_SESSION['actionMessage']) and isset($_SESSION['typeMessage'])){ $message = $_SESSION['actionMessage']; $typeMessage = $_SESSION['typeMessage']; ?>
                            <div class="alert alert-<?= $typeMessage ?>"><button class="close" data-dismiss="alert"></button><?= $message ?></div>
                            <?php } unset($_SESSION['actionMessage']); unset($_SESSION['typeMessage']); ?>
                            <!-- addChatMessage box begin -->
                            <div id="addChatMessage" class="modal hide fade in" tabindex="-1" role="dialog" aria-hidden="false" >
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h3>Ajouter ChatMessage</h3>
                                </div>
                                <form class="form-horizontal" action="../app/Dispatcher.php" method="post">
                                    <div class="modal-body">
                                    <div class="control-group">
                                            <label class="control-label">To_user_id</label>
                                            <div class="controls">
                                                <input required="required" type="text" name="to_user_id" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">From_user_id</label>
                                            <div class="controls">
                                                <input required="required" type="text" name="from_user_id" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Chat_message</label>
                                            <div class="controls">
                                                <input required="required" type="text" name="chat_message" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Timestamp</label>
                                            <div class="controls">
                                                <input required="required" type="text" name="timestamp" />
                                            </div>
                                        </div>
                                             
                                    </div>
                                    <div class="modal-footer">
                                        <div class="control-group">
                                            <div class="controls">
                                                <input type="hidden" name="action" value="add" />
                                                <input type="hidden" name="source" value="chatMessage" />    
                                                <button class="btn" data-dismiss="modal" aria-hidden="true">Non</button>
                                                <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>    
                            <!-- addChatMessage box end -->
                            <div class="portlet box light-grey">
                                <div class="portlet-title">
                                    <h4>Liste des ChatMessages</h4>
                                    <div class="tools">
                                        <a href="javascript:;" class="reload"></a>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="clearfix">
                                        <div class="btn-group">
                                            <a class="btn blue pull-right" href="#addChatMessage" data-toggle="modal">
                                                <i class="icon-plus-sign"></i>&nbsp;ChatMessage
                                            </a>
                                        </div>
                                    </div>
                                    <table class="table table-striped table-bordered table-hover" id="sample_2">
                                        <thead>
                                            <tr>
                                                <th class="t10 hidden-phone">Actions</th>
                                                <th class="t10">To_user_id</th>
                                                <th class="t10">From_user_id</th>
                                                <th class="t10">Chat_message</th>
                                                <th class="t10">Timestamp</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            //if ( $chatMessagesNumber != 0 ) { 
                                            foreach ( $chatMessages as $chatMessage ) {
                                            ?>
                                            <tr>
                                                <td class="hidden-phone">
                                                    <a href="#deleteChatMessage<?= $chatMessage->id() ?>" data-toggle="modal" data-id="<?= $chatMessage->id() ?>" class="btn mini red"><i class="icon-remove"></i></a>
                                                    <a href="#updateChatMessage<?= $chatMessage->id() ?>" data-toggle="modal" data-id="<?= $chatMessage->id() ?>" class="btn mini green"><i class="icon-refresh"></i></a>
                                                </td>
                                                <td><?= $chatMessage->to_user_id() ?></td>
                                                <td><?= $chatMessage->from_user_id() ?></td>
                                                <td><?= $chatMessage->chat_message() ?></td>
                                                <td><?= $chatMessage->timestamp() ?></td>
                                            </tr> 
                                            <!-- updateChatMessage box begin -->
                                            <div id="updateChatMessage<?= $chatMessage->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-hidden="false">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h3>Modifier Info ChatMessage</h3>
                                                </div>
                                                <form class="form-inline" action="../app/Dispatcher.php" method="post">
                                                    <div class="modal-body">
                                                        <div class="control-group">
                                                            <label class="control-label">To_user_id</label>
                                                            <div class="controls">
                                                                <input required="required" type="text" name="to_user_id"  value="<?= $chatMessage->to_user_id() ?>" />
                                                            </div>
                                                        </div>
                                                        <div class="control-group">
                                                            <label class="control-label">From_user_id</label>
                                                            <div class="controls">
                                                                <input required="required" type="text" name="from_user_id"  value="<?= $chatMessage->from_user_id() ?>" />
                                                            </div>
                                                        </div>
                                                        <div class="control-group">
                                                            <label class="control-label">Chat_message</label>
                                                            <div class="controls">
                                                                <input required="required" type="text" name="chat_message"  value="<?= $chatMessage->chat_message() ?>" />
                                                            </div>
                                                        </div>
                                                        <div class="control-group">
                                                            <label class="control-label">Timestamp</label>
                                                            <div class="controls">
                                                                <input required="required" type="text" name="timestamp"  value="<?= $chatMessage->timestamp() ?>" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <div class="control-group">
                                                            <div class="controls">
                                                                <input type="hidden" name="idChatMessage" value="<?= $chatMessage->id() ?>" />
                                                                <input type="hidden" name="action" value="update" />
                                                                <input type="hidden" name="source" value="chatMessage" />    
                                                                <button class="btn" data-dismiss="modal" aria-hidden="true">Non</button>
                                                                <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- updateChatMessage box end --> 
                                            <!-- deleteChatMessage box begin -->
                                            <div id="deleteChatMessage<?= $chatMessage->id() ?>" class="modal modal-big hide fade in" tabindex="-1" role="dialog" aria-hidden="false">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h3>Supprimer ChatMessage</h3>
                                                </div>
                                                <form class="form-horizontal" action="../app/Dispatcher.php" method="post">
                                                    <div class="modal-body">
                                                        <h4 class="dangerous-action">Êtes-vous sûr de vouloir supprimer ChatMessage : <?= $chatMessage->to_user_id() ?> ? Cette action est irréversible!</h4>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <div class="control-group">
                                                            <div class="controls">
                                                                <input type="hidden" name="idChatMessage" value="<?= $chatMessage->id() ?>" />
                                                                <input type="hidden" name="action" value="delete" />
                                                                <input type="hidden" name="source" value="chatMessage" />    
                                                                <button class="btn" data-dismiss="modal" aria-hidden="true">Non</button>
                                                                <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- deleteChatMessage box end --> 
                                            <?php 
                                            }//end foreach 
                                            //}//end if
                                            ?>
                                        </tbody>
                                    </table>
                                    <?php /*if($chatMessagesNumber != 0){ echo $pagination; }*/ ?><br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include('../include/footer.php'); ?>
        <?php include('../include/scripts.php'); ?>     
        <script>jQuery(document).ready( function(){ App.setPage("table_managed"); App.init(); } );</script>
    </body>
</html>
<?php
}
else{
    header('Location:../index.php');    
}
?>
