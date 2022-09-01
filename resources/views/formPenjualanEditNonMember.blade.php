@extends('layouts.jnb.app')

@section('content')
<div id="main" class="clearfix">
    <div class="secInfo">
        <h1 class="secTitle">Form Edit Penjualan</h1>
        <span class="secExtra">Form Edit Penjualan Dari Setiap Member Nutrition Club</span>

    </div> <!-- /SecInfo -->
    <div class="fluid">				
        <div class="widget leftcontent grid12">
            <div class="topTabs">					
                <div id="topTabs-container-form">
                    <div class="topTabs-header clearfix">						
                        <ul class="etabs tabs">
                            
                            <li class="tab">
                                <a href="#tab2" class="non_member ">
                                    <span class="to-hide">
                                        <i class="fa fa-user"></i><br>Non Member
                                    </span>
                                    <i class="fa icon-hidden fa-play" data-toggle="tooltip" data-placement="bottom" title="NonMember"></i>
                                </a>
                            </li> 
                        </ul> <!-- /tabs -->
                    </div><!-- /topTabs-header -->
                    <div class="topTabsContent" style="padding-left:0;">
                        <!-- TAB PENAWARAN =========================================================================== -->
                         
                        <div id="tab2">
                            
                         <form id="form-penjualan" class="form-horizontal" method="POST" action="{{ url('/') }}/detail-penjualan/{{$data->id}}" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                             <input type="hidden"  name="_method" value="PUT"> 
                            <br>
                            <div class="widget-header">
                                <h3 class="widget-title">JENIS MEMBER</h3>
                            </div> 
                            <div class="widget-content pad20f"> 
                                 <div class="form-group  {{ $errors->has('pelanggan_id_non_member') ? ' has-error' : '' }}">
                                    <label for="pelanggan_id" class="col-sm-3 control-label">Jenis Member <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <select  id="pelanggan_id" name="pelanggan_id" class="form-control"> 
                                            @foreach ($pelanggan as $key=>$value)
                                            <option selected="" value="{{$value->id}}">{{$value->nama_pelanggan}}</option>  
                                            @endforeach
                                        </select>
                                    </div> 
                                </div>
                                 <div class="form-group {{ $errors->has('harga') ? ' has-error' : '' }}">
                                    <label for="non_member" class="col-sm-3 control-label">Nama <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input required=""  type="text" name="non_member" value="{{ old('non_member',$data->non_member) }}" class="form-control" id="non_member"> 
                                    </div>
                                </div>  
                                <div class="form-group {{ $errors->has('nama_member') ? ' has-error' : '' }}">
                                    <label for="jenis_paket" class="col-sm-3 control-label">Jenis Paket <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input  type="text" name="menu_id" value="{{ old('menu_id',$data->paket->menu->id) }}" class="form-control hidden" id="menu_id"> 
                                        <input  type="text" name="paket_id" value="{{ old('paket_id',$data->paket->id) }}" class="form-control hidden" id="paket_id"> 
                                        <input readonly="" type="text" name="jenis_paket" value="{{ old('jenis_paket',$data->paket->menu->nama_menu) }}" class="form-control" id="jenis_paket"> 
                                    </div>
                                </div>   
                                <div class="form-group {{ $errors->has('harga') ? ' has-error' : '' }}">
                                    <label for="Harga" class="col-sm-3 control-label">Harga <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input readonly="" type="text" name="harga" value="{{ old('harga',$data->paket->harga_jual) }}" class="form-control numeric" id="harga"> 
                                    </div>
                                </div>  
                                <div class="form-group {{ $errors->has('total_bayar') ? ' has-error' : '' }}">
                                    <label for="total_bayar" class="col-sm-3 control-label">Total Bayar <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input readonly="" type="text" name="total_bayar" value="{{ old('total_bayar',$data->paket->total_bayar) }}" class="form-control numeric" id="total_bayar"> 
                                    </div>
                                </div>  
                                <div class="form-group {{ $errors->has('qty_paket') ? ' has-error' : '' }}">
                                    <label for="qty_paket" class="col-sm-3 control-label">Jumlah Paket <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input readonly="" type="text" name="qty_paket" value="{{ old('qty_paket',$data->paket->qty) }}" class="form-control" id="qty_paket"> 
                                    </div>
                                </div>   
                            </div> 
                            <div class="widget-header">
                                <h3 class="widget-title">DATA COACH</h3>
                            </div>
                            <div class="widget-content pad20f">  
                                <div class="form-group">
                                    <label for="non_member_coach" class="col-sm-3 control-label">Nama Coach <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <select id="non_member_coach" name="sales_id" class="form-control">
                                            <option value="{{$data->sales->id}}">{{$data->sales->karyawan->nama_karyawan}}</option> 
                                        </select>
                                          <input type="text" name="iuran" value="{{ old('iuran',$data->sales->iuran) }}" class="form-control hidden" id="iuran_non"> 
                                          <input type="text" name="sales_level" value="{{ old('sales_level',$data->sales->level_id) }}" class="form-control hidden" id="sales_level"> 
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
                                        @foreach ($stok as $key) 
                                                <tr>
                                                <td>
                                                  {{$key['barang_id']}}
                                                </td> 
                                                <td>
                                                    {{$key['nama_barang']}}
                                                </td>
                                                <td>
                                                     {{$key['stok']}}
                                                </td>
                                                <td>
                                                   {{$key['takaran']}}
                                                </td>
                                                <td>
                                                  {{$key['kaleng']}}
                                                </td>
                                                <td>
                                                   {{$key['porsi']}}
                                                </td> 
                                            </tr>
                                             @endforeach
                                        </tbody>
                                        <tbody id="tblstokshow">
                                      
                                        </tbody>
                                    </table> 
                            </div>
                         
                            <div class="widget-header">
                                <h3 class="widget-title">DATA TRANSAKSI</h3>
                            </div>
                            <div class="widget-content pad20f">     
                                <div class="form-group {{ $errors->has('tgl_transaksi') ? ' has-error' : '' }} hidden">
                                    <label for="no_transaksi" class="col-sm-3 control-label">Nomor Transaksi<span class="text-danger">*</span></label>
                                    <div class="col-sm-9"> 
                                                <input readonly="" type="text" name="no_transaksi" value="{{ old('no_transaksi') }}" class="form-control" id="no_transaksi">
                                    </div> 
                                </div>  
                                <div class="form-group {{ $errors->has('tgl_transaksi') ? ' has-error' : '' }}">
                                    <label for="tgl_transaksi" class="col-sm-3 control-label">Tgl Transaksi <span class="text-danger">*</span></label>
                                    <div class="col-sm-4">
                                        <div class="input-group">
                                            <input readonly="" type="text" name="tgl_transaksi" value="<?php echo old('tgl_transaksi', date('d-m-Y', strtotime($data->tgl_jual))) ?>" class="form-control  clearClone tgl_transaksi " placeholder="dd-mm-yyyy">
                                            <span  class="input-group-addon"><i class="fa fa-calendar"></i></span>
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
                                        <input readonly="" type="text" name="harga_jual" value="{{ old('harga_jual',$data->paket->harga_jual) }}" class="form-control numeric" id="harga_jual">
                                    </div>
                                </div> 
                               <div class="form-group">
                                    <label for="jumlah" class="col-sm-3 control-label">Jumlah</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="jumlah" value="{{ old('jumlah',$data->qty_jual) }}" class="form-control" id="jumlah">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="total_harga" class="col-sm-3 control-label">Total Harga</label>
                                    <div class="col-sm-9">
                                        <input readonly="" type="text" name="total_harga" value="{{ old('total_harga',$data->qty_jual*$data->paket->harga_jual) }}" class="form-control numeric" id="total_harga">
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
                        	 					
                        </form>
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
            $('#total_harga').val(formatNumber(Math.ceil(total)));
});

 $('#proses').on('click', function () {
//$(this).prop('disabled', true);
        var harga = parseFloat($('#harga').autoNumeric('get')) || 0; 
        var total_bayar = parseFloat($('#total_bayar').autoNumeric('get')) || 0; 
        var harga_pokok = parseFloat($('#harga_pokok').autoNumeric('get')) || 0; 
        var harga_jual = parseFloat($('#harga_jual').autoNumeric('get')) || 0; 
        var total_harga = parseFloat($('#total_harga').autoNumeric('get')) || 0; 
		
        $('#harga').val(harga);
        $('#total_bayar').val(total_bayar);
        $('#harga_pokok').val(harga_pokok);
        $('#harga_jual').val(harga_jual);
        $('#total_harga').val(total_harga);
//        $("#form").submit();
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
 
       
        $('#pelanggan_id').change(function(){  
           var cari= $(this).val();
                  $.ajax({ 
                      url: '/non-pelanggan?jenis=umum&q='+cari,
                      dataType: 'json',
                      delay: 100, 
                      cache: true,
                      success:function (blueprint) {
//                           console.log(blueprint);
                            $('#no_transaksi').val(blueprint.no_transaksi);  
                            $('#pelanggan_id').val(blueprint.pelanggan_id);  
                            $('#jenis_paket').val(blueprint.nama_menu);  
                            $('#menu_id').val(blueprint.menu_id);  
                            $('#paket_id').val(blueprint.paket_id);  
                            $('#harga').val(formatNumber(blueprint.harga));  
                            $('#total_bayar').val(formatNumber(blueprint.total_bayar));   
                            $('#qty_paket').val(blueprint.qty_paket);   
                                     
                           }  
                  }) 
                  
        });
        
 pilihCoach();          
function pilihCoach()
{
    var menu_id =  $('#menu_id').val();
    $('#non_member_coach').select2({ 

 placeholder: "Silahkan pilih Coach...",
 allowClear: true,
 ajax: {

       url: '/pilih-coach?menu_id='+menu_id,
       dataType: 'json',
       delay: 100,
       processResults: function (data) {
         return {
           results:  $.map(data, function (print) 
           {  
//                               console.log(print);
             return {
                 text    : print.sales[0].karyawan.nama_karyawan,//untuk tampilan visual pada select 2
                 id        : print.sales_id// untuk mengisi value select 2
             }

           })
         };
       },
       cache: true,
       success:function (blueprint) {   
           
           console.log(blueprint);
           
            $("#sales_level").val(blueprint.data.level_id); 
            $("#iuran_non").val(blueprint.data.iuran); 
            $("#harga_jual").val(formatNumber(Math.ceil(blueprint.data.harga_jual))); 
            $("#harga_pokok").val(formatNumber(Math.ceil(blueprint.data.harga_pokok))); 
             $('#jumlah').keyup(function(){
                    var total =$(this).val()*blueprint.data.harga_jual;
                    $('#total_harga').val(formatNumber(Math.ceil(total)));
            }); 
        
        
            console.log(blueprint.data.stok_all); 
             var dataku =blueprint.data.stok_all
             let i = 1;  
              $("#tblstok").attr('hidden',true); 
              $("#tblstokshow").empty(); 
              for (var print of  dataku) 
              { 
 
                      $("#tblstokshow"). append(" <tr>\n\
                         <td>"+i+"</td>\n\
                        <td>"+print.nama_barang+"</td>\n\
                       <td>"+print.stok+"</td>\n\
                       <td>"+print.takaran+"</td>\n\
                       <td>"+print.kaleng+"</td>\n\
                       <td>"+print.porsi+"</td>\n\
                       </tr>"); 
                   i++;
             }   
            }  
}
});     
}
            
        $('#member').select2({
                placeholder: "Silahkan pilih Member...",
                allowClear: true,
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