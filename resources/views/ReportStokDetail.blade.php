<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Laporan Rekap Stok</title>
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
                        <h3 align="center"><strong>LAPORAN REKAP STOK COACH</strong></h3>
                        <h4 align="center"><strong>Periode S/D {{$tglSelesai}} </strong></h4>
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
                                        <th>Nama Coach</th>  
                                        <th>Nama Barang</th> 
                                        <th>Stok </th> 
                                        <th>Takaran </th> 
                                        <th>Kaleng </th> 
                                        <th>Porsi </th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                     @php
                                            $totalPorsi = 0;
                                            $totalKaleng = 0;
                                            
                                            $totalShake = 0;
                                            $totalNRG = 0;
                                            $totalAloe = 0;
                                            
                                             $totalKalengShake = 0;
                                             $totalKalengNRG = 0;
                                             $totalKalengAloe = 0;
                                             
                                             $totalPorsiShake = 0;
                                             $totalPorsiNRG = 0;
                                             $totalPorsiAloe = 0;
                                            
                                     @endphp
                                     @foreach ($data_stok as $key => $item)
                                     @php 
                                            $porsi = $item->stok%$item->barang->takaran;
                                            $kaleng =($item->stok-$porsi)/$item->barang->takaran;
                                            
                                            if ($item->barang->nama_barang=="SHAKE"){
                                                 $totalShake+=$item->stok;
                                                 $totalKalengShake+=$kaleng;
                                                 $totalPorsiShake+=$porsi;
                                            }
                                            
                                            if ($item->barang->nama_barang=="NRG"){
                                                 $totalNRG+=$item->stok;
                                                 $totalKalengNRG+=$kaleng;
                                                 $totalPorsiNRG+=$porsi;
                                            }
                                            
                                            if ($item->barang->nama_barang=="ALOE"){
                                                 $totalAloe+=$item->stok;
                                                 $totalKalengAloe+=$kaleng;
                                                 $totalPorsiAloe+=$porsi;
                                            }
                                            
                                            
                                          
                                    @endphp
                                    <tr>
                                        <td align="center">{{$key+1}}</td>  
                                        <td>{{$item->sales->karyawan->nama_karyawan}}</td> 
                                        <td>{{$item->barang->nama_barang}}</td> 
                                        <td align="right">{{$item->stok}}</td>                   
                                        <td align="right">{{$item->barang->takaran}}</td>                   
                                        <td align="right">{{$kaleng }}</td>                   
                                        <td align="right">{{$porsi}}</td>                   
                                    </tr>
                                      @php
                                            $totalPorsi+=$porsi;
                                            $totalKaleng+=$kaleng;
                                      @endphp
                                    @endforeach
                              
                                </tbody>
                                <tfoot> 
                                    <tr>
                                        <td colspan="3" align="right"><strong>Total Shake</strong></td> 
                                        <td align="right"><strong>{{ number_format($totalShake   ,0,",",".") }}</strong></td>  
                                        <td align="right"></td> 
                                        <td align="right"><strong>{{$totalKalengShake}}</strong></td> 
                                        <td align="right"><strong>{{ $totalPorsiShake}}</strong></td> 
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="right"><strong>Total NRG</strong></td> 
                                        <td align="right"><strong>{{ number_format($totalNRG   ,0,",",".") }}</strong></td>  
                                        <td align="right"></td> 
                                        <td align="right"><strong>{{$totalKalengNRG}}</strong></td> 
                                        <td align="right"><strong>{{ $totalPorsiNRG}}</strong></td> 
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="right"><strong>Total Aloe</strong></td> 
                                        <td align="right"><strong>{{ number_format($totalAloe   ,0,",",".") }}</strong></td>  
                                        <td align="right"></td> 
                                        <td align="right"><strong>{{$totalKalengAloe}}</strong></td> 
                                        <td align="right"><strong>{{ $totalPorsiAloe}}</strong></td> 
                                    </tr>
                                     <tr>
                                        <td colspan="3" align="right"><strong>Total</strong></td> 
                                        <td align="right"><strong>{{ number_format($sumStok   ,0,",",".") }}</strong></td>  
                                        <td align="right"></td> 
                                        <td align="right"><strong>{{$totalKaleng}}</strong></td> 
                                        <td align="right"><strong>{{ $totalPorsi}}</strong></td> 
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </body>
</html>