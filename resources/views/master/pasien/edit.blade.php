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
        <a href="master/pasien" >Pasien</a>
        <i class="fa fa-angle-double-right" ></i> Create
    </h1>
</section>

<!-- Main content -->
<section class="content">
  {{-- <form method="POST" action="master/pasien/insert" > --}}
    <div class="box box-solid" >
      <div class="box-body" >
        <form method="POST" action="master/pasien/update" >
          <input type="hidden" name="pasien_id" value="{{$data->id}}"/>
          <table class="table table-bordered table-condensed" >
            <tbody>
                <tr>
                    <td class="col-lg-2 col-md-2 col-sm-2" >
                        <label>Nama</label>
                    </td>
                    <td colspan="3" >
                        <input type="text" name="nama" class="form-control" required autofocus autocomplete="off" value="{{$data->nama}}" >
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 col-md-2 col-sm-2" >
                        <label>Jenis Kelamin</label>
                    </td>
                    <td colspan="3" >
                        <select class="form-control" name="jenis_kelamin">
                          <option {{$data->jenis_kelamin == 'L' ? 'selected':''}} value="L">Laki-laki</option>
                          <option {{$data->jenis_kelamin == 'P' ? 'selected' :''}} value="P">Perempuan</option>
                        </select>
                    </td>
                </tr>
                <tr>
                  <td>
                    <label>Tempat/Tanggal Lahir</label>
                  </td>
                  <td>
                    <input type="text" name="tempat_lahir" class="form-control" value="{{$data->tempat_lahir}}"/>
                  </td>
                  <td colspan="2" >
                    <input type="text" name="tanggal_lahir" class="form-control input-date" value="{{$data->tanggal_lahir_formatted}}" />
                  </td>
                </tr>
                <tr>
                  <td>
                    <label>Nomor Identitas</label>
                  </td>
                  <td colspan="3">
                    <input type="text" name="ktp" class="form-control " value="{{$data->ktp}}"/>
                  </td>
                </tr>
                <tr>
                    <td class="col-lg-2 col-md-2 col-sm-2" >
                        <label>Alamat</label>
                    </td>
                    <td colspan="3">
                        <input type="text" name="alamat" class="form-control" autocomplete="off" value="{{$data->alamat}}" >
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 col-md-2 col-sm-2" >
                        <label>Desa</label>
                    </td>
                    <td >
                        <input type="text" name="desa" class="form-control" autocomplete="off" value="{{$data->desa}}" >
                    </td>
                    <td class="col-lg-2 col-md-2 col-sm-2" >
                        <label>Kecamatan</label>
                    </td>
                    <td >
                        <input type="text" name="kecamatan" class="form-control" autocomplete="off" value="{{$data->kecamatan}}" >
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 col-md-2 col-sm-2" >
                        <label>Kabupaten</label>
                    </td>
                    <td >
                        <input type="text" name="kabupaten" class="form-control" autocomplete="off" value="{{$data->kabupaten}}" >
                    </td>
                    <td class="col-lg-2 col-md-2 col-sm-2" >
                        <label>Provinsi</label>
                    </td>
                    <td >
                        <input type="text" name="provinsi" class="form-control" autocomplete="off" value="{{$data->provinsi}}" >
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 col-md-2 col-sm-2" >
                        <label>Umum/BPJS</label>
                    </td>
                    <td >
                        <select name="is_bpjs" class="form-control" >
                          <option {{$data->is_bpjs == 'N' ? 'selected':''}} value="U" >Umum</option>
                          <option {{$data->is_bpjs == 'Y' ? 'selected' : ''}} value="B" >BPJS</option>
                        </select>
                    </td>
                    <td class="col-lg-2 col-md-2 col-sm-2" >
                        <label>Nomor BPJS</label>
                    </td>
                    <td >
                        <input type="text" name="no_bpjs" class="form-control" autocomplete="off" readonly value="{{$data->is_bpjs == 'Y' ? $data->no_bpjs : ''}}" >
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 col-md-2 col-sm-2" >
                        <label>Pekerjaan</label>
                    </td>
                    <td colspan="3">
                        <input type="text" name="pekerjaan" class="form-control" autocomplete="off" value="{{$data->pekerjaan}}" >
                    </td>
                </tr>

                <tr>
                    <td class="col-lg-2 col-md-2 col-sm-2" >
                        <label>Telepon</label>
                    </td>
                    <td colspan="3">
                        <input type="text" name="telepon" class="form-control" autocomplete="off" value="{{$data->telepon}}" >
                    </td>
                </tr>

                <tr>
                    <td></td>
                    <td colspan="3">
                        <button type="submit" class="btn btn-primary" id="btn-save" >Save</button>
                        <a class="btn btn-danger" href="master/pasien" >Cancel</a>
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
  // $('select').val([]);

  // SET DATEPICKER
    $('.input-date').datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        autoclose: true
    });
    // END OF SET DATEPICKER

    // SELECT BPJS
    $('select[name=is_bpjs]').change(function(){
      if($(this).val() == 'B'){
          // $('#row-no-bpjs').removeClass('hide');
          // $('#row-no-bpjs').fadeIn(250);
          $('input[name=no_bpjs]').val('');
          $('input[name=no_bpjs]').removeAttr('readonly');
      }else{
        $('input[name=no_bpjs]').attr('readonly','readonly');
      }

    });

// alert('pret');
})(jQuery);
</script>
@append
