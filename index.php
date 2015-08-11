<html>
    <head>
        <title>Birdman Draft Tool</title>
        <link href="libs/css/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="libs/css/bootstrap-theme.css" rel="stylesheet" type="text/css">
        <link href="libs/css/simple-sidebar.css" rel="stylesheet" type="text/css">
        <script src="libs/js/jquery.js"></script>
        <script src="libs/js/bootstrap.js"></script>
        <script src="libs/js/list.js"></script>
        <script src="libs/js/index.js"></script>
    </head>
    <body>
        <div class="container-fluid">
            <br>
            <div class="row">
                <div class="col-lg-12">
                    <ul class="nav nav-tabs" id="draft_tabs">
                        <li><a href="#setup_tab" data-toggle="tab">Draft Setup</a></li>
                        <li><a href="#players_tab" data-toggle="tab">Draft Board</a></li>
                        <li><a href="#teams_tab" data-toggle="tab">Drafted Teams</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane" id="setup_tab">
                            <?php include ('setup.php'); ?>
                        </div>
                        <div class="tab-pane" id="players_tab">
                            <?php include ('draftBoard.php'); ?>
                        </div>
                        <div class="tab-pane" id="teams_tab">
                            <?php include ('teams.php'); ?>
                        </div>
                    </div><!-- tab content -->
                </div>
            </div>
        </div>
    </body>
</html>