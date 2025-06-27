<script language="javascript">

    function getLocation() {
        return '<?php echo BASE_URL;?>includes/controllers/ajax.review.php';
    }

    function getTableId() {
        return 'table_dnd';
    }

    $(document).ready(function () {
        oTable = $('#example').dataTable({
            "bJQueryUI": true,
            "sPaginationType": "full_numbers"
        }).rowReordering({
            sURL: "<?php echo BASE_URL;?>includes/controllers/ajax.review.php?action=sort",
            fnSuccess: function (message) {
                var msg = jQuery.parseJSON(message);
                showMessage(msg.action, msg.message);
            }
        });
    });


    /*************************************** Toggle AddEdit Form ********************************************/
    function toggleMetadata() {
        $(".metadata").slideToggle("slow", function () {
        });
    }


    // Edit records
    function editRecord(Re) {
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: getLocation(),
            data: 'action=editExistsRecord&id=' + Re,
            success: function (data) {
                var msg = eval(data);
                $("#title").val(msg.title);
                $("#idValue").val(msg.editId);
            }
        });
    }


    // Deleting Record
    function recordReviewDelete(Re) {
        $('.MsgTitle').html('<?php echo sprintf($GLOBALS['basic']['deleteRecord_'], "review")?>');
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
                    data: 'action=delete&id=' + Re,
                    success: function (data) {
                        var msg = eval(data);
                        showMessage(msg.action, msg.message);
                        $('#' + Re).remove();
                        reStructureList(getTableId());
                    }
                });
            }
            $('.divMessageBox').fadeOut();
            $('.MessageBoxContainer').fadeOut(1000);
        });
    }

    /***************************************** View Vacencys Lists *******************************************/
    function viewreviewlist() {
        window.location.href = "<?php echo ADMIN_URL?>review/list";
    }


    /***************************************** Edit records *****************************************/
    function editReview(Re) {
        window.location.href = "<?php echo ADMIN_URL?>review/EditReview/" + Re;
    }
</script>