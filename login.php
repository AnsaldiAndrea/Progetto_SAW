<!DOCTYPE html>
<html lang="it">

<?php
    $map = FALSE;
    $title = "Login";
    include('template/head.php');

    if(isset($_SESSION['logged_in'])){
        $_SESSION['error'] = ['warning', "Non puoi effettuare di nuovo il login. Se vuoi accedere con un altro account prima fare il <a href='logout.php'>Logout</a>"];
        header("Location: index.php");
        exit();
    }
?>

<body>

<?php include('template/navbar.php') ?>

<div class="container">
    <div class="col-md-9 center-block">
        <h1>Login</h1><br>
        <?php include('template/error.php') ?>
        <form method="post" action="checklogin.php">
            <div class="form-group">
                <label for="nome">Username:</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-user"></span>
                    </div>
                    <input class="form-control"  id="username" name="username" placeholder="Inserisci Username">
                </div>
            </div>

            <div class="form-group">
                <label for="nome">Password: </label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-lock"></span>
                    </div>
                    <input class="form-control"  id="password" name="password" type="password" placeholder="Inserisci Password">
                </div>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        <br>
        <span>Non hai un account?
            <a href="iscrizione.php">Iscriviti</a>
        </span>
    </div>
</div>

<?php include('template/footer.php') ?>

</body>
</html>