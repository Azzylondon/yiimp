<?php

/*
*
*
* Este fichero fue modificado o actualizado por sabiasque.space
* Web: https://sabiasque.space/
*
*
*/ 

require('misc.php');
echo <<<END

<!doctype html>
<!--[if IE 7 ]>         <html class="no-js ie ie7 lte7 lte8 lte9" lang="en-US"> <![endif]-->
<!--[if IE 8 ]>         <html class="no-js ie ie8 lte8 lte9" lang="en-US"> <![endif]-->
<!--[if IE 9 ]>         <html class="no-js ie ie9 lte9>" lang="en-US"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html class="no-js" lang="en-US"> <!--<![endif]-->

<head>

<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

<meta name="description" content="Built With Dirty Harry Yiimp Server Installer">
<meta name="keywords" content="anonymous,mining,pool,maxcoin,bitcoin,altcoin,auto,switch,exchange,profit,decred,scrypt,x11,x13,x14,x15,lbry,lyra2re,neoscrypt,sha256,quark,skein2,BTC,btc">

END;

if ( YAAMP_ADIM_LTE )
{
  echo <<<END
   <!-- Google Font: Source Sans Pro -->
   <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
   <!-- Font Awesome Icons -->
   <link rel="stylesheet" href="/yaamp/AdminLTE/plugins/fontawesome-free/css/all.min.css">
   <!-- IonIcons -->
   <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
   <!-- overlayScrollbars -->
   <link rel="stylesheet" href="/yaamp/AdminLTE/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
   <!-- Theme style -->
   <link rel="stylesheet" href="/yaamp/AdminLTE/dist/css/adminlte.min.css">

  END;
}

$pageTitle = empty($this->pageTitle) ? YAAMP_SITE_NAME : YAAMP_SITE_NAME . " - " . $this->pageTitle;

echo '<title>' . $pageTitle . '</title>';

echo CHtml::cssFile("/extensions/jquery/themes/ui-lightness/jquery-ui.css");
echo CHtml::cssFile('/yaamp/ui/css/main.css');
echo CHtml::cssFile('/yaamp/ui/css/table.css');

//echo CHtml::scriptFile('/extensions/jquery/js/jquery-1.8.3-dev.js');
//echo CHtml::scriptFile('/extensions/jquery/js/jquery-ui-1.9.1.custom.min.js');

$cs = app()->getClientScript();
$cs->registerCoreScript('jquery.ui');
//$cs->registerScriptFile('/yaamp/ui/js/jquery.tablesorter.js', CClientScript::POS_END);

echo CHtml::scriptFile('/yaamp/ui/js/jquery.tablesorter.js');

if ( YAAMP_ADIM_LTE )
{
  echo CHtml::scriptFile('/yaamp/AdminLTE/plugins/datatables/jquery.dataTables.min.js');
  echo CHtml::scriptFile('/yaamp/AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js');
  echo CHtml::scriptFile('/yaamp/AdminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js');
  echo CHtml::scriptFile('/yaamp/AdminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js');
  echo CHtml::scriptFile('/yaamp/AdminLTE/plugins/datatables-buttons/js/dataTables.buttons.min.js');
  echo CHtml::scriptFile('/yaamp/AdminLTE/plugins/datatables-buttons/js/buttons.bootstrap4.min.js');

  echo CHtml::scriptFile('/yaamp/AdminLTE/plugins/jquery/jquery.min.js');
  echo CHtml::scriptFile('/yaamp/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js');
  echo CHtml::scriptFile('/yaamp/AdminLTE/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js');
  echo CHtml::scriptFile('/yaamp/AdminLTE/dist/js/adminlte.js');
  echo CHtml::scriptFile('/yaamp/AdminLTE/plugins/chart.js/Chart.min.js');
  echo CHtml::scriptFile('/yaamp/AdminLTE/dist/js/pages/dashboard.js');
}

/*
* Mostrar publicidad si no eres administrador
* Show ads if you are not an administrator
*/

if(!controller()->admin)
   echo <<<end
   // code publicidad
   end;

// if(!controller()->admin)
// echo <<<end
// <script>
// (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
// (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
// m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
// })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

// ga('create', 'UA-58136019-1', 'auto');
// ga('send', 'pageview');

// $(document).ajaxSuccess(function(){ga('send', 'pageview');});

// </script>
// end;

echo "</head>";

///////////////////////////////////////////////////////////////

if (YAAMP_ADIM_LTE)
{
    echo '<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">';
}
else
{
    echo '<body class="page">';
    echo '<a href="/site/mainbtc" style="display: none;">main</a>';
}

if ( ! YAAMP_ADIM_LTE ) { showPageHeader(); }
showPageContent($content);
showPageFooter();

