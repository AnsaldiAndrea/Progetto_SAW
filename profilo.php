<!DOCTYPE html>
<html lang="it">
<?php
    $map = FALSE;
    $title = 'Profilo';
    include('template/head.php');
    include("template/403.php");
    include('helper/tags_helper.php');
    include('helper/request_helper.php');
    include('helper/game_helper.php');
?>

<script src="js/profilo.js"></script>

<body>
    <?php include('template/navbar.php') ?>
    
    <div class="container">
        <?php include('template/error.php') ?>
        <h2><strong><?php if($_SESSION['gender']==='F') :?>Benvenuta<?php else: ?>Benvenuto<?php endif ?>
            <?= $_SESSION['name'] ?> </strong>
        </h2>

        <div class="col-md-4">
        <ul class="list-group">
            <li class="list-group-item text-muted">Profilo</li>
            <li class="list-group-item">
                <img class="profile_pic img-circle center-block" src="uploads/<?= $_SESSION['username']?>" onError="this.onerror=null;this.src='uploads/default.jpg';"></img>
                <a href="" class="btn btn-default"  data-toggle="modal" data-target="#upload_modal" title="Modifica Immagine Profilo"><span class="glyphicon glyphicon-pencil"></span></a>
            </li> 
            <li class="list-group-item">Username: <strong><?= $_SESSION['username'] ?></strong></li>
            <li class="list-group-item">Nome: <strong><?= $_SESSION['name'] ?></strong></li>
            <li class="list-group-item">Email: <strong><?= $_SESSION['email'] ?></strong></li>
            <li class="list-group-item">Età: <strong><?= $_SESSION['age'] ?></strong></li>
            <li class="list-group-item">Indirizzo: <strong><?= $_SESSION['address'] ?></strong></li>
            <?php $tags = get_user_tags(); ?>
            <li class="list-group-item">Tags: <strong><?= implode(', ', $tags) ?></strong></li>
        </ul>
        <a href="modificaprofilo.php" class="btn btn-primary">Modifica Profilo</a> 
        </div>

        <div class="col-md-8">
            <div id="request_error" class="alert alert-dismissible" style="display: none;">
                <span></span>
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            </div>
            <ul class="nav nav-tabs">
                <li class="active">
                    <a data-toggle="tab" href="#request">Status Richieste</a>
                </li>
                <li>
                    <a data-toggle="tab" href="#received">Richieste Ricevute</a>
                </li>
                <li>
                    <a data-toggle="tab" href="#games">Partite Create</a>
                </li>
            </ul>

            <div class="tab-content">
                <div id="request" class="tab-pane fade active in">
                    <ul class="list-group">
                    <?php $requests = get_requests($_SESSION['username']) ?>
                    <?php if($requests==NULL or empty($requests)) :?>
                        <li class="list-group-item">Non hai ancora mandato nessuna richiesta. Vai alla pagina di una partita e clicca su Invia Richista per inviare una richiesta all'host della Partita</li>
                    <?php else: ?>
                        <?php foreach($requests as $r) :?>
                            <?php $r['date'] = DateTime::createFromFormat('Y-m-d H:i:s',$r['date'])->format('d/m/Y H:i');?>
                            <li id="req_<?= $r['game_id'] ?>" class="row list-group-item list-group-item-<?php if($r['status']===0) :?>warning<?php elseif($r['status']===1) : ?>success<?php else : ?>danger<?php endif; ?>">
                                <div class="col-md-9">
                                    <a href="partita.php?id=<?= $r['game_id'] ?>"><strong><?= $r['game'] ?></strong></a><br>
                                    Host: <a href="utente.php?user=<?= base64_encode($r['host'])?>"><strong><?= $r['host'] ?></strong></a><br>
                                    Data: <strong><?= $r['date'] ?></strong><br>
                                </div>
                                <div class="col-md-3">
                                    <a onclick="deleteRequest(<?= $r['game_id']?>,'<?= $_SESSION['username'] ?>')" class="btn btn-danger pull-right" title="Cancella Richista"><span class="glyphicon glyphicon-remove"></span></a>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    <?php endif ?>
                    </ul> 
                </div>
                <div id="received" class="tab-pane fade">
                    <ul class="list-group">
                    <?php $requests = get_received_requests($_SESSION['username']) ?>
                    <?php if($requests==NULL or empty($requests)) :?>
                        <li class="list-group-item">Non hai ancora ricevuto nessuna richiesta</li>
                    <?php else: ?>
                        <?php foreach($requests as $r) :?>
                            <?php $r['date'] = DateTime::createFromFormat('Y-m-d H:i:s',$r['date'])->format('d/m/Y H:i');?>
                            <li id="rec_<?= $r['id'] ?>_<?= $r['user'] ?>" class="row list-group-item list-group-item-<?php if($r['status']===0) :?>warning<?php elseif($r['status']===1) : ?>success<?php else : ?>danger<?php endif; ?>">
                                <div class="col-md-9">
                                    <a href="partita.php?id=<?= $r['id'] ?>"><strong><?= $r['game'] ?></strong></a><br>
                                    Utente: <a href="utente.php?user=<?= base64_encode($r['user'])?>"><strong><?= $r['user'] ?></strong></a><br>
                                    Data: <strong><?= $r['date'] ?></strong><br>
                                </div>
                                <div class="col-md-3">
                                    <a onclick="denyRequest(<?= $r['id'] ?>, '<?= $r['user'] ?>')" class="btn btn-danger pull-right" title="Rifiuta"><span class="glyphicon glyphicon-remove"></span></a>
                                    <a onclick="acceptRequest(<?= $r['id'] ?>, '<?= $r['user'] ?>')" class="btn btn-success pull-right" title="Accetta"><span class="glyphicon glyphicon-ok-sign"></span></a>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    <?php endif ?>
                    </ul> 
                </div>
                <div id="games" class="tab-pane fade">
                    <ul class="list-group">
                    <?php $games = userGames($_SESSION['username']) ?>
                    <?php if($games==NULL or empty($games)) :?>
                        <li class="list-group-item">Non hai ancora creato una partita.</li>
                    <?php else: ?>
                        <?php foreach($games as $g) :?>
                            <?php $g['date'] = DateTime::createFromFormat('Y-m-d H:i:s',$g['date'])->format('d/m/Y H:i');?>
                            <li id="game_<?= $g['id'] ?>" class="row list-group-item list-group-item-<?php if($g['status']===0) :?>danger<?php else : ?>success<?php endif; ?>">
                                <div class="col-md-9">
                                    <a href="partita.php?id=<?= $g['id'] ?>"><strong><?= $g['game'] ?></strong></a><br>
                                    Data: <strong><?= $g['date'] ?></strong><br>
                                    Indirizzo: <strong><?= $g['address'] ?></strong><br>
                                </div>
                                <div class="col-md-3">
                                    <a onclick="deleteGame(<?= $g['id']?>)" class="btn btn-danger pull-right" title="Cancella Partita"><span class="glyphicon glyphicon-remove"></span></a>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    <?php endif ?>
                    </ul> 
                </div>
            </div>
        </div>

    </div>

    <div id="upload_modal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modifica Immagine Profilo</h4>
                </div>
                <form method="post" action="checkprofilepicture.php" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="profile_pic">Scegli l'immagine da caricare</label>
                        <input type="file" id="profile_pic" name="profile_pic">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-default">Modifica</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Esci</button>
                </div>
                <form>
            </div>

        </div>
    </div>

<?php include("template/footer.php") ?>

</body>

</html>
