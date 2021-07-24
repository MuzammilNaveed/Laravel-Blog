
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });
});

function savePermissions() {
    var page = $("#page").val();
    var role = $("#role").val();
    var permission = '';
    var permissions = $("#permissions").val();
    permission = permissions.join(',');
    var form_data = {
        page:page,
        role:role,
        permissions:permission,
    }
    $.ajax({
        type: "POST",
        url: save_permissions,
        data:form_data,
        beforeSend:function(data) {
            $("#loader").show();
        },  
        success: function(data) {
            console.log(data);
            if(data.status == 200 && data.success == true) {
                notyf.success(data.message);
                $("#page").val("").trigger('change');
                $("#role").val("").trigger('change');
                $("#permissions").val("").trigger('change');
            }else{
                notyf.error(data.message);
            }
        },
        complete:function(data) {
            $("#loader").hide();
        },
        error: function(e) {
            console.log(e);
            $("#loader").hide();
        }
    });
}


function showRolePermissions(role_id) {
    var page = $("#page").val();

    var form_data = {
        page:page,
        role_id:role_id,
    }
    if(role_id != "") {
        $.ajax({
            type: "POST",
            url: show_role_permissions,
            data:form_data,
            success: function(data) {
                console.log(data);
                var obj = data.permissions;
                $("#action_block").removeAttr('style');
                if(data.status == 200 && data.success == true) {

                    if(obj != null && obj != "") {
                        let action = obj.action.split(',');
                        $("#permissions").val(action).trigger('change');
                    }else{
                        $("#permissions").val("").trigger('change');
                    }
                }
            },
            error: function(e) {
                console.log(e);
                $("#loader").hide();
            }
        });
    }
    
}

function Permissionpages() {
    $("#action_block").hide();
    $("#role").val("").trigger('change');
}