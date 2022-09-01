@extends('layouts.jnb.app')

@section('content')
<div id="main" class="clearfix">
    <div class="secInfo">
        <h1 class="secTitle">Form Input Data Pelanggan</h1>
        <span class="secExtra">Form penginputan Pelanggan  Nutrition Club</span>

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
                            <form id="form-penjualan" class="form-horizontal" method="POST" action="{{ url('/') }}/create-pelanggan" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            <!--<input type="hidden" id="spps_type" name="jenis" value="{{ old('jenis', 1) }}">--> 
                            <br>
                     	 
                            <div class="widget-header">
                                <h3 class="widget-title">DATA PELANGGAN</h3>
                            </div>
                            <div class="widget-content pad20f">     
                               <div class="form-group">
                                    <label for="nama_pelanggan" class="col-sm-3 control-label">Nama Pelanggan <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="nama_pelanggan" value="{{ old('nama_pelanggan') }}" class="form-control" id="nama_pelanggan">
                                    </div>
                                </div>   
                                <div class="form-group {{ $errors->has('tgl_lahir') ? ' has-error' : '' }}">
                                    <label for="tgl_lahir" class="col-sm-3 control-label">Tgl Lahir <span class="text-danger">*</span></label>
                                    <div class="col-sm-4">
                                        <div class="input-group">
                                            <input id="tgl_lahir"   type="text" name="tgl_lahir" value="<?php echo old('tgl_lahir', date('d-m-Y')) ?>" class="form-control  clearClone " placeholder="dd-mm-yyyy">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                                     <div class="form-group">
                                    <label for="alamat" class="col-sm-3 control-label">Alamat</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="alamat" value="{{ old('alamat') }}" class="form-control" id="alamat">
                                    </div>
                                </div>    
                                <div class="form-group">
                                    <label for="telp" class="col-sm-3 control-label">No Telephone</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="telp" value="{{ old('telp') }}" class="form-control" id="telp">
                                    </div>
                                </div>   
                                
                            </div> 				
                     				
                            <div class="widget-header">
                                <h3 class="widget-title">DATA COACH</h3>
                            </div>
                            <div class="widget-content pad20f">
                               <div class="form-group">
                                    <label for="nama_coach" class="col-sm-3 control-label">Nama Coach</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" id="nama_coach" name="sales_id">
                                            <option value="">Pilih Coach</option>
                                            @foreach($data_sales as $data) 
                                             <option value="{{$data->id}}">{{$data->karyawan->nama_karyawan}}</option>
                                            @endforeach
                                        </select>
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
                                            <input readonly="" type="text" name="tgl_transaksi" value="<?php echo old('tgl_transaksi', date('d-m-Y')) ?>" class="form-control  clearClone " placeholder="dd-mm-yyyy">
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

 $('#nama_coach').select2({
         placeholder: "Silahkan pilih Coach...",
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

$('#tgl_cetak,#tgl_lahir').datepicker({
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