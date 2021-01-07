<!DOCTYPE html>
<html lang="fr" prefix="og: http://ogp.me/ns#">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require(VIEW . "component/link.php"); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:type" content="website">
    <meta property="og:title" content="RhinoShield Api" />
    <meta property="og:description" content="Hey mate, wanna try something new ?" />
    <meta property="og:url" content="https://heavenmc.org" />
    <meta property="og:image" content="https://heavenmc.org/images/icon.png" />
    <link rel="icon" href="<?php echo IMG . "favicon.ico"; ?>" type="image/ico" />
    <!-- <link href="https://fonts.googleapis.com/css?family=Varela+Round&display=swap" rel="stylesheet"> -->
    <link href="https://fonts.googleapis.com/css?family=Bellota+Text:700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Muli:wght@300&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/cd6031ebf4.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="<?php echo JS . "parallax.min.js"; ?>"></script>
    <title>RhinoShield</title>
</head>

<body>
    <div class="main">
        <div class="row --error">
            <p class="--tcenter"><i><?php echo $content; ?></i></p>
        </div>
        <div class="row --bwhite">
            <p class="--tcenter"><img src="<?php echo IMG . "rickgif.gif"; ?>" alt="" height="100" width="75"></p>
        </div>
    </div>
</body>

</html>