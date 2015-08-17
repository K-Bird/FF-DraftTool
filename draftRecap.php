<!-- DB Connection -->
<?php
$getDrafted = mysql_query("SELECT * FROM `draftedplayers` ORDER BY `draftorder_ID` ASC");
$RecapPoolFilter = mysql_result(mysql_query("SELECT Value from `draftsettings` WHERE Setting='recapFilter'", $con), 0);
?>
<div class="row">
    <div class="col-lg-3">
        <br>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Draft Recap</h3>
            </div>
            <div class="panel-body" style="max-height: 800px;overflow-y: scroll;">
                <ul id="recapPool" class="list-group" style="text-align: left; font-size: smaller;">
                    <?php
                    $qbCount = 0;
                    $rbCount = 0;
                    $wrCount = 0;
                    $teCount = 0;
                    $dstCount = 0;
                    $kCount = 0;
                    while ($tableValue = mysql_fetch_array($getDrafted)) {
                        $getDraftOrderInfo = mysql_query("SELECT * FROM `draftorder` WHERE Row_ID='{$tableValue['draftorder_ID']}'");
                        $draftedValue = mysql_fetch_array($getDraftOrderInfo);
                        $getPlayerInfo = mysql_query("SELECT * FROM `playerpool` WHERE Row_ID='{$tableValue['playerpool_ID']}'");
                        $playerValue = mysql_fetch_array($getPlayerInfo);
                        if ($RecapPoolFilter === 'ALL') {
                            echo '<button type="button" class="list-group-item playerListItem">',
                            $draftedValue['Round'], '.', $draftedValue['Pick'],
                            ' ', $playerValue['PlayerName'],
                            ', ', $playerValue['Position'],
                            ' - ', $playerValue['Team'],
                            '</button>';
                        } else {
                            if (trim($playerValue['Position']) === $RecapPoolFilter) {
                                echo '<button type="button" class="list-group-item playerListItem">',
                                $draftedValue['Round'], '.', $draftedValue['Pick'],
                                ' ', $playerValue['PlayerName'],
                                ', ', $playerValue['Position'],
                                ' - ', $playerValue['Team'],
                                '</button>';
                            }
                        }

                        if (trim($playerValue['Position']) === 'QB') {
                            $qbCount = $qbCount + 1;
                        } elseif (trim($playerValue['Position']) === 'RB') {
                            $rbCount = $rbCount + 1;
                        } elseif (trim($playerValue['Position']) === 'WR') {
                            $wrCount = $wrCount + 1;
                        } elseif (trim($playerValue['Position']) === 'TE') {
                            $teCount = $teCount + 1;
                        } elseif (trim($playerValue['Position']) === 'DST') {
                            $dstCount = $dstCount + 1;
                        } elseif (trim($playerValue['Position']) === 'K') {
                            $kCount = $kCount + 1;
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
        <label>Filter Recap Board:</label><br>
        <input id="recap_board" class="form-control">
        <br>
    </div>
    <div class="col-lg-3">
        <br>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Drafted Positions</h3>
            </div>
            <div class="panel-body">
                <label>Filter Drafted By Position:</label><br>
                <button class="btn btn-default filterDraftedPOS" data-pos="ALL">ALL</button>
                <button class="btn btn-default filterDraftedPOS" data-pos="RB">RB</button>
                <button class="btn btn-default filterDraftedPOS" data-pos="WR">WR</button><br><br>
                <button class="btn btn-default filterDraftedPOS" data-pos="TE">TE</button>
                <button class="btn btn-default filterDraftedPOS" data-pos="DST">DST</button>
                <button class="btn btn-default filterDraftedPOS" data-pos="K">K</button>
                <hr>
                <label>Taken ----</label><br>
                <label>QBs: </label><?php echo ' ' . $qbCount; ?><br>
                <label>RBs: </label><?php echo ' ' . $rbCount; ?><br>
                <label>WRs: </label><?php echo ' ' . $wrCount; ?><br>
                <label>TEs: </label><?php echo ' ' . $teCount; ?><br>
                <label>DSTs: </label><?php echo ' ' . $dstCount; ?><br>
                <label>Ks: </label><?php echo ' ' . $kCount; ?><br>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <br>
        <?php
        $DraftStatus = mysql_result(mysql_query("SELECT Value from `draftsettings` WHERE Setting='draftstatus'", $con), 0);
        $getOwners = mysql_query("SELECT * FROM `owners`", $con);
        $getDraftedPicks = mysql_query("SELECT * FROM `draftedplayers`", $con);
        $teamFilter = mysql_result(mysql_query("SELECT Value from `draftsettings` WHERE Setting='teamsFilter'", $con), 0);
        ?>
        <div class="panel panel-default" style="text-align: center">
            <div class="panel-heading">
                <h3 class="panel-title">Drafted Team</h3>
            </div>
            <div class="panel-body">
                <label>Filter Drafted Team By Owner:</label><br>
                <select id="select_team" class="form-control"
                        <?php
                        if ($DraftStatus === 'setup') {
                            echo' disabled';
                        }
                        while ($ownersRow = mysql_fetch_array($getOwners)) {
                            if ($ownersRow['OwnerName'] === $teamFilter) {
                                echo '<option selected="selected" value=', $ownersRow['OwnerName'], '>', $ownersRow['OwnerName'], ' - Pick: ', $ownersRow['DraftPosition'], '</option>';
                            } else {
                                echo '<option value=', $ownersRow['OwnerName'], '>', $ownersRow['OwnerName'], ' - Pick: ', $ownersRow['DraftPosition'], '</option>';
                            }
                        }
                        ?>
            </select>
            <hr>
            <?php
            if ($teamFilter === 'None') {
                echo '<h2>Draft In Setup';
            } elseif ($teamFilter === 'Started') {
                echo '<h2>Drafted Started, Select An Owner to Filter By';
            } else {

                $qbCount = 0;
                $rbCount = 0;
                $wrCount = 0;
                $teCount = 0;
                $dstCount = 0;
                $kCount = 0;
                echo $teamFilter, "'s Team<br>";
                while ($draftedPicksRow = mysql_fetch_array($getDraftedPicks)) {

                    $getOwnerOfPick = mysql_query("SELECT * FROM `draftorder` WHERE Row_ID='{$draftedPicksRow['draftorder_ID']}'", $con);
                    $getOwnerOfPickRow = mysql_fetch_array($getOwnerOfPick);
                    if ($getOwnerOfPickRow['Owner'] === $teamFilter) {
                        $getDraftedPlayer = mysql_query("SELECT * FROM `playerpool` WHERE Row_ID='{$draftedPicksRow['playerpool_ID']}'", $con);
                        $getDraftedPlayerRow = mysql_fetch_array($getDraftedPlayer);
                        echo $getDraftedPlayerRow['Position'], ' - ',
                        $getDraftedPlayerRow['PlayerName'], ' - ',
                        $getDraftedPlayerRow['Team'], ' in Round ',
                        $getOwnerOfPickRow['Round'], ' - Pick: ',
                        $getOwnerOfPickRow['Pick'], ' - Overall: ',
                        $getOwnerOfPickRow['Overall'], '<br>';
                        if (trim($getDraftedPlayerRow['Position']) === 'QB') {
                            $qbCount = $qbCount + 1;
                        } elseif (trim($getDraftedPlayerRow['Position']) === 'RB') {
                            $rbCount = $rbCount + 1;
                        } elseif (trim($getDraftedPlayerRow['Position']) === 'WR') {
                            $wrCount = $wrCount + 1;
                        } elseif (trim($getDraftedPlayerRow['Position']) === 'TE') {
                            $teCount = $teCount + 1;
                        } elseif (trim($getDraftedPlayerRow['Position']) === 'DST') {
                            $dstCount = $dstCount + 1;
                        } elseif (trim($getDraftedPlayerRow['Position']) === 'K') {
                            $kCount = $kCount + 1;
                        }
                    }
                }
                echo '<br><br><label>Team Breakdown:</label><br>';
                echo 'QBs: ', $qbCount, ' / 4 | RBs: ', $rbCount, ' / 8 | WRs: ', $wrCount, ' / 8 | TEs: ', $teCount, ' / 3 | DST: ', $dstCount, ' / 3 | K: ', $kCount, ' / 3';
            }
            ?>
        </div>
    </div>
</div>
</div>