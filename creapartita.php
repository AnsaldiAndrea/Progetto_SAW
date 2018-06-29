<!DOCTYPE html>
<html lang="it">
<?php
    $map=TRUE;
    $title = "Crea Partita";
    include('template/head.php');
    include('template/403.php');
?>

<head>
    <script>
    $(function () {
        setDefaultPosition(<?= $_SESSION['lat'] ?>, <?= $_SESSION['lng'] ?>,
            "<?= $_SESSION['address'] ?>")
        initMap();
        var current_value = "";
        $('#indirizzo').blur(function () {
            if (current_value != $("#indirizzo").val()) {
                current_value = $("#indirizzo").val();
                initMap();
            }
        });
    });
    </script>

</head>

<body>
    <?php include('template/navbar.php'); ?>

    <div class="container">

        <h1>Crea la tua Partita</h1>
        <?php include('template/error.php') ?>
        <form method="post" action="checkcreategame.php">
            <div class="form-group">
                <label for="titolo">Titolo: </label>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="glyphicon glyphicon-pencil"></i>
                    </span>
                    <input class="form-control" id="titolo" name="titolo" placeholder="Inserisci il titolo">
                    <br>
                </div>
            </div>
            <div class="form-group">
                <label for="partecipanti">Numero Partecipanti (indicativo): </label>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="glyphicon glyphicon-user"></i>
                    </span>
                    <input class="form-control" id="partecipanti" name="partecipanti" placeholder="inserisci il numero di partecipanti(indicativo)">
                </div>
            </div>
            <div class="form-group">
                <label for="indirizzo">Indirizzo (se diverso da quello di residenza): </label>
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
                <div id="address_error"class="well well-danger well-sm" style="display:none">
                    <input name="address_error" hidden>
                    <span>test</span>
                </div>
            </div>
            <input id="lat" name="lat" hidden>
            <input id="lng" name="lng" hidden>
            <input id="address" name="address" hidden>
            <div id="map_container" class="collapse">
                <div id="map" style="width: 100%; height: 500px; margin: auto;"></div>
            </div>
            <div class="form-group">
                <label for="data">Data e Ora (Giorno/Mese/Anno Ora:Minuti): </label>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="glyphicon glyphicon-calendar"></i>
                    </span>
                    <input class="form-control" id="data" name="data" placeholder="Inserisci la data in cui vuoi iniziare la partita">
                </div>
            </div>
            <div class="form-group">
                <label for="descrizione">Descrizione/Commento:(massimo 255 caratteri) </label>
                <div class="form-group">
                    <textarea maxlength="255" class="form-control" name="descrizione" id="descrizione"></textarea>
                </div>
            </div>

            <div class="form-group">
                <label>Tags (seleziona almeno 1):</label>
                <?php $_tags=[]; include('template/tags.php') ?>
            </div>
            <br>
            <button type="submit" class="btn btn-primary" name="submit_button" style="margin-top: 5px">Crea partita</button>
        </form>
    </div>

    <?php include('template/footer.php'); ?>

</body>

</html>
