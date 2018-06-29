<!DOCTYPE html>
<html lang="it">
<?php
    $map = TRUE;
    $title = "Iscrizione";
    include('template/head.php');

    if(isset($_SESSION['logged_in'])){
        $_SESSION['error'] = ['warning', "Non puoi creare un nuovo account mentre sei connesso. Devi prima fare il <a href='logout.php'>Logout</a>"];
        header("Location: index.php");
        exit();
    }
?>
<head>
    <script>
        $(function () {
            setDefaultPosition(44.4056499, 8.946256,"Inserisci un indirizzo");
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
    <script src="js/creapartita.js"></script>
</head>
<body>
    <?php include('template/navbar.php') ?>

    <div class="container">
        <div class="col-md-9 center-block">
            <h1>Registrazione</h1>
            <?php include('template/error.php') ?>
            <form action="checkiscrizione.php" method="post">
                <div class="form-group">
                    <label for="nome">Nome Cognome:</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-pencil"></span>
                        </div>
                        <input class="form-control" id="nome" name="nome" placeholder="Inserisci nome e cognome" maxlenght=64>
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
                    <label>Genere:</label>
                    <div class="radio" id="gender">
                        <label class="radio-inline">
                            <input id="genere_m" type="radio" name="genere" value="m">Maschio</label>
                        <label class="radio-inline">
                            <input id="genere_f" type="radio" name="genere" value="f">Femmina</label>
                        <label class="radio-inline">
                            <input id="genere_a" type="radio" name="genere" value="a">Altro</label>
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
                    <label for="email">Email:</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-envelope"></span>
                        </div>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Inserisci email">
                    </div>
                </div>

                <div class="form-group">
                    <label for="username">Username:</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-user"></span>
                        </div>
                        <input class="form-control" id="username" name="username" placeholder="Inserisci username">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-lock"></span>
                        </div>
                        <input class="form-control" id="password" name="password" type="password" placeholder="Inserisci password (almeno 8 caratteri dei quali almeno un numero e un carattere">
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
                <br>
                <button type="submit" class="btn btn-primary">Registrati</button>
            </form>
            <br>
            <span>Hai gi&agrave; un account?
                <a href="login.php">Accedi</a>
            </span>
        </div>
    </div>

    <?php include("template/footer.php") ?>
</body>

</html>