@extends('layouts.jnb.app')

@section('content')
<div id="main" class="clearfix">
    <div class="secInfo">
        <h1 class="secTitle">Form Edit Penerimaan Stok</h1>
        <span class="secExtra">Form Perubahan data Stok Dari Setiap Coach Nutrition Club</span>

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
                                       
                                    </span>
                                    <i class="fa icon-hidden fa-tag" data-toggle="tooltip" data-placement="bottom" title="Member"></i>
                                </a>
                            </li>
                             
                        </ul> <!-- /tabs -->
                    </div><!-- /topTabs-header -->
                    <div class="topTabsContent" style="padding-left:0;">
                        <div id="tab1">
                            <form id="form-penjualan" class="form-horizontal" method="POST" action="{{ url('/') }}/detail-pembelian/{{$data->id}}" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                             <input type="hidden" name="_method" value="PUT"> 
                            <br>
                             <div class="widget-header">
                                <h3 class="widget-title">DATA COACH</h3>
                            </div>
                            <div class="widget-content pad20f">  
                                <div class="form-group">
                                    <label for="nama_coach" class="col-sm-3 control-label">Nama Coach <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <select id="pilih_coach" name="sales_id" class="form-control">
                                            <option value="{{$data->sales->id}}">{{$data->sales->karyawan->nama_karyawan}}</option> 
                                        </select>  
                                          <input type="text" name="sales_level" value="{{ old('sales_level',$data->sales->level_id) }}" class="form-control hidden" id="sales_level"> 
                                    </div>
                                </div>  
                            </div> 	
                            
                            <div class="widget-header">
                                <h3 class="widget-title">DATA BARANG</h3>
                            </div>
                            <div class="widget-content pad20f">     
                               <div class="form-group">
                                    <label for="nama_barang" class="col-sm-3 control-label">Nama Barang <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <select id="barang_id" name="barang_id" class="form-control">
                                            <option value="{{$data->barang->id}}">{{$data->barang->nama_barang}}</option> 
                                        </select>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label for="harga_pokok" class="col-sm-3 control-label">Harga Pokok</label>
                                    <div class="col-sm-9">
                                        <input readonly="" type="text" name="harga_pokok" value="{{ old('harga_pokok',$data->harga_pokok) }}" class="form-control numeric" id="harga_pokok">
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label for="takaran" class="col-sm-3 control-label">Takaran</label>
                                    <div class="col-sm-9">
                                        <input readonly="" type="text" name="takaran" value="{{ old('takaran',$data->barang->takaran) }}" class="form-control" id="takaran">
                                    </div>
                                </div>   
                                <div class="form-group">
                                    <label for="qty" class="col-sm-3 control-label">Qty</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="qty" value="{{ old('qty',$data->qty) }}" class="form-control" id="qty">
                                    </div>
                                </div>   
                                <div class="form-group">
                                    <label for="stok_saji" class="col-sm-3 control-label">Stok Sajian</label>
                                    <div class="col-sm-9">
                                        <input readonly="" type="text" name="stok_saji" value="{{ old('stok_saji',$data->qty*$data->barang->takaran) }}" class="form-control" id="stok_saji">
                                    </div>
                                </div>   
                                 
                            </div> 				
                            <div class="widget-header">
                                <h3 class="widget-title">DATA SUPPLIER</h3>
                            </div>
                            <div class="widget-content pad20f">     
                                  <div class="form-group">
                                    <label for="nama_supplier" class="col-sm-3 control-label">Nama Suppiler <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <select id="supplier_id" name="supplier_id" class="form-control">
                                            <option value="">Nama Supplier</option>  
                                            @foreach ($supplier as $value)
                                              <option @if($data->supplier_id==$value->id) selected='' @endif value="{{$value->id}}">{{$value->nama_supplier}}</option> 
                                            @endforeach
                                        </select> 
                                    </div>
                                </div>  
                            </div> 				
                            <div class="widget-header">
                                <h3 class="widget-title">TANGGAL EDIT</h3>
                            </div>
                            <div class="widget-content pad20f">      
                                     <div class="form-group {{ $errors->has('tgl_transaksi') ? ' has-error' : '' }}">
                                    <label for="tgl_transaksi" class="col-sm-3 control-label">Tgl Transaksi <span class="text-danger">*</span></label>
                                    <div class="col-sm-4">
                                        <div class="input-group">
                                            <input readonly="" type="text" name="tgl_transaksi" value="<?php echo old('tgl_transaksi', date('d-m-Y')) ?>" class="form-control  clearClone tgl_transaksi " placeholder="dd-mm-yyyy">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        </div>
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

$('#proses').on('click', function () {
//$(this).prop('disabled', true);
        var harga_pokok = parseFloat($('#harga_pokok').autoNumeric('get')) || 0;  
        $('#harga_pokok').val(harga_pokok); 
})

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
 
 
   $('#qty').keyup(function(){ 
                var takaran     =      $("#takaran").val(); 
                var total           =     $(this).val()*takaran;
                $('#stok_saji').val(formatNumber(Math.ceil(total)));
    });  
        
 pilihCoach(); 
 
function pilihCoach()
{ 
         $('#pilih_coach').select2({  
         placeholder: "Silahkan pilih Coach...",
         allowClear: true,
         ajax: { 
               url: '/pilih-coach',
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
//                   console.log(blueprint); 
                    $("#sales_level").val(blueprint.data.level_id); 
                    $("#iuran_non").val(blueprint.data.iuran); 
//                    $("#harga_jual").val(formatNumber(Math.ceil(blueprint.data.harga_jual))); 
//                    $("#harga_pokok").val(formatNumber(Math.ceil(blueprint.data.harga_pokok)));   
                    
                    }   
        }
        });
}

pilihBarang() ;            
function pilihBarang()
{ 
    
        var level =$('#sales_level').val(); 
         $('#barang_id').select2({  
         placeholder: "Silahkan pilih Barang...",
         allowClear: true,
         ajax: { 
               url: '/pilih-barang?level='+level,
               dataType: 'json',
               delay: 100,
               processResults: function (data) {
                 return {
                   results:  $.map(data, function (print) 
                   {  
//                                       console.log(print);
                     return {
                         text    : print.data[0].nama_barang,//untuk tampilan visual pada select 2
                         id        : print.data[0].id// untuk mengisi value select 2
                     }

                   })
                 };
               },
               cache: true,
               success:function (blueprint) {      
                    $('#takaran').val(blueprint.databarang.harga.takaran); 
                   
                    var takaran =  $('#takaran').val();
                    var qty = $('#qty').val();   
                    var stok_saji=qty*takaran;
//                   alert(stok_saji);
                    $("#harga_pokok").val(formatNumber(blueprint.databarang.harga.harga_pokok));  
                    $("#stok_saji").val(stok_saji);    
           }   
                     
        }
        });
}
             
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