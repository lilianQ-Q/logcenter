<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>noxLogcenter</title>
    <script src="https://kit.fontawesome.com/cd6031ebf4.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,900;1,100;1,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php ECHO CSS . "main.css" ?>">
</head>
<body>
    
    <div class="header">
        <!-- Blabla title blabla, c'est le path en gros -->
        <div id="burger" class="menu"><i class="fas fa-bars"></i></div>
        <h2 class="title --ccyan">Actulog Logcenter //</h2>
    </div>

    <div id="sidebar" class="sidebar">
        <!-- Blabla sidebar blabla -->
        <div class="element-list">
            <ul>
                <li><div class="element"><i class="fas fa-home"></i><h2 class="element-title">Accueil</h2></div></li>
                <li><div class="element"><i class="fas fa-list"></i><h2 class="element-title">Log list</h2></div></li>
                <li><div class="element"><i class="fas fa-paper-plane"></i><h2 class="element-title">Partager</h2></div></li>
            </ul>
        </div>
    </div>

    <div class="main">
        <!-- Here goes the main things -->
        <div class="row">
            <div class="research">
                <div class="display"><i class="fas fa-monument"></i></div>
                <div class="text-area"><input type="text" id="research" placeholder="Recherche de logs..."></div>
                <div class="search"><i class="fas fa-search"></i></div>
            </div>
        </div>

        <div class="row">
            <table>
                <!-- Here goes the main table -->
                <thead>
                    <tr>
                        <th width="50px">Time</th>
                        <th width="100px">Méthode</th>
                        <th width="120px">Origine</th>
                        <th>Log</th>
                        <th width="120px" style="text-align:center;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>21:34</td>
                        <td class="--get">GET</td>
                        <td>HappyAuto</td>
                        <td>Balblablabla requête éxécutée blabla</td>
                        <td><div class="status"><div class="--circle --bcyan"></div> 200 OK</div></td>
                    </tr>
                    <tr>
                        <td>21:35</td>
                        <td class="--get">GET</td>
                        <td>HappyAuto</td>
                        <td>Balblablabla requête éxécutée blabla</td>
                        <td><div class="status"><div class="--circle --bcyan"></div> 200 OK</div></td>
                    </tr>
                    <tr>
                        <td>21:36</td>
                        <td class="--post">POST</td>
                        <td>HappyAuto</td>
                        <td>Balblablabla requête éxécutée blabla</td>
                        <td><div class="status"><div class="--circle --bcyan"></div> 200 OK</div></td>
                    </tr>
                    <tr>
                        <td>21:29</td>
                        <td class="--post">POST</td>
                        <td>HappyAuto</td>
                        <td>Balblablabla requête éxécutée blabla</td>
                        <td><div class="status"><div class="--circle --bcyan"></div> 200 OK</div></td>
                    </tr>
                    <tr>
                        <td>21:28</td>
                        <td class="--post">POST</td>
                        <td>HappyAuto</td>
                        <td>Balblablabla requête éxécutée blabla</td>
                        <td><div class="status"><div class="--circle --bcyan"></div> 200 OK</div></td>
                    </tr>
                    <tr>
                        <td>21:29</td>
                        <td class="--post">POST</td>
                        <td>HappyAuto</td>
                        <td>Balblablabla requête éxécutée blabla</td>
                        <td><div class="status"><div class="--circle --bcyan"></div> 200 OK</div></td>
                    </tr>
                    <tr>
                        <td>21:30</td>
                        <td class="--post">POST</td>
                        <td>HappyAuto</td>
                        <td>Balblablabla requête éxécutée blabla</td>
                        <td><div class="status"><div class="--circle --bcyan"></div> 200 OK</div></td>
                    </tr>
                    <tr>
                        <td>21:34</td>
                        <td class="--post">POST</td>
                        <td>HappyAuto</td>
                        <td>Balblablabla requête éxécutée blabla</td>
                        <td><div class="status"><div class="--circle --bcyan"></div> 200 OK</div></td>
                    </tr>
                    <tr>
                        <td>21:34</td>
                        <td class="--post">POST</td>
                        <td>HappyAuto</td>
                        <td>Balblablabla requête éxécutée blabla</td>
                        <td><div class="status"><div class="--circle --bcyan"></div> 200 OK</div></td>
                    </tr>
                    <tr>
                        <td>21:34</td>
                        <td class="--post">POST</td>
                        <td>HappyAuto</td>
                        <td>Balblablabla requête éxécutée blabla</td>
                        <td><div class="status"><div class="--circle --bcyan"></div> 200 OK</div></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="row" style="margin-top:20px;justify-content:space-around;flex-wrap:wrap;">
            <div class="card">
                <div class="card--title"><h2 class="--csmoke">Statistics</h2></div>
                <div class="card--body">
                    <table>
                        <tbody>
                            <tr>
                                <td>Nombre de logs</td>
                                <td>8920</td>
                            </tr>
                            <tr>
                                <td>Estimation d'aujourd'hui</td>
                                <td>Stonks <i class="fas fa-long-arrow-alt-up fa-lg --stonks"></i></td>
                            </tr>
                            <tr>
                                <td>Solenne</td>
                                <td>0 request</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card--title"><h2 class="--csmoke">Réponse</h2></div>
                <div class="card--body">
                    <table>
                        <tbody>
                            <tr>
                                <td>Attend</td>
                                <td>Quoi ?</td>
                            </tr>
                            <tr>
                                <td>Oui</td>
                                <td>Je sais pas</td>
                            </tr>
                            <tr>
                                <td>Aled</td>
                                <td>c'est la merde</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row"></div>

        <script src="<?php echo JS . "sidebar.js" ?>"></script>
    </div>

</body>
</html>