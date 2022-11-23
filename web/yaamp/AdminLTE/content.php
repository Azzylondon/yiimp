<?php

require_once 'function.php';

function openMainContent()
{ ?>
   <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__wobble" src="dist/img/logo.png" alt="Logo" height="60" width="60">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <?php

                $action = controller()->action->id;
                $wallet = user()->getState('yaamp-wallet');
                $ad     = isset($_GET['address']);

                showItem_Header(controller()->id == 'site' && $action == 'index' && !$ad, '/', 'Home');
                showItem_Header($action == 'mining', '/site/mining', 'Pool');
                showItem_Header(controller()->id == 'site' && ($action == 'index' || $action == 'wallet') && $ad, "/?address=$wallet", 'Wallet');
                showItem_Header(controller()->id == 'stats', '/stats', 'Graphs');
                showItem_Header($action == 'miners', '/site/miners', 'Miners');
                if (YIIMP_PUBLIC_EXPLORER)
                    showItem_Header(controller()->id == 'explorer', '/explorer', 'Explorers');

                if (YIIMP_PUBLIC_BENCHMARK)
                    showItem_Header(controller()->id == 'bench', '/bench', 'Benchs');

                if (YAAMP_RENTAL)
                    showItem_Header(controller()->id == 'renting', '/renting', 'Rental');

                if (controller()->admin) {
                    if (isAdminIP($_SERVER['REMOTE_ADDR']) === false)
                        debuglog("admin {$_SERVER['REMOTE_ADDR']}");

                    showItem_Header(controller()->id == 'coin', '/coin', 'Coins');
                    showItem_Header($action == 'common', '/site/common', 'Dashboard');
                    showItem_Header(controller()->id == 'site' && $action == 'admin', "/site/admin", 'Wallets');

                    if (YAAMP_RENTAL)
                        showItem_Header(controller()->id == 'renting' && $action == 'admin', '/renting/admin', 'Jobs');

                    if (YAAMP_ALLOW_EXCHANGE)
                        showItem_Header(controller()->id == 'trading', '/trading', 'Trading');

                    if (YAAMP_USE_NICEHASH_API)
                        showItem_Header(controller()->id == 'nicehash', '/nicehash', 'Nicehash');
                }


            ?>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
            <!-- Navbar Search -->
            <li class="nav-item">
                <a class="nav-link" data-widget="navbar-search" href="/?address=<?=$wallet;?>" role="button">
                <i class="fas fa-search"></i>
                </a>
                <div class="navbar-search-block">
                <form class="form-inline">
                    <div class="input-group input-group-sm">
                    <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-navbar" type="submit">
                        <i class="fas fa-search"></i>
                        </button>
                        <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                        <i class="fas fa-times"></i>
                        </button>
                    </div>
                    </div>
                </form>
                </div>
            </li>

            <!-- Messages Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-comments"></i>
                <span class="badge badge-danger navbar-badge">1</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a href="#" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                    <img src="/images/logo.png" alt="imag" class="img-size-50 mr-3 img-circle">
                    <div class="media-body">
                        <h3 class="dropdown-item-title">
                        Test
                        <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                        </h3>
                        <p class="text-sm">test notifications</p>
                        <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 1 Hours Ago</p>
                    </div>
                    </div>
                    <!-- Message End -->
                </a>

                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                </div>
            </li>
            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge">1</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">1 Notification</span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-envelope mr-2"></i> Test messages
                    <span class="float-right text-muted text-sm">3 mins</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                <i class="fas fa-th-large"></i>
                </a>
            </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="/index.php" class="brand-link">
            <img src="/images/logo.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <?php $domain = explode(".",ucwords(YAAMP_SITE_URL))?>
            <span class="brand-text font-weight-light"><?=$domain[0]?></span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                </div>
            </div>

            <!-- SidebarSearch Form -->
            <div class="form-inline">
                <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                    <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                    with font-awesome or any other icon font library -->

              <!--  <li class="nav-item">
                    <a href="pages/widgets.html" class="nav-link">
                    <i class="nav-icon fas fa-th"></i>
                    <p>
                        Widgets
                        <span class="right badge badge-danger">New</span>
                    </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-chart-pie"></i>
                    <p>
                        Explorers
                        <i class="right fas fa-angle-left"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>test-coin</p>
                        </a>
                    </li>
                    </ul>
                </li> -->
                <li class="nav-header">Pool</li>
                    <?php
                    function _showItem_Header($url, $name)
                    {
                        if ($name == "Home")
                            $icon = 'fas fa-tachometer-alt';
                        else if ($name == "Pool")
                            $icon = 'fas fa-table';
                        else if ($name == "Wallet")
                            $icon = 'fas fa-wallet';
                        else if ($name == "Wallets")
                            $icon = 'fas fa-wallet';
                        else if ($name == "Explorers")
                            $icon = 'fas fa-circle';
                        else if ($name == "Coins")
                            $icon = 'fas fa-coins';
                        else
                            $icon = 'fas fa-circle'; // Defaut

                        echo '<li class="nav-item">
                                <a href='.$url.' class="nav-link">
                                <i class="nav-icon '.$icon.'"></i>
                                <p>
                                  '.$name.'
                                </p>
                                </a>
                              </li>';
                    }

                    _showItem_Header(controller()->id == 'site' && $action == 'index' && !$ad, '/', 'Home');
                    _showItem_Header($action == 'mining', '/site/mining', 'Pool');
                    _showItem_Header(controller()->id == 'site' && ($action == 'index' || $action == 'wallet') && $ad, "/?address=$wallet", 'Wallet');
                    _showItem_Header(controller()->id == 'stats', '/stats', 'Graphs');
                    _showItem_Header($action == 'miners', '/site/miners', 'Miners');
                    if (YIIMP_PUBLIC_EXPLORER)
                        _showItem_Header(controller()->id == 'explorer', '/explorer', 'Explorers');

                    if (YIIMP_PUBLIC_BENCHMARK)
                        _showItem_Header(controller()->id == 'bench', '/bench', 'Benchs');

                    if (YAAMP_RENTAL)
                        _showItem_Header(controller()->id == 'renting', '/renting', 'Rental');

                    if (controller()->admin) {
                        if (isAdminIP($_SERVER['REMOTE_ADDR']) === false)
                            debuglog("admin {$_SERVER['REMOTE_ADDR']}");

                        _showItem_Header(controller()->id == 'coin', '/coin', 'Coins');
                        _showItem_Header($action == 'common', '/site/common', 'Dashboard');
                        _showItem_Header(controller()->id == 'site' && $action == 'admin', "/site/admin", 'Wallets');

                        if (YAAMP_RENTAL)
                            _showItem_Header(controller()->id == 'renting' && $action == 'admin', '/renting/admin', 'Jobs');

                        if (YAAMP_ALLOW_EXCHANGE)
                            _showItem_Header(controller()->id == 'trading', '/trading', 'Trading');

                        if (YAAMP_USE_NICEHASH_API)
                            _showItem_Header(controller()->id == 'nicehash', '/nicehash', 'Nicehash');
                    }
                    ?>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
          <!-- Content Header (Page header) -->
           <div class="content-header">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-6">
                 <?php
                 $mining = getdbosql('db_mining');
                 $nextpayment = date('H:i T', $mining->last_payout+YAAMP_PAYMENTS_FREQ);
                 $eta = ($mining->last_payout+YAAMP_PAYMENTS_FREQ) - time();
                 $eta_mn = round($eta / 60);
                 ?>
                 <h1 class="m-0"> <?='<span id="nextpayout" style="font-size: .8em;" title="' . $nextpayment . '">Next Payout: ' . $nextpayment . '</span> in <b style="color:#43F50A"> ' . $eta_mn . '</b> minutes';?></h1> 
                  </div><!-- /.col -->
                   <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/index.php">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            
            <!-- Main content -->
            <section class="content">
             <div class="container-fluid">
            <?php                    
            }

function closeMainContent()
{
?>
            </div><!--/. container-fluid -->
          </section> <!-- /.content -->
  </div> <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
<?php
}
?>