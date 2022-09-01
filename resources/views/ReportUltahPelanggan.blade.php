<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Laporan Rekap Detail</title>
        <style type="text/css">
            body{
                font-family: 'Dejavu Sans';
                font-size: 12px;
            }
            .widget-content.pad20f {
                padding: 0 20px 20px;
            }
            h3{
                font-size: 18px;
                line-height: 20px;
                margin-bottom: 40px
            }
            p{
                margin: 0;
                padding: 0;
                text-align: justify;
            }
            table.data thead tr{
                background: #efefef;
                padding: 4px 0;
            }
            table.data tr td{
                font-size: 10px;
            }
        </style>
    </head>
    <body>
        <div id="wrapper" class="container">
            <div id="main" class="form-horizontal clearfix">
                <div class="widget-content pad20f">
                    <div class="form-group">
                        <h3 align="center"><strong>LAPORAN ULTAH PELANGGAN</strong></h3>
                        <h4 align="center"><strong>Per Tanggal : {{date('d-m-Y')}} </strong></h4>
                    </div>
                    <table cellspacing="0" width="100%">
                        <tr>
                            <td width="10%">Nama Coach</td>
                            <td>: {{$namaCoach}} </td>
                        </tr> 
                    </table>
                    <p>&nbsp;</p>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <table class="data" cellspacing="0" cellpadding="2" width="100%" border="1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>No Telp</th> 
                                        <th>Tgl Lahir</th>
                                        <th>Umur Sekarang</th> 
                                        <th>Alamat </th>   
                                        <th>Hari Ultah </th>  
                                    </tr>
                                </thead>
                                <tbody>
                                
                                     @foreach ($datas as $key => $item)
                                    <tr>    
                                        <td align="center">{{$key+1}}</td> 
                                        <td>{{$item->nama_pelanggan}}</td>  
                                        <td>{{$item->telp}}</td>  
                                         <td align="center">{{tgl_indo($item->tgl_lahir)}}</td> 
                                         <td>{{hitungUmurs($item->tgl_lahir)}}</td>  
                                         <td>{{$item->alamat}}</td>  
                                         <td>{{hitungHariLahir($item->tgl_lahir)}}</td>  
                                    @endforeach
                                </tbody>
                                 
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </body>
</html>