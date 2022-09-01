@extends('layouts.jnb.app')

@section('content')	
<div id="main" class="clearfix">
    <div class="secInfo">
        <h1 class="secTitle">Tambah Pengguna</h1>
        <span class="secExtra">Form untuk menambahkan data pengguna</span>
    </div> <!-- /SecInfo -->
    <div class="fluid">
        <div class="widget leftcontent grid12">
            <form id="penggunaForm" class="form-horizontal" method="POST" action="{{ url('/') }}/tambah-pengguna">
                {!! csrf_field() !!}
                <div class="widget-content pad20f">
                    <div class="form-group {{ $errors->has('jenis_user') ? ' has-error' : '' }}">
                        <label class="col-sm-3 control-label">Jenis User <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-blue btn-default @if (old('jenis_user')=='karyawan') active @endif">
                                    <input type="radio" name="jenis_user" value="karyawan" @if (old('jenis_user')=='karyawan') checked @endif autocomplete="off">
                                           Karyawan
                                </label>
                                <label class="btn btn-orange btn-default @if (old('jenis_user')=='pelanggan') active @endif">
                                    <input type="radio" name="jenis_user" value="pelanggan" @if (old('jenis_user')=='pelanggan') checked @endif autocomplete="off">
                                           Pelanggan
                                </label>
                            </div>
                            <span class="help-block"><small>silahkan klik salah satu tab untuk memilih (tab terpilih akan berubah warna menjadi abu-abu)</small></span>
                        </div>
                    </div>
                    <div id="field_karyawan"class="form-group">
                        <label for="nama_karyawan" class="col-sm-3 control-label">Nama Karyawan</label>
                        <div class="col-sm-9">
                            <select class="form-control select2" id="karyawan_id" name="karyawan_id">
                                <option value="">Pilih Karyawan</option>
                                @foreach($data_karyawan as $data) 
                                <option value="{{$data->id}}">{{$data->nama_karyawan}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>   
                    <div id="field_pelanggan" class="form-group">
                        <label for="nama_pelanggan" class="col-sm-3 control-label">Nama Pelanggan</label>
                        <div class="col-sm-9">
                            <select class="form-control select2" id="pelanggan_id" name="pelanggan_id">
                                <option value="">Pilih Pelanggan</option>
                                @foreach($data_pelanggan as $data) 
                                <option value="{{$data->id}}">{{$data->nama_pelanggan}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>   
                    <div   class="form-group">
                        <label for="role" class="col-sm-3 control-label">Role</label>
                        <div class="col-sm-9">
                            <select class="form-control select2" id="role" name="role">
                                <option value="">Pilih Role</option> 
                                <option value="AA">Admin Access</option> 
                                <option value="SA">Staff Access</option> 
                                <option value="PA">Pelanggan Access</option> 
                                <option value="OA">Ower Access</option> 
                            </select>
                        </div>
                    </div>   
                    <div class="form-group {{ $errors->has('username') ? ' has-error' : '' }}">
                        <label for="username" class="col-sm-3 control-label">Username <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" name="username" value="{{ old('username') }}" class="form-control" id="username">
                            @if ($errors->has('username'))
                            <code>{{ $errors->first('username') }}</code>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="col-sm-3 control-label">Email <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control" id="email">
                            @if ($errors->has('email'))
                            <code>{{ $errors->first('email') }}</code>
                            @endif
                        </div>
                    </div> 
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Password <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <p class="form-control-static text-danger">password123</p>
                            <span class="help-block"><small>password default dari pengguna</small></span>
                        </div>
                    </div>
                </div> 
                <hr/>
                <div class="widget-content pad20f">
                    <div class="form-group">
                        <div class="col-sm-6">
                            <a href="{{ url('/home') }}" class="btn btn-dark-grey"><i class="fa fa-undo"></i> KEMBALI</a>
                        </div>
                        <div class="col-sm-6 text-right">
                            <button id="proses" type="button" class="btn"><i class="fa fa-save"></i> PROSES</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div> <!-- /fluid -->

</div> <!-- /main -->
@endsection
@push('scripts')
<link rel="stylesheet" href="{{ asset('jnb/css/bootstrap-datepicker3.min.css') }}" />
<script type="text/javascript" src="{{ asset('jnb/js/bootstrap-datepicker.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('jnb/css/select2-4.0.3.css') }}" />
<script type="text/javascript" src="{{ asset('jnb/js/select2.min.js') }}"></script>
<script>
$(document).ready(function () { 
    
     $('#karyawan_id').select2({
         placeholder: "Silahkan pilih Karyawan",
         allowClear: true,
        });
     $('#pelanggan_id').select2({
         placeholder: "Silahkan pilih Pelanggan",
         allowClear: true,
        });
    $('input:radio[name=jenis_user]').change(function () {
        if (this.value == 'karyawan')
        {
             $('#field_pelanggan').addClass('hide');
             $('#field_karyawan').removeClass('hide');
             $('#field_karyawan').addClass('form-group');
        } 
        else
        {
             $('#field_pelanggan').removeClass('hide');
             $('#field_pelanggan').addClass('form-group');
             $('#field_karyawan').addClass('hide'); 
        }
            
    });
    $('#proses').on('click', function () {
        $(this).prop('disabled', true);
        $("#penggunaForm").submit();
    })
});
</script>    
@endpush