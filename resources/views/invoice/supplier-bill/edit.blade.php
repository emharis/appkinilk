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
        <a href="invoice/supplier-bill" >Bon Obat</a>
        <i class="fa fa-angle-double-right" ></i> {{$bill->bill_number}}
    </h1>
</section>

<!-- Main content -->
<section class="content">
  {{-- <form method="POST" action="invoice/supplier-bill/insert" > --}}
    <div class="box box-solid" >
      <div class="box-header with-border" style="padding-top:5px;padding-bottom:5px;" >
          <label><h3 style="margin:0;padding:0;font-weight:bold;" >{{$bill->bill_number}}</h3></label>

          <label class="pull-right" >&nbsp;&nbsp;&nbsp;</label>
          <a class="btn btn-arrow-right pull-right disabled bg-gray" >Paid</a>

          <label class="pull-right" >&nbsp;&nbsp;&nbsp;</label>
          <a class="btn btn-arrow-right pull-right disabled bg-blue" >Open</a>

          <label class="pull-right" >&nbsp;&nbsp;&nbsp;</label>
          <a class="btn btn-arrow-right pull-right disabled bg-gray" >Draft</a>
      </div>
      <div class="box-body" >
        <form method="POST" action="invoice/supplier-bill/update" name="form-bill" >
          <input type="hidden" name="bill_id" value="{{$bill->id}}" />
          <table class="table table-condensed" >
            <tbody>
                <tr>
                    <td class="col-lg-2 col-md-2 col-sm-2" >
                        <label>Supplier</label>
                    </td>
                    <td>
                        <input type="text" name="supplier" class="form-control"  autofocus required autocomplete="off" value="{{$bill->nama_supplier}}" >
                        <input type="hidden" name="supplier_id"  value="{{$bill->supplier_id}}" >
                    </td>
                    <td>
                      <label>Nomor Nota Supplier</label>
                    </td>
                    <td>
                      <input type="text"  name="no_nota_supplier" class="form-control" value="{{$bill->no_nota_supplier}}" />
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 col-md-2 col-sm-2" >
                        <label>Tanggal Order</label>
                    </td>
                    <td>
                        <input type="text" name="tanggal_order" class="input-tanggal form-control" value="{{$bill->order_date_formatted}}" required autocomplete="off" >
                    </td>
                    <td>
                      <label>Jatuh Tempo</label>
                    </td>
                    <td>
                      <input type="text" name="jatuh_tempo" class="input-tanggal form-control" value="{{$bill->due_date_formatted}}" required autocomplete="off" >
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-2 col-md-2 col-sm-2" >
                        <label>Jumlah</label>
                    </td>
                    <td>
                        <input type="text" name="jumlah" class="uang text-right form-control" required autocomplete="off" value="{{$bill->total}}" required >
                    </td>
                    <td>
                      <label>Tanggal Pelunasan</label>
                    </td>
                    <td>
                      <input type="text" name="tanggal_lunas" class="input-tanggal form-control" value="{{$bill->paid_date_formatted}}" autocomplete="off" >
                    </td>
                </tr>
                <tr>
                    <td>
                      <label>Paraf</label>
                    </td>
                    <td>
                      <input type="text" readonly name="paraf" class="form-control" data-userid="{{$bill->user_id}}" value="{{$bill->username}}"/>
                      <input type="hidden" readonly name="user_id"  value="{{$bill->user_id}}"/>
                    </td>
                    <td></td>
                    <td></td>
                </tr>

            </tbody>
        </table>

        {{-- <h4 class="page-header" style="font-size:14px;color:#3C8DBC"><strong>DATA OBAT</strong></h4>

        <table class="table table-bordered table-condensed" id="table-obat" >
          <thead>
            <tr>
              <th>NAMA</th>
              <th class="col-sm-2 col-md-2 col-lg-2" >JUMLAH</th>
              <th class="col-sm-2 col-md-2 col-lg-2" >SATUAN</th>
              <th class="col-sm-1 col-md-1 col-lg-1" ></th>
            </tr>
          </thead>
          <tbody>
            <tr id="row-for-add" >
              <td colspan="5" >
                <a id="btn-add-obat" href="#" >Add Obat</a>
              </td>
            </tr>
          </tbody>
        </table> --}}
      {{-- </form> --}}
    </div>
    <div class="box-footer" >
      <button type="submit" class="btn btn-primary" id="btn-save" >Save</button>
      <button class="btn btn-success" id="btn-set-as-paid">Set as paid</button>
      <a class="btn btn-danger" href="invoice/supplier-bill" >Close</a>
    </div>
  </form>
</section><!-- /.content -->

@stop

@section('scripts')
<script src="plugins/jqueryform/jquery.form.min.js" type="text/javascript"></script>
<script src="plugins/autocomplete/jquery.autocomplete.min.js" type="text/javascript"></script>
<script src="plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
<script src="plugins/autonumeric/autoNumeric-min.js" type="text/javascript"></script>
<script type="text/javascript">
(function ($) {

  var table_obat = $('#table-obat');

  // SET DATEPICKER
  $('.input-tanggal').datepicker({
      format: 'dd-mm-yyyy',
      todayHighlight: true,
      autoclose: true
  });
  // END OF SET DATEPICKER

  // -----------------------------------------------------
    // SET AUTO NUMERIC
    // =====================================================
    $('.uang').autoNumeric('init',{
        vMin:'0',
        vMax:'9999999999'
    });
    // END OF AUTONUMERIC

    // SET AUTOCOMPLETE SUPPLIER
    $('input[name=supplier]').autocomplete({
          serviceUrl: 'api/get-auto-complete-supplier',
          params: {
                      'nama': function() {
                          return $('input[name=supplier]').val();
                      }
                  },
          onSelect:function(suggestions){
              // // set satuan
              // label_satuan.text(suggestions.satuan);
              // // set obat id
              // input_obat.attr('data-obatid',suggestions.data);
              // // disable input
              // input_obat.attr('readonly','readonly');
              // // focuskan ke input_jumlah
              // input_jumlah.focus();
              $('input[name=supplier_id]').val(suggestions.data);
              // disable input
              $('input[name=supplier]').attr('readonly','readonly');
          }

      });
    // END SET AUTOCOMPLETE SUPPLIER

    $('#btn-set-as-paid').click(function(){
      var formbill = $('form[name=form-bill]');
      formbill.attr('action','invoice/supplier-bill/set-as-paid');
      formbill.submit();
    });


// alert('pret');
})(jQuery);
</script>
@append
