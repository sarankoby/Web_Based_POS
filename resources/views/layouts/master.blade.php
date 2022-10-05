<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Web Based POS</title>
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/app.min.css') }}">
    <!-- Template CSS -->
    <link rel="stylesheet" href="assets/bundles/fullcalendar/fullcalendar.min.css">
    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/datatables.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bundles/pretty-checkbox/pretty-checkbox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bundles/summernote/summernote-bs4.css') }}">



    <!-- Custom style CSS -->

    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel='shortcut icon' type='image/x-icon' href="{{ asset('assets/img/favicon.ico') }}" />
    {{-- <link rel="stylesheet" href="{{ asset('assets/bundles/fullcalendar/fullcalendar.min.css') }}"> --}}
    @livewireStyles
</head>

<body>

    {{-- header --}}
    <?php $access = session()->get('Controls'); ?>

    <div class="loader"></div>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar sticky">
                <div class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li>
                            <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg collapse-btn">
                                <i data-feather="align-justify"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link nav-link-lg fullscreen-btn">
                                <i data-feather="maximize"></i>
                            </a>
                        </li>

                    </ul>
                </div>
                <ul class="navbar-nav navbar-right">
                    {{-- <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                            class="nav-link nav-link-lg message-toggle"><i data-feather="mail"></i>
                            <span class="badge headerBadge1">
                                1 </span> </a>
                        <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
                            <div class="dropdown-header">
                                NEWS
                                <div class="float-right">
                                    <a href="#">Mark All As Read</a>
                                </div>
                            </div>
                            <div class="dropdown-list-content dropdown-list-message">
                                <a href="#" class="dropdown-item"> <span
                                        class="dropdown-item-avatar
                                              text-white">
                                        <img alt="image" src="{{ asset('assets/img/users/user-1.png') }}"
                                            class="rounded-circle">
                                    </span> <span class="dropdown-item-desc"> <span class="message-user">John
                                            Deo</span>
                                        <span class="time messege-text">Please check your mail !!</span>
                                        <span class="time">2 Min Ago</span>
                                    </span>
                                </a> <a href="#" class="dropdown-item"> <span
                                        class="dropdown-item-avatar text-white">
                                        <img alt="image" src="{{ asset('assets/img/users/user-2.png') }}"
                                            class="rounded-circle">
                                    </span> <span class="dropdown-item-desc"> <span class="message-user">Sarah
                                            Smith</span> <span class="time messege-text">Request for leave
                                            application</span>
                                        <span class="time">5 Min Ago</span>
                                    </span>
                                </a> <a href="#" class="dropdown-item"> <span
                                        class="dropdown-item-avatar text-white">
                                        <img alt="image" src="{{ asset('assets/img/users/user-5.png') }}"
                                            class="rounded-circle">
                                    </span> <span class="dropdown-item-desc"> <span class="message-user">Jacob
                                            Ryan</span> <span class="time messege-text">Your payment invoice is
                                            generated.</span> <span class="time">12 Min Ago</span>
                                    </span>
                                </a> <a href="#" class="dropdown-item"> <span
                                        class="dropdown-item-avatar text-white">
                                        <img alt="image" src="{{ asset('assets/img/users/user-4.png') }}"
                                            class="rounded-circle">
                                    </span> <span class="dropdown-item-desc"> <span class="message-user">Lina
                                            Smith</span> <span class="time messege-text">hii John, I have upload
                                            doc
                                            related to task.</span> <span class="time">30
                                            Min Ago</span>
                                    </span>
                                </a> <a href="#" class="dropdown-item"> <span
                                        class="dropdown-item-avatar text-white">
                                        <img alt="image" src="{{ asset('assets/img/users/user-3.png') }}"
                                            class="rounded-circle">
                                    </span> <span class="dropdown-item-desc"> <span class="message-user">Jalpa
                                            Joshi</span> <span class="time messege-text">Please do as specify.
                                            Let me
                                            know if you have any query.</span> <span class="time">1
                                            Days Ago</span>
                                    </span>
                                </a> <a href="#" class="dropdown-item"> <span
                                        class="dropdown-item-avatar text-white">
                                        <img alt="image" src="{{ asset('assets/img/users/user-2.png') }}"
                                            class="rounded-circle">
                                    </span> <span class="dropdown-item-desc"> <span class="message-user">Sarah
                                            Smith</span> <span class="time messege-text">Client Requirements</span>
                                        <span class="time">2 Days Ago</span>
                                    </span>
                                </a>
                            </div>
                            <div class="dropdown-footer text-center">
                                <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </li> --}}
                    {{-- <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                            class="nav-link notification-toggle nav-link-lg"><i data-feather="bell"
                                class="bell"></i>
                        </a>
                        <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
                            <div class="dropdown-header">
                                NOTIFICATION
                                <div class="float-right">
                                    <a href="#">Mark All As Read</a>
                                </div>
                            </div>
                            <div class="dropdown-list-content dropdown-list-icons">
                                <a href="#" class="dropdown-item dropdown-item-unread"> <span
                                        class="dropdown-item-icon bg-primary text-white"> <i
                                            class="fas
                                                  fa-code"></i>
                                    </span> <span class="dropdown-item-desc"> Template update is
                                        available now! <span class="time">2 Min
                                            Ago</span>
                                    </span>
                                </a> <a href="#" class="dropdown-item"> <span
                                        class="dropdown-item-icon bg-info text-white"> <i
                                            class="far
                                                  fa-user"></i>
                                    </span> <span class="dropdown-item-desc"> <b>You</b> and <b>Dedik
                                            Sugiharto</b> are now friends <span class="time">10 Hours
                                            Ago</span>
                                    </span>
                                </a> <a href="#" class="dropdown-item"> <span
                                        class="dropdown-item-icon bg-success text-white"> <i
                                            class="fas
                                                  fa-check"></i>
                                    </span> <span class="dropdown-item-desc"> <b>Kusnaedi</b> has
                                        moved task <b>Fix bug header</b> to <b>Done</b> <span class="time">12
                                            Hours
                                            Ago</span>
                                    </span>
                                </a> <a href="#" class="dropdown-item"> <span
                                        class="dropdown-item-icon bg-danger text-white"> <i
                                            class="fas fa-exclamation-triangle"></i>
                                    </span> <span class="dropdown-item-desc"> Low disk space. Let's
                                        clean it! <span class="time">17 Hours Ago</span>
                                    </span>
                                </a> <a href="#" class="dropdown-item"> <span
                                        class="dropdown-item-icon bg-info text-white"> <i
                                            class="fas
                                                  fa-bell"></i>
                                    </span> <span class="dropdown-item-desc"> Welcome to Otika
                                        template! <span class="time">Yesterday</span>
                                    </span>
                                </a>
                            </div>
                            <div class="dropdown-footer text-center">
                                <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </li> --}}
                    <li class="dropdown"><a href="#" data-toggle="dropdown"
                            class="nav-link dropdown-toggle nav-link-lg nav-link-user"> <img alt="image"
                                src="{{ asset('assets/img/icons8-user-96.png') }}" class="user-img-radious-style"> <span
                                class="d-sm-none d-lg-inline-block"></span></a>
                        <div class="dropdown-menu dropdown-menu-right pullDown">
                            <div class="dropdown-title text-sm">
                                {{ Auth::user()->name }}

                            </div>

                            <div class="dropdown-divider"></div>
                            <a href="/logout" class="dropdown-item has-icon text-danger"> <i
                                    class="fas fa-sign-out-alt"></i>
                                Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>

            <div class="main-sidebar sidebar-style-2">
                <aside id="sidebar-wrapper">
                    <div class="sidebar-brand">
                        <a href="#"> <img alt="image" src="{{ asset('assets/img/logo.png') }}"
                                class="header-logo" />
                            <span class="logo-name">POS</span>
                        </a>
                    </div>
                    <ul class="sidebar-menu">
                        <li class="menu-header">Main</li>
                        <li class="dropdown @stack('category', '') @stack('brand', '') @stack('measurement', '') @stack('item', '')">
                            <a href="#" class="menu-toggle nav-link has-dropdown">
                                <i class="fas fa-weight"></i><span>New</span></a>
                            <ul class="dropdown-menu">
                                <li class="dropdown @stack('category', '')">
                                    <a href="/category" class="nav-link"><span>Category</span></a>
                                </li>

                                <li class="dropdown @stack('brand', '')">
                                    <a href="/brand" class="nav-link"><span>Brand</span></a>
                                </li>

                                <li class="dropdown @stack('measurement', '')">
                                    <a href="/measurement" class="nav-link"><span>Measurements</span></a>
                                </li>

                                <li class="dropdown @stack('item', '')">
                                    <a href="/item" class="nav-link"><span>Item(s)</span></a>
                                </li>

                            </ul>
                        </li>






                        <li class="dropdown @stack('company', '') @stack('dealer', '') @stack('purchase', '')">
                            <a href="#" class="menu-toggle nav-link has-dropdown">
                                <i class="fab fa-cuttlefish"></i><span>Purchase</span></a>
                            <ul class="dropdown-menu">
                                <li class="dropdown @stack('company', '')">
                                    <a href="/company" class="nav-link"><span>Company</span></a>
                                </li>

                                <li class="dropdown @stack('dealer', '')">
                                    <a href="/dealer" class="nav-link"><span>Dealer</span></a>
                                </li>

                                <li class="dropdown @stack('purchase', '')">
                                    <a href="/purchase-invoice" class="nav-link"><span>Invoice & Stock</span></a>
                                </li>

                            </ul>
                        </li>



                        <li class="dropdown @stack('stock-transfer', '')">
                            <a href="#" class="menu-toggle nav-link has-dropdown">
                                <i class="fas fa-building"></i><span>Stock</span></a>
                            <ul class="dropdown-menu">


                                <li class="dropdown @stack('stock-transfer', '')">
                                    <a href="/stock-transfer" class="nav-link"><span>Stock Transfer</span></a>
                                </li>

                            </ul>
                        </li>



                        <li class="menu-header">CUSTOMER</li>
                        <li class="dropdown @stack('customer', '') @stack('shop', '')">
                            <a href="#" class="menu-toggle nav-link has-dropdown">
                                <i class="fas fa-user-friends"></i><span>Customers</span></a>
                            <ul class="dropdown-menu">
                                <li class="dropdown @stack('customer', '')">
                                    <a href="/customer" class="nav-link"><span>Customers</span></a>
                                </li>

                                <li class="dropdown @stack('shop', '')">
                                    <a href="/shop" class="nav-link"><span>Shop</span></a>
                                </li>

                            </ul>
                        </li>

                        <li class="dropdown @stack('sale', '') @stack('return', '')">
                            <a href="#" class="menu-toggle nav-link has-dropdown">
                                <i class="fas fa-dolly"></i><span>Sales</span></a>
                            <ul class="dropdown-menu">
                                <li class="dropdown @stack('sale', '')">
                                    <a href="/sale" class="nav-link"><span>Sales</span></a>
                                </li>

                                <li class="dropdown @stack('shop', '')">
                                    <a href="#" class="nav-link"><span>Return</span></a>
                                </li>

                            </ul>
                        </li>



                        <li class="menu-header">Accounts</li>

                        <li class="dropdown">
                            <a href="#" class="menu-toggle nav-link has-dropdown"><i
                                class="fas fa-donate"></i><span>Account</span></a>
                            <ul class="dropdown-menu">
                                <li><a class="nav-link" href="/bank">Bank</a></li>
                                <li><a class="nav-link" href="/expence-type">Expence Type</a></li>
                                <li><a class="nav-link" href="#">Expence</a></li>
                                <li><a class="nav-link" href="#">Cheque</a></li>
                            </ul>
                        </li>




                        {{-- <li><a class="nav-link" @stack('sale') href="/sale">dadsa</a></li> --}}


                        <li class="dropdown">
                            <a href="#" class="menu-toggle nav-link has-dropdown"><i
                                class="fas fa-file-invoice"></i><span>Reports</span></a>
                            <ul class="dropdown-menu">
                                <li><a class="nav-link" href="/#">Report 1</a></li>
                                <li><a class="nav-link" href="/#">Report 2</a></li>
                                <li><a class="nav-link" href="/#">Report 3</a></li>
                            </ul>
                        </li>

                        {{-- admin --}}
                      
                                <li class="menu-header">ADMINSTRITION</li>
                                @if (in_array('access-model', $access) || in_array('user-type', $access) || in_array('users', $access))

                            <li class="dropdown @stack('access-model', '') @stack('user-type', '') @stack('users', '')">
                                <a href="#" class="menu-toggle nav-link has-dropdown">
                                    <i class="fas fa-user-check"></i><span>Auth</span></a>
                                <ul class="dropdown-menu">

                                    @if (in_array('access-model', $access))
                                        <li class="dropdown @stack('auth', '')">
                                            <a href="/access-model" class="nav-link"><span>Access-Model</span></a>
                                        </li>
                                    @endif

                                    @if (in_array('user-type', $access))
                                        <li class="dropdown @stack('user-type', '')">
                                            <a href="/user-type" class="nav-link"><span>User-Types</span></a>
                                        </li>
                                    @endif

                                    @if (in_array('users', $access))

                                        <li class="dropdown @stack('users', '')">
                                            <a href="/users" class="nav-link"><span>User</span></a>
                                        </li>
                                    @endif

                                </ul>
                            </li>
                            @endif

                    </ul>
                </aside>
            </div>

            <!-- Main Content -->
            {{-- <div class="main-content">
                <section class="section">
                    <div class="section-body">
                        <!-- add content here -->
                        {{ $slot }}
                    </div>
                </section>
            </div> --}}

            <!-- Main Content -->
            <div class="main-content">

                <!-- add content here -->
                {{ $slot }}


            </div>


            <div class="settingSidebar">
                <a href="javascript:void(0)" class="settingPanelToggle"> <i class="fa fa-spin fa-cog"></i>
                </a>
                <div class="settingSidebar-body ps-container ps-theme-default">
                    <div class=" fade show active">
                        <div class="setting-panel-header">Setting Panel
                        </div>
                        <div class="p-15 border-bottom">
                            <h6 class="font-medium m-b-10">Select Layout</h6>
                            <div class="selectgroup layout-color w-50">
                                <label class="selectgroup-item">
                                    <input type="radio" name="value" value="1"
                                        class="selectgroup-input-radio select-layout" checked>
                                    <span class="selectgroup-button">Light</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="radio" name="value" value="2"
                                        class="selectgroup-input-radio select-layout">
                                    <span class="selectgroup-button">Dark</span>
                                </label>
                            </div>
                        </div>
                        <div class="p-15 border-bottom">
                            <h6 class="font-medium m-b-10">Sidebar Color</h6>
                            <div class="selectgroup selectgroup-pills sidebar-color">
                                <label class="selectgroup-item">
                                    <input type="radio" name="icon-input" value="1"
                                        class="selectgroup-input select-sidebar">
                                    <span class="selectgroup-button selectgroup-button-icon" data-toggle="tooltip"
                                        data-original-title="Light Sidebar"><i class="fas fa-sun"></i></span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="radio" name="icon-input" value="2"
                                        class="selectgroup-input select-sidebar" checked>
                                    <span class="selectgroup-button selectgroup-button-icon" data-toggle="tooltip"
                                        data-original-title="Dark Sidebar"><i class="fas fa-moon"></i></span>
                                </label>
                            </div>
                        </div>
                        <div class="p-15 border-bottom">
                            <h6 class="font-medium m-b-10">Color Theme</h6>
                            <div class="theme-setting-options">
                                <ul class="choose-theme list-unstyled mb-0">
                                    <li title="white" class="active">
                                        <div class="white"></div>
                                    </li>
                                    <li title="cyan">
                                        <div class="cyan"></div>
                                    </li>
                                    <li title="black">
                                        <div class="black"></div>
                                    </li>
                                    <li title="purple">
                                        <div class="purple"></div>
                                    </li>
                                    <li title="orange">
                                        <div class="orange"></div>
                                    </li>
                                    <li title="green">
                                        <div class="green"></div>
                                    </li>
                                    <li title="red">
                                        <div class="red"></div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="p-15 border-bottom">
                            <div class="theme-setting-options">
                                <label class="m-b-0">
                                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input"
                                        id="mini_sidebar_setting">
                                    <span class="custom-switch-indicator"></span>
                                    <span class="control-label p-l-10">Mini Sidebar</span>
                                </label>
                            </div>
                        </div>
                        <div class="p-15 border-bottom">
                            <div class="theme-setting-options">
                                <label class="m-b-0">
                                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input"
                                        id="sticky_header_setting">
                                    <span class="custom-switch-indicator"></span>
                                    <span class="control-label p-l-10">Sticky Header</span>
                                </label>
                            </div>
                        </div>
                        <div class="mt-4 mb-4 p-3 align-center rt-sidebar-last-ele">
                            <a href="#" class="btn btn-icon icon-left btn-primary btn-restore-theme">
                                <i class="fas fa-undo"></i> Restore Default
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <footer class="main-footer">
            <div class="footer-left">
                <a href="#"></a></a>
            </div>
            <div class="footer-right">
            </div>
        </footer>

        @yield('model')
    </div>
    </div>
    {{-- end header --}}
    @livewireScripts
    <!-- General JS Scripts -->
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/summernote/summernote-bs4.js') }}"></script>
    <!-- JS Libraies -->
    <script src="{{ asset('assets/bundles/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('assets/js/page/advance-table.js') }}"></script>
    <script src="{{ asset('assets/bundles/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>

    {{-- <script src="{{ asset('assets/bundles/datatables/export-tables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/datatables/export-tables/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/datatables/export-tables/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/datatables/export-tables/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/datatables/export-tables/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/bundles/datatables/export-tables/buttons.print.min.js') }}"></script> --}}


    <!-- Template JS File -->
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <!-- Custom JS File -->
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script src="{{ asset('assets/bundles/fullcalendar/fullcalendar.min.js') }}"></script>
    <!-- Page Specific JS File -->
    <script>
        // this is for insert
        window.addEventListener('insert-show-form', event => {
            $('#insert-model').modal('show');
        });
        window.addEventListener('insert-hide-form', event => {
            $('#insert-model').modal('hide');
        });

        // this is for delete
        window.addEventListener('delete-show-form', event => {
            $('#delete-model').modal('show');
        });

        window.addEventListener('delete-hide-form', event => {
            $('#delete-model').modal('hide');
        });


        window.addEventListener('change-focus-other-field', event => {
            $('#search_bar').focus();
        });
    </script>
</body>

</html>
