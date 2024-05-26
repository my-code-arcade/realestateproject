jQuery.noConflict();
jQuery(document).ready(function ($) {
    function load_table() {
        $.ajax({
            url: "product_controller.php",
            type: "POST",
            data: { action: "load" },
            success: function (result) {
                // Assuming the result returned by ajax_load.php is the HTML table content
                $("#unitTableContents").html(result);
            },
            error: function (xhr, status, error) {
                console.error("AJAX request failed:", status, error);
            }
        });
    }
    load_table();

    $("#unitForm12").on("submit", function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        formData.append('action', 'insert');
        $.ajax({
            url: "product_controller.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (result) {
                console.log(result);
                if (result.duplicate) {
                    $("#msg").fadeIn().removeClass('sucess-msg').addClass('error-msg').html("Duplicate Record Detected: Please Make Changes.");
                } else if (result.success) {
                    $("#msg").fadeIn().removeClass('error-msg').addClass('sucess-msg').html("Save successful: Your record has been successfully saved.");
                    load_table(); // Assuming this function loads the table data
                } else {
                    $("#msg").fadeIn().removeClass('sucess-msg').addClass('error-msg').html("Save Failed: Record Not Saved.");
                }
                setTimeout(function () {
                    $("#msg").fadeOut("slow");
                    $("#unitForm12").trigger("reset");
                }, 2000);
            }
        });
    });


    $(document).on("click", ".unitDelete", function () {
        var uid = $(this).data("id");
        var uaction = "delete";
        var element = this;
        $.ajax({
            url: "product_controller.php",
            type: "POST",
            data: { action: uaction, id: uid },
            success: function (result) {
                if (result == 1) {
                    $(element).closest("tr").fadeOut();
                    load_table();
                } else {
                    alert("can't delete");
                }
            }
        });
    });

    $(document).on("click", ".unitEdit", function () {
        var uid = $(this).data("id");
        var uaction = "edit";
        $.ajax({
            url: "ajax_load.php",
            type: "POST",
            data: { action: uaction, id: uid },
            success: function (result) {
                $("#myModalUpdate").html(result);
                $("#myModalUpdate").modal('show');
            }
        });
    });

    $(document).on("click", ".btnUpdate", function () {
        var uid = $("#unitId").val();
        var editUnit = $("#editunitname").val();
        var editStatus = $("#editstatus").val();;
        var uaction = "update";
        $.ajax({
            url: "ajax_load.php",
            type: "POST",
            data: { action: uaction, id: uid, unit: editUnit, status: editStatus },
            success: function (result) {
                $("#myModalUpdate").modal('hide');
                if (result == 1) {
                    load_table();
                    $("#unitForm").trigger("reset");
                } else {
                    alert("not saved");
                }
                // $("#unitFormUpdata").html(result);
                // $("#myModalUpdate").modal('show');
            }
        });
    });
});