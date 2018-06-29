<!DOCTYPE html>
<html lang="it">

<?php
    $map = FALSE;
    $title = "Homepage";
    include('template/head.php'); 
    include('helper/game_helper.php');
?>

<body>

<?php include('template/navbar.php') ?>
<div class="container">
    <?php include('template/error.php'); ?>
    <div class="row">
        <div class="col-md-8">
            <blockquote>
                <p>Si pu&ograve; scoprire di pi&ugrave; su una persona in un’ora di gioco che in un anno di conversazione.</p>
                <footer class="text-muted">Platone</footer>
            </blockquote>

            <h3 class="justify-text">Tabletop Tavern &egrave; un luogo d'incontro per gli appassionati di giochi di carte e da tavolo.
                <br> Nasce da un problema comune a tutti i giocatori di questo tipo, ovvero la mancanza di un giocatore durante una
                partita, di solito si realizza di frequente con i giochi da tavolo, dove &egrave; richiesto un minimo numero
                di giocatori per poter creare una partita.
                <br> Perci&ograve; questo sito offre la possibilità di condividere e cercare partite per qualsiasi tipo di gioco
                di carte e da tavolo. Ha una modalit&agrave; di ricerca territoriale in modo tale da cercare partite e giocatori
                nella propria zona rendendo il servizio facile e comodo.
                <br>
            </h3>
            <span>Non hai un account?
                <a href="register.html">Registrati</a>
            </span>
            <img src="tabletop.jpg" class="img-responsive" alt="scacchiera">
        </div>
        <div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <span class="glyphicon glyphicon-exclamation-sign"></span><strong><?php if(isset($_SESSION['logged_in'])) :?>  Partite che potrebbero Interessarti<?php else : ?>  Nuove Partite<?php endif ?></strong></div>
                <div class="panel-body list-group" id="partite">
                <?php $games = get_new_games(); ?>
                <?php foreach($games as $g) :?>
                    <li id="<?= $g['id'] ?>" class="row list-group-item">
                    <?php $d = DateTime::createFromFormat('Y-m-d H:i:s', $g['date'])->format('d/m/Y H:i'); ?>
                        <a href="partita.php?id=<?= $g['id'] ?>"><strong><?= $g['game'] ?></strong></a><br>
                        Host: <a href="utente.php?user=<?= base64_encode($g['host'])?>"><strong><?= $g['host'] ?></strong></a><br>
                        Data: <strong><?= $d ?></strong><br>
                        Indirizzo: <strong><?= $g['address'] ?></strong><br>
                    </li>
                <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include('template/footer.php') ?>
</body>

</html>
