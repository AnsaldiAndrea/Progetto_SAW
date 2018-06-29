<!DOCTYPE html>
<html lang="it">

<?php
    $map = FALSE;
    $title = "Chat";
    include('template/head.php');
    include('template/403.php');
    include('helper/get_messages.php');
    include_once('helper/connection.php');
    include_once('helper/functions.php');

    $user = "";
    $result = [];
    $_new = FALSE;
    if(isset($_GET['user'])){
        $user = base64_decode($_GET['user']);
        $result = get_messages($user);
    }
?>
<script src="js/chat.js"></script>
<body>
<?php include('template/navbar.php') ?>
<div class="container">
    <?php include('template/error.php'); ?>
    <div class="row">
        <div class="col-md-3">
            <h4><strong>Chat attive</strong></h4>
            <?php $active_chat = get_chat(); ?>
            <?php if($active_chat==NULL or empty($active_chat)) :?>
                <p>Non hai ancora chattato con nessuno.</p>
                <p>Per farlo, vai alla loro pagina profilo e clicca su "Invia Messaggio"</p>
            <?php else: ?>
            <div class="list-group">
                <?php foreach($active_chat as $active) : ?>
                    <a href="chat.php?user=<?= base64_encode($active['user']) ?>" class="list-group-item"><?= $active['user'] ?></a>
                <?php endforeach ?>
            </div> 
            <?php endif; ?>
        </div>
        <div class="col-md-9">
            <?php if($result!==NULL and $user) :?>
            <h2><?php if($user) : ?>Stai chattando con <?= $user ?><?php else : ?>Seleziona un nome per chattare<?php endif ?></h2>
            <div id="chat" class="pre-scrollable" >
                <?php $_new=1;foreach($result as $message) : ?>
                <?php if($message['sender']===$_SESSION['username']):?>
                    <div class="row chat_row">
                        <div class="col-md-9 col-md-offset-3">
                            <div class="well well-sm well-sender">
                            <?=$message['message'] ?></div>
                        </div>
                    </div>
                <?php else : ?>
                    <?php if($message['read_time'] == NULL and $_new): ?>
                    <div class="row chat_row">
                        <span><mark>New!</mark></span><br>
                    </div>
                    <?php $_new=0; endif ?>
                    <div class="row chat_row">
                        <div class="col-md-9">
                        <div class="well well-sm well-receiver">
                            <?=$message['message'] ?></div>
                        </div>
                    </div>
                <?php endif ?>
                <?php endforeach ?>
            </div>
            <br>
            <form method='post' action='chatsupport.php'>
                <div class="input-group">
                    <input type='hidden' name='receiver' id='receiver' value="<?=$user?>" >
                    <input type="text" class="form-control" placeholder="Scrivi un messaggio" name="message" maxlenght=255>
                    <div class="input-group-btn">
                    <button class="btn btn-default" type="submit" title="Invia Messaggio">
                        <i class="glyphicon glyphicon-send"></i>
                    </button>
                    </div>
                </div>
            </form>
            <?php else: ?>
            <h2>Seleziona un utente per chattare</h2>
            <?php endif ?>
        </div>
    </div>
</div>

<?php include('template/footer.php') ?>

</body>
</html>