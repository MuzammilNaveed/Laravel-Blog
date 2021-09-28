@extends('admin.layout.master')
@section('page_title','Manage Contact')
@section('contact','active')
@section('container')

<div class="row mt-2">
  <div class="container-fluid p-0">

    <div class="d-flex justify-content-between pt-3 pb-3 pr-0 pl-0">
      <div class="card-title font-weight-bolder"> Contacts </div>
    </div>

    <div class="card card_shadow">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover w-100 text-center" id="contact_table">
            <thead>
              <tr>
                <th>Sr#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Created at</th>
                <th>View</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>




@endsection
@section('scripts')
<script>
  $(document).ready(function() {
    get_all_contacts();
  });


  function get_all_contacts() {
    $("#contact_table").DataTable().destroy();
    $.fn.dataTable.ext.errMode = "none";
    var tbl =$("#contact_table").DataTable({
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
        ajax: {
            url: "{{url('get_contacts')}}",
        },
        columns: [
            {
                data: null,
                defaultContent: ""
            },
            {
                render: function(data, type, full, meta) {
                    return full.name != null ? full.name : "-";
                }
            },
            {
                className: "small text-center",
                render: function(data, type, full, meta) {
                    return full.email != null ? full.email : '-';
                }
            },
            {
                render: function(data, type, full, meta) {
                  return moment(full.created_at).format("DD-MM-YYYY");
                }
            },
            {
                render: function(data, type, full, meta) {
                    let update_btn =
                    `<a  href="{{url('view_contacts')}}/` + full.id + `" type="button" 
                        class="btn btn-primary text-white btn_cirlce" title="View contact">
                        <i class="fas fa-eye"></i>
                    </a>`;
                  return update_btn;
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
</script>
@show