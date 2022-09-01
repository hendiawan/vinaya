<div id="profile">
    <div class="wrapper20">
        <div class="userInfo">
            <div class="userImg"> 
                <img src="{{ asset('assets/img') }}/user.jpg" rel="user">	 
            </div>
            <div class="userTxt">
                @if(Auth::user()->role=='AA')
                <span class="fullname">ADMIN</span> <i class="fa fa-chevron-right"></i><br>
                @endif
                @if(Auth::user()->role=='SA')
                <span class="fullname">COACH</span> <i class="fa fa-chevron-right"></i><br>
                @endif
                @if(Auth::user()->role=='PA')
                <span class="fullname">PELANGGAN</span> <i class="fa fa-chevron-right"></i><br>
                @endif
                @if(Auth::user()->role=='OA')
                <span class="fullname">OWNER</span> <i class="fa fa-chevron-right"></i><br>
                @endif
                <span class="username">{{strtoupper(Auth::user()->username)}}</span>
            </div>
        </div> <!-- /userInfo -->
        @can('admin-access')
        <div class="userStats"> 
            <div class="uStat graph">
                <!--<div id="stats_visits" class="stat-chart" values="0,0,0,0,0,0,0,0,0,0,0,0,0"></div>-->
                <div class="stat-name">
                        Penjualan (Qty)
                </div>
                @php 
         
                @endphp
                <div class="stat-number">{{$penjualan_all}}</div>

            </div>
            <div class="uStat graph">
<!--                <div id="stats_balance" class="stat-chart" values="0,0,0,0,0,0,0,0,0,0,0,0,0"></div>-->
                <div class="stat-name">
                    All Stock
                </div>
                <div class="stat-number">{{$stok_all}}</div>
            </div>
            <div class="uStat graph">
                <!--<div id="stats_balance" class="stat-chart" values="0,0,0,0,0,0,0,0,0,0,0,0,0"></div>-->
                <div class="stat-name">
                    Shake
                </div>
                <div class="stat-number">{{$shake}}</div>
            </div>
            <div class="uStat graph">
                <!--<div id="stats_balance" class="stat-chart" values="0,0,0,0,0,0,0,0,0,0,0,0,0"></div>-->
                <div class="stat-name">
                    Aloe
                </div>
                <div class="stat-number">{{$aloe}}</div>
            </div>
            <div class="uStat graph">
                <!--<div id="stats_balance" class="stat-chart" values="0,0,0,0,0,0,0,0,0,0,0,0,0"></div>-->
                <div class="stat-name">
                    NRG
                </div>
                <div class="stat-number">{{$nrg}}</div>
            </div>
        </div>
        @endcan
        @can('owner-access')
        <div class="userStats"> 
            <div class="uStat graph">
                <div id="stats_visits" class="stat-chart" values="0,0,0,0,0,0,0,0,0,0,0,0,0"></div>
                <div class="stat-name">
                    Jumlah Penjualan (Qty)
                </div>
                @php 
         
                @endphp
                <div class="stat-number">{{$penjualan_all}}</div>

            </div>
            <div class="uStat graph">
                <div id="stats_balance" class="stat-chart" values="0,0,0,0,0,0,0,0,0,0,0,0,0"></div>
                <div class="stat-name">
                    All Stock
                </div>
                <div class="stat-number">{{$stok_all}}</div>
            </div>
        </div>
        @endcan
       
       
        @can('staff-access')
        <div class="userStats"> 
            <div class="uStat graph">
                <div id="stats_visits" class="stat-chart" values="0,0,0,0,0,0,0,0,0,0,0,0,0"></div>
                <div class="stat-name">
                    Penjualan Paket
                </div> 
                <div class="stat-number">{{$penjualan_all}}</div> 
            </div>
            <div class="uStat graph">
                <div id="stats_balance" class="stat-chart" values="0,0,0,0,0,0,0,0,0,0,0,0,0"></div>
                <div class="stat-name">
                    Sisa Stok
                </div>
                <div class="stat-number">{{$stok_all}}</div>
            </div>
        </div>
        @endcan
        
        <i class="fa fa-bars icon-nav-mobile"></i>

    </div>
</div> <!-- /profile -->