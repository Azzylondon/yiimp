<?php

if ( YAAMP_ADIM_LTE )
{
  include_once "/home/yiimp-data/yiimp/site/web/yaamp/AdminLTE/function.php";
  include_once "/home/yiimp-data/yiimp/site/web/yaamp/AdminLTE/content.php";
  include_once "index_lte.php";

} else { include_once"index_yiimp.php"; }