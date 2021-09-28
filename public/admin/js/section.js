$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });

    $("#add_section").click(function() {
        $("#modal_title").text("Add Section");
       $("#addModal").modal('show'); 
    });

    $("#addRecord").submit(function(e) {
        e.preventDefault();

        $.ajax({
            type: "POST",
            url: "/save_section",
            data: new FormData(this),
            dataType: "JSON",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend:function(data) {
            },
            success: function(data) {
                console.log(data, "a");
                if ((data.status == 200) & (data.success == true)) {
                    notyf.success(data.message);
                    get_all_sections();
                    $('#addModal').modal('hide');
                    $("#title").val("");
                } else {
                    notyf.error(data.message);
                }
            },
            complete: function(data) {
            },
            error: function(e) {
                console.log(e);
            }
        });
    });

    get_all_sections();
    
});


function viewRecord(id,name,status) {

    $("#addModal").modal('show');
    $("#id").val(id);
    $("#title").val(name);

    if(status == 1) {
        $("#checkcircleColorOpt2").prop("checked",true);
    }else{
        $("#checkcircleColorOpt2").prop("checked",false);
    }
}


function deleteRecord(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          
        $.ajax({
            type: "POST",
            url: "/delete_section/",
            data:{id:id},
            dataType: 'json',
            success: function(data) {
    
                if ((data.status == 200) & (data.success == true)) {
                    get_all_sections();
                    notyf.success(data.message);
                } else {
                    notyf.error(data.message);
                }    
            },
            error: function(e) {
                console.log(e);
            }
        });
        }
      })
}


function get_all_sections() {
    $("#section_table").DataTable().destroy();
    $.fn.dataTable.ext.errMode = "none";
    var tbl =$("#section_table").DataTable({
        processing: true,
        serverSide: true,
        searching: true,
        pageLength: 10,
        columnDefs: [
            {
                orderable: false,
                targets: 0
            }
        ],
        ajax: { url: get_section },
        columns: [
            {
                data: null,
                defaultContent: ""
            },
            {
                render: function(data, type, full, meta) {
                    return full.title;
                }
            },
            {
                render: function(data, type, full, meta) {
                    let active = `<span class="badge badge-pill bg-success"> active </span>`;
                    let de_active = `<span class="badge badge-pill bg-danger"> not active </span>`;
                    return full.status == 1 ? active : de_active;
                }
            },
            {
                render: function(data, type, full, meta) {
                    return moment(full.created_at).format("DD-MM-YYYY");
                }
            },
            {
                render: function(data, type, full, meta) {
                    return `
                        <button onclick="viewRecord(`+ full.id +`, '`+full.title+`',`+full.status+`)" type="button" 
                            class="btn btn-primary text-white btn_cirlce" data-toggle="tooltip" data-placement="top" title="Edit" >
                            <i class="fas fa-pencil-alt"></i> 
                        </button>
                        <button onclick="deleteRecord(`+full.id+`)" type="button" 
                            class="btn btn-danger text-white ml-2 text-white btn_cirlce" data-toggle="tooltip" data-placement="top" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>`;
                }
            },
        ]
    });
    tbl.on("order.dt search.dt", function() {
        tbl.column(0, {
            search: "applied",
            order: "applied"
        })
            .nodes()
            .each(function(cell, i) {
                cell.innerHTML = i + 1;
            });
    }).draw();
}
