<!DOCTYPE html>
<html lang="it">
<?php
    $map = FALSE;
    $title = 'Profilo';
    include('template/head.php');
    include("template/403.php");
    include('helper/game_helper.php');
    include("helper/user_helper.php");
    include("helper/tags_helper.php");

    if(isset($_GET['user']) and !empty($_GET['user'])){
        $info =get_user_info(base64_decode($_GET['user']));
        if(!$info){
            header("Location: 404.php");
            exit();    
        }
    } else {
        header("Location: 404.php");
        exit();
    }
?>

<script src="js/profilo.js"></script>

<body>
    <?php include('template/navbar.php') ?>
    
    <div class="container">
        <?php include('template/error.php') ?>
        <h2>Profilo di <strong><?= $info['name'] ?></strong></h2>

        <div class="col-md-4">
        <ul class="list-group">
            <li class="list-group-item text-muted">Profilo</li>
            <li class="list-group-item">
                <img class="profile_pic img-circle center-block" src="uploads/<?= $info['username']?>" onError="this.onerror=null;this.src='uploads/default.jpg';"></img>
            </li> 
            <li class="list-group-item">Username: <strong><?= $info['username'] ?></strong></li>
            <li class="list-group-item">Nome: <strong><?= $info['name'] ?></strong></li>
            <li class="list-group-item">Email: <strong><?= $info['email'] ?></strong></li>
            <li class="list-group-item">Età: <strong><?= $info['age'] ?></strong></li>
            <li class="list-group-item">Indirizzo: <strong><?= $info['address'] ?></strong></li>
            <?php $tags = get_user_tags_from_username($info['username']); ?>
            <li class="list-group-item">Tags: <strong><?= implode(', ', $tags) ?></strong></li>
        </ul>
        <a href="chat.php?user=<?= base64_encode($info['username']) ?>" class="btn btn-primary">Inizia Chat</a> 
        </div>

        <div class="col-md-8">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a data-toggle="tab" href="#games">Partite Create</a>
                </li>
            </ul>

            <div class="tab-content">
                <div id="games" class="tab-pane fade active in">
                    <ul class="list-group">
                    <?php $games = userGames($info['username']) ?>
                    <?php if($games==NULL or empty($games)) :?>
                        <li class="list-group-item"><?= $info['username'] ?> non ha ancora creato nessuna partita</li>
                    <?php else: ?>
                        <?php foreach($games as $g) :?>
                            <?php $g['date'] = DateTime::createFromFormat('Y-m-d H:i:s',$g['date'])->format('d/m/Y H:i');?>
                            <li id="game_<?= $g['id'] ?>" class="row list-group-item list-group-item-<?php if($g['status']===0) :?>danger<?php else : ?>success<?php endif; ?>">
                                <a href="partita.php?id=<?= $g['id'] ?>"><strong><?= $g['game'] ?></strong></a><br>
                                Data: <strong><?= $g['date'] ?></strong><br>
                                Indirizzo: <strong><?= $g['address'] ?></strong><br>
                            </li>
                        <?php endforeach; ?>
                    <?php endif ?>
                    </ul> 
                </div>
            </div>
        </div>

    </div>

<?php include("template/footer.php") ?>

</body>

</html>
