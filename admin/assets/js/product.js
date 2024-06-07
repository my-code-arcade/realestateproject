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


   $('#fileUploadId').on('change', function(){
    var file = this.files[0]; // Get the selected file
    if (file) {
        var reader = new FileReader(); // Create a new FileReader object
        reader.onload = function(e) {
            $('#logo_image').attr('src', e.target.result); // Set the src attribute of the image with the data URL of the selected file
        };
        reader.readAsDataURL(file); // Read the selected file as a data URL
    }
});

    $("#unitForm12").on("submit", function (e) {
        e.preventDefault();
        var formData = new FormData(this);
       
        var id = $('#modalid').val();
            // console.log('id='.id);
            if(id =='' || id == undefined){
                action = 'insert';
                formData.append("action","insert");
            }
            else{
                action = 'update';
                var currentImage =  $("#logo_image").attr('src') ?? '';
                formData.append("image",currentImage);
                formData.append("action","update");
            }
        // formData.append('action', 'insert');
        $.ajax({
            url: "product_controller.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (result) {
                // console.log(result);
                if (result.duplicate) {
                    $("#msg").fadeIn().removeClass('sucess-msg').addClass('error-msg').html("Duplicate Record Detected: Please Make Changes.");
                } else if (result.success) {
                    $("#msg").fadeIn().removeClass('error-msg').addClass('sucess-msg').html(result.msg);
                   load_table(); // Assuming this function loads the table data
                } else {
                    $("#msg").fadeIn().removeClass('sucess-msg').addClass('error-msg').html(result.msg);
                }
                setTimeout(function () {
                    $("#msg").fadeOut("slow");
                    $("#unitForm12").trigger("reset");
                    $("modalid").val('');
                    $("#logo_image").attr('src','');
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
                    alert("Succesfully Deleted");
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
            url: "product_controller.php",
            type: "POST",
            data: { action: uaction, id: uid },
            success: function (result) {

                // var filename = $(fileUploadId).val(arr['imgsource']).split('\\').pop();
                // $('#fileName').text(filename);
                var arr = JSON.parse(result);
                // $("#myModalUpdate").html(result);
                $("#modalid").val(arr['id']);
                $("#headingId").val(arr['heading']);
                $("#subHeadingId").val(arr['subheading']);

                // attr('value', fileUrl);
                $("#fileUploadId").attr('value',arr['imgsource']);
                $("#logo_image").attr('src',arr['imgsource']);
                $("#aresId").val(arr['building_area']);
                $("#bedroomsId").val(arr['bedrooms']);
                $("#bathroomsId").val(arr['bathroom']);
                $("#flatTypeId").val(arr['flat_type']);
                $("#status").val(arr['isActive']);
                $("#myModal").modal('show');
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