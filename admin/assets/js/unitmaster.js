jQuery.noConflict();
jQuery(document).ready(function ($) {
    function load_table() {
        $.ajax({
            url: "ajax_load.php",
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

    

    $(document).on("click", ".modalsubmit", function (e) {
        e.preventDefault();
        var unitname = $("#unitname").val();
        var unitstatus = $("#status").val();
        $.ajax({
            url: "ajax_load.php",
            type: "POST",
            data: { action: "insert", uname: unitname, ustatus: unitstatus },
            success: function (result) {
                if (result == 1) {
                    load_table();
                    $("#unitForm").trigger("reset");
                } else {
                    alert("not saved");
                }
            }
        });
    });

    
    $(document).on("click",".unitDelete",function(){
        var uid = $(this).data("id");
        var uaction = "delete";
        var element = this;
        $.ajax({
            url : "ajax_load.php",
            type : "POST",
            data : {action : uaction, id : uid},
            success : function(result){
                if(result == 1){
                    $(element).closest("tr").fadeOut();
                    load_table();
            }else{
                alert("can't delete");
            }
        }
        });
    });

    $(document).on("click",".unitEdit",function(){
        var uid = $(this).data("id");
        var uaction = "edit";
        $.ajax({
            url : "ajax_load.php",
            type : "POST",
            data : {action : uaction, id : uid},
            success : function(result){
                $("#myModalUpdate").html(result);
                $("#myModalUpdate").modal('show');
            }
        });
    });

    $(document).on("click",".btnUpdate",function(){
        var uid = $("#unitId").val();
        var editUnit = $("#editunitname").val();
        var editStatus = $("#editstatus").val();;
        var uaction = "update";
        $.ajax({
            url : "ajax_load.php",
            type : "POST",
            data : {action : uaction, id : uid, unit : editUnit, status : editStatus},
            success : function(result){
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