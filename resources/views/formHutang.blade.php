@extends('layouts.jnb.app')

@section('content')
<div id="main" class="clearfix">
    <div class="secInfo">
        <h1 class="secTitle">Form Input Pembayaran Hutang</h1>
        <span class="secExtra">Form penginputan Pembayaran Hutang Dari Setiap Member Nutrition Club</span>

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
                    
                     @if(Session::has('msgupdate'))
                            <div class="alert alert-info">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <i class="fa fa-info-circle"></i> {{ Session::get('msgupdate') }}
                            </div>
                    @endif
                    <div class="topTabsContent" style="padding-left:0;">
                        <!-- TAB PENAWARAN =========================================================================== -->
                        <div id="tab1">
                            <form id="form-penjualan" class="form-horizontal" method="POST" action="{{ url('/') }}/create-bayar-hutang" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            <!--<input type="hidden" id="spps_type" name="jenis" value="{{ old('jenis', 1) }}">--> 
                            <br>
                            <div class="widget-header">
                                <h3 class="widget-title">DATA MEMBER</h3>
                            </div>
                            
                            <div class="widget-content pad20f">
                                <div class="form-group {{ $errors->has('nama_member') ? ' has-error' : '' }}">
                                    <label for="nama_member" class="col-sm-3 control-label">Nama Member <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <select id="member" name="pelanggan_id" class="form-control">
                                        <option></option>
                                         
                                    </select>
                                    </div>
                                </div>   
                                <div class="form-group {{ $errors->has('nama_member') ? ' has-error' : '' }}">
                                    <label for="jenis_paket" class="col-sm-3 control-label">Jenis Paket <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input  type="text" name="menu_id" value="{{ old('menu_id') }}" class="form-control hidden" id="menu_id"> 
                                        <input  type="text" name="paket_id" value="{{ old('paket_id') }}" class="form-control hidden" id="paket_id"> 
                                        <input readonly="" type="text" name="jenis_paket" value="{{ old('jenis_paket') }}" class="form-control" id="jenis_paket"> 
                                    </div>
                                </div>   
                                <div class="form-group {{ $errors->has('harga') ? ' has-error' : '' }}">
                                    <label for="Harga" class="col-sm-3 control-label">Harga <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input readonly="" type="text" name="harga" value="{{ old('harga') }}" class="form-control" id="harga"> 
                                    </div>
                                </div>  
                                <div class="form-group {{ $errors->has('total_bayar') ? ' has-error' : '' }}">
                                    <label for="total_bayar" class="col-sm-3 control-label">Total Bayar <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input readonly="" type="text" name="total_bayar" value="{{ old('total_bayar') }}" class="form-control" id="total_bayar"> 
                                    </div>
                                </div>  
                                <div class="form-group {{ $errors->has('sisa_hutang') ? ' has-error' : '' }}">
                                    <label for="sisa_hutang" class="col-sm-3 control-label">Sisa Hutang <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input style="background: thistle" readonly="" type="text" name="sisa_hutang" value="{{ old('sisa_hutang') }}" class="form-control" id="sisa_hutang"> 
                                    </div>
                                </div>  
                                <div class="form-group {{ $errors->has('qty_paket') ? ' has-error' : '' }}">
                                    <label for="qty_paket" class="col-sm-3 control-label">Jumlah Paket <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input readonly="" type="text" name="qty_paket" value="{{ old('qty_paket') }}" class="form-control" id="qty_paket"> 
                                    </div>
                                </div>  
                                <div class="form-group {{ $errors->has('total_penggunaan') ? ' has-error' : '' }}">
                                    <label for="total_penggunaan" class="col-sm-3 control-label">Total Sudah Digunakan <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input readonly="" type="text" name="total_penggunaan" value="{{ old('total_penggunaan') }}" class="form-control" id="total_penggunaan"> 
                                    </div>
                                </div>    
                                <div class="form-group {{ $errors->has('sisa_paket') ? ' has-error' : '' }}">
                                    <label for="sisa_paket" class="col-sm-3 control-label">Sisa Paket <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input readonly="" type="text" name="sisa_paket" value="{{ old('sisa_paket') }}" class="form-control" id="sisa_paket"> 
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
                                        <tbody id="tblpenjualan">
                                      
                                        </tbody>
                                    </table> 
                            </div>	
                            
                            <div class="widget-header">
                                <h3 class="widget-title">DATA TRANSAKSI PEMBAYARAN HUTANG</h3>
                            </div>
                            <div class="widget-content pad20f">     
                         
                                <div class="form-group">
                                    <label for="jumlah_setor" class="col-sm-3 control-label">Jumlah Setor</label>
                                    <div class="col-sm-9">
                                        <input  type="text" name="jumlah_setor" value="{{ old('jumlah_setor') }}" class="form-control numeric" id="jumlah_setor">
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <a href="{{ url('/home') }}" class="btn btn-dark-grey"><i class="fa fa-undo"></i> KEMBALI</a>
                                    </div>
                                    <div class="col-sm-6 text-right">
                                        <button  id="proses" type="submit" class="btn"><i class="fa fa-save"></i> PROSES</button>
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
                                        <input type="text" name="sales_level" value="{{ old('sales_id') }}" class="form-control hidden" id="sales_level_m"> 
                                        <input type="text" name="sales_id" value="{{ old('sales_id') }}" class="form-control hidden" id="sales_id"> 
                                        <input type="text" name="iuran" value="{{ old('iuran') }}" class="form-control hidden" id="iuran"> 
                                        <input readonly="" type="text" name="nama_coach" value="{{ old('nama_coach') }}" class="form-control" id="nama_coach"> 
                                    </div>
                                </div>    
                            </div>
                          
                            
                            <div class="divider"></div>			
                            <div class="widget-header">
                                <h3 class="widget-title">TABEL STOK COACH</h3>
                            </div>
                            <div class="widget-content pad20f">
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
                                      
                                        </tbody>
                                    </table> 
                            </div>	 					
                        </form>
                        </div>
                         
                        <div id="tab2"></div>
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
var li = 'li:first-child';
        @if (old('jenis') == 1) var li = 'li:first-child'; @endif
        @if (old('jenis') == 2) var li = 'li:nth-child(2)'; @endif 
 
 
