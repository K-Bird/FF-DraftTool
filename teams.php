<?php
$DraftStatus = mysql_result(mysql_query("SELECT Value from `draftsettings` WHERE Setting='draftstatus'", $con), 0);
$getOwners = mysql_query("SELECT * FROM `owners`", $con);
$getDraftedPicks = mysql_query("SELECT * FROM `draftedplayers`", $con);
$teamFilter = mysql_result(mysql_query("SELECT Value from `draftsettings` WHERE Setting='teamsFilter'", $con), 0);
?>
<div class="row">
    <div class="col-lg-2">

    </div>
    <div class="col-lg-8">
        <br><br><br>
        <div class="panel panel-default" style="text-align: center">
            <div class="panel-heading">
                <h3 class="panel-title">Drafted Team</h3>
            </div>
            <div class="panel-body">
                <label>Filter Drafted Team By Owner:</label><br>
                <select id="select_team" class="form-control" <?php if ($DraftStatus === 'setup') {
    echo' disabled';
} ?>>
                    <?php
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
                            if ($getDraftedPlayerRow['Position'] === 'QB') {
                                $qbCount = $qbCount + 1;
                            } elseif ($getDraftedPlayerRow['Position'] === 'RB') {
                                $rbCount = $rbCount + 1;
                            } elseif ($getDraftedPlayerRow['Position'] === 'WR') {
                                $wrCount = $wrCount + 1;
                            } elseif ($getDraftedPlayerRow['Position'] === 'TE') {
                                $teCount = $teCount + 1;
                            } elseif ($getDraftedPlayerRow['Position'] === 'DST') {
                                $dstCount = $dstCount + 1;
                            } elseif ($getDraftedPlayerRow['Position'] === 'K') {
                                $kCount = $kCount + 1;
                            }
                        }
                    }
                    echo '<br><br><label>Team Breakdown:</label><br>';
                    echo 'QBs: ', $qbCount, ' / 4 | RBs: ',$rbCount,' / 8 | WRs: ',$wrCount,' / 8 | TEs: ',$teCount,' / 3 | DST: ',$dstCount,' / 3 | K: ',$kCount,' / 3';
                }
                ?>
            </div>
        </div>
    </div>
    <div class="col-lg-2">

    </div>
</div>
