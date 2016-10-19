<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        {{-- <img src="img/logo-bg-white.png" class="img-responsive"> --}}
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="{{Request::is('home') ? 'active':''}}" >
                <a href="home"> <i class="fa fa-home"></i> <span>Home</span> </a>
            </li>



            <!--Menu Inventory-->
            <li class="treeview {{Request::is('master/*') ? 'active':''}}" >
                <a href="#">
                    <i class="fa fa-th"></i>
                    <span>Master</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{Request::is('master/user*') ? 'active':''}}" ><a href="master/user"><i class="fa fa-circle-o"></i> User</a></li>
                    <li class="{{Request::is('master/poli*') ? 'active':''}}" ><a href="master/poli"><i class="fa fa-circle-o"></i> Poli</a></li>
                    <li class="{{Request::is('master/dokter*') ? 'active':''}}" ><a href="master/dokter"><i class="fa fa-circle-o"></i> Dokter</a></li>
                    <li class="{{Request::is('master/shift*') ? 'active':''}}" ><a href="master/shift"><i class="fa fa-circle-o"></i> Shift Kerja</a></li>
                    <li class="{{Request::is('master/karyawan*') ? 'active':''}}" ><a href="master/karyawan"><i class="fa fa-circle-o"></i> Karyawan</a></li>
                    {{-- <li class="{{Request::is('master/obat*') ? 'active':''}}" ><a href="master/obat"><i class="fa fa-circle-o"></i> Obat</a></li> --}}
                    <li class="{{Request::is('master/pasien*') ? 'active':''}}" ><a href="master/pasien"><i class="fa fa-circle-o"></i> Pasien</a></li>
                    <li class="{{Request::is('master/supplier*') ? 'active':''}}" ><a href="master/supplier"><i class="fa fa-circle-o"></i> Supplier</a></li>
                </ul>
            </li>

            <li class="treeview {{Request::is('inventory/*') ? 'active':''}}" >
                <a href="#">
                    <i class="fa fa-briefcase"></i>
                    <span>Inventory</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{Request::is('inventory/satuan*') ? 'active':''}}" ><a href="inventory/satuan"><i class="fa fa-circle-o"></i> Satuan</a></li>
                    <li class="{{Request::is('inventory/obat*') ? 'active':''}}" ><a href="inventory/obat"><i class="fa fa-circle-o"></i> Obat</a></li>
                    <li class="{{Request::is('inventory/mutasi*') ? 'active':''}}" ><a href="inventory/mutasi"><i class="fa fa-circle-o"></i> Mutasi</a></li>
                </ul>
            </li>

            <li class="treeview {{Request::is('invoice/*') ? 'active':''}}" >
                <a href="#">
                    <i class="fa fa-newspaper-o"></i>
                    <span>Invoice</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{Request::is('invoice/supplier-bill*') ? 'active':''}}" ><a href="invoice/supplier-bill"><i class="fa fa-circle-o"></i> Bon Obat</a></li>
                </ul>
            </li>

            {{-- <li class="treeview {{Request::is('purchase/*') ? 'active':''}}" >
                <a href="#">
                    <i class="fa fa-calculator"></i>
                    <span>Purchases</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{Request::is('purchase/order*') ? 'active':''}}" ><a href="purchase/order"><i class="fa fa-circle-o"></i> Purchase Orders</a></li>
                </ul>
            </li> --}}

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
