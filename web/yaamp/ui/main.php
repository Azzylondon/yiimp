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
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

<meta name="description" content="Built With  SabiasQue.Space Yiimp Server Installer">
<meta name="keywords" content="anonymous,mining,pool,maxcoin,bitcoin,altcoin,auto,switch,exchange,profit,decred,scrypt,x11,x13,x14,x15,lbry,lyra2re,neoscrypt,sha256,quark,skein2,BTC,btc">

END;

  echo <<<END
   <!-- Google Font: Source Sans Pro -->
   <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
   <!-- IonIcons -->
   <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  END;

$pageTitle = empty($this->pageTitle) ? YAAMP_SITE_NAME : YAAMP_SITE_NAME . " - " . $this->pageTitle;
echo '<title>' . $pageTitle . '</title>';

echo CHtml::cssFile('/yaamp/AdminLTE/plugins/fontawesome-free/css/all.min.css');
echo CHtml::cssFile('/yaamp/AdminLTE/plugins/overlayScrollbars/css/OverlayScrollbars.min.css');
echo CHtml::cssFile('/yaamp/AdminLTE/dist/css/adminlte.min.css');

echo CHtml::cssFile("/extensions/jquery/themes/ui-lightness/jquery-ui.css");
echo CHtml::cssFile('/yaamp/ui/css/main.css');
echo CHtml::cssFile('/yaamp/ui/css/table.css');

//echo CHtml::scriptFile('/extensions/jquery/js/jquery-1.8.3-dev.js');
//echo CHtml::scriptFile('/extensions/jquery/js/jquery-ui-1.9.1.custom.min.js');

$cs = app()->getClientScript();
$cs->registerCoreScript('jquery.ui');
//$cs->registerScriptFile('/yaamp/ui/js/jquery.tablesorter.js', CClientScript::POS_END);

echo CHtml::scriptFile('/yaamp/ui/js/jquery.tablesorter.js');

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


/*
* Mostrar publicidad si no eres administrador
* Show ads if you are not an administrator
*/
if(!controller()->admin)
   echo <<<end
   // code publicidad
   end;

echo "</head>";

///////////////////////////////////////////////////////////////

echo '<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">';

showPageHeader();
showPageContent($content);
showPageFooter();

echo "</body></html>";
return;

/////////////////////////////////////////////////////////////////////

function showPageHeader()
{
}

function showPageFooter()
{
   include_once "/home/yiimp-data/yiimp/site/web/yaamp/AdminLTE/footer.php";
}
