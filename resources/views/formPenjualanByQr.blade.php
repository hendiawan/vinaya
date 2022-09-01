@extends('layouts.jnb.app')

@section('content')
<div id="main" class="clearfix">
    <div class="secInfo">
        <h1 class="secTitle">Form  Penjualan</h1>
        <span class="secExtra">Form  Penjualan Dari Setiap Member Nutrition Club</span>

    </div> <!-- /SecInfo -->
    <div class="fluid">				
        <div class="widget leftcontent grid12">
            <div class="topTabs">					
                <div id="topTabs-container-form">
                    <div class="topTabs-header clearfix">						
                        <ul class="etabs tabs">
                            <li class="tab">
                                <a href="#tab1" class="member">
                                    <span class="to-hide">
                                        <i class="fa fa-group"></i><br>Member
                                    </span>
                                    <i class="fa icon-hidden fa-tag" data-toggle="tooltip" data-placement="bottom" title="Member"></i>
                                </a>
                            </li>

                        </ul> <!-- /tabs -->
                    </div><!-- /topTabs-header -->
                    <div class="topTabsContent" style="padding-left:0;">
                        <!-- TAB PENAWARAN =========================================================================== -->
                        <div id="tab1">
                            <form id="form-penjualan" class="form-horizontal" method="POST" action="{{ url('/') }}/create-penjualan" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            <!--<input type="hidden"  name="_method" value="PUT">--> 
                            <br>
                            <div class="widget-header">
                                <h3 class="widget-title">DATA MEMBER</h3>
                            </div>
                    
                            <div class="widget-content pad20f">
                                <div class="form-group {{ $errors->has('nama_member') ? ' has-error' : '' }}">
                                    <label for="nama_member" class="col-sm-3 control-label">Nama Member <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <select disabled=""    id="member" name="nama_pelanggan" class="form-control">
                                            <option value="{{$data->id}}">{{$data->nama_pelanggan}}</option> 
                                       </select>
                                        <input hidden="" name="pelanggan_id" value="{{$data->id}}">
                                    </div>
                                </div>   
                                <div class="form-group {{ $errors->has('nama_member') ? ' has-error' : '' }}">
                                    <label for="jenis_paket" class="col-sm-3 control-label">Jenis Paket <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input  type="text" name="menu_id" value="{{ old('menu_id',$menu_id) }}" class="form-control hidden" id="menu_id"> 
                                        <input  type="text" name="paket_id" value="{{ old('paket_id',$paket_id) }}" class="form-control hidden" id="paket_id"> 
                                        <input readonly="" type="text" name="jenis_paket" value="{{ old('jenis_paket',$nama_menu) }}" class="form-control" id="jenis_paket"> 
                                    </div>
                                </div>   
                                <div class="form-group {{ $errors->has('harga') ? ' has-error' : '' }}">
                                    <label for="Harga" class="col-sm-3 control-label">Harga Paket<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input readonly="" type="text" name="harga" value="{{ old('harga',$harga_paket) }}" class="form-control numeric" id="harga"> 
                                    </div>
                                </div>  
                                <div class="form-group {{ $errors->has('total_bayar') ? ' has-error' : '' }}">
                                    <label for="total_bayar" class="col-sm-3 control-label">Total Bayar / Saldo Paket<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input readonly="" type="text" name="total_bayar" value="{{ old('total_bayar',$total_bayar) }}" class="form-control numeric" id="total_bayar"> 
                                    </div>
                                </div>  
                                <div class="form-group {{ $errors->has('nominal_penggunaan') ? ' has-error' : '' }}">
                                    <label for="nominal_penggunaan" class="col-sm-3 control-label">Nominal Penggunaan<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input readonly="" type="text" name="nominal_penggunaan" value="{{ old('nominal_penggunaan',$total_nominal_penggunaan) }}" class="form-control numeric" id="nominal_penggunaan"> 
                                    </div>
                                </div> 
                                <div class="form-group {{ $errors->has('status_bayar') ? ' has-error' : '' }}">
                                    <label for="status_bayar" class="col-sm-3 control-label">Status Bayar <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input readonly="" type="text" name="status_bayar" value="{{ old('status_bayar',$status_bayar) }}" class="form-control numeric" id="status_bayar"> 
                                    </div>
                                </div>  
                                <div class="form-group {{ $errors->has('qty_paket') ? ' has-error' : '' }}">
                                    <label for="qty_paket" class="col-sm-3 control-label">Jumlah Paket <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input readonly="" type="text" name="qty_paket" value="{{ old('qty_paket',$qty_paket) }}" class="form-control" id="qty_paket"> 
                                    </div>
                                </div>  
                                <div class="form-group {{ $errors->has('total_penggunaan') ? ' has-error' : '' }}">
                                    <label for="total_penggunaan" class="col-sm-3 control-label">Total Sudah Digunakan <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input readonly="" type="text" name="total_penggunaan" value="{{ old('total_penggunaan',$penggunaan_paket) }}" class="form-control" id="total_penggunaan"> 
                                    </div>
                                </div>    
                                <div class="form-group {{ $errors->has('sisa_paket') ? ' has-error' : '' }}">
                                    <label for="sisa_paket" class="col-sm-3 control-label">Sisa Paket <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input readonly="" type="text" name="sisa_paket" value="{{ old('sisa_paket',$sisa_paket) }}" class="form-control" id="sisa_paket"> 
                                    </div>
                                </div>    
                                     <div class="form-group {{ $errors->has('status_paket') ? ' has-error' : '' }}">
                                    <label for="status_paket" class="col-sm-3 control-label">Status Saldo Paket <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input readonly="" type="text" name="status_paket" value="{{ old('status_paket',$status_paket) }}" class="form-control" id="status_paket"> 
                                        @if($status_paket=='habis')
                                        <b id="error-status-paket" style="color: red">Paket sudah habis, proses tidak dapat dilanjutkan !!!</b>
                                        @endif
                                    </div>
                                </div>    
                                <div class="form-group {{ $errors->has('tgl_kadaluarsa') ? ' has-error' : '' }}">
                                    <label for="tgl_kadaluarsa" class="col-sm-3 control-label">Tgl Kadaluarsa <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input readonly="" type="text" name="tgl_kadaluarsa" value="{{ old('tgl_kadaluarsa',$tgl_kadaluarsa) }}" class="form-control" id="tgl_kadaluarsa"> 
                                    </div>
                                </div>    
                                <div class="form-group {{ $errors->has('status_kadaluarsa') ? ' has-error' : '' }}">
                                    <label  for="status_kadaluarsa" class="col-sm-3 control-label">Status Kadaluarsa <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input readonly="" type="text" name="status_kadaluarsa" value="{{ old('status_kadaluarsa',$status_kadaluarsa) }}" class="form-control" id="status_kadaluarsa"> 
                                        @if($status_kadaluarsa=='Kadaluarsa')
                                        <b id="error-status-kadaluarsa" style="color: red">Paket sudah kadaluarsa, proses tidak dapat dilanjutkan !!!</b>
                                        @endif
                                    </div>
                                </div>    
                            </div>
                         
                              <div class="divider"></div>			
                            <div class="widget-header">
                                <h3 class="widget-title">HISTORY PENGGUNAAN PAKET</h3>
                            </div>
                            <div class="widget-content pad20f">
                                  <table id="sp3kbg-datatable" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <td>
                                                   No
                                                </td> 
                                                <td>
                                                   Tanggal Transaksi
                                                </td>
                                                <td>
                                                  Id Pelanggan
                                                </td>
                                                <td>
                                                  Id Paket
                                                </td>
                                                <td>
                                                   Jumlah Penggunaan
                                                </td>
                                                <td>
                                                  Harga Pokok
                                                </td>
                                                <td>
                                                 Harga Jual
                                                </td>
                                            </tr>
                                        </thead>
                                       
                                         <tbody  id="tblpenjualan">    
                                             @if($history_penjualan!='0')
                                                @foreach ($history_penjualan as $data) 
                                                <tr>
                                                    <td>
                                                      {{$data->id}}
                                                   </td> 
                                                   <td>
                                                        {{$data->tgl_jual}}
                                                   </td>
                                                   <td>
                                                       {{$data->pelanggan_id}}
                                                   </td>
                                                   <td>
                                                     {{$data->paket_id}}
                                                   </td>
                                                   <td>
                                                        {{$data->qty_jual}}
                                                   </td>
                                                   <td>
                                                         {{number_format($data->harga_pokok,0,',','.')}}
                                                   </td>
                                                   <td>
                                                        {{number_format($data->harga_jual,0,',','.')}}
                                                   </td>
                                                   </tr>
                                                 @endforeach  
                                            @endif
                                        </tbody>
                                        <tbody id="tblShow">
                                            
                                        </tbody>
                                    </table> 
                            </div>	
                            
                            <div class="widget-header">
                                <h3 class="widget-title">DATA TRANSAKSI</h3>
                            </div>
                            <div class="widget-content pad20f">     
                                
                                <div id="body-pesan" hidden="" class="alert alert-danger">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <i class="fa fa-info-circle"></i> Peringatan <p id="pesan"></p>
                                </div>
                                
                                <div class="form-group {{ $errors->has('tgl_transaksi') ? ' has-error' : '' }} hidden">
                                    <label for="no_transaksi" class="col-sm-3 control-label">Nomor Transaksi<span class="text-danger">*</span></label>
                                    <div class="col-sm-9"> 
                                                <input readonly="" type="text" name="no_transaksi" value="{{ old('no_transaksi') }}" class="form-control" id="no_transaksi">
                                    </div> 
                                </div>  
                                <div class="form-group {{ $errors->has('tgl_transaksi') ? ' has-error' : '' }}">
                                    <label for="tgl_transaksi" class="col-sm-3 control-label">Tgl Edit <span class="text-danger">*</span></label>
                                    <div class="col-sm-4">
                                        <div class="input-group">
                                            <input readonly="" type="text" name="tgl_transaksi" value="<?php echo old('tgl_transaksi', date('d-m-Y')) ?>" class="form-control  clearClone tgl_transaksi " placeholder="dd-mm-yyyy">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>  
                                <div class="form-group">
                                    <label for="harga_pokok" class="col-sm-3 control-label">Harga Pokok</label>
                                    <div class="col-sm-9">
                                        <input readonly="" type="text" name="harga_pokok" value="{{ old('harga_pokok',$harga_pokok) }}" class="form-control numeric" id="harga_pokok">
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label for="harga_jual" class="col-sm-3 control-label">Harga Jual</label>
                                    <div class="col-sm-9">
                                        <input readonly="" type="text"  value="{{ old('harga_jual',$harga_jual) }}" class="form-control numeric" id="harga_jual">
                                        <input hidden="" type="text" name="harga_jual" value="{{ old('harga_jual',$harga_jual) }}"    >
                                    </div>
                                </div> 
                               <div class="form-group">
                                    <label for="jumlah" class="col-sm-3 control-label">Jumlah</label>
                                    <div class="col-sm-9">
                                        <input required="" type="text" name="jumlah" value="{{ old('jumlah') }}" class="form-control" id="jumlah">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="total_harga" class="col-sm-3 control-label">Total Harga</label>
                                    <div class="col-sm-9">
                                        <input readonly="" type="text" name="total_harga" value="{{ old('total_harga') }}" class="form-control numeric" id="total_harga">
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <a href="{{ url('/home') }}" class="btn btn-dark-grey"><i class="fa fa-undo"></i> KEMBALI</a>
                                    </div>
                                    <div class="col-sm-6 text-right">
                                        <!--<button  id="proses" type="submit" class="btn"><i class="fa fa-save"></i> PROSES</button>-->
                                         <button id="proses" type="button" class="btn"><i class="fa fa-check"></i>PROSES</button>

                                    </div>
                                </div>
                                
                                
                                <div class="modal fade remark-modal-md" role="dialog" aria-labelledby="mySmallModalLabel">
                                    <div class="modal-dialog modal-sm" role="document">
                                        <div class="panel panel-danger">
                                            <div class="panel-heading">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="panel-title" id="gridSystemModalLabel"><i class="fa fa-warning"></i> Peringatan</h4>
                                            </div>
                                            <div class="panel-body">
                                                Anda yakin data sudah lengkap?
                                            </div>
                                            <div class="panel-footer"> 

                                                <button type="button" class="btn btn-red" data-dismiss="modal"><i class="fa fa-close"></i> Tidak</button>
                                                <button id="btnSave" type="button" class="btn"><i class="fa fa-check"></i>Ya</button> 
                                            </div>
                                        </div>
                                    </div>
                                </div>     
                                
                            </div>
                                <div class="widget-header">
                                <h3 class="widget-title">DATA COACH</h3>
                            </div>

                            <div class="widget-content pad20f"> 
                                <div class="form-group {{ $errors->has('nama_member') ? ' has-error' : '' }}">
                                    <label for="nama_coach" class="col-sm-3 control-label">Nama Coach <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="sales_level" value="{{ old('sales_level',$sales_level) }}" class="form-control hidden" id="sales_level_m"> 
                                        <input type="text" name="sales_id" value="{{ old('sales_id',$data->sales->id) }}" class="form-control hidden" id="sales_id"> 
                                        <input type="text" name="iuran" value="{{ old('iuran',$data->sales->iuran) }}" class="form-control hidden" id="iuran"> 
                                        <input readonly="" type="text" name="nama_coach" value="{{ old('nama_coach',$data->sales->karyawan->nama_karyawan) }}" class="form-control" id="nama_coach"> 
                                    </div>
                                </div>    
                            </div>
                          
                            
                            <div class="divider"></div>			
                            <div class="widget-header">
                                <h3 class="widget-title">TABEL STOK COACH</h3>
                            </div>
                            <div class="widget-content pad20f">
                                <input hidden="" class="numeric"  value="{{old('stok_terkecil',$stok_terkecil)}}" id="stok_terkecil" name="stok_terkecil">
                                  <table id="sp3kbg-datatable" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <td>
                                                   No
                                                </td> 
                                                <td>
                                                   Nama Barang
                                                </td>
                                                <td>
                                                  Qty
                                                </td>
                                                <td>
                                                  Takaran
                                                </td>
                                                <td>
                                                  Kaleng
                                                </td>
                                                <td>
                                                  Porsi
                                                </td> 
                                            </tr>
                                        </thead>
                                        <tbody id="tblstok">  
                                            @if(count($stok)>0)
                                             @foreach ($stok as $datastok) 
                                                <tr>
                                                <td>
                                                  {{$datastok['barang_id']}}
                                                </td> 
                                                <td>
                                                    {{$datastok['nama_barang']}}
                                                </td>
                                                <td>
                                                     {{$datastok['stok']}}
                                                </td>
                                                <td>
                                                   {{$datastok['takaran']}}
                                                </td>
                                                <td>
                                                  {{$datastok['kaleng']}}
                                                </td>
                                                <td>
                                                   {{$datastok['porsi']}}
                                                </td> 
                                            </tr>
                                             @endforeach
                                             @endif
                                        </tbody>
                                        <tbody id="tblstokshow">
                                      
                                        </tbody>
                                    </table> 
                            </div>	 					
                        </form>
                        </div>
                        <div id="tab2"> 
                       
                        </div>
                        <div id="tab3"></div>
                        <div id="tab4"></div>
                        <div id="tab5"></div>
                        <div id="tab6"></div>
                        	
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- /fluid -->

