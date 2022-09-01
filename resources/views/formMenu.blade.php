@extends('layouts.jnb.app')

@section('content')
<div id="main" class="clearfix">
    <div class="secInfo">
        <h1 class="secTitle">Form Input Master Menu</h1>
        <span class="secExtra">Form penginputan untk setiap menu yang dijual</span>

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
                            <form id="form-penjualan" class="form-horizontal" method="POST" action="{{ url('/') }}/create-menu" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            <!--<input type="hidden" id="spps_type" name="jenis" value="{{ old('jenis', 1) }}">--> 
                            <br>
                     	 
                            <div class="widget-header">
                                <h3 class="widget-title">DATA MENU</h3>
                            </div>
                            <div class="widget-content pad20f">     
                               <div class="form-group">
                                    <label for="nama_menu" class="col-sm-3 control-label">Nama Menu <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="nama_menu" value="{{ old('nama_menu') }}" class="form-control" id="nama_menu">
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label for="harga" class="col-sm-3 control-label">Harga</label>
                                    <div class="col-sm-9">
                                        <input   type="text" name="harga" value="{{ old('harga') }}" class="form-control text-right numeric" id="harga">
                                    </div> 
                                </div>  
                                <div class="form-group">
                                    <label for="qty" class="col-sm-3 control-label">Qty</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="qty" value="{{ old('qty') }}" class="form-control" id="qty">
                                    </div>
                                </div>   
                                <div class="form-group">
                                    <label for="masa_kadaluarsa" class="col-sm-3 control-label">Masa Kadaluarsa</label>
                                    <div class="col-sm-3">
                                        <input type="text" name="masa_kadaluarsa" value="{{ old('masa_kadaluarsa') }}" class="form-control" id="masa_kadaluarsa">Bulan
                                    </div>
                                </div>   
                                <div class="form-group">
                                    <label for="harga_jual" class="col-sm-3 control-label">Harga Jual</label>
                                    <div class="col-sm-9">
                                        <input readonly=""  type="text" name="harga_jual" value="{{ old('harga_jual') }}" class="form-control  text-right numeric" id="harga_jual">
                                    </div> 
                                </div>  
                                 
                            </div> 				
                     				
                            <div class="widget-header">
                                <h3 class="widget-title">Tanggal Input</h3>
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

$('#proses').on('click', function () {
//$(this).prop('disabled', true);
        var harga = parseFloat($('#harga').autoNumeric('get')) || 0;
        var harga_jual = parseFloat($('#harga_jual').autoNumeric('get')) || 0;
        $('#harga').val(harga);
        $('#harga_jual').val(harga_jual);
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

$('#qty').keyup(function(){
    var qty = $(this).val();
    var harga = parseFloat($('#harga').autoNumeric('get')) || 0;
    var harga_jual = formatNumber(Math.ceil(harga/qty));
    if(harga_jual!='Infinity')
    {  $('#harga_jual').val(harga_jual);} 
    
    
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
  

}); 
        function formatNumber(num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
        }
</script>
@endpush