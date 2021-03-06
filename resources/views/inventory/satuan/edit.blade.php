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
        <a href="inventory/satuan" >Satuan</a>
        <i class="fa fa-angle-double-right" ></i> {{$data->nama}}
    </h1>
</section>

<!-- Main content -->
<section class="content">
  {{-- <form method="POST" action="inventory/satuan/insert" > --}}
    <div class="box box-solid" >
      <div class="box-body" >
        <form method="POST" action="inventory/satuan/update" >
          <input type="hidden" name="satuan_id" value="{{$data->id}}"/>
          <table class="table table-bordered table-condensed" >
            <tbody>
                <tr>
                    <td class="col-lg-2 col-md-2 col-sm-2" >
                        <label>Nama</label>
                    </td>
                    <td>
                        <input type="text" name="nama" class="form-control" required autofocus autocomplete="off" value="{{$data->nama}}" >
                    </td>
                </tr>

                {{-- <tr>
                    <td class="col-lg-2 col-md-2 col-sm-2" >
                        <label>Deskripsi</label>
                    </td>
                    <td>
                        <input type="text" name="desc" class="form-control"  autofocus autocomplete="off" value="{{$data->desc}}" >
                    </td>
                </tr> --}}
                <tr>
                    <td></td>
                    <td>
                        <button type="submit" class="btn btn-primary" id="btn-save" >Save</button>
                        <a class="btn btn-danger" href="inventory/satuan" >Cancel</a>
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
<script type="text/javascript">
(function ($) {



// alert('pret');
})(jQuery);
</script>
@append
