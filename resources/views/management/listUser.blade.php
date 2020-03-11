@extends('layouts.master_admin')
@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="" style="margin: 0;font-size: 26px;">List User</h3>
                <div class="clearfix"></div>
                <a href="#add" class="btn btn-success" style="margin:10px 0px;" data-toggle="modal">Add new User</a>    
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="user_table" class="display">
                    <thead>
                        <tr>
                            <th>Id.</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>#</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>
<div class="modal fade" id="add">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" class="" role="form" id="user_add" data-url="{{route('user.store')}}">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>            
                </div>
                <div class="modal-body">
                    <h2 style="text-align: center;">User:</h2>
                    @csrf
                    <div id="user-error-add" style="text-align: center;">

                    </div>
                    <div class="form-group">
                        <label for="">Name</label>
                        <input name="name" type="text" class="form-control" id="user_add_name" placeholder="Enter Name">
                    </div>
                    <div class="form-group">
                        <label for="">Username</label>
                        <input name="username" type="text" class="form-control" id="user_add_username" placeholder="Enter Username">
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input name="email" type="email" class="form-control" id="user_add_email" placeholder="Enter Email">
                    </div>
                    <div class="form-group">
                        <label for="">Password</label>
                        <input name="password" type="password" class="form-control" id="user_add_password" placeholder="Enter Password">
                    </div>
                    <div class="form-group">
                        <label for="">Password-Confirm</label>
                        <input name="password_confirmation" type="password" class="form-control" id="user_add_password_confirm" placeholder="Enter Password Confirm">
                    </div>
                    <div class="form-group">
                        <div class="">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-show">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">User Detail</h4>
            </div>
            <div class="modal-body" style="text-align: center;">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="text-align: center;">Name</th>
                            <th style="text-align: center;">Username</th>
                            <th style="text-align: center;">Email</th>  
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td id="user_name"></td>
                            <td id="user_username"></td>
                            <td id="user_email"></td>
                        </tr>
                    </tbody>
                </table>
            </div> 
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-edit">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action=""​ id="user_form_edit" method="POST" role="form">
                {{ csrf_field() }}

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Edit User</h4>
                </div>
                <div class="modal-body">
                    <div id="user-error-edit">

                    </div>
                    <div class="form-group">
                        <label for="">Name</label>
                        <input name="name" type="text" class="form-control" id="user_edit_name" placeholder="Enter Name">
                    </div>
                    <div class="form-group">
                        <label for="">Username</label>
                        <input name="username" type="text" class="form-control" id="user_edit_username" placeholder="Enter Username">
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input name="email" type="email" class="form-control" id="user_edit_email" placeholder="Enter Email">
                    </div>
                    <div class="form-group">
                        <label for="">Password</label>
                        <input name="password" type="password" class="form-control" id="user_edit_password" placeholder="Enter Password">
                    </div>
                    <div class="form-group">
                        <label for="">Password-Confirm</label>
                        <input name="password_confirmation" type="password" class="form-control" id="user_edit_password_confirm" placeholder="Enter Password Confirm">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Edit</button>

                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // $('#table_id').DataTable();
    $(document).ready( function () {
     $('#user_table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "{{ route('user.getdata') }}",
        "columns":[
        { "data": "id" },
        { "data": "name" },
        { "data": "username" },
        { "data": "email" },
        { "data": "action", orderable:false, searchable: false}
        ]
    });
     $('#user_add').submit(function(event) {
        event.preventDefault();
        var url=$(this).attr('data-url');
        console.log(url);
        $.ajax({
            url: url,
            type: 'POST',
            data: $(this).serializeArray(),
            success: function(response){
                console.log(response);
                if(typeof response.errors != 'undefined'){
                    var alert = "";
                    for(var i=0;i<response.errors.length;i++){
                       alert += '<div class="err alert alert-danger">'+response.errors[i]+'</div>';
                   }
                   $('#user-error-add').html(alert);
                   setTimeout(function () {
                    $('.err').remove();
                },5000);
               }else{
                console.log('thanhcong');
                $('#user_add_name').val('');
                $('#user_add_username').val(''),
                $('#user_add_email').val(''),
                $('#user_add_password').val(''),
                $('#user_add_password_confirm').val('') 
                $('#add').modal('hide');
                toastr.success('Thêm mới thành công');
                $('#user_table').DataTable().ajax.reload();
            }
        },
    });
    });
     $("#user_table").on('click','.btn-delete',function(){
        var id = $(this).attr('data-id');
        if(confirm("Bạn có muốn xóa không ?"))
        {
            $.ajax({
                url:"{{route('user.destroy')}}",
                mehtod:"get",
                data:{id:id},
                success:function(data)
                {
                    toastr.success('Xóa thành công');
                    $('#user_table').DataTable().ajax.reload();
                }
            })
        }
        else
        {
            return false;
        }
    });
     $("#user_table").on('click', '.btn-show', function() {
        event.preventDefault();
        $('#modal-show').modal('show');
        /* Act on the event */
        var id = $(this).attr('data-id');
        $.ajax({
            url:"{{route('user.show')}}",
            type: 'GET',
            data:{id:id},
            dataType:'json',
            success: function(response){
                console.log(response);
                $("#user_name").html(response.name);
                $("#user_username").html(response.username);
                $("#user_email").html(response.email);
            },
        })
    });
        //bắt sự kiện click vào nút edit
        $("#user_table").on('click', '.btn-edit', function(e) {
        //mở modal edit lên
        $('#modal-edit').modal('show');
        e.preventDefault();
        var id = $(this).attr("data-id");
        console.log(id);
        $.ajax({
            url:"{{route('user.edit')}}",
            method:'get',
            data:{id:id},
            dataType:'json',
            success: function (response) {
                console.log(response);
                $('#user_edit_name').val(response.name);
                $('#user_edit_username').val(response.username),
                $('#user_edit_email').val(response.email),
                $('#user_form_edit').attr('data-url','{{ asset('admin/user/') }}/'+response.id)
            },
        })
    })
      //bắt sự kiện submit form edit
      $('#user_form_edit').submit(function (e) {
        e.preventDefault();
        //lấy data-url của form edit
        var url=$(this).attr('data-url');
        $.ajax({
          //phương thức put
          type: 'put',
          url: url,
          //lấy dữ liệu trong form
          data: $(this).serializeArray(),
          success: function (response) {
            if(typeof response.errors != 'undefined'){
                var alert = "";
                for(var i=0;i<response.errors.length;i++){
                   alert += '<div class="err alert alert-danger">'+response.errors[i]+'</div>';
               }
               $('#user-error-edit').html(alert);
               setTimeout(function () {
                $('.err').remove();
            },5000);
           }else{
            //thông báo update thành công
            toastr.success('edit success!')
                //ẩn modal edit
                $('#modal-edit').modal('hide');
                $('#user_table').DataTable().ajax.reload();
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            //xử lý lỗi tại đây
        }
    })
    })    

  } );

</script>
@endsection