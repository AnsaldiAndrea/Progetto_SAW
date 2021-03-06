<?php session_start() ?>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="favicon.ico" >
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/generale.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<?php if($map) : ?>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDG1sLHUnPTXltEtkhUPVXxTPbvg-Kali8&sensor=false"></script>
    <script src="js/map_utils.js"></script>
<?php endif ?>
    <title>Tabletop Tavern: <?= $title ?></title>
</head>
