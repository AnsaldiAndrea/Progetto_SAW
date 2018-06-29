<!DOCTYPE html>
<html lang="it">

<?php
    $map=FALSE;
    $title = "Cerca Partita";
    include('template/head.php');
    include('helper/functions.php');
    include('template/403.php');
    include('helper/search.php');
    $input = clear_input($_GET);
?>

<body>
<?php include('template/navbar.php') ?>
<div class="container">
    <?php include("template/error.php") ?>
<div class="row">
    <div class="col-md-4">
    <form action="cerca.php" method="get">
        <div class="form-group">
            <label for="titolo">Ricerca per titolo:</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
                <input class="form-control" id="titolo" name="titolo" placeholder="Inserisci il titolo" value=<?= $input['title']?>><br>
            </div>
        </div>
        <div class="form-group">
            <label for="citta">Ricerca per citt&agrave;: </label>
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
                <input class="form-control"  id="citta" name="citta" placeholder="Inserisci la citta"value=<?= $input['city']?>><br>
            </div>
        </div>
        <div class="form-group">
            <label>Ricerca per Tag</label>
            <?php $_tags=$input['tags']; include('template/tags.php') ?>
        </div>
        <button type="submit" class="btn btn-primary">Cerca</button>
        <a href="cerca.php" class="btn btn-default">Cancella</a>

    </form>
    </div>
    
    <div class=col-md-8>
        <h2>Risultati ricerca</h2>
        <ul>
        <?php $search_result = search($_GET);?>
        <?php if($search_result): ?>
            <?php foreach($search_result as $item) :?>
                <li id="<?= $item['id'] ?>" class="row list-group-item">
                <?php $d = DateTime::createFromFormat('Y-m-d H:i:s', $item['date'])->format('d/m/Y H:i'); ?>
                    <a href="partita.php?id=<?= $item['id'] ?>"><strong><?= $item['game'] ?></strong></a><br>
                    Host: <strong><a href="utente.php?user=<?= base64_encode($item['host']) ?>"><?= $item['host']?></a></strong><br>
                    Data: <strong><?= $d ?></strong><br>
                    Indirizzo: <strong><?= $item['address'] ?></strong><br>
                </li>
            <?php endforeach ?>
        <?php else : ?>
            <li class="row list-group-item">Nessun Risultato</li>
        <?php endif ?>
        </ul>

    </div>
    </div>
</div>

<?php include('template/footer.php') ?>

</body>
</html>
