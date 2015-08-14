$(document).ready(function () {

//Call active list group item function
    platformListGroupActive();

// ---- Tab Functions (To Remember The Tab Last Opened ----//
    $('#draft_tabs a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
        $('html, body').animate({scrollTop: 0}, 'slow');
    });

    // store the currently selected tab in the hash value
    $("ul.nav-tabs > li > a").on("shown.bs.tab", function (e) {
        var id = $(e.target).attr("href").substr(1);
        window.location.hash = id;
    });

    // on load of the page: switch to the currently selected tab
    var hash = window.location.hash;
    $('#draft_tabs a[href="' + hash + '"]').tab('show');

//---- Draft Setup Functions ----//
    //Pull text from selected owner list item and pass values to edit owner modal | if nothing selected alert user and stop execution
    $('#btn_editOwner').click(function (e) {
        var OwnerPick = $('#playerPool .list-group-item.active').text();

        if (OwnerPick === '') {
            alert("You must select an owner to edit");
            $('#btn_editOwner').attr('data-target', '');
        } else {
            $('#btn_editOwner').attr('data-target', '#editOwnerModal');
            $('#editOwnerTitle').append(' ' + OwnerPick);
        }

    });

    //Edit Owner Name
    $('#submit_editOwner').click(function (e) {
        var newName = $('#editOwner_Name').val();
        var rowID = $('#playerPool .list-group-item.active').attr('ID');

        $.ajax(
                {
                    url: "_actions/editOwner.php",
                    type: "POST",
                    data: {
                        newName: newName,
                        rowID: rowID
                    },
                    success: function (data, textStatus, jqXHR)
                    {
                        location.reload();
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert("Add Item Failed: " + errorThrown);
                    }
                });
    });

    //Move Owner Up
    $('#btn_moveOwnerUp').click(function (e) {
        var draftPos = $('#ownersList .list-group-item.active').attr('data-pos');

        $.ajax(
                {
                    url: "_actions/moveOwnerUp.php",
                    type: "POST",
                    data: {
                        draftPos: draftPos
                    },
                    success: function (data, textStatus, jqXHR)
                    {
                        location.reload();
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert("Add Item Failed: " + errorThrown);
                    }
                });
    });

    //Move Owner Down
    $('#btn_moveOwnerDown').click(function (e) {
        var draftPos = $('#ownersList .list-group-item.active').attr('data-pos');

        $.ajax(
                {
                    url: "_actions/moveOwnerDown.php",
                    type: "POST",
                    data: {
                        draftPos: draftPos
                    },
                    success: function (data, textStatus, jqXHR)
                    {
                        location.reload();
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert("Add Item Failed: " + errorThrown);
                    }
                });
    });

    //Generate the order of the draft based on the setup tab order
    $('#btn_genDraftOrder').click(function (e) {

        $.ajax(
                {
                    url: "_actions/genDraftOrder.php",
                    type: "POST",
                    data: {
                    },
                    success: function (data, textStatus, jqXHR)
                    {
                        alert("Draft Order is Set");
                        location.reload();
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert("Draft Order Set Failed: " + errorThrown);
                    }
                });
    });


    //---- Draft Board Functions ----//
    //Start the Draft
    $('#btn_startDraft').click(function (e) {

        var checkDraftOrder = $(this).attr('data-count');

        if (checkDraftOrder > 0) {

            $.ajax(
                    {
                        url: "_actions/startDraft.php",
                        type: "POST",
                        data: {
                        },
                        success: function (data, textStatus, jqXHR)
                        {
                            location.reload();
                        },
                        error: function (jqXHR, textStatus, errorThrown)
                        {
                            alert("Draft Did Not Start: " + errorThrown);
                        }
                    });
        } else {
            alert('Draft Order is Not Set.');
        }
    });

    //Draft a Player
    $('#btn_draftPlayer').click(function (e) {

        var pool_ID = $('#playerPool .list-group-item.active').attr('id');

        if (typeof pool_ID === 'undefined') {
            alert("Please Select A Player");
            return;
        }

        $.ajax(
                {
                    url: "_actions/draftPlayer.php",
                    type: "POST",
                    data: {
                        pool_ID: pool_ID
                    },
                    success: function (data, textStatus, jqXHR)
                    {
                        location.reload();
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert("Add Item Failed: " + errorThrown);
                    }
                });

    });

    //Undo Draft Picks
    $('#btn_undoPick').click(function (e) {

        $.ajax(
                {
                    url: "_actions/undoPick.php",
                    type: "POST",
                    data: {
                    },
                    success: function (data, textStatus, jqXHR)
                    {
                        location.reload();
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert("Undo Pick Failed: " + errorThrown);
                    }
                });

    });

    //Reset the Draft
    $('#btn_resetDraft').click(function (e) {

        $.ajax(
                {
                    url: "_actions/resetDraft.php",
                    type: "POST",
                    data: {
                    },
                    success: function (data, textStatus, jqXHR)
                    {
                        location.reload();
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert("Draft Did Not Reset: " + errorThrown);
                    }
                });
    });

    //Set player as will not draft
    $('#btn_wontDraft').click(function (e) {

        var pool_ID = $('#playerPool .list-group-item.active').attr('id');

        $.ajax(
                {
                    url: "_actions/wontDraft.php",
                    type: "POST",
                    data: {
                        pool_ID: pool_ID
                    },
                    success: function (data, textStatus, jqXHR)
                    {
                        location.reload();
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert("Player Not Set as Won't Draft: " + errorThrown);
                    }
                });
    });

    //Set player as will draft
    $('#btn_willDraft').click(function (e) {

        var pool_ID = $('#playerPool .list-group-item.active').attr('id');

        $.ajax(
                {
                    url: "_actions/willDraft.php",
                    type: "POST",
                    data: {
                        pool_ID: pool_ID
                    },
                    success: function (data, textStatus, jqXHR)
                    {
                        location.reload();
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert("Player Not Set as Will Draft: " + errorThrown);
                    }
                });
    });

    //Filter by position button clicked
    $('.filterPOS').click(function (e) {

        var position = $(this).attr('data-pos');

        $.ajax(
                {
                    url: "_actions/filterPOS.php",
                    type: "POST",
                    data: {
                        pos: position
                    },
                    success: function (data, textStatus, jqXHR)
                    {
                        location.reload();
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert("Filter Not Applied: " + errorThrown);
                    }
                });
    });

    //Add a Note to Selected Player
    $('#btn_addNote').click(function (e) {

        var pool_ID = $('#playerPool .list-group-item.active').attr('id');
        var note = $('#player_note').val();

        $.ajax(
                {
                    url: "_actions/addNote.php",
                    type: "POST",
                    data: {
                        pool_ID: pool_ID,
                        note: note
                    },
                    success: function (data, textStatus, jqXHR)
                    {
                        location.reload();
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert("Player Note Not Added: " + errorThrown);
                    }
                });
    });

    //Remove Note From Selected Player
    $('#btn_removeNote').click(function (e) {

        var pool_ID = $('#playerPool .list-group-item.active').attr('id');

        $.ajax(
                {
                    url: "_actions/removeNote.php",
                    type: "POST",
                    data: {
                        pool_ID: pool_ID
                    },
                    success: function (data, textStatus, jqXHR)
                    {
                        location.reload();
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert("Player Note Not Removed: " + errorThrown);
                    }
                });
    });

    //Add Player to Draft Board
    $('#btn_addPlayer').click(function (e) {

        var playerName = $('#addplayer_name').val();
        var playerPOS = $('#addplayer_pos').val();
        var playerTeam = $('#addplayer_team').val();

        $.ajax(
                {
                    url: "_actions/addPlayer.php",
                    type: "POST",
                    data: {
                        name: playerName,
                        pos: playerPOS,
                        team: playerTeam
                    },
                    success: function (data, textStatus, jqXHR)
                    {
                        location.reload();
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert("Player Not Added: " + errorThrown);
                    }
                });
    });

    //Filter Draft Board when text is entered to filter field
    $('#search_board').on('input', function () {
        var searchText = $(this).val();
        $('#playerPool button').each(function () {
            if (searchText === '') {
                $(this).show();
            } else {
                if ($(this).is(':contains(' + searchText + ')')) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            }
        });
    });
    
    //Move Player Up
    $('#btn_movePlayerUp').click(function (e) {
        var poolRank = $('#playerPool .list-group-item.active').attr('data-rk');

        $.ajax(
                {
                    url: "_actions/movePlayerUp.php",
                    type: "POST",
                    data: {
                        poolRank: poolRank
                    },
                    success: function (data, textStatus, jqXHR)
                    {
                        location.reload();
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert("Add Item Failed: " + errorThrown);
                    }
                });
    });

    //Move Player Down
    $('#btn_movePlayerDown').click(function (e) {
        var poolRank = $('#playerPool .list-group-item.active').attr('data-rk');

        $.ajax(
                {
                    url: "_actions/movePlayerDown.php",
                    type: "POST",
                    data: {
                        poolRank: poolRank
                    },
                    success: function (data, textStatus, jqXHR)
                    {
                        location.reload();
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert("Add Item Failed: " + errorThrown);
                    }
                });
    });
    
    //---- Drafted Team Functions ---//
    //Add Player to Draft Board
    $('#select_team').change(function (e) {

        var newOwner = $('#select_team').val();

        $.ajax(
                {
                    url: "_actions/filterTeam.php",
                    type: "POST",
                    data: {
                        owner: newOwner
                    },
                    success: function (data, textStatus, jqXHR)
                    {
                        location.reload();
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert("Filter Not Applied: " + errorThrown);
                    }
                });
    });

});

function  platformListGroupActive() {

    //For each disabled (drafted) list item, make the disabled property true
    $('.list-group-item').each(function (e) {
        if ($(this).hasClass("disabled")) {
            $(this).prop("disabled", true);
        }
    });

    //For any list group: Remove all active classes from items in platform dropdown list, add active class when a new item is selected
    $('.list-group-item').click(function (e) {
        $(this).parent().find('.playerListItem').removeClass('active');
        $(this).addClass('active');
    });

}