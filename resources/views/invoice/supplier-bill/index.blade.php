@extends('layouts.master')

@section('styles')
<!--Bootsrap Data Table-->
<link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">

<style>
    #table-data > tbody > tr{
        cursor:pointer;
    }
</style>

@append

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Bon Obat
    </h1>
</section>

<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box box-solid">
        <div class="box-body">
            <a class="btn btn-primary btn-sm" id="btn-add" href="invoice/supplier-bill/create" >Create</a>
            <a class="btn btn-danger btn-sm hide" id="btn-delete" href="#" >Delete</a>
            <div class="clearfix" ></div>
            <br/>

            <?php $rownum=1; ?>
            <table class="table table-bordered table-condensed table-striped table-hover" id="table-data" >
                <thead>
                    <tr>
                        <th style="width:25px;">
                            <input type="checkbox" name="ck_all" style="margin-left:15px;padding:0;" >
                        </th>
                        <th style="width:25px;" >No</th>
                        <th>Ref#</th>
                        <th>Tanggal</th>
                        <th>Supplier</th>
                        <th>No. Nota Supplier</th>
                        <th>Tanggal Jatuh Tempo</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        {{-- <th>Deskripsi</th> --}}
                        <th class="col-sm-1 col-md-1 col-lg-1" ></th>
                    </tr>
                </thead>
                <tbody>
                  <?php $rownum=1; ?>
                  @foreach ($data as $dt)
                    <tr>
                      <td class="text-center" >
                        <input type="checkbox" class="ck-row"/>
                      </td>
                      <td>
                        {{$rownum++}}
                      </td>
                      <td>
                        {{$dt->bill_number}}
                      </td>
                      <td>
                        {{$dt->order_date_formatted}}
                      </td>
                      <td>
                        {{$dt->nama_supplier}}
                      </td>
                      <td>
                        {{$dt->no_nota_supplier}}
                      </td>
                      <td>
                        {{$dt->due_date_formatted}}
                      </td>
                      <td class="uang text-right" >
                        {{$dt->total}}
                      </td>
                      <td>
                        @if($dt->status == 'O')
                          Open
                        @else
                          Paid
                        @endif
                      </td>
                      <td class="text-center">
                        <a class="btn btn-success btn-xs" href="invoice/supplier-bill/edit/{{$dt->id}}" ><i class="fa fa-edit" ></i></a>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
            </table>
        </div><!-- /.box-body -->
    </div><!-- /.box -->

</section><!-- /.content -->

@stop

@section('scripts')
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="plugins/jqueryform/jquery.form.min.js" type="text/javascript"></script>
<script src="plugins/autonumeric/autoNumeric-min.js" type="text/javascript"></script>

<script type="text/javascript">
(function ($) {

    var TBL_KATEGORI = $('#table-data').DataTable({
        sort:false
    });

    // -----------------------------------------------------
      // SET AUTO NUMERIC
      // =====================================================
      $('.uang').autoNumeric('init',{
          vMin:'0',
          vMax:'9999999999'
      });
      $('.uang').each(function(){
        $(this).autoNumeric('set',$(this).autoNumeric('get'));
      });
      // END OF AUTONUMERIC

    // check all checkbox
    $('input[name=ck_all]').change(function(){
        if($(this).prop('checked')){
            $('input.ck_row').prop('checked',true);
        }else{
            $('input.ck_row').prop('checked',false);

        };
        showOptionButton();
    });

    // tampilkan btn delete
    $(document).on('change','.ck_row',function(){
        showOptionButton();
    });

    function showOptionButton(){
        var checkedCk = $('input.ck_row:checked');

        if(checkedCk.length > 0){
            // tampilkan option button
            $('#btn-delete').removeClass('hide');
        }else{
            $('#btn-delete').addClass('hide');
        }
    }

    // Row Clicked
    $(document).on('click','.row-to-edit',function(){
        var row = $(this).parent();
        var data_id = row.data('id');
        location.href = 'invoice/supplier-bill/edit/' + data_id ;
    });

    // Delete Data Lokasi
    $('#btn-delete').click(function(e){
        if(confirm('Anda akan menhapus data ini?')){
            var dataid = [];
            $('input.ck_row:checked').each(function(i){
                var data_id = $(this).parent().parent().data('id');
                // alert(data_id);
                var newdata = {"id":data_id}
                dataid.push(newdata);
            });

            var deleteForm = $('<form>').attr('method','POST').attr('action','invoice/supplier-bill/delete');
            deleteForm.append($('<input>').attr('type','hidden').attr('name','dataid').attr('value',JSON.stringify(dataid)));
            deleteForm.submit();
        }

        e.preventDefault();
        return false;
    });



})(jQuery);
</script>
@append
