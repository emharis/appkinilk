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
        <a href="master/material" >Data Material</a> 
        <i class="fa fa-angle-double-right" ></i> 
        Edit
    </h1>
</section>

<!-- Main content -->
<section class="content">
  {{-- <form method="POST" action="master/material/insert" > --}}
    <div class="box box-solid" >
      <div class="box-body" >
        <table class="table table-bordered table-condensed" >
             <tbody>
                <tr>
                    <td class="col-lg-2 col-md-2 col-sm-2" >
                        <label>Nama</label>
                    </td>
                    <td>
                        <input type="text" name="nama" class="form-control" required autofocus autocomplete="off" value="{{$data->nama}}" >
                        <input type="hidden" name="id" value="{{$data->id}}" >
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 col-md-2 col-sm-2" >
                        <label>Kode</label>
                    </td>
                    <td>
                        <input type="text" name="kode" class="form-control" required autocomplete="off" value="{{$data->kode}}" >
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <button type="submit" class="btn btn-primary" id="btn-save" >Save</button>
                        <a class="btn btn-danger" href="master/material" >Cancel</a>
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
        var id = $('input[name=id]').val();
        var nama = $('input[name=nama]').val();
        var kode = $('input[name=kode]').val();

        if(nama != ""  ){
            var formdata = $('<form>').attr('method','POST').attr('action','master/material/update');
            formdata.append($('<input>').attr('type','hidden').attr('name','id').val(id));
            formdata.append($('<input>').attr('type','hidden').attr('name','nama').val(nama));
            formdata.append($('<input>').attr('type','hidden').attr('name','kode').val(kode));
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