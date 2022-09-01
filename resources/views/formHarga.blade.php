@extends('layouts.jnb.app')

@section('content')
<div id="main" class="clearfix">
    <div class="secInfo">
        <h1 class="secTitle">Form Input Harga Dasar</h1>
        <span class="secExtra">Form penginputan Harga Dasar Barang  Nutrition Club</span>

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
                            <form id="form-penjualan" class="form-horizontal" method="POST" action="{{ url('/') }}/create-harga" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            <!--<input type="hidden" id="spps_type" name="jenis" value="{{ old('jenis', 1) }}">--> 
                            <br>
                     	 
                            <div class="widget-header">
                                <h3 class="widget-title">DATA HARGA POKOK</h3>
                            </div>
                            <div class="widget-content pad20f">     
                               <div class="form-group">
                                    <label for="nama_barang" class="col-sm-3 control-label">Nama Barang <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <select name="barang_id" id="barang_id"  class="form-control">
                                            <option value="">Ketik Nama Barang</option> 
                                            @foreach($data as $barang)
                                                <option value="{{$barang->id}}">{{$barang->nama_barang}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>  
                                <div class="form-group">
                                    <label for="takaran" class="col-sm-3 control-label">Takaran</label>
                                    <div class="col-sm-9">
                                        <input readonly="" type="text" name="takaran" value="{{ old('takaran') }}" class="form-control" id="takaran">
                                    </div>
                                </div>  
                                <div class="form-group">
                                    <label for="jabatan" class="col-sm-3 control-label">Level <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <select id="level" name="level" class="form-control">
                                            <option value="">Pilih Level</option>
                                            @foreach($level as $value)
                                                <option value="{{$value->id}}">{{$value->level}}</option> 
                                            @endforeach 
                                        </select> 
                                    </div>
                                </div>  
                                <div class="form-group">
                                    <label for="harga_pokok" class="col-sm-3 control-label">Harga Pokok</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="harga_pokok" value="{{ old('harga_pokok') }}" class="form-control numeric"  id="harga_pokok">
                                    </div>
                                </div>    
                                <div class="form-group">
                                    <label for="harga_jual" class="col-sm-3 control-label">Harga Jual</label>
                                    <div class="col-sm-9">
                                        <input readonly="" type="text" name="harga_jual" value="{{ old('harga_jual') }}" class="form-control numeric"  id="harga_jual">
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
        var harga_pokok = parseFloat($('#harga_pokok').autoNumeric('get')) || 0; 
        var harga_jual = parseFloat($('#harga_jual').autoNumeric('get')) || 0; 
        $('#harga_pokok').val(harga_pokok);
        $('#harga_jual').val(harga_jual);
//        $("#form").submit();
})

 $('#barang_id').change(function(){
        
    var cari= $(this).val();
    $.ajax({ 
        url: '/cari-barang?q='+cari,
        dataType: 'json',
        delay: 100, 
        cache: true,
        success:function (blueprint) {
                console.log(blueprint);
              $('#takaran').val(blueprint[0].takaran);  
             
             }  
    }) 

 })
 
 $('#harga_pokok').keyup(function(){
        var takaran = $('#takaran').val(); 
        var harga_pokok = parseFloat($('#harga_pokok').autoNumeric('get')) || 0; 
        var harga_jual  =   Math.ceil(harga_pokok/takaran);
        $('#harga_jual').val(formatNumber(harga_jual));
 })
 
 $('#barang_id').select2({
                placeholder: "Silahkan ketik nama barang...",
                allowClear: true, 
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