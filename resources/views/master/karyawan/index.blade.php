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
        Karyawan
    </h1>
</section>

<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box box-solid">
        <div class="box-body">
            <a class="btn btn-primary btn-sm" id="btn-add" href="master/karyawan/create" >Create</a>
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
                        <th style="width:25px;">No</th>
                        <th class="col-sm-2 col-md-2 col-lg-2" >NIK</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Telepon</th>
                        <th class="col-sm-1 col-md-1 col-lg-1" ></th>
                    </tr>
                </thead>
                <tbody>
                  <?php $rownum=1; ?>
                  @foreach ($data as $dt)
                    <tr>
                      <td class="text-center" >
                        {{-- @if ($dt->karyawanname != 'admin') --}}
                          <input type="checkbox" class="ck-row"/>
                        {{-- @endif --}}
                      </td>
                      <td>
                        {{$rownum++}}
                      </td>
                      <td>
                        {{$dt->nik}}
                      </td>
                      <td>
                        {{$dt->nama}}
                      </td>
                      <td>
                        {{$dt->alamat}}
                      </td>
                      <td>
                        {{$dt->telepon}}
                      </td>
                      <td>
                        <a class="btn btn-success btn-xs" href="master/karyawan/edit/{{$dt->id}}" ><i class="fa fa-edit" ></i></a>
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

<script type="text/javascript">
(function ($) {

    var TBL_KATEGORI = $('#table-data').DataTable({
        sort:false
    });

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
        location.href = 'master/karyawan/edit/' + data_id ;
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

            var deleteForm = $('<form>').attr('method','POST').attr('action','master/karyawan/delete');
            deleteForm.append($('<input>').attr('type','hidden').attr('name','dataid').attr('value',JSON.stringify(dataid)));
            deleteForm.submit();
        }

        e.preventDefault();
        return false;
    });



})(jQuery);
</script>
@append
