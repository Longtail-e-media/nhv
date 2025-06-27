<script language="javascript">
    /*********************************** Message Display ***********************************************/
    function showMessage(mode, msg) {
        switch (mode) {
            case 'success': // Success message
                newClass = 'success-bg';
                myicon = 'icon-check-square-o';
                break;
            case 'error': // Error Message
                newClass = 'error-bg';
                myicon = 'icon-cog';
                break;
            case 'notice': // Notice message
                newClass = 'notice-bg';
                myicon = 'icon-info-circle';
                break;
            case 'warning': // Warning Message
                newClass = 'warning-bg';
                myicon = 'icon-warning';
                break;
        }
        var message = '<div class="myinfobox infobox clearfix infobox-close-wrapper ' + newClass + '"><div class="info-icon"><i class="glyph-icon ' + myicon + '"></i></div><a href="javascript:void(0);" onclick="infoboxclose(this);" title="Close Message" class="glyph-icon infobox-close icon-remove"></a><p>' + msg + '</p></div>';
        //$(message).prependTo('.my-msg').fadeIn(2500).fadeOut(4000,function(){window.location.href=window.location.href;});
        $(message).prependTo('.my-msg').fadeIn(500, function () {
            $('.myinfobox').fadeOut(6000)
        });
        $("html, body").animate({scrollTop: 0}, "slow");
    }

    /************************************ Message Popup close *******************************************/
    function infoboxclose(Re) {
        $(Re).parent().fadeOut(1000);
    }

    /******************************* Temp Remove table row when delete **********************************/
    function reStructureList(tableId) {
        $('tbody tr:even').addClass("alt-row");
        $('#' + tableId + ' tbody tr').removeClass('alt-row');
        $('#' + tableId + ' tr:even').addClass('alt-row');
        $('.sort-order').each(function (i) {
            $(this).text(i + 1);
        });
    }

    /************************************ Check parent with all chield **************************************/
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

        /************************************* Bulk Transactions *******************************************/
        $('#applySelected_btn').on("click", function () {
            var action = $('#groupTaskField').val();
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
                    case "toggleStatus":
                        $('.record-checkbox').each(function () {
                            if ($(this).is(":checked")) {
                                $('#imgHolder_' + $(this).attr('bulkId')).html('<img src="../images/apanel/loadwheel.gif" />');
                            }
                        });
                        $.ajax({
                            type: "POST",
                            url: getLocation(),
                            data: "action=bulkToggleStatus&idArray=" + idArray,
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

                    case "delete":
                        $('.MsgTitle').html('Do you want to delete the selected rows?');
                        $('.pText').html('Click on yes button to delete this rows permanently.!!');
                        $('.divMessageBox').fadeIn();
                        $('.MessageBoxContainer').fadeIn(1000);

                        $(".botTempo").on("click", function () {
                            var popAct = $(this).attr("id");
                            if (popAct == 'yes') {
                                deleteSelectedRecords(idArray);
                            }
                            $('.divMessageBox').fadeOut();
                            $('.MessageBoxContainer').fadeOut(1000);
                        });
                        break;

                    case "copyRecord":
                        $('.MsgTitle').html('Do you want to duplicate the records ?');
                        $('.pText').html('click on yes to duplicate the records. !!!');
                        $('.divMessageBox').fadeIn();
                        $('.MessageBoxContainer').fadeIn(1000);

                        $(".botTempo").on("click", function () {
                            var popAct = $(this).attr("id");
                            if (popAct == 'yes') {
                                duplicateSelectedRecords(idArray);
                            }
                            $('.divMessageBox').fadeOut();
                            $('.MessageBoxContainer').fadeOut(1000);
                        });
                        break;
                    case "moveRecord":
                        var location = getLocation();
                        $.ajax({
                            type: "POST",
                            url: getLocation(),
                            data: "action=" + action + "&idArray=" + idArray + '&targetArticle=' + $('#moveTargetRecord').val()<?php if (isset($_GET['currpage'])) echo "+'&currpage='+" . $_GET['currpage']?><?php if (isset($_GET['ipp'])) echo "+'&ipp='+" . $_GET['ipp']?>,
                            success: function (msg) {
                                window.location.href = msg;
                            }
                        });
                        break;

                    case "subtoggleStatus":
                        $('.record-checkbox').each(function () {
                            if ($(this).is(":checked")) {
                                $('#imgHolder_' + $(this).attr('bulkId')).html('<img src="../images/apanel/loadwheel.gif" />');
                            }
                        });
                        $.ajax({
                            type: "POST",
                            url: getLocation(),
                            data: "action=subbulkToggleStatus&idArray=" + idArray,
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

                    case "subdelete":
                        $('.MsgTitle').html('Do you want to delete the selected rows?');
                        $('.pText').html('Click on yes button to delete this rows permanently.!!');
                        $('.divMessageBox').fadeIn();
                        $('.MessageBoxContainer').fadeIn(1000);

                        $(".botTempo").on("click", function () {
                            var popAct = $(this).attr("id");
                            if (popAct == 'yes') {
                                subdeleteSelectedRecords(idArray);
                            }
                            $('.divMessageBox').fadeOut();
                            $('.MessageBoxContainer').fadeOut(1000);
                        });
                        break;
                } // end switch section
                reStructureList(getTableId());
            } // end if section
        });

        /*************************************** Delete Toggler ******************************************/
        function deleteSelectedRecords(idArray) {
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: getLocation(),
                data: "action=bulkDelete&idArray=" + idArray,
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

        /*************************************** Delete Sub Toggler ******************************************/
        function subdeleteSelectedRecords(idArray) {
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: getLocation(),
                data: "action=subbulkDelete&idArray=" + idArray,
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

        /*************************************** Status Toggler ******************************************/
        $('.statusToggler').on('click', function () {
            var id = $(this).attr('moduleId');
            var status = $(this).attr('status');
            newStatus = (status == 1) ? 0 : 1;
            $.ajax({
                type: "POST",
                url: getLocation(),
                data: "action=toggleStatus&id=" + id,
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

        /*************************************** Status Sub Toggler ******************************************/
        $('.statusSubToggler').on('click', function () {
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
    });

    /********************  Clear all log **********************/
    function Clearlog() {
        $('.MsgTitle').html('Do you want to Clear all log ?');
        $('.pText').html('Clicking yes will be delete all log permanently. !!!');
        $('.divMessageBox').fadeIn();
        $('.MessageBoxContainer').fadeIn(1000);

        $(".botTempo").on("click", function () {
            var popAct = $(this).attr("id");
            if (popAct == 'yes') {
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: "../includes/controllers/ajax.log.php",
                    data: 'action=delete_all',
                    success: function (data) {
                        var msg = eval(data);
                        if (msg.action == 'success') {
                            $('.tr_logs').remove();
                            $('.fg-toolbar').remove();
                            reStructureList(getTableId());
                        }
                    }
                });
            }
            $('.divMessageBox').fadeOut();
            $('.MessageBoxContainer').fadeOut(1000);
            setTimeout(function () {
                window.location.href = window.location.href;
            }, 1500);
        });
    }


    /*************************************** Duplication Toggler ******************************************/
    function duplicateSelectedRecords(idArray) {
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: getLocation(),
            data: "action=bulkDuplication&idArray=" + idArray,
            success: function (data) {
                var msg = eval(data);
                if (msg.action == 'warning') {
                    showMessage(msg.action, msg.message);
                    setTimeout(function () {
                        window.location.href = window.location.href;
                    }, 3000);
                }
                if (msg.action == 'error') {
                    showMessage(msg.action, msg.message);
                }
            }
        });
    }

    /*************************************** Redirect Userwise Answer sheet ******************************************/
    function viewNotification(Re) {
        window.location.href = "main.php?page=personsetting&mode=view&id=2#PersonInfo3";
    }

    /********************  View All Feedback Record  **********************/
    function viewAllFeedback() {
        window.location.href = "main.php?page=usersfeedback";
    }

    /********************  View All Feedback Record  **********************/
    function feedbackDetails(Re) {
        window.location.href = "main.php?page=usersfeedback&mode=view&id=" + Re;
    }

    /********************  Reply Related User Feedback **********************/
    function feedbackReply(Re) {
        window.location.href = "main.php?page=personsetting&mode=view&id=" + Re + "#PersonInfo5";
    }

   
    function create_editor(base_url, editor_arr) {
        if (editor_arr.length > 0) {
            for (var i in editor_arr) {
                CKEDITOR.replace(editor_arr[i], {
                    filebrowserBrowseUrl: base_url + 'ckfinder/ckfinder.html'
                });
                /* allow empty i tags in editor */
                CKEDITOR.dtd.$removeEmpty.i = 0;
                /* For Read More*/
                var element = CKEDITOR.document.getById('readMore');
                element.on('click', function (ev) {
                    var data = CKEDITOR.instances['content'].getData();
                    if (data.match(/<hr id="system_readmore" style="border-style: dashed; border-color: orange;" \/>/g)) {
                        showMessage('notice', 'Action already exists.');
                        return false;
                    } else {
                        CKEDITOR.instances['content'].insertHtml('<hr id="system_readmore" style="border-style: dashed; border-color: orange;" />');
                    }
                });
            }
        }
    }


    $(function () {
        $(".character-keyword").keyup(function () {
            var a = 250, b = $(this).val().length;
            if (b >= a) $(".keyword-remaining").text(" you have reached the limit");
            else {
                var c = a - b;
                $(".keyword-remaining").text(c + " characters left")
            }
        });

        $(".character-description").keyup(function () {
            var a = 160, b = $(this).val().length;
            if (b >= a) $(".description-remaining").text(" you have reached the limit");
            else {
                var c = a - b;
                $(".description-remaining").text(c + " characters left")
            }
        });
    });
</script>