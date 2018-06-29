<!DOCTYPE html>
<html lang="it">

<?php
    $map = FALSE;
    $title = "Accesso Non Autorizzato";
    include('template/head.php');
?>

<body>

<?php include('template/navbar.php') ?>

<div class="container">
    <h1>Errore 403: Accesso non autorizzato</h1>
    <p>Per accedere a molte delle funzioni di questo sito è necessario avere un account</p>
    <p>Sei sei già iscritto, effettua l'accesso: <a href="login.php">Login</a></p>
    <p>Altrimenti, crea un account: <a href="iscrizione.php">Registrati</a></p>
</div>

<?php include('template/footer.php') ?>

</body>
</html>