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
        <a href="inventory/obat" >Obat</a>
        <i class="fa fa-angle-double-right" ></i> {{$data->nama}}
    </h1>
</section>

<!-- Main content -->
<section class="content">

  <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#tab_1" data-toggle="tab">Data Master</a></li>
                  <li><a href="#tab_2" data-toggle="tab">Kartu Stok</a></li>

                </ul>
                <div class="tab-content">
                  <div class="tab-pane active" id="tab_1">
                    <form method="POST" action="inventory/obat/update" >
                      <input type="hidden" name="obat_id" value="{{$data->id}}"/>
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

                            <tr>
                                <td class="col-lg-2 col-md-2 col-sm-2" >
                                    <label>Satuan</label>
                                </td>
                                <td>
                                    {!! Form::select('satuan_kecil',$select_satuan,$data->satuan_kecil_id,['class'=>'form-control']) !!}
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <button type="submit" class="btn btn-primary" id="btn-save" >Save</button>
                                    <a class="btn btn-danger" href="inventory/obat" >Close</a>
                                </td>
                            </tr>
                        </tbody>
                      </table>
                    </form>
                  </div><!-- /.tab-pane -->
                  <div class="tab-pane" id="tab_2">
                    <table class="table" >
                      <tbody>
                        <tr>
                          <td>
                            <label>Nama</label>
                          </td>
                          <td>
                            <input type="text" readonly class = "form-control" value="{{$data->nama}}"/>
                          </td>
                          <td>
                            <label>Satuan</label>
                          </td>
                          <td>
                            <input type="text" readonly class = "form-control" value="{{$data->satuan_kecil_id != "" ? $select_satuan[$data->satuan_kecil_id] :''}}"/>
                          </td>
                        </tr>
                      </tbody>
                    </table>

                    <table class="table table-bordered table-condensed" >
                      <thead>
                        <tr>
                          <th class="col-sm-2 col-md-2 col-lg-2" >Tanggal</th>
                          <th>No. Mutasi</th>
                          <th>Paraf</th>
                          <th class="col-sm-1 col-md-1 col-lg-1">Masuk</th>
                          <th class="col-sm-1 col-md-1 col-lg-1">Keluar</th>
                          <th class="col-sm-1 col-md-1 col-lg-1" >Sisa</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $sisa_stok=0; ?>
                        @foreach($stok_moving as $dt)
                          @if($dt->in_out == 'I')
                            <?php $sisa_stok += $dt->jumlah; ?>
                          @else
                            <?php $sisa_stok -= $dt->jumlah; ?>
                          @endif

                          <tr>
                            <td>
                              {{$dt->tanggal_formatted}}
                            </td>
                            <td>
                              {{$dt->nomor_mutasi}}
                            </td>
                            <td>
                              {{$dt->username}}
                            </td>
                            <td class="text-right" >
                              @if($dt->in_out == 'I')
                                {{$dt->jumlah}}
                              @else
                                -
                              @endif
                            </td>
                            <td class="text-right" >
                              @if($dt->in_out == 'O')
                                {{$dt->jumlah}}
                              @else
                                -
                              @endif
                            </td>
                            <td class="text-right" >
                              {{$sisa_stok}}
                            </td>
                          </tr>

                        @endforeach

                      </tbody>
                    </table>
                  </div><!-- /.tab-pane -->

                </div><!-- /.tab-content -->
              </div>

  {{-- <form method="POST" action="inventory/obat/insert" > --}}

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
