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
        <a href="inventory/mutasi" >Mutasi</a>
        <i class="fa fa-angle-double-right" ></i> {{$mutasi->nomor_mutasi}}
    </h1>
</section>

<!-- Main content -->
<section class="content">
  {{-- <form method="POST" action="inventory/mutasi/insert" > --}}
    <div class="box box-solid" >
      <div class="box-header with-border" style="padding-top:5px;padding-bottom:5px;" >
          <label><h3 style="margin:0;padding:0;font-weight:bold;" >{{$mutasi->nomor_mutasi}}</h3></label>

          <label class="pull-right" >&nbsp;&nbsp;&nbsp;</label>
          <a class="btn btn-arrow-right pull-right disabled bg-blue" >Posted</a>

          <label class="pull-right" >&nbsp;&nbsp;&nbsp;</label>
          <a class="btn btn-arrow-right pull-right disabled bg-gray" >Draft</a>
      </div>
      <div class="box-body" >
        {{-- <form method="POST" action="inventory/mutasi/insert" > --}}
          <table class="table table-condensed" >
            <tbody>
                <tr>
                    <td class="col-lg-2 col-md-2 col-sm-2" >
                        <label>Tanggal</label>
                    </td>
                    <td>
                        <input type="text" name="tanggal" class="input-tanggal form-control" value="{{$mutasi->tanggal_formatted}}" readonly autocomplete="off" >
                    </td>
                    <td>
                      <label>Paraf</label>
                    </td>
                    <td>
                      <input type="text" readonly name="paraf" class="form-control" data-userid="{{\Auth::user()->id}}" value="{{\Auth::user()->username}}"/>
                    </td>
                </tr>
                <tr>
                  <td>
                    <label>Jenis</label>
                  </td>
                  <td>
                    {{-- <select name="jenis" class="form-control" >
                      <option value="I">Mutasi Masuk</option>
                      <option value="O">Mutasi Keluar</option>
                    </select> --}}
                    @if($mutasi->in_out == 'I')
                      <input type="text" readonly class="form-control" value="Mutasi Masuk"/>
                    @else
                      <input type="text" readonly class="form-control" value="Mutasi Keluar"/>
                    @endif
                  </td>
                  <td></td>
                  <td></td>
                </tr>

            </tbody>
        </table>

        <h4 class="page-header" style="font-size:14px;color:#3C8DBC"><strong>DATA OBAT</strong></h4>

        <table class="table table-bordered table-condensed" id="table-obat" >
          <thead>
            <tr>
              <th>NAMA</th>
              <th class="col-sm-2 col-md-2 col-lg-2" >JUMLAH</th>
              <th class="col-sm-2 col-md-2 col-lg-2" >SATUAN</th>
            </tr>
          </thead>
          <tbody>
            @foreach($mutasi_detail as $dt)
              <tr>
                <td>
                  {{$dt->obat}}
                </td>
                <td class="text-right" >
                  {{$dt->jumlah}}
                </td>
                <td>
                  {{$dt->satuan}}
                </td>
              </tr>
            @endforeach
            {{-- <tr id="row-for-add" >
              <td colspan="5" >
                <a id="btn-add-obat" href="#" >Add Obat</a>
              </td>
            </tr> --}}
          </tbody>
        </table>
      {{-- </form> --}}
    </div>
    <div class="box-footer" >
      {{-- <button type="submit" class="btn btn-primary" id="btn-save" >Save</button> --}}
      <a class="btn btn-danger" href="inventory/mutasi" >Close</a>
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

  var table_obat = $('#table-obat');

  // SET DATEPICKER
  $('.input-tanggal').datepicker({
      format: 'dd-mm-yyyy',
      todayHighlight: true,
      autoclose: true
  });
  // END OF SET DATEPICKER

  // ADD OBAT
  $('#btn-add-obat').click(function(){
    // create new row
    // var newrow='<tr data-obatid="" ><td><input type="text" name="input-nama-obat" class="form-control input-nama-obat" /></td><td><input type="number" class="form-control" name="input-jumlah" min="1" /></td><td class="label-satuan" ></td> <td class="text-center" > <a class="btn-remove-row-obat" href="#" ><i class="fa fa-trash-o" ></i></a> </td> </tr>';

    var newrow = $('<tr>').addClass('row-obat');
    newrow.append($('<td>').append($('<input>').attr('type','text').attr('name','input-nama-obat').addClass('form-control input-nama-obat')));
    newrow.append($('<td>').append($('<input>').attr('type','number').attr('min','1').attr('name','input-jumlah').addClass('form-control input-jumlah text-right ')));
    newrow.append($('<td>').addClass('label-satuan'));
    newrow.append($('<td>').addClass('text-center').append($('<a>').addClass('btn-remove-obat-on-row').attr('href','#').append($('<i>').addClass('fa fa-lg fa-trash-o'))));

    $('#row-for-add').before(newrow);

    var input_obat = newrow.children('td:first').children('input');
    var input_jumlah = newrow.children('td:first').next().children('input');
    var label_satuan = newrow.children('td:first').next().next();
    input_obat.focus();

    // SET AUTOCOMPLETE NAMA OBAT
    input_obat.autocomplete({
          serviceUrl: 'api/get-auto-complete-obat',
          params: {
                      'nama': function() {
                          return input_obat.val();
                      }
                  },
          onSelect:function(suggestions){
              // set satuan
              label_satuan.text(suggestions.satuan);
              // set obat id
              input_obat.attr('data-obatid',suggestions.data);
              // disable input
              input_obat.attr('readonly','readonly');
              // focuskan ke input_jumlah
              input_jumlah.focus();
          }

      });
    // SET AUTOCOMPLETE NAMA OBAT

    return false;
  });
  // END OF ADD OBAT

  // REMOVE OBAT FROM ROW
  $(document).on('click','.btn-remove-obat-on-row',function(){
      var the_row = $(this).parent().parent();
      the_row.fadeOut(250,null,function(){
        the_row.remove();
      });

    return false;
  });
  // END OF REMOVE OBAT FROM ROW

  // SAVE MUTASI
  $('#btn-save').click(function(){
    var mutasi = {"tanggal":"","jenis":"","paraf":""};
    mutasi.tanggal = $('input[name=tanggal]').val();
    mutasi.jenis = $('select[name=jenis]').val();
    mutasi.paraf = $('input[name=paraf]').data('userid');

    var mutasi_detail = JSON.parse('{"obat" : [] }');
    $('.row-obat').each(function(){
      mutasi_detail.obat.push({
        'obat_id' : $(this).children('td:first').children('input').data('obatid'),
        'jumlah' : $(this).children('td:first').next().children('input').val()
      });
    });

    // alert(JSON.stringify(mutasi));
    // alert(JSON.stringify(mutasi_detail));

    var newform = $('<form>').attr('method','POST').attr('action','inventory/mutasi/insert');
    newform.append($('<input>').attr('type','hidden').attr('name','mutasi').val(JSON.stringify(mutasi)));
    newform.append($('<input>').attr('type','hidden').attr('name','mutasi_detail').val(JSON.stringify(mutasi_detail)));
    newform.submit();

  });
  // END OF SAVE MUTASI


// alert('pret');
})(jQuery);
</script>
@append
