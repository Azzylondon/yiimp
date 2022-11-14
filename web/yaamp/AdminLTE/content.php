<?php

function openMainContent() 
{ ?>
   <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__wobble" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="/index.php" class="nav-link">Home</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="/site/mining" class="nav-link">Pool</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="/coin" class="nav-link">Coin</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="/?address=" class="nav-link">Wallet</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="/site/miners" class="nav-link">Miners</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="/explorer" class="nav-link">Explores</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="#" class="nav-link">Contact</a>
            </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
            <!-- Navbar Search -->
            <li class="nav-item">
                <a class="nav-link" data-widget="navbar-search" href="#" role="button">
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
            <img src="/images/logo.png" alt=" domain Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">domain</span>
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

                <li class="nav-item">
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
                </li>
                <li class="nav-header">EXAMPLES</li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-calendar-alt"></i>
                    <p>
                        test
                        <span class="badge badge-info right">2</span>
                    </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                    <i class="nav-icon far fa-image"></i>
                    <p>
                        test
                    </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pages/kanban.html" class="nav-link">
                    <i class="nav-icon fas fa-columns"></i>
                    <p>
                        test
                    </p>
                    </a>
                </li>
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
                 $eta_mn = 'in '.round($eta / 60).' minutes';
                 ?>
                 <h1 class="m-0"> <?='<span id="nextpayout" style="font-size: .8em;" title="' . $nextpayment . '">Next Payout: ' . $nextpayment . ' ' . $eta_mn . '</span>';?></h1> 
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
                <!-- Info boxes -->
<?php                    
}

function closeMainContent() 
{
?>
   </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
<?php
}

?>