$('a.non_member').on('click', function () {
//      alert('Non member')
});

$('a.member').on('click', function () {
//      alert('member') 
});

 
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
 
    $('#proses').on('click', function () {
//$(this).prop('disabled', true);
        var jumlah_setor = parseFloat($('#jumlah_setor').autoNumeric('get')) || 0;  
        $('#jumlah_setor').val(jumlah_setor);
//        $("#form").submit();
}) 
        
        $('#member').select2({
                placeholder: "Silahkan pilih Member...",
                allowClear: true,
                ajax: {
                      url: '/cek-paket-pelanggan?jenis=aktif',
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
                           var total_bayar        =  blueprint.total_bayar; 
                           var harga_paket      =   blueprint.harga;
                           var sisa_hutang       =  harga_paket-total_bayar;
                           
                            $('#pelanggan_id').val(blueprint.pelanggan_id);  
                            $('#jenis_paket').val(blueprint.nama_menu);  
                            $('#menu_id').val(blueprint.menu_id);  
                            $('#paket_id').val(blueprint.paket_id);  
                            $('#harga').val(formatNumber(blueprint.harga));  
                            $('#total_bayar').val(formatNumber(blueprint.total_bayar));  
                            $('#sisa_hutang').val(formatNumber(sisa_hutang));  
                            $('#total_penggunaan').val(blueprint.penggunaan_paket);  
                            $('#harga_pokok').val(formatNumber(Math.ceil(blueprint.harga_pokok)));  
                            $('#harga_jual').val(formatNumber(Math.ceil(blueprint.harga_jual)));  
                            $('#qty_paket').val(blueprint.qty_paket);  
                            $('#sisa_paket').val(blueprint.sisa_paket);  
                            $('#total_penggunaan').val(blueprint.penggunaan_paket);  
                            $('#nama_coach').val(blueprint.data[0].sales.karyawan.nama_karyawan);  
                            $('#iuran').val(blueprint.iuran);  
                            $('#sales_id').val(blueprint.data[0].sales_id);   
                            $('#sales_level_m').val(blueprint.sales_level);   
                         
                            var dataku =blueprint.stok_all; 
                            let i = 1; 
                             $("#tblstok").empty(); 
                            for (var print of  dataku) 
                            { 
//                              document.write(car.name + "<br />");
//                                  $("#tblPengalaman"). append(" <table>"+print.nama_kontraktor+"</b> </table>");
                                     $("#tblstok"). append(" <tr>\n\
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
                            $("#tblpenjualan").empty(); 
                           if (history_penjualan!=0){
                            let j = 1;  
                            for (var print of  history_penjualan) 
                            { 
//                              document.write(car.name + "<br />");
//                                  $("#tblPengalaman"). append(" <table>"+print.nama_kontraktor+"</b> </table>");
                                     $("#tblpenjualan"). append(" <tr>\n\
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