<script language="javascript">

    function getLocation() {
        return '<?php echo BASE_URL;?>includes/controllers/ajax.package.php';
    }

    function getTableId() {
        return 'table_dnd';
    }

    $(document).ready(function () {
        /*************************************** USer Package Featured Toggler ******************************************/
        $('.featureToggler').on('click', function () {
            var Re = $(this).attr('moduleId');
            var status = $(this).attr('status');
            newStatus = (status == 1) ? 0 : 1;
            $.ajax({
                type: "POST",
                url: getLocation(),
                data: "action=toggleFeatured&id=" + Re,
                success: function (msg) {
                }
            });
            $(this).attr({'status': newStatus});
            if (status == 1) {
                $('#futimgHolder_' + Re).removeClass("bg-green");
                $('#futimgHolder_' + Re).addClass("bg-red");
                $(this).attr("data-original-title", "Click to Publish");
            } else {
                $('#futimgHolder_' + Re).removeClass("bg-red");
                $('#futimgHolder_' + Re).addClass("bg-green");
                $(this).attr("data-original-title", "Click to Un-publish");
            }
        });

        /*************************************** USer Package Lastmin Toggler ******************************************/
        $('.lstminToggler').on('click', function () {
            var Re = $(this).attr('moduleId');
            var status = $(this).attr('status');
            newStatus = (status == 1) ? 0 : 1;
            $.ajax({
                type: "POST",
                url: getLocation(),
                data: "action=togglelstmin&id=" + Re,
                success: function (msg) {
                }
            });
            $(this).attr({'status': newStatus});
            if (status == 1) {
                $('#lstimgHolder_' + Re).removeClass("bg-green");
                $('#lstimgHolder_' + Re).addClass("bg-red");
                $(this).attr("data-original-title", "Click to Publish");
            } else {
                $('#lstimgHolder_' + Re).removeClass("bg-red");
                $('#lstimgHolder_' + Re).addClass("bg-green");
                $(this).attr("data-original-title", "Click to Un-publish");
            }
        });

        /*************************************** USer Package Home Toggler ******************************************/
        /*************************************** USer Package Home Toggler ******************************************/
        $('.homeToggler').on('click', function () {
            var Re = $(this).attr('moduleId');
            var status = $(this).attr('status');
            newStatus = (status == 1) ? 0 : 1;
            $.ajax({
                type: "POST",
                url: getLocation(),
                data: "action=togglehome&id=" + Re,
                success: function (msg) {
                }
            });
            $(this).attr({'status': newStatus});
            if (status == 1) {
                $('#hmimgHolder_' + Re).removeClass("bg-green");
                $('#hmimgHolder_' + Re).addClass("bg-red");
                $(this).attr("data-original-title", "Click to Publish");
            } else {
                $('#hmimgHolder_' + Re).removeClass("bg-red");
                $('#hmimgHolder_' + Re).addClass("bg-green");
                $(this).attr("data-original-title", "Click to Un-publish");
            }
        });

        /*************************************** USer Review Home Toggler ******************************************/
        $('.reviewhomeToggler').on('click', function () {
            var Re = $(this).attr('moduleId');
            var status = $(this).attr('status');
            newStatus = (status == 1) ? 0 : 1;
            $.ajax({
                type: "POST",
                url: getLocation(),
                data: "action=togglehomeReview&id=" + Re,
                success: function (msg) {
                }
            });
            $(this).attr({'status': newStatus});
            if (status == 1) {
                $('#hmimgHolder_' + Re).removeClass("bg-green");
                $('#hmimgHolder_' + Re).addClass("bg-red");
                $(this).attr("data-original-title", "Click to Publish");
            } else {
                $('#hmimgHolder_' + Re).removeClass("bg-red");
                $('#hmimgHolder_' + Re).addClass("bg-green");
                $(this).attr("data-original-title", "Click to Un-publish");
            }
        });


        $(".offerprice").css("display", "none");
        $('#offers').on('change', function () {
            var selVal = $(this).val();
            (selVal == "none") ? $('.offerprice').slideUp() : $('.offerprice').slideDown();
        })
    });



    /***************************************** Itinerary
     *******************************************/
    $(document).ready(function () {
        $(".check-all").on("click", function () {
            if ($(this).is(':checked')) {
                $("input[type='checkbox']").prop("checked", true);
            } else {
                $("input[type='checkbox']").prop("checked", false);
            }
        });


        function checkIfAnyCheckBoxChecked() {
            var countCheckBox = 0;
            $.each($("input.bulkCheckbox:checked"), function () {
                countCheckBox++;
            });
            if (countCheckBox > 0) {
            } else {
                showMessage('warning', 'Please select at least on row!!.');
                return false;
            }
        }

        /************************************* Bulk Transactions  for itenary*******************************************/
        $('#applySelected_btn1').on("click", function () {
            var action = $('#groupTaskField1').val();
            if (action == '0') {
                showMessage('warning', 'Please select an action!!.');
            }
            var idArray = '0';
            $('.bulkCheckbox').each(function () {
                if ($(this).is(":checked")) {
                    idArray += "|" + $(this).attr('bulkId');
                }
            });
            checkIfAnyCheckBoxChecked();
            if (idArray != '0') {

                switch (action) {

                    case "subitoggleStatus":
                        $('.record-checkbox').each(function () {
                            if ($(this).is(":checked")) {
                                $('#imgHolder_' + $(this).attr('bulkId')).html('<img src="../images/apanel/loadwheel.gif" />');
                            }
                        });
                        $.ajax({
                            type: "POST",
                            url: getLocation(),
                            data: "action=subibulkToggleStatus&idArray=" + idArray,
                            success: function (msg) {
                                var myMessage = idArray.split("|");
                                var counter = myMessage.length;
                                for (i = 1; i < counter; i++) {
                                    var status = $('#imgHolder_' + myMessage[i]).attr('status');
                                    newStatus = (status == 1) ? 0 : 1;
                                    $('#imgHolder_' + myMessage[i]).attr({'status': newStatus});
                                    if (status == 1) {
                                        $('#imgHolder_' + myMessage[i]).removeClass("bg-green");
                                        $('#imgHolder_' + myMessage[i]).addClass("bg-red");
                                        $('#imgHolder_' + myMessage[i]).attr("data-original-title", "Click to Publish");
                                    } else {
                                        $('#imgHolder_' + myMessage[i]).removeClass("bg-red");
                                        $('#imgHolder_' + myMessage[i]).addClass("bg-green");
                                        $('#imgHolder_' + myMessage[i]).attr("data-original-title", "Click to Un-publish");
                                    }
                                }
                                showMessage('success', 'Status has been toggled.');
                            }
                        });
                        break;

                    case "subidelete":
                        $('.MsgTitle').html('Do you want to delete the selected rows?');
                        $('.pText').html('Click on yes button to delete this rows permanently.!!');
                        $('.divMessageBox').fadeIn();
                        $('.MessageBoxContainer').fadeIn(1000);

                        $(".botTempo").on("click", function () {
                            var popAct = $(this).attr("id");
                            if (popAct == 'yes') {
                                subideleteSelectedRecords(idArray);
                            }
                            $('.divMessageBox').fadeOut();
                            $('.MessageBoxContainer').fadeOut(1000);
                        });
                        break;
                } // end switch section
                reStructureList(getTableId());
            } // end if section
        });
        /************************************* Bulk Transactions  for review*******************************************/
        $('#applySelected_btn2').on("click", function () {
            var action = $('#groupTaskField2').val();
            if (action == '0') {
                showMessage('warning', 'Please select an action!!.');
            }
            var idArray = '0';
            $('.bulkCheckbox').each(function () {
                if ($(this).is(":checked")) {
                    idArray += "|" + $(this).attr('bulkId');
                }
            });
            checkIfAnyCheckBoxChecked();
            if (idArray != '0') {

                switch (action) {

                    case "subreviewtoggleStatus":
                        $('.record-checkbox').each(function () {
                            if ($(this).is(":checked")) {
                                $('#imgHolder_' + $(this).attr('bulkId')).html('<img src="../images/apanel/loadwheel.gif" />');
                            }
                        });
                        $.ajax({
                            type: "POST",
                            url: getLocation(),
                            data: "action=subreviewbulkToggleStatus&idArray=" + idArray,
                            success: function (msg) {
                                var myMessage = idArray.split("|");
                                var counter = myMessage.length;
                                for (i = 1; i < counter; i++) {
                                    var status = $('#imgHolder_' + myMessage[i]).attr('status');
                                    newStatus = (status == 1) ? 0 : 1;
                                    $('#imgHolder_' + myMessage[i]).attr({'status': newStatus});
                                    if (status == 1) {
                                        $('#imgHolder_' + myMessage[i]).removeClass("bg-green");
                                        $('#imgHolder_' + myMessage[i]).addClass("bg-red");
                                        $('#imgHolder_' + myMessage[i]).attr("data-original-title", "Click to Publish");
                                    } else {
                                        $('#imgHolder_' + myMessage[i]).removeClass("bg-red");
                                        $('#imgHolder_' + myMessage[i]).addClass("bg-green");
                                        $('#imgHolder_' + myMessage[i]).attr("data-original-title", "Click to Un-publish");
                                    }
                                }
                                showMessage('success', 'Status has been toggled.');
                            }
                        });
                        break;

                    case "subreviewdelete":
                        $('.MsgTitle').html('Do you want to delete the selected rows?');
                        $('.pText').html('Click on yes button to delete this rows permanently.!!');
                        $('.divMessageBox').fadeIn();
                        $('.MessageBoxContainer').fadeIn(1000);

                        $(".botTempo").on("click", function () {
                            var popAct = $(this).attr("id");
                            if (popAct == 'yes') {
                                subreviewdeleteSelectedRecords(idArray);
                            }
                            $('.divMessageBox').fadeOut();
                            $('.MessageBoxContainer').fadeOut(1000);
                        });
                        break;
                } // end switch section
                reStructureList(getTableId());
            } // end if section
        });

        /*************************************** Delete Sub Toggler ******************************************/
        function subideleteSelectedRecords(idArray) {
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: getLocation(),
                data: "action=subibulkDelete&idArray=" + idArray,
                success: function (data) {
                    var msg = eval(data);
                    if (msg.action == 'success') {
                        showMessage(msg.action, msg.message);
                        var myMessage = idArray.split("|");
                        var counter = myMessage.length;
                        for (i = 1; i < counter; i++) {
                            $('#' + myMessage[i]).remove();
                            reStructureList(getTableId());
                        }
                    }
                    if (msg.action == 'error') {
                        showMessage(msg.action, msg.message);
                    }
                }
            });
        }

        function subreviewdeleteSelectedRecords(idArray) {
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: getLocation(),
                data: "action=subreviewbulkDelete&idArray=" + idArray,
                success: function (data) {
                    var msg = eval(data);
                    if (msg.action == 'success') {
                        showMessage(msg.action, msg.message);
                        var myMessage = idArray.split("|");
                        var counter = myMessage.length;
                        for (i = 1; i < counter; i++) {
                            $('#' + myMessage[i]).remove();
                            reStructureList(getTableId());
                        }
                    }
                    if (msg.action == 'error') {
                        showMessage(msg.action, msg.message);
                    }
                }
            });
        }


        /*************************************** Status Sub Toggler ******************************************/
        $('.statusItinerary').on('click', function () {
            var id = $(this).attr('moduleId');
            var status = $(this).attr('status');
            newStatus = (status == 1) ? 0 : 1;
            $.ajax({
                type: "POST",
                url: getLocation(),
                data: "action=SubitoggleStatus&id=" + id,
                success: function (msg) {
                }
            });
            $(this).attr({'status': newStatus});
            if (status == 1) {
                $('#imgHolder_' + id).removeClass("bg-green");
                $('#imgHolder_' + id).addClass("bg-red");
                $(this).attr("data-original-title", "Click to Publish");
            } else {
                $('#imgHolder_' + id).removeClass("bg-red");
                $('#imgHolder_' + id).addClass("bg-green");
                $(this).attr("data-original-title", "Click to Un-publish");
            }
        });


        $('.statusReview').on('click', function () {
            var id = $(this).attr('moduleId');
            var status = $(this).attr('status');
            newStatus = (status == 1) ? 0 : 1;
            $.ajax({
                type: "POST",
                url: getLocation(),
                data: "action=SubreviewtoggleStatus&id=" + id,
                success: function (msg) {
                }
            });
            $(this).attr({'status': newStatus});
            if (status == 1) {
                $('#imgHolder_' + id).removeClass("bg-green");
                $('#imgHolder_' + id).addClass("bg-red");
                $(this).attr("data-original-title", "Click to Publish");
            } else {
                $('#imgHolder_' + id).removeClass("bg-red");
                $('#imgHolder_' + id).addClass("bg-green");
                $(this).attr("data-original-title", "Click to Un-publish");
            }
        });
    });

    /***************************************** Re ordering Users *******************************************/

    $(document).ready(function () {
        oTable = $('#example').dataTable({
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "fnDrawCallback": function (oSettings) {
                /* Need to redo the counters if filtered or sorted */
                if (oSettings.bSorted || oSettings.bFiltered) {
                    for (var i = 0, iLen = oSettings.aiDisplay.length; i < iLen; i++) {
                        $('td:eq(0)', oSettings.aoData[oSettings.aiDisplay[i]].nTr).html(i + 1);
                    }
                }
            }
        }).rowReordering({
            sURL: "<?php echo BASE_URL;?>includes/controllers/ajax.package.php?action=sort",
            fnSuccess: function (message) {
                var msg = jQuery.parseJSON(message);
                showMessage(msg.action, msg.message);
            }
        });
    });

    $(document).ready(function () {
        oTable = $('#subexample').dataTable({
            "bJQueryUI": true,
            "sPaginationType": "full_numbers"
        }).rowReordering({
            sURL: "<?php echo BASE_URL;?>includes/controllers/ajax.package.php?action=subSort",
            fnSuccess: function (message) {
                var msg = jQuery.parseJSON(message);
                showMessage(msg.action, msg.message);
            }
        });
    });

    $(document).ready(function () {
        oTable = $('#subexample1').dataTable({
            "bJQueryUI": true,
            "sPaginationType": "full_numbers"
        }).rowReordering({
            sURL: "<?php echo BASE_URL;?>includes/controllers/ajax.package.php?action=subiSort",
            fnSuccess: function (message) {
                var msg = jQuery.parseJSON(message);
                showMessage(msg.action, msg.message);
            }
        });
    });

    $(document).ready(function () {
        oTable = $('#subexample2').dataTable({
            "bJQueryUI": true,
            "sPaginationType": "full_numbers"
        }).rowReordering({
            sURL: "<?php echo BASE_URL;?>includes/controllers/ajax.package.php?action=subiiSort",
            fnSuccess: function (message) {
                var msg = jQuery.parseJSON(message);
                showMessage(msg.action, msg.message);
            }
        });
    });

    $(function () {
        /*************************************** USer Image Status Toggler ******************************************/
        $('.imageStatusToggle').on('click', function () {
            var Re = $(this).attr('rowId');
            var status = $(this).attr('status');
            newStatus = (status == 1) ? 0 : 1;
            $.ajax({
                type: "POST",
                url: getLocation(),
                data: "action=SubGallerytoggleStatus&id=" + Re,
                success: function (msg) {
                }
            });
            $(this).attr({'status': newStatus});
            if (status == 1) {
                $('#toggleImg' + Re).removeClass("icon-check-circle-o");
                $('#toggleImg' + Re).addClass("icon-clock-os-circle-o");
            } else {
                $('#toggleImg' + Re).removeClass("icon-clock-os-circle-o");
                $('#toggleImg' + Re).addClass("icon-check-circle-o");
            }
        });
    });


    /***************************************** Package Record delete *******************************************/
    function recordDelete(Re) {
        $('.MsgTitle').html('<?php echo sprintf($GLOBALS['basic']['deleteRecord_'], "User")?>');
        $('.pText').html('Click on yes button to delete this user permanently.!!');
        $('.divMessageBox').fadeIn();
        $('.MessageBoxContainer').fadeIn(1000);

        $(".botTempo").on("click", function () {
            var popAct = $(this).attr("id");
            if (popAct == 'yes') {
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: getLocation(),
                    data: 'action=delete&id=' + Re,
                    success: function (data) {
                        var msg = eval(data);
                        showMessage(msg.action, msg.message);
                        $('#' + Re).remove();
                        reStructureList(getTableId());
                    }
                });
            } else {
                Re = null;
            }
            $('.divMessageBox').fadeOut();
            $('.MessageBoxContainer').fadeOut(1000);
        });
    }

    /*************************************** Toggle Meta tags********************************************/
    function toggleMetadata() {
        $(".metadata").slideToggle("slow", function () {
        });
    }

    /***************************************** Add new Package link *******************************************/
    function AddNewPackage() {
        window.location.href = "<?php echo ADMIN_URL?>package/addEdit";
    }

    /***************************************** View Package link *******************************************/
    function viewPackagelist() {
        window.location.href = "<?php echo ADMIN_URL?>package/list";
    }

    /***************************************** Edit Package link *******************************************/
    function editRecord(Re) {
        window.location.href = "<?php echo ADMIN_URL?>package/addEdit/" + Re;
    }

    function viewpackagedatelist(Re) {
        window.location.href = "<?php echo ADMIN_URL?>package/packagedatelist/" + Re;
    }


    function AddNewPackagedate(Re) {
        window.location.href = "<?php echo ADMIN_URL?>package/addEditpackagedate/" + Re;
    }


    function editsubpackage(Pid, Re) {
        window.location.href = "<?php echo ADMIN_URL?>package/addEditpackagedate/" + Pid + "/" + Re;
    }

    function editItinerary(Pid, Re) {
        window.location.href = "<?php echo ADMIN_URL?>package/addEdititinerary/" + Pid + "/" + Re;
    }

    function AddNewItinerary(Re) {
        window.location.href = "<?php echo ADMIN_URL?>package/addEdititinerary/" + Re;
    }

    function viewItinerarylist(Re) {
        window.location.href = "<?php echo ADMIN_URL?>package/itinerarylist/" + Re;
    }

    function viewreviewlist(Re) {
        window.location.href = "<?php echo ADMIN_URL?>package/reviewlist/" + Re;
    }

    function AddNewReview(Re) {
        window.location.href = "<?php echo ADMIN_URL?>package/addEditreview/" + Re;
    }

    function editReview(Pid, Re) {
        window.location.href = "<?php echo ADMIN_URL?>package/addEditreview/" + Pid + "/" + Re;
    }

    $(document).ready(function () {
        $('#package_date').datepicker({
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            dateFormat: 'yy-mm-dd'
        });
        $('#package_closure').datepicker({
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            dateFormat: 'yy-mm-dd',
        });
    });

    // Deleting Record
    function subrecordDelete(Re) {
        $('.MsgTitle').html('<?php echo sprintf($GLOBALS['basic']['deleteRecord_'], "Package")?>');
        $('.pText').html('Click on yes button to delete this package permanently.!!');
        $('.divMessageBox').fadeIn();
        $('.MessageBoxContainer').fadeIn(1000);

        $(".botTempo").on("click", function () {
            var popAct = $(this).attr("id");
            if (popAct == 'yes') {
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: getLocation(),
                    data: 'action=deletesubpackage&id=' + Re,
                    success: function (data) {
                        var msg = eval(data);
                        showMessage(msg.action, msg.message);
                        $('#' + Re).remove();
                        reStructureList(getTableId());
                    }
                });
            } else {
                Re = null;
            }
            $('.divMessageBox').fadeOut();
            $('.MessageBoxContainer').fadeOut(1000);
        });
    }

    /***Itineratry***/
    function subreDelete(Re) {
        $('.MsgTitle').html('<?php echo sprintf($GLOBALS['basic']['deleteRecord_'], "Itineratry")?>');
        $('.pText').html('Click on yes button to delete this itinerary permanently.!!');
        $('.divMessageBox').fadeIn();
        $('.MessageBoxContainer').fadeIn(1000);

        $(".botTempo").on("click", function () {
            var popAct = $(this).attr("id");
            if (popAct == 'yes') {
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: getLocation(),
                    data: 'action=deleteitinerary&id=' + Re,
                    success: function (data) {
                        var msg = eval(data);
                        showMessage(msg.action, msg.message);
                        $('#' + Re).remove();
                        reStructureList(getTableId());
                    }
                });
            } else {
                Re = null;
            }
            $('.divMessageBox').fadeOut();
            $('.MessageBoxContainer').fadeOut(1000);
        });
    }

    $('.statusItinerary').on('click', function () {
        var id = $(this).attr('moduleId');
        var status = $(this).attr('status');
        newStatus = (status == 1) ? 0 : 1;
        $.ajax({
            type: "POST",
            url: getLocation(),
            data: "action=SubtoggleStatus&id=" + id,
            success: function (msg) {
            }
        });
        $(this).attr({'status': newStatus});
        if (status == 1) {
            $('#imgHolder_' + id).removeClass("bg-green");
            $('#imgHolder_' + id).addClass("bg-red");
            $(this).attr("data-original-title", "Click to Publish");
        } else {
            $('#imgHolder_' + id).removeClass("bg-red");
            $('#imgHolder_' + id).addClass("bg-green");
            $(this).attr("data-original-title", "Click to Un-publish");
        }
    });

    /***Review****/
    function subreviewDelete(Re) {
        $('.MsgTitle').html('<?php echo sprintf($GLOBALS['basic']['deleteRecord_'], "Review")?>');
        $('.pText').html('Click on yes button to delete this review permanently.!!');
        $('.divMessageBox').fadeIn();
        $('.MessageBoxContainer').fadeIn(1000);

        $(".botTempo").on("click", function () {
            var popAct = $(this).attr("id");
            if (popAct == 'yes') {
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: getLocation(),
                    data: 'action=deletereview&id=' + Re,
                    success: function (data) {
                        var msg = eval(data);
                        showMessage(msg.action, msg.message);
                        $('#' + Re).remove();
                        reStructureList(getTableId());
                    }
                });
            } else {
                Re = null;
            }
            $('.divMessageBox').fadeOut();
            $('.MessageBoxContainer').fadeOut(1000);
        });
    }

    /***************************************** AddEdit login Info *******************************************/
    $(document).ready(function () {
        $('.btn-submit').on('click', function () {
            var actVal = $(this).attr('btn-action');
            $('#idValue').attr('myaction', actVal);
        })
        // form submisstion actions
        jQuery('#package_frm').validationEngine({
            autoHidePrompt: true,
            scroll: false,
            onValidationComplete: function (form, status) {
                if (status == true) {
                    $('.btn-submit').attr('disabled', 'true');
                    var action = ($('#idValue').val() == 0) ? "action=add&" : "action=edit&";
                    for (instance in CKEDITOR.instances)
                        CKEDITOR.instances[instance].updateElement();

                    var data = $('#package_frm').serialize();
                    queryString = action + data;
                    $.ajax({
                        type: "POST",
                        dataType: "JSON",
                        url: getLocation(),
                        data: queryString,
                        success: function (data) {
                            var msg = eval(data);
                            if (msg.action == 'warning') {
                                showMessage(msg.action, msg.message);
                                $('.btn-submit').removeAttr('disabled');
                                $('.formButtons').show();
                                return false
                            }
                            if (msg.action == 'success') {
                                showMessage(msg.action, msg.message);
                                var actionId = $('#idValue').attr('myaction');
                                if (actionId == 2)
                                    setTimeout(function () {
                                        window.location.href = "<?php echo ADMIN_URL?>package/list";
                                    }, 3000);
                                if (actionId == 1)
                                    setTimeout(function () {
                                        window.location.href = "<?php echo ADMIN_URL?>package/addEdit";
                                    }, 3000);
                                if (actionId == 0)
                                    setTimeout(function () {
                                        window.location.href = "";
                                    }, 3000);
                            }
                            if (msg.action == 'notice') {
                                showMessage(msg.action, msg.message);
                                setTimeout(function () {
                                    window.location.href = window.location.href;
                                }, 3000);
                            }
                            if (msg.action == 'error') {
                                showMessage(msg.action, msg.message);
                                $('#buttonsP img').remove();
                                $('.formButtons').show();
                                return false;
                            }
                        }
                    });
                    return false;
                }
            }
        });


        /***************************************** View Sub Package Lists *******************************************/
        jQuery('#subpackage_frm').validationEngine({
            prettySelect: true,
            autoHidePrompt: true,
            useSuffix: "_chosen",
            promptPosition: "bottomLeft",
            scroll: true,
            onValidationComplete: function (form, status) {
                if (status == true) {
                    var Re = $("#package_id").val();
                    $('.btn-submit').attr('disabled', 'true');
                    var action = ($('#idValue').val() == 0) ? "action=addpackagedate&" : "action=editpackagedate&";
                    for (instance in CKEDITOR.instances)
                        CKEDITOR.instances[instance].updateElement();

                    var data = $('#subpackage_frm').serialize();
                    queryString = action + data;
                    $.ajax({
                        type: "POST",
                        dataType: "JSON",
                        url: getLocation(),
                        data: queryString,
                        success: function (data) {
                            var msg = eval(data);
                            if (msg.action == 'warning') {
                                showMessage(msg.action, msg.message);
                                $('.btn-submit').removeAttr('disabled');
                                $('.formButtons').show();
                                return false
                            }
                            if (msg.action == 'success') {
                                showMessage(msg.action, msg.message);
                                var actionId = $('#idValue').attr('myaction');
                                if (actionId == 2)
                                    setTimeout(function () {
                                        window.location.href = "<?php echo ADMIN_URL?>package/packagedatelist/" + Re;
                                    }, 3000);
                                if (actionId == 1)
                                    setTimeout(function () {
                                        window.location.href = "<?php echo ADMIN_URL?>package/addEditpackagedate/" + Re;
                                    }, 3000);
                                if (actionId == 0)
                                    setTimeout(function () {
                                        window.location.href = "<?php echo ADMIN_URL?>package/packagedatelist/" + Re;
                                    }, 3000);
                            }
                            if (msg.action == 'notice') {
                                showMessage(msg.action, msg.message);
                                setTimeout(function () {
                                    window.location.href = window.location.href;
                                }, 3000);
                            }
                            if (msg.action == 'error') {
                                showMessage(msg.action, msg.message);
                                $('#buttonsP img').remove();
                                $('.formButtons').show();
                                return false;
                            }
                        }
                    });
                    return false;
                }
            }
        });

        jQuery('#itinerary_frm').validationEngine({
            prettySelect: true,
            autoHidePrompt: true,
            useSuffix: "_chosen",
            promptPosition: "bottomLeft",
            scroll: true,
            onValidationComplete: function (form, status) {
                if (status == true) {
                    var Re = $("#package_id").val();
                    $('.btn-submit').attr('disabled', 'true');
                    var action = ($('#idValue').val() == 0) ? "action=additinerary&" : "action=edititinerary&";
                    for (instance in CKEDITOR.instances)
                        CKEDITOR.instances[instance].updateElement();

                    var data = $('#itinerary_frm').serialize();
                    queryString = action + data;
                    $.ajax({
                        type: "POST",
                        dataType: "JSON",
                        url: getLocation(),
                        data: queryString,
                        success: function (data) {
                            var msg = eval(data);
                            if (msg.action == 'warning') {
                                showMessage(msg.action, msg.message);
                                $('.btn-submit').removeAttr('disabled');
                                $('.formButtons').show();
                                return false
                            }
                            if (msg.action == 'success') {
                                showMessage(msg.action, msg.message);
                                var actionId = $('#idValue').attr('myaction');
                                if (actionId == 2)
                                    setTimeout(function () {
                                        window.location.href = "<?php echo ADMIN_URL?>package/itinerarylist/" + Re;
                                    }, 3000);
                                if (actionId == 1)
                                    setTimeout(function () {
                                        window.location.href = "<?php echo ADMIN_URL?>package/addEdititinerary/" + Re;
                                    }, 3000);
                                if (actionId == 0)
                                    setTimeout(function () {
                                        window.location.href = "<?php echo ADMIN_URL?>package/itinerarylist/" + Re;
                                    }, 3000);
                            }
                            if (msg.action == 'notice') {
                                showMessage(msg.action, msg.message);
                                setTimeout(function () {
                                    window.location.href = window.location.href;
                                }, 3000);
                            }
                            if (msg.action == 'error') {
                                showMessage(msg.action, msg.message);
                                $('#buttonsP img').remove();
                                $('.formButtons').show();
                                return false;
                            }
                        }
                    });
                    return false;
                }
            }
        });
////////Review///////
        jQuery('#review_frm').validationEngine({
            prettySelect: true,
            autoHidePrompt: true,
            useSuffix: "_chosen",
            promptPosition: "bottomLeft",
            scroll: true,
            onValidationComplete: function (form, status) {
                if (status == true) {
                    var Re = $("#package_id").val();
                    $('.btn-submit').attr('disabled', 'true');
                    var action = ($('#idValue').val() == 0) ? "action=addreview&" : "action=editreview&";
                    for (instance in CKEDITOR.instances)
                        CKEDITOR.instances[instance].updateElement();

                    var data = $('#review_frm').serialize();
                    queryString = action + data;
                    $.ajax({
                        type: "POST",
                        dataType: "JSON",
                        url: getLocation(),
                        data: queryString,
                        success: function (data) {
                            var msg = eval(data);
                            if (msg.action == 'warning') {
                                showMessage(msg.action, msg.message);
                                $('.btn-submit').removeAttr('disabled');
                                $('.formButtons').show();
                                return false
                            }
                            if (msg.action == 'success') {
                                showMessage(msg.action, msg.message);
                                var actionId = $('#idValue').attr('myaction');
                                if (actionId == 2)
                                    setTimeout(function () {
                                        window.location.href = "<?php echo ADMIN_URL?>package/reviewlist/" + Re;
                                    }, 3000);
                                if (actionId == 1)
                                    setTimeout(function () {
                                        window.location.href = "<?php echo ADMIN_URL?>package/addEditreview/" + Re;
                                    }, 3000);
                                if (actionId == 0)
                                    setTimeout(function () {
                                        window.location.href = "<?php echo ADMIN_URL?>package/reviewlist/" + Re;
                                    }, 3000);
                            }
                            if (msg.action == 'notice') {
                                showMessage(msg.action, msg.message);
                                setTimeout(function () {
                                    window.location.href = window.location.href;
                                }, 3000);
                            }
                            if (msg.action == 'error') {
                                showMessage(msg.action, msg.message);
                                $('#buttonsP img').remove();
                                $('.formButtons').show();
                                return false;
                            }
                        }
                    });
                    return false;
                }
            }
        });


        /*********Package Gallery*************/
        jQuery('#gallery_frm').validationEngine({
            autoHidePrompt: true,
            scroll: false,
            onValidationComplete: function (form, status) {
                if (status == true) {
                    $('#btn-submit').attr('disabled', 'true');
                    var action = "action=addPackageImage&";
                    var data = $('#gallery_frm').serialize();
                    queryString = action + data;
                    $.ajax({
                        type: "POST",
                        dataType: "JSON",
                        url: getLocation(),
                        data: queryString,
                        success: function (data) {
                            var msg = eval(data);
                            if (msg.action == 'warning') {
                                showMessage(msg.action, msg.message);
                                $('#btn-submit').removeAttr('disabled');
                                $('.formButtons').show();
                                return false
                            }
                            if (msg.action == 'success') {
                                showMessage(msg.action, msg.message);
                                setTimeout(function () {
                                    window.location.href = window.location.href;
                                }, 3000);
                            }
                            if (msg.action == 'notice') {
                                showMessage(msg.action, msg.message);
                                setTimeout(function () {
                                    window.location.href = window.location.href;
                                }, 3000);
                            }
                            if (msg.action == 'error') {
                                showMessage(msg.action, msg.message);
                                $('#buttonsP img').remove();
                                $('.formButtons').show();
                                return false;
                            }
                        }
                    });
                    return false;
                }
            }
        })

        //Filter Destinatino wise activity option
        $('.destinationId').on('change', function () {
            var destId = $(this).val();
            var seltId = $('.actaction').attr('selId');
            $('.actaction').html('<option>Loading...</optioin>');
            $('.actregion').html('<option>Loading...</optioin>');
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: getLocation(),
                data: "action=filteractivity&destid=" + destId + "&selct=" + seltId,
                success: function (data) {
                    var msg = eval(data);
                    if (msg.action == 'success') {
                        $('.actaction').html(msg.result);
                        $('.actregion').html('<option value="">None</optioin>');
                    }
                }
            });
            return false;
        });

        //Filter Activity wise Region option
        $('.actaction').on('change', function () {
            var actId = $(this).val();
            var seltId = $('.actaction').attr('selId');
            $('.actregion').html('<option>Loading...</optioin>');
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: getLocation(),
                data: "action=filterRegion&actid=" + actId + "&selct=" + seltId,
                success: function (data) {
                    var msg = eval(data);
                    if (msg.action == 'success') {
                        $('.actregion').html(msg.result);
                    }
                }
            });
            return false;
        });

        //Map type on change
        $("input[name='maptype']").change(function () {
            var rVal = $(this).val();
            if (rVal == 1) {
                $('.googlemap, .videolink').addClass('hide');
                $('.imagemap').removeClass('hide');
            }
            if (rVal == 2) {
                $('.imagemap, .videolink').addClass('hide');
                $('.googlemap').removeClass('hide');
            }
            if (rVal == 3) {
                $('.googlemap, .imagemap').addClass('hide');
                $('.videolink').removeClass('hide');
            }
        });
    });
    /*************************** Shorting Sub Image Gallery Postion *******************************/
    $(document).ready(function () {
        $(function () {
            $(".Imagegallery-sort").sortable({
                //connectWith: ".video-sort",
                start: function (event, ui) {
                    var start_pos = ui.item.index();
                    ui.item.data('start_pos', start_pos);
                },
                update: function (event, ui) {
                    var mySel = "";
                    $('div.oldsort').each(function (i) {
                        mySel = mySel + ';' + $(this).attr('csort');
                    });
                    //var start_pos = ui.item.data('start_pos');
                    var id = ui.item.context.id;
                    var end_pos = ui.item.index();
                    $.ajax({
                        type: "POST",
                        dataType: "JSON",
                        url: getLocation(),
                        data: "action=sortGalley&id=" + id + "&toPosition=" + end_pos + "&sortIds=" + mySel,
                        success: function (data) {
                            var msg = eval(data);
                            showMessage(msg.action, msg.message);
                        }
                    });
                }
            });
        });
    });


    /******************************** Remove temp upload image ********************************/
    function deleteTempimage(Re) {
        $('#previewUserimage' + Re).fadeOut(1000, function () {
            $('#previewUserimage' + Re).remove();
            $('#preview_Image').html('<input type="hidden" name="imageArrayname" value="" class="">');
        });
    }

    /******************************** Remove User saved Sub Package images ********************************/
    function deleteSavedimage(Re) {
        $('.MsgTitle').html('<?php echo sprintf($GLOBALS['basic']['deleteRecord_'], "image")?>');
        $('.pText').html('Click on yes button to delete this image permanently.!!');
        $('.divMessageBox').fadeIn();
        $('.MessageBoxContainer').fadeIn(1000);

        $(".botTempo").on("click", function () {
            var popAct = $(this).attr("id");
            if (popAct == 'yes') {
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: getLocation(),
                    data: 'action=deleteimage&id=' + Re,
                    success: function (data) {
                        var msg = eval(data);
                        if (msg.action == 'success') {
                            $('.removeSavedimg' + Re).fadeOut(1000, function () {
                                $('.removeSavedimg' + Re).remove();
                            });
                        }
                    }
                });
            } else {
                Re = '';
            }
            $('.divMessageBox').fadeOut();
            $('.MessageBoxContainer').fadeOut(1000);
        });
    }


    /******************************** Remove saved slideshow image ********************************/
    function deleteSavedPackageimage(Re) {
        $('.MsgTitle').html('Do you want to delete the record ?');
        $('.pText').html('Clicking yes will be delete this record permanently. !!!');
        $('.divMessageBox').fadeIn();
        $('.MessageBoxContainer').fadeIn(1000);

        $(".botTempo").on("click", function () {
            var popAct = $(this).attr("id");
            if (popAct == 'yes') {
                $('#removeSavedimg' + Re).fadeOut(1000, function () {
                    $('#removeSavedimg' + Re).remove();
                    $('.uploader').fadeIn(500);
                });
            } else {
                Re = '';
            }
            $('.divMessageBox').fadeOut();
            $('.MessageBoxContainer').fadeOut(1000);
        });
    }

    function deleteSavedItineraryimage(Re) {
        $('.MsgTitle').html('Do you want to delete the record ?');
        $('.pText').html('Clicking yes will be delete this record permanently. !!!');
        $('.divMessageBox').fadeIn();
        $('.MessageBoxContainer').fadeIn(1000);

        $(".botTempo").on("click", function () {
            var popAct = $(this).attr("id");
            if (popAct == 'yes') {
                $('#removeSavedimg' + Re).fadeOut(1000, function () {
                    $('#removeSavedimg' + Re).remove();
                    $('.uploader' + Re).fadeIn(500);
                });
            } else {
                Re = '';
            }
            $('.divMessageBox').fadeOut();
            $('.MessageBoxContainer').fadeOut(1000);
        });
    }

    function deleteSavedReviewimage(Re) {
        $('.MsgTitle').html('Do you want to delete the record ?');
        $('.pText').html('Clicking yes will be delete this record permanently. !!!');
        $('.divMessageBox').fadeIn();
        $('.MessageBoxContainer').fadeIn(1000);

        $(".botTempo").on("click", function () {
            var popAct = $(this).attr("id");
            if (popAct == 'yes') {
                $('#removeSavedimg' + Re).fadeOut(1000, function () {
                    $('#removeSavedimg' + Re).remove();
                    $('.uploader' + Re).fadeIn(500);
                });
            } else {
                Re = '';
            }
            $('.divMessageBox').fadeOut();
            $('.MessageBoxContainer').fadeOut(1000);
        });
    }

    // **** **** //
    $(document).on('click', '.add_tripdate', function (e) {
        var rand = Math.floor((Math.random() * 100) + 1);
        var newinput = '<div class="col-md-3" id="trip-' + rand + '">\
            <div class="row">\
            	<div class="col-md-10">\
                	<input placeholder="Date" class="col-md-10 dobpicker validate[custom[date]]" type="text" name="pdate[' + rand + ']" id="pdate' + rand + '">\
                </div>\
                <span class="btn medium bg-red remove_tripdate" data-rid="' + rand + '">-</span>\
                <div class="clear"></div>\
                <div class="form-checkbox-radio col-md-12 form-input">\
                    <input type="radio" value="1" name="date_status[' + rand + ']" checked><label>Available</label>\
                    <input type="radio" value="2" name="date_status[' + rand + ']"><label>Sold Out</label>\
                </div>\
            </div>\
        </div>';
        $('.trip-date').append(newinput);
    });

    $(document).on('click', '.remove_tripdate', function (e) {
        var rid = $(this).attr('data-rid');
        $('#trip-' + rid).remove();
    });

    $(document).on('focus', ".dobpicker", function () {
        $(this).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd'
        })
    });

    function viewsubimagelist(Re) {
        window.location.href = "<?php echo ADMIN_URL?>package/packageImageList/" + Re;
    }

    function viewSubImageslist(Re) {
        window.location.href = "<?php echo ADMIN_URL?>package&mode=packageImageList/" + Re;
    }

    function editImageTitle(Re) {
        var clicked = $('.clicked' + Re);
        $(clicked).html("");
        $('<input/>').attr({
            type: 'text',
            id: 'ne-title',
            name: 'ne-title',
            class: 'validate[required,length[0,250]] col-md-9',
            'imgId': Re
        }).appendTo($(clicked)).focus();
        $(clicked).append(' <button type="submit" id="ne-submit" class="col-md-3">Save</button>');

        $('.up-title').on("click", "#ne-submit", function (e) {
            var data = $("#ne-title");
            var id = $(data).attr("imgId");
            var title = $(data).val();
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: getLocation(),
                data: 'action=editGalleryImageText&id=' + id + '&title=' + title,
                success: function (data) {
                    var msg = eval(data);
                    if (msg.action == 'success') {
                        showMessage(msg.action, msg.message);
                        setTimeout(function () {
                            window.location.href = window.location.href;
                        }, 3000);
                    }
                    if (msg.action == 'error') {
                        showMessage(msg.action, msg.message);
                        setTimeout(function () {
                            window.location.href = window.location.href;
                        }, 3000);
                    }
                    if (msg.action == 'notice') {
                        showMessage(msg.action, msg.message);
                        setTimeout(function () {
                            window.location.href = window.location.href;
                        }, 3000);
                    }
                }
            });
        });
    }
</script>