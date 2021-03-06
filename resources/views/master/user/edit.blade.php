@extends('layouts.master')

@section('styles')
<style>
    .col-top-item{
        cursor:pointer;
        border: thin solid #CCCCCC;

    }
    .table-top-item > tbody > tr > td{
        border-top-color: #CCCCCC;
    }
</style>
@append

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <a href="master/user" >User</a>
        <i class="fa fa-angle-double-right" ></i> {{$data->username}}
    </h1>
</section>

<!-- Main content -->
<section class="content">
  {{-- <form method="POST" action="master/user/insert" > --}}
    <div class="box box-solid" >
      <div class="box-body" >
        <input type="hidden" name="user_id" value="{{$data->id}}"/>
        <table class="table table-bordered table-condensed" >
            <tbody>
                <tr>
                    <td class="col-lg-2 col-md-2 col-sm-2" >
                        <label>Username</label>
                    </td>
                    <td>
                        <input type="text" name="nama" class="form-control" required autofocus autocomplete="off" value="{{$data->username}}" readonly >
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 col-md-2 col-sm-2" >
                        <label>Role</label>
                    </td>
                    <td>
                        <select class="form-control" >
                          <option {{$data->role_id == 1 ? 'checked':''}} value="1">Administrator</option>
                          <option {{$data->role_id == 2 ? 'checked':''}} value="2">Owner</option>
                          <option {{$data->role_id == 3 ? 'checked':''}} value="3">Operator</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 col-md-2 col-sm-2" >
                        <label>Password</label>
                    </td>
                    <td>
                        <input type="password" name="password" class="form-control" required autofocus autocomplete="off" placeholder="Input to change password" >
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <button type="submit" class="btn btn-primary" id="btn-save" >Save</button>
                        <a class="btn btn-danger" href="master/user" >Cancel</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
  {{-- </form> --}}
</section><!-- /.content -->

@stop

@section('scripts')
<script src="plugins/jqueryform/jquery.form.min.js" type="text/javascript"></script>
<script src="plugins/autocomplete/jquery.autocomplete.min.js" type="text/javascript"></script>
<script type="text/javascript">
(function ($) {

    // SAVE LOKASI GALIAN

    $('#btn-save').click(function(){
        // cek kelengkapan data
        var nama = $('input[name=nama]').val();
        var kode = $('input[name=kode]').val();


        if(nama != "" ){
            var formdata = $('<form>').attr('method','POST').attr('action','master/user/insert');
            formdata.append($('<input>').attr('type','hidden').attr('name','kode').val(kode));
            formdata.append($('<input>').attr('type','hidden').attr('name','nama').val(nama));
            formdata.submit();
        }else{
            alert('Lengkapi data yang kosong.');
        }
    });

    // END OF LOKASI GALIAN

// alert('pret');
})(jQuery);
</script>
@append
