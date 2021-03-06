@extends('layouts.master')

@section('styles')
  <link href="plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css"/>
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
        <a href="master/karyawan" >Karyawan</a>
        <i class="fa fa-angle-double-right" ></i> Create
    </h1>
</section>

<!-- Main content -->
<section class="content">
  {{-- <form method="POST" action="master/karyawan/insert" > --}}
    <div class="box box-solid" >
      <div class="box-body" >
        <form method="POST" action="master/karyawan/insert" >
          <table class="table table-bordered table-condensed" >
            <tbody>
                <tr>
                    <td class="col-lg-2 col-md-2 col-sm-2" >
                        <label>Nama</label>
                    </td>
                    <td>
                        <input type="text" name="nama" class="form-control" required autofocus autocomplete="off" >
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 col-md-2 col-sm-2" >
                        <label>NIK</label>
                    </td>
                    <td>
                        <input type="text" name="nik" class="form-control" autocomplete="off" >
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 col-md-2 col-sm-2" >
                        <label>Jenis Kelamin</label>
                    </td>
                    <td>
                        <select class="form-control" name="jenis_kelamin">
                          <option value="L">Laki-laki</option>
                          <option value="P">Perempuan</option>
                        </select>
                    </td>
                </tr>
                <tr>
                  <td>
                    <label>Tempat Lahir</label>
                  </td>
                  <td>
                    <input type="text" name="tempat_lahir" class="form-control"/>
                  </td>
                </tr>
                <tr>
                  <td>
                    <label>Tanggal Lahir</label>
                  </td>
                  <td>
                    <input type="text" name="tanggal_lahir" class="form-control input-date"/>
                  </td>
                </tr>
                <tr>
                    <td class="col-lg-2 col-md-2 col-sm-2" >
                        <label>Alamat</label>
                    </td>
                    <td>
                        <input type="text" name="alamat" class="form-control" autocomplete="off" >
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 col-md-2 col-sm-2" >
                        <label>Telepon</label>
                    </td>
                    <td>
                        <input type="text" name="telepon" class="form-control" autocomplete="off" >
                    </td>
                </tr>

                <tr>
                    <td></td>
                    <td>
                        <button type="submit" class="btn btn-primary" id="btn-save" >Save</button>
                        <a class="btn btn-danger" href="master/karyawan" >Cancel</a>
                    </td>
                </tr>
            </tbody>
        </table>
      </form>
    </div>
  {{-- </form> --}}
</section><!-- /.content -->

@stop

@section('scripts')
<script src="plugins/jqueryform/jquery.form.min.js" type="text/javascript"></script>
<script src="plugins/autocomplete/jquery.autocomplete.min.js" type="text/javascript"></script>
<script src="plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
<script type="text/javascript">
(function ($) {

  // clear select
  $('select').val([]);

  // SET DATEPICKER
    $('.input-date').datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        autoclose: true
    });
    // END OF SET DATEPICKER

// alert('pret');
})(jQuery);
</script>
@append
