<!-- DB Connection -->
<?php
$PlayerPoolFilter = mysql_result(mysql_query("SELECT Value from `draftsettings` WHERE Setting='poolFilter'", $con), 0);
if ($PlayerPoolFilter === 'ALL') {
    $getPlayers = mysql_query("SELECT * FROM `playerpool` ORDER BY `Rank` ASC");
} elseif ($PlayerPoolFilter === 'FLEX') {
    $getPlayers = mysql_query("SELECT * FROM `playerpool` WHERE trim(`Position`) IN ('RB','WR','TE') ORDER BY `Rank` ASC");
} elseif ($PlayerPoolFilter === 'AVL') {
    $getPlayers = mysql_query("SELECT * FROM `playerpool` WHERE Status='Available' ORDER BY `Rank` ASC");
} else {
    $getPlayers = mysql_query("SELECT * FROM `playerpool` WHERE trim(`Position`)='{$PlayerPoolFilter}' ORDER BY `Rank` ASC");
}
?>
<div class="row">
    <div class="col-lg-4">
        <br>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Draft Board</h3>
            </div>
            <div class="panel-body" style="max-height: 800px;overflow-y: scroll;">
                <ul id="playerPool" class="list-group" style="text-align: left; font-size: smaller;">
                    <?php
                    while ($tableValue = mysql_fetch_array($getPlayers)) {
                        if ($tableValue['Status'] === 'Available') {
                            echo '<button id=', $tableValue['Row_ID'], ' type="button" class="list-group-item playerListItem" data-rk=',$tableValue['Rank'],'>',
                            '#', $tableValue['Rank'],
                            ' ', $tableValue['PlayerName'],
                            ', ', $tableValue['Position'],
                            ' - ', $tableValue['Team'],
                            ' -- Bye Week: ', $tableValue['ByeWeek'],
                            '   - ', $tableValue['Note'],
                            '</button>';
                        }
                        if ($tableValue['Status'] === 'Drafted') {
                            echo '<button id=', $tableValue['Row_ID'], ' type="button" class="list-group-item playerListItem data-rk=',$tableValue['Rank'],' disabled">',
                            '#', $tableValue['Rank'],
                            ' ', $tableValue['PlayerName'],
                            ', ', $tableValue['Position'],
                            ' - ', $tableValue['Team'],
                            ' -- Bye Week: ', $tableValue['ByeWeek'],
                            '   - ', $tableValue['Note'],
                            '</button>';
                        }
                        if ($tableValue['Status'] === 'W') {
                            echo '<button id=', $tableValue['Row_ID'], ' type="button" class="list-group-item list-group-item-danger playerListItem" data-rk=',$tableValue['Rank'],'>',
                            '#', $tableValue['Rank'],
                            ' ', $tableValue['PlayerName'],
                            ', ', $tableValue['Position'],
                            ' - ', $tableValue['Team'],
                            ' -- Bye Week: ', $tableValue['ByeWeek'],
                            '   - ', $tableValue['Note'],
                            '</button>';
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
        <label>Filter Draft Board:</label><br>
        <input id="search_board" class="form-control">
        <br>
        <label>Move Selected Player: </label>&nbsp;&nbsp;
        <button id="btn_movePlayerUp" class="btn btn-primary">
            <span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span>&nbsp;Move Rank Up
        </button>
        <button id="btn_movePlayerDown" class="btn btn-primary">
            <span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span>&nbsp;Move Rank Down
        </button>
    </div>
    <div class="col-lg-5">
        <br>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Draft Controls</h3>
            </div>
            <div class="panel-body">
                <?php
                $countDraftOrder = mysql_query("SELECT COUNT(*) AS Row_ID FROM `draftorder`");
                $num = mysql_fetch_array($countDraftOrder);
                $count = $num['Row_ID'];
                $DraftStatus = mysql_result(mysql_query("SELECT Value from `draftsettings` WHERE Setting='draftstatus'", $con), 0);
                $DraftRow = mysql_result(mysql_query("SELECT Value from `draftsettings` WHERE Setting='draftingRow'", $con), 0);
                $GetDraftRowInfo = mysql_query("SELECT * FROM `draftorder` WHERE Row_ID='{$DraftRow}'", $con);
                $DraftInfoRow = mysql_fetch_array($GetDraftRowInfo);
                $NextDraftRow = $DraftRow + 1;
                $GetNextDraftRowInfo = mysql_query("SELECT * FROM `draftorder` WHERE Row_ID='{$NextDraftRow}'", $con);
                $NextDraftInfoRow = mysql_fetch_array($GetNextDraftRowInfo);
                if ($DraftStatus === 'active') {
                    echo '<button id="btn_startDraft" class="btn btn-success disabled">Begin Draft</button>';
                } else {
                    echo '<button id="btn_startDraft" class="btn btn-success" data-count=' . $count . '>Begin Draft</button>';
                }
                echo '&nbsp';
                if ($DraftStatus === 'setup') {
                    echo '<button id="btn_resetDraft" class="btn btn-danger disabled">Reset Draft</button>';
                } else {
                    echo '<button id="btn_resetDraft" class="btn btn-danger">Reset Draft</button>';
                }
                ?>
                <hr>
                <label>Round:</label>&nbsp;<?php
                if ($DraftStatus === 'active') {
                    echo $DraftInfoRow['Round'];
                } else {
                    echo 'Draft In Setup';
                }
                ?><br>
                <label>Pick:</label>&nbsp;<?php
                if ($DraftStatus === 'active') {
                    echo $DraftInfoRow['Pick'];
                } else {
                    echo 'Draft In Setup';
                }
                ?><br>
                <label>Overall Pick:</label>&nbsp;<?php
                if ($DraftStatus === 'active') {
                    echo $DraftInfoRow['Overall'];
                } else {
                    echo 'Draft In Setup';
                }
                ?><br>
                <label>On The Clock: </label>&nbsp;<?php
                if ($DraftStatus === 'active') {
                    echo $DraftInfoRow['Owner'];
                } else {
                    echo 'Draft In Setup';
                }
                ?><br>
                <label>Next Up:</label>&nbsp;<?php
                if ($DraftStatus === 'active') {
                    echo $NextDraftInfoRow['Owner'];
                } else {
                    echo 'Draft In Setup';
                }
                ?><br>
                <br>
                <?php
                if ($DraftStatus === 'active') {
                    echo '<button id="btn_draftPlayer" class="btn btn-primary">Draft Selected Player</button>&nbsp;';
                    echo '<button id="btn_undoPick" class="btn btn-primary">Undo Pick</button>';
                } else {
                    echo '<button id="btn_draftPlayer" class="btn btn-primary disabled">Draft Selected Player</button>&nbsp;';
                    echo '<button id="btn_undoPick" class="btn btn-primary disabled">Undo Pick</button>';
                }
                ?>               
                <hr>
                <label>Filter By Position:</label><br>
                <button class="btn btn-default filterPOS" data-pos="ALL">ALL</button>
                <button class="btn btn-default filterPOS" data-pos="AVL" data-toggle="tooltip" data-placement="top" title="Show Available Players Only">AVL</button>
                <button class="btn btn-default filterPOS" data-pos="QB">QB</button>
                <button class="btn btn-default filterPOS" data-pos="RB">RB</button>
                <button class="btn btn-default filterPOS" data-pos="WR">WR</button>
                <button class="btn btn-default filterPOS" data-pos="TE">TE</button>
                <button class="btn btn-default filterPOS" data-pos="FLEX">FLEX</button>
                <button class="btn btn-default filterPOS" data-pos="DST">DST</button>
                <button class="btn btn-default filterPOS" data-pos="K">K</button>
                <hr>
                <label>Add Player to Board</label><br><bR>
                <label>Player Name:</label><br>
                <input id="addplayer_name" type="text" class="form-control">
                <label>Player Position:</label><br>
                <select id="addplayer_pos" class="form-control">
                    <option value="QB">QB</option>
                    <option value="RB">RB</option>
                    <option value="WR">WR</option>
                    <option value="TE">TE</option>
                    <option value="DST">DST</option>
                    <option value="K">K</option>
                </select>
                <label>Player Team:</label><br>
                <?php
                $FranchiseList = array();
                array_push($FranchiseList, 'ARI', 'ATL', 'BAL', 'BUF', 'CAR', 'CHI', 'CIN', 'CLE', 'DAL', 'DEN', 'DET', 'GB', 'HOU', 'IND', 'JAC', 'KC', 'MIA', 'MIN', 'NE', 'NO', 'NYG', 'NYJ', 'OAK', 'PHI', 'PIT', 'SD', 'SEA', 'SF', 'STL', 'TB', 'TEN', 'WAS');
                ?>
                <select id="addplayer_team" class="form-control" name="fran">
                    <?php
                    foreach ($FranchiseList as $Fran) {
                        echo '<option value="' . $Fran . '">' . $Fran . '</option>';
                    }
                    ?>
                </select>
                <br>
                <button id="btn_addPlayer" class="btn btn-success">Add Player</button>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <br>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Analysis Controls</h3>
            </div>
            <div class="panel-body">
                <label>Add Notes to Selected Player</label><br>
                <textarea id="player_note" class="form-control" row="5"></textarea><br>
                <button id="btn_addNote" class="btn btn-primary">Add Note</button>&nbsp;
                <button id="btn_removeNote" class="btn btn-danger">Remove Note</button>
                <hr>
                <label>Set Selected Player as Won't Draft:</label>
                &nbsp;
                <button id="btn_wontDraft" class="btn btn-warning">Set</button>
                <button id="btn_willDraft" class="btn btn-warning">Unset</button>
            </div>
        </div>
    </div>
</div>