<!-- Navbar STart -->
<header id="topnav" class="defaultscroll sticky">
    <div class="container">
        <!-- Logo container-->
        <a class="logo" href="/">
            <img src="assets/images/logo-dark.png" height="24" class="logo-light-mode" alt="">
            <img src="assets/images/logo-light.png" height="24" class="logo-dark-mode" alt="">
        </a>
        <!-- Logo End -->

        <div class="menu-extras">
            <div class="menu-item">
                <!-- Mobile menu toggle-->
                <a class="navbar-toggle" id="isToggle" onclick="toggleMenu()">
                    <div class="lines">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </a>
                <!-- End mobile menu toggle-->
            </div>
        </div>

        <!--Login button Start-->
        {{-- <ul class="buy-button list-inline mb-0">
            <li class="list-inline-item mb-0">
                <a href="javascript:void(0)" class="btn btn-icon btn-light">
                    <img src="assets/images/app/app-store.png" class="avatar avatar-ex-small p-1" alt="">
                </a>
            </li>
    
            <li class="list-inline-item mb-0">
                <a href="javascript:void(0)" class="btn btn-icon btn-light">
                    <img src="assets/images/app/play-store.png" class="avatar avatar-ex-small p-1" alt="">
                </a>
            </li>
        </ul> --}}
        <!--Login button End-->

        <div id="navigation">
            <!-- Navigation Menu-->   
            <ul class="navigation-menu">
                <li><a href="/" class="sub-menu-item">Home</a></li>
                <li><a href="/" class="sub-menu-item">Precios</a></li>
                <li><a href="/" class="sub-menu-item">Demo</a></li>
                
                
                
                <li class="has-submenu parent-menu-item">
                    <a href="javascript:void(0)">Modulos</a><span class="menu-arrow"></span>
                    <ul class="submenu">
                        <li><a href="documentation.html" class="sub-menu-item">Facturación POS</a></li>
                        <li><a href="changelog.html" class="sub-menu-item">Ingresos y Gastos</a></li>
                        <li><a href="widget.html" class="sub-menu-item">Inventario</a></li>
                        <li><a href="widget.html" class="sub-menu-item">Facturación Electrónica</a></li>
                        <li><a href="widget.html" class="sub-menu-item">Reportes</a></li>
                    </ul>
                </li>
                <li><a href="{{route('login')}}" class="sub-menu-item">TimeLine</a></li>
                <li><a href="{{route('login')}}" class="sub-menu-item">Login</a></li>
            </ul><!--end navigation menu-->
        </div><!--end navigation-->
    </div><!--end container-->
</header><!--end header-->
<!-- Navbar End -->