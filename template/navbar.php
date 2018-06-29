<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="index.php" class="navbar-left navbar-icon-container"><img class="navbar-icon" src="navbar_icon.png"></a>
            <a class="navbar-brand" href="index.php">
                Tabletop Tavern
            </a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right">
            <?php if(isset($_SESSION['logged_in'])) : ?>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="profilo.php">Benvenuto/a <strong><?= $_SESSION['name'] ?> </strong>
                    <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="profilo.php"><span class="glyphicon glyphicon-user"></span> Profilo</a></li>
                        <li><a href="cerca.php"><span class="glyphicon glyphicon-search"></span> Cerca Partite</a></li>
                        <li><a href="creapartita.php"><span class="glyphicon glyphicon-plus"></span> Crea Partita</a></li>
                        <li><a href="chat.php"><span class="glyphicon glyphicon-comment"></span> Chat</a></li>
                    </ul>
                <li>
                <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
            <?php else : ?>
                <li><a href="iscrizione.php"><span class="glyphicon glyphicon-user"></span> Registrazione</a></li>
                <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
            <?php endif ?>
            </ul>
        </div>
    </div>
</nav>
