<!-- DB Connection -->
<?php
$con = mysql_connect("localhost", 'root', 'Fly0Bird797979');
if (!$con) {
    die('Could not connect!' . mysql_error());
}

mysql_select_db("fantasyfootball_db", $con);

$getOwners = mysql_query("SELECT * FROM `owners` ORDER BY `DraftPosition` ASC");
?>
<div class="row">
    <div class="col-lg-3">

    </div>
    <div class="col-lg-6">
        <br><br><br>
        <div class="panel panel-default" style="text-align: center">
            <div class="panel-heading">
                <h3 class="panel-title">Draft Order</h3>
            </div>
            <div class="panel-body">
                <ul id="ownersList" class="list-group" style="text-align: center">
                    <?php
                    while ($tableValue = mysql_fetch_array($getOwners)) {
                        echo '<button id=', $tableValue['Row_ID'], ' type="button" class="list-group-item playerListItem" data-pos=', $tableValue['DraftPosition'], '>',
                        'Pick Number: ', $tableValue['DraftPosition'],
                        ' - ', $tableValue['OwnerName'],
                        '</button>';
                    }
                    ?>
                </ul>
            </div>
            <div>
                <button id="btn_moveOwnerUp" class="btn btn-primary">
                    <span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span>&nbsp;Move Up
                </button>
                <button id="btn_moveOwnerDown" class="btn btn-primary">
                    <span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span>&nbsp;Move Down
                </button>
                <button id="btn_editOwner" class="btn btn-warning" data-toggle="modal">
                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>&nbsp;Edit Owner
                </button>
                <br><br>
                <button id="btn_genDraftOrder" class="btn btn-success">Generate Draft Order</button>
                <br><br>
            </div>
        </div>
    </div>
    <div class="col-lg-3">

    </div>
</div>
<?php include('_modals/modal_editOwner.php'); ?>