echo "</body></html>";
return;

/////////////////////////////////////////////////////////////////////

function showItemHeader($selected, $url, $name)
{
    if ($selected)
        $selected_text = "class='selected'";
    else
        $selected_text = '';

    echo "<span><a $selected_text href='$url'>$name</a></span>";
    echo "&nbsp;";
}

if ( YAAMP_ADIM_LTE )
{

    function showPageHeader()
    {
        echo '<div class="tabmenu-out">';
        echo '<a href="/"><img src="/images/logo.png"></a>';
        echo '<div class="tabmenu-inner">';

        echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="/">' . YAAMP_SITE_NAME . '</a>';

        $action = controller()->action->id;
        $wallet = user()->getState('yaamp-wallet');
        $ad     = isset($_GET['address']);

        showItemHeader(controller()->id == 'site' && $action == 'index' && !$ad, '/', 'Home');
        showItemHeader($action == 'mining', '/site/mining', 'Pool');
        showItemHeader(controller()->id == 'site' && ($action == 'index' || $action == 'wallet') && $ad, "/?address=$wallet", 'Wallet');
        showItemHeader(controller()->id == 'stats', '/stats', 'Graphs');
        showItemHeader($action == 'miners', '/site/miners', 'Miners');
        if (YIIMP_PUBLIC_EXPLORER)
            showItemHeader(controller()->id == 'explorer', '/explorer', 'Explorers');

        if (YIIMP_PUBLIC_BENCHMARK)
            showItemHeader(controller()->id == 'bench', '/bench', 'Benchs');

        if (YAAMP_RENTAL)
            showItemHeader(controller()->id == 'renting', '/renting', 'Rental');

        if (controller()->admin) {
            if (isAdminIP($_SERVER['REMOTE_ADDR']) === false)
                debuglog("admin {$_SERVER['REMOTE_ADDR']}");

            showItemHeader(controller()->id == 'coin', '/coin', 'Coins');
            showItemHeader($action == 'common', '/site/common', 'Dashboard');
            showItemHeader(controller()->id == 'site' && $action == 'admin', "/site/admin", 'Wallets');

            if (YAAMP_RENTAL)
                showItemHeader(controller()->id == 'renting' && $action == 'admin', '/renting/admin', 'Jobs');

            if (YAAMP_ALLOW_EXCHANGE)
                showItemHeader(controller()->id == 'trading', '/trading', 'Trading');

            if (YAAMP_USE_NICEHASH_API)
                showItemHeader(controller()->id == 'nicehash', '/nicehash', 'Nicehash');
        }

        echo '<span style="float: right;">';

        $mining      = getdbosql('db_mining');
        $nextpayment = date('H:i T', $mining->last_payout + YAAMP_PAYMENTS_FREQ);
        // $nextpayment = date('H:i', $mining->last_payout+YAAMP_PAYMENTS_FREQ) . ' UTC (US)';
        // define('UTCEUR', 7200);
        // $nextpaymentEUR = date('H:i', $mining->last_payout+YAAMP_PAYMENTS_FREQ+UTCEUR); // . ' UTC+2 (EUR)';
        $eta         = ($mining->last_payout + YAAMP_PAYMENTS_FREQ) - time();
        $eta_mn      = 'in ' . round($eta / 60) . ' minutes';

        //echo '<span id="nextpayout" style="font-size: .8em;" title="' . $eta_mn . '">Next Payout: ' . $nextpayment . '</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        // echo '<span id="nextpayout" style="font-size: .8em;" title="'.$eta_mn.'">Next Payout: '.$nextpayment.' / '.$nextpaymentEUR.'</span>';
        //echo '<span id="nextpayout" style="font-size: .8em;" title="'.$eta_mn.'">Next Payout: '.$nextpayment.' UTC (US) / '.$nextpaymentEUR.' UTC+2 (EUR)</span>';
        //Next Payout: 18:44 UTC in 20 minutes
        echo '<span id="nextpayout" style="font-size: .8em;" title="' . $nextpayment . '">Next Payout: ' . $nextpayment . ' ' . $eta_mn . '</span>';

        echo "</div>";
        echo "</div>";
    }
}   

function showPageFooter()
{
    if ( YAAMP_ADIM_LTE )
    {
      include_once "/home/yiimp-data/yiimp/site/web/yaamp/AdminLTE/footer.php";
    }
    else
    {
        echo '<div class="footer">';
        $year = date( "Y", time() );
    
        echo "<p>&copy; $year " . YAAMP_SITE_NAME . ' - ' . '<a href="https://sabiasque.space">En colaboración con SabiasQue.Space</a></p>';
    
        echo '</div><!-- footer -->';
    }

}
