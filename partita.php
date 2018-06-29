<?php 
include('helper/game_helper.php');
if(!($game = get_partita($_GET['id']))){
    header('Location: 404.php');
    exit();
}
$game['date'] = DateTime::createFromFormat('Y-m-d H:i:s', $game['date'])->format('d/m/Y H:i');
?>

<!DOCTYPE html>
<html lang="it">
<?php
    $map = TRUE;
    $title = 'Partita';
    include('template/head.php');
    include("template/403.php");
    include("helper/tags_helper.php");
    include("helper/request_helper.php");
?>
<head>
    <script src="js/profilo.js"></script>
    <script src="js/partita.js"></script>
    <script>
    $(function () {
        createMap(<?= $game['lat']?>, <?= $game['lng']?>, "<?= $game['address']?>");
    });
    </script>
</head>

<body>
    <?php include('template/navbar.php') ?>

<div class="container">
    <div>
        <?php include("template/error.php") ?>
        <div id="request_error" class="alert alert-dismissible" style="display: none;">
            <span></span>
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        </div>
        <h2><?= $game['game']?></h2>

        <div class="col-md-4">
            <ul class="list-group">
                <li class="list-group-item">Host: <strong><a href="utente.php?user=<?= base64_encode($game['host']) ?>"><?= $game['host']?></a></strong></li>
                <li class="list-group-item">Numero giocatori: <strong><?= $game['n_player'] ?></strong></li>
                <li class="list-group-item">Data: <strong><?= $game['date'] ?></strong></li>
                <li class="list-group-item">Indirizzo: <strong><?= $game['address'] ?></strong></li>
                <?php $tags = get_game_tags($_GET['id']); ?>
                <li class="list-group-item">Tags: <strong><?= implode(', ', $tags) ?></strong></li>
                <li class="list-group-item">Commenti:<br><strong><?= $game['comment']?></strong></li>
            </ul>

            <?php if($_SESSION['username']!==$game['host']) : ?>
            <a id="send_request" onclick="send_request(<?= $game['id'] ?>, '<?= $_SESSION['username'] ?>')" class="btn btn-primary" style="margin-bottom:15px">Invia Richiesta</a><br>
            <?php endif ?>
            <ul class="list-group">
            <?php $requests = get_requests_for_game($game['id']) ?>
            <?php if($game['host'] == $_SESSION['username']) : ?>
                <li class="list-group-item text-muted">Richieste ricevute</li>
                <?php foreach($requests as $r) :?>
                    <li id="rec_<?= $r['id'] ?>_<?= $r['user'] ?>" class="row list-group-item list-group-item-<?php if($r['status']===0) :?>warning<?php elseif($r['status']===1) : ?>success<?php else : ?>danger<?php endif; ?>">
                        <div class="col-md-7">
                            Utente: <a href="utente.php?user=<?= base64_encode($r['user']) ?>"><?= $r['user']?></a><br>
                        </div>
                        <div class="col-md-5">
                            <a onclick="denyRequest(<?= $r['id'] ?>, '<?= $r['user'] ?>')" class="btn btn-danger btn-sm pull-right" title="Rifiuta"><span class="glyphicon glyphicon-remove"></span></a>
                            <a onclick="acceptRequest(<?= $r['id'] ?>, '<?= $r['user'] ?>')" class="btn btn-success btn-sm pull-right" title="Accetta"><span class="glyphicon glyphicon-ok-sign"></span></a>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php else : ?>
                <li class="list-group-item text-muted">Richieste Accettate</li>
                <?php foreach($requests as $r) :?>
                    <?php if($r['status']===1) :?>
                    <li id="rec_<?= $r['id'] ?>_<?= $r['user'] ?>" class="row list-group-item list-group-item-success">
                        <div>
                            Utente: <a href="utente.php?user=<?= base64_encode($r['user']) ?>"><?= $r['user']?></a><br>
                        </div>
                    </li>
                    <?php endif ?>
                <?php endforeach; ?>
            <?php endif; ?>
            </ul> 

        </div>
        <div class="col-md-8">
            <div id="map_container">
                <div id="map" style="width: 100%; height: 500px; margin: auto;"></div>
            </div>
        </div>   
    </div>


</div>

<?php include('template/footer.php') ?>

</body>
</html>