</div> <!-- /main -->

@endsection

@push('scripts')    
<link rel="stylesheet" href="{{ asset('jnb/css/bootstrap-fileupload.css') }}" />
<link rel="stylesheet" href="{{ asset('jnb/css/bootstrap-datepicker3.min.css') }}" />
<link rel="stylesheet" href="{{ asset('jnb/css/select2-4.0.3.css') }}" />

<script type="text/javascript" src="{{ asset('jnb/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('jnb/js/bootstrap-fileupload.js') }}"></script>
<script type="text/javascript" src="{{ asset('jnb/js/select2.min.js') }}"></script>
<script type="text/javascript">
$(document).ready(function () { 
        
        cekstatus();
        
        function cekstatus()
        {
                             var  statusKadaluarsa;
                             var  statusPaket;
                             statusKadaluarsa=$('#status_kadaluarsa').val();
                            statusPaket=$('#status_paket').val();

                            if(statusKadaluarsa=='Kadaluarsa')
                            {
                              $('#error-status-kadaluarsa').attr('hidden',false);  
                              $('#proses').prop('disabled', true);
                              
                            }else{
                               $('#error-status-kadaluarsa').attr('hidden',true);   
                               $('#proses').prop('disabled',false);  
                            }

                            if(statusPaket=='habis')
                            {
                              $('#error-status-paket').attr('hidden',false);  
                              $('#proses').prop('disabled',true);   
                            }else{
                               $('#error-status-paket').attr('hidden',true);   
                                $('#proses').prop('disabled',false);  
                            }
        }
    
var li = 'li:first-child';
        @if (old('jenis') == 1) var li = 'li:first-child'; @endif
        @if (old('jenis') == 2) var li = 'li:nth-child(2)'; @endif 
 
 
$('a.non_member').on('click', function () {
//      alert('Non member')
});

$('a.member').on('click', function () {
//      alert('member') 
});


$('#jumlah').keyup(function(){
            var harga_jual = parseFloat($('#harga_jual').autoNumeric('get')) || 0; 
            var total =$(this).val()*harga_jual;
            $('#total_harga').val(formatNumber(Math.floor(total)));
});

 $('#proses').on('click', function () {
//$(this).prop('disabled', true);
         $('.remark-modal-md').modal('show');  
        var harga = parseFloat($('#harga').autoNumeric('get')) || 0; 
        var total_bayar = parseFloat($('#total_bayar').autoNumeric('get')) || 0; 
        var harga_pokok = parseFloat($('#harga_pokok').autoNumeric('get')) || 0; 
        var harga_jual = parseFloat($('#harga_jual').autoNumeric('get')) || 0; 
        var total_harga = parseFloat($('#total_harga').autoNumeric('get')) || 0; 
        var stok_sales = parseFloat($('#stok_terkecil').autoNumeric('get')) || 0;  
         var nominal_penggunaan = parseFloat($('#nominal_penggunaan').autoNumeric('get')) || 0; 
        var cek_total_penggunaan = nominal_penggunaan+total_harga;
//        $("#form").submit();

      $('#btnSave').on('click', function () { 
            $('#harga').val(harga);
            $('#total_bayar').val(total_bayar);
            $('#harga_pokok').val(harga_pokok);
            $('#harga_jual').val(harga_jual);
            $('#total_harga').val(total_harga);
            $('#nominal_penggunaan').val(nominal_penggunaan); 
            $('.remark-modal-md').modal('hide');  
            var jumlah_penggunaan= $('#jumlah').val();
           
            if(cek_total_penggunaan<=total_bayar){ 
                if (stok_sales>jumlah_penggunaan){
                      $("#form-penjualan").submit(); 
                }else{ 
                     $('#body-pesan').attr('hidden',false);
                     $('#pesan').html('<b>Penginputan tidak dapat dilanjutkan, stok Coach tidak mencukupi !!!</b>')
                } 
            }
            
            if (cek_total_penggunaan>total_bayar){
                     $('#body-pesan').attr('hidden',false);
                     $('#pesan').html('<b>Penginputan tidak dapat dilanjutkan, Total penggunaan paket lebih besar dari sisa saldo !!!</b>')
            }
//                 
      })
})
 
 $('#topTabs-container-form').easytabs({
        updateHash: false,
        tabs: "ul.etabs > li",
        animate: true,
        defaultTab: li,
        transitionIn: 'slideDown',
        transitionOut: 'slideUp'
});

$('.autoNumeric').autoNumeric('init');

$('#tgl_transaksi, #tgl_cetak').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true
});

