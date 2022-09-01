@extends('layouts.jnb.app')

@section('content')	
<div id="main" class="clearfix">
    <div class="secInfo">
        <h1 class="secTitle">Profil Pengguna</h1>
        <span class="secExtra"></span>
    </div> <!-- /SecInfo -->
    <div class="fluid">
        <div class="widget leftcontent grid4">
            <div class="widget-header" style="background:transparent">
                <h3 class="widget-title">QrCode User</h3>
                <!--
                <div class="widget-controls">
                        <div class="btn-group xtra">
                                <a href="#" onclick="return false;" class="icon-button dropdown-toggle" data-toggle="dropdown"><i class="fa fa-gear"></i></a>
                                <ul class="dropdown-menu pull-right">
            <li><a href="#"><i class="fa fa-pencil"></i> Edit</a></li>
            <li><a href="#"><i class="fa fa-trash-o"></i> Delete</a></li>
            <li><a href="#"><i class="fa fa-ban"></i> Ban</a></li>
            <li class="divider"></li>
            <li><a href="#"> Other actions</a></li>
        </ul>
</div>
                </div>
                -->
            </div>

            <div class="widget-content pad20f">
                <div class="profileImg">
<!--                    <img src="{{ asset('assets/img') }}/user.jpg" rel="user">	-->
                    <a href="/detail-penjualan-Scan/{{ enkripsi($user->pelanggan_id) }}" target="_blank">
                        <img rel="user" align="right" src= "data:image/png;base64,{{base64_encode(QrCode::encoding('ISO-8859-1')->format('png')->size(300)->generate('https:/vinayafitclub.com/detail-penjualan-Scan/'.enkripsi($user->pelanggan_id) ))}}">
                    </a> 
                </div>
                
            </div> <!-- /widget-content -->

            <div class="divider"></div>

        </div> <!-- /widget -->

        <div class="widget grid8 form-horizontal">
            <div class="widget-header" style="background:transparent">
                <h3 class="widget-title">Data Pengguna </h3>
            </div>

            <div class="clearfix"></div>

            <div class="widget-content pad20f">

                <div class="form-group">
                    <label class="col-sm-4 control-label"><strong>Nama Pengguna</strong></label>
                    <div class="col-sm-8">
                        <p class="form-control-static">: {{ $user->username }}</p>
                    </div>
                </div>	
                	
                <div class="form-group">
                    <label class="col-sm-4 control-label"><strong>Email</strong></label>
                    <div class="col-sm-8">
                        <p class="form-control-static">: {{ $user->email }}</p>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-4 control-label"><strong>No Telp</strong></label>
                    <div class="col-sm-8"> 
                        @if($user->jenis_user=='karyawan')
                        <p class="form-control-static">: {{ $user->karyawan->telp }}</p>
                        @else
                         <p class="form-control-static">: {{ $user->pelanggan->telp }}</p>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><strong>Alamat</strong></label>
                    <div class="col-sm-8">
                           @if($user->jenis_user=='karyawan')
                        <p class="form-control-static">: {{ $user->karyawan->alamat }}</p>
                           @else
                  <p class="form-control-static">: {{ $user->pelanggan->alamat }}</p>
                            @endif
                    </div>
                </div>  
                <div class="form-group">
                    <label class="col-sm-4 control-label"><strong>Dibuat Tanggal</strong></label>
                    <div class="col-sm-8">
                        <p class="form-control-static">: {{ Carbon\Carbon::parse($user->created_at)->format('d M Y') }}</p>
                    </div>
                </div>	

            </div> <!-- /widget-content -->
             
        </div> <!-- /widget -->
    </div> <!-- /fluid -->

</div> <!-- /main -->
@endsection