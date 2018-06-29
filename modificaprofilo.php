<!DOCTYPE html>
<html lang="it">

<?php
    $map = TRUE;
    $title = "Modifica Profilo";
    include('template/head.php');
    include('template/403.php');
    include('helper/tags_helper.php');
?>

<head>
<script>
    $(function () {
        createMap(<?= $_SESSION['lat']?>, <?= $_SESSION['lng']?>, "<?= $_SESSION['address']?>");
    });
</script>
</head>

<body>

<?php include('template/navbar.php') ?>

<div class="container">
    <h1>Modifica Profilo</h1>
    <?php include('template/error.php') ?>
    <form method="post" action="checkchanges.php">
        <div class="form-group">
            <label for="email">Email:</label>
            <div class="input-group">
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-envelope"></span>
                </div>
                <input type="email" class="form-control" id="email" name="email" placeholder="Inserisci email">
            </div>
        </div>
        <div class="form-group">
            <label for="dataN">Et&agrave;</label>
            <div class="input-group">
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </div>
                <input class="form-control" id="eta" name="eta" placeholder="Inserisci la tua et&agrave;">
            </div>
        </div>
        <div class="form-group">
            <label for="indirizzo">Indirizzo: </label>
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="glyphicon glyphicon-home"></i>
                </span>
                <input class="form-control" id="indirizzo" name="indirizzo" placeholder="Inserisci l'indirizzo">
                <div class="input-group-btn" id="show-map" data-toggle="collapse" data-target="#map_container">
                    <a class="btn btn-default" title="Visualizza Mappa">
                        <i class="glyphicon glyphicon-map-marker"></i>
                    </a>
                </div>
            </div>
        </div>
        <input id="lat" name="lat" hidden>
        <input id="lng" name="lng" hidden>
        <input id="address" name="address" hidden>
        <div id="map_container" class="collapse">
            <div id="map" style="width: 100%; height: 500px; margin: auto;"></div>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <div class="input-group">
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-lock"></span>
                </div>
                <input class="form-control" id="password" name="password" type="password" placeholder="Inserisci password">
            </div>
        </div>

        <div class="form-group">
            <label for="confirm_password">Conferma Password:</label>
            <div class="input-group">
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-exclamation-sign"></span>
                </div>
                <input class="form-control" id="conferma_password" name="conferma_password" type="password" placeholder="Reinserisci la password">
            </div>
        </div>
        <div class="form-group">
            <label>Modifica Tag</label>
            <?php $_tags=get_user_tags_id(); include('template/tags.php') ?>
        </div>
        <br><button type="submit" class="btn btn-primary">Modifica</button>
    </form>
</div>

<?php include('template/footer.php') ?>

</body>
</html>