$('.tgl_transaksi').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true
});

 if (($('#startDate').length) && ($('#expiredDate').length)) {
            $('#startDate').datepicker({
            format: 'dd-mm-yyyy',
                    autoclose: true,
                    todayHighlight: true
            }).on('changeDate', function (e) {
            $('#expiredDate').datepicker('setStartDate', e.date);
            });
                    $('#expiredDate').datepicker({
            format: 'dd-mm-yyyy',
                    autoclose: true,
                    todayHighlight: true
            }).on('changeDate', function (e) {
            $('#startDate').datepicker('setEndDate', e.date)
                    calculate();
            });
}
 
 
            
        $('#member').select2({
                placeholder: "Silahkan pilih Member...",
                allowClear: true,
//                disabled: true,
//                readonly: true,
                ajax: {
                      url: '/pelanggan?jenis=aktif',
                      dataType: 'json',
                      delay: 100, 
                      processResults: function (data) {
                        return {
                          results:  $.map(data, function (dataku) 
                          {
//                             console.log(dataku);
                            return {
                                text    : dataku[0].nama_pelanggan,//untuk tampilan visual pada select 2
                                id        : dataku[0].id,// untuk mengisi value select 2
                            }
                          })
                        };
                      },
                      cache: true,
                      success:function (blueprint) {
                           console.log(blueprint);
                            $('#no_transaksi').val(blueprint.no_transaksi);  
                            $('#pelanggan_id').val(blueprint.pelanggan_id);  
                            $('#jenis_paket').val(blueprint.nama_menu);  
                            $('#menu_id').val(blueprint.menu_id);  
                            $('#paket_id').val(blueprint.paket_id);  
                            $('#harga').val(formatNumber(blueprint.harga));  
                            $('#total_bayar').val(formatNumber(blueprint.total_bayar));  
                            $('#total_penggunaan').val(blueprint.penggunaan_paket);  
                            $('#harga_pokok').val(formatNumber(Math.ceil(blueprint.harga_pokok)));  
                            $('#harga_jual').val(formatNumber(Math.ceil(blueprint.harga_jual)));  
                            $('#qty_paket').val(blueprint.qty_paket);  
                            $('#nominal_penggunaan').val(blueprint.total_nominal_penggunaan);  
                            $('#sisa_paket').val(blueprint.sisa_paket);  
                            $('#total_penggunaan').val(blueprint.penggunaan_paket);  
                            $('#nama_coach').val(blueprint.data[0].sales.karyawan.nama_karyawan);  
                            $('#iuran').val(blueprint.iuran);  
                            $('#sales_id').val(blueprint.data[0].sales_id);   
                            $('#sales_level_m').val(blueprint.sales_level);   
                           
                            
        
                            var dataku =blueprint.stok_all; 
                            let i = 1; 
                             $("#tblstok").attr('hidden',true); 
                             $("#tblstokshow").empty(); 
                            for (var print of  dataku) 
                            { 
//                              document.write(car.name + "<br />");
//                                  $("#tblPengalaman"). append(" <table>"+print.nama_kontraktor+"</b> </table>");
                                     $("#tblstokshow"). append(" <tr>\n\
                                       <td>"+i+"</td>\n\
                                       <td>"+print.nama_barang+"</td>\n\
                                      <td>"+print.stok+"</td>\n\
                                      <td>"+print.takaran+"</td>\n\
                                      <td>"+print.kaleng+"</td>\n\
                                      <td>"+print.porsi+"</td> \n\
                                       </tr>"); 
                                  i++;
                            } 
                            
                            
                            var history_penjualan=blueprint.history_penjualan; 
                            $("#tblpenjualan").attr('hidden',true); 
                            $("#tblShow").empty(); 
                           if (history_penjualan!=0){
                            let j = 1;  
                            for (var print of  history_penjualan) 
                            { 
//                              document.write(car.name + "<br />");
//                                  $("#tblPengalaman"). append(" <table>"+print.nama_kontraktor+"</b> </table>");
                                     $("#tblShow"). append(" <tr>\n\
                                       <td>"+j+"</td>\n\
                                       <td>"+print.tgl_jual+"</td>\n\
                                      <td>"+print.pelanggan_id+"</td>\n\
                                      <td>"+print.paket_id+"</td>\n\
                                      <td>"+print.qty_jual+"</td>\n\
                                      <td>"+formatNumber(Math.ceil(print.harga_pokok))+"</td>\n\
                                      <td>"+formatNumber(Math.ceil(print.harga_jual))+"</td>\n\
                                  </tr>"); 
                                  j++;
                            } 
                            
                           }
                             
                           
                      }
                       
            }
        });
 
        function calculate() {
        var d1 = $('#startDate').datepicker('getDate');
                var d2 = $('#expiredDate').datepicker('getDate');
                var oneDay = 24 * 60 * 60 * 1000;
                var diff = 0;
                if (d1 && d2) {

        diff = Math.round(Math.abs((d2.getTime() - d1.getTime()) / (oneDay)));
        }
        $('#durasi').val(diff + 1);
//$('.minim').val(d1)
        }

}); 
        function formatNumber(num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
        }
</script>
@endpush