<?php


include_once "/home/yiimp-data/yiimp/site/web/yaamp/AdminLTE/function.php";
include_once "/home/yiimp-data/yiimp/site/web/yaamp/AdminLTE/content.php";

openMainContent();

?>

<div class="row">
    <?php

    $total_active    = 0;
    $total_installed = 0;

    $coins = getdbolist('db_coins', "1 ORDER BY created DESC");
    foreach ($coins as $coin) {
        //    if($coin->symbol == 'BTC') continue;
        if ($coin->enable)
            $total_active++;
        if ($coin->installed)
            $total_installed++;

        $coin->errors  = substr($coin->errors, 0, 30);
        $coin->version = substr($coin->version, 0, 20);
        $difficulty    = Itoa2($coin->difficulty, 3);
        $created       = datetoa2($coin->created);

        if ($coin->enable)
        {
            $state_card = 'success';
            $state = 'running';
        }
        else if ($coin->installed)
        {
            $state_card = 'warning';
            $state = 'installed';
        }
        else
        {
            $state_card = 'danger';
            $state = 'removed';
        }

        ?>
        <div class="col-md-3">
            <div class="card card-<?=$state_card?>">
                <div class="card-header">
                    <h3 class="card-title"><a href="/coin/update?id=<?=$coin->id?>"><?=$coin->name?></a></h3>
                </div>
                <div class="card-body">

                <div class="position-relative p-3" style="height: 190px">
                      <?php
                      if ( ( time() - $coin->created ) <= YAAMP_NEW_COINS )
                      {
                      ?>
                         <div class="ribbon-wrapper ribbon-lg">
                           <div class="ribbon bg-success text-lg">
                             New Coin
                           </div>
                         </div>
                       <?php
                       }
                       ?>

                        <div>
                            <div class="widget-user-image">
                            <img class="img-circle elevation-2" src="<?=$coin->image?>" alt="<?=$coin->name?>">
                            </div>
                            <h6 class="widget-user-username">Nadia Carmichael</h3>
                            <h6 class="widget-user-desc">Lead Developer</h5>
                        </div>
                </div>

                <div class="card-footer p-0">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                              Status <span class="float-right badge bg-<?=$state_card?>"><?=$state?></span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                              Algo <span class="float-right badge bg-info"><?=$coin->algo?></span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                              Port <span class="float-right"> </span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                              Symbol <span class="float-right badge bg-<?=$state_card?>"><?=$coin->symbol?></span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                              Version <span class="float-right"><?=$coin->version?></span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                              Difficulty <span class="float-right"><?=$difficulty?></span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                              Height <span class="float-right"><?=$coin->block_height?></span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                              Created <span class="float-right"><?=$created?></span>
                            </a>
                        </li>

                        <?php
                        if ($this->admin)
                        {
                        ?>
                         <li class="nav-item">
                            <a href="#" class="nav-link">
                              Error <span class="float-right"><?=$coin->errors?></span>
                            </a>
                         </li>
                        <?php 
                        } 
                        ?>

                    </ul>
                </div>

        <?php

        /*if ($this->admin)
            echo "<p><a href='/site/update?id=$coin->id'>$coin->symbol</a></p>";


        if ( ! empty( $coin->link_bitcointalk ) )
            echo "<a href='$coin->link_bitcointalk' target=_blank>forum</a> ";

        if ( ! empty( $coin->link_github ) )
            echo "<a href='$coin->link_github' target=_blank>git</a> ";

        //    if(!empty($coin->link_explorer))
        //        echo "<a href='$coin->link_explorer' target=_blank>expl</a> ";

        echo "<a href='http://google.com/search?q=$coin->name%20$coin->symbol%20bitcointalk' target=_blank>google</a> ";*/

        //    if(!empty($coin->link_exchange))
        //        echo "<a href='$coin->link_exchange' target=_blank>exch</a> ";

        /*$list2 = getdbolist('db_markets', "coinid=$coin->id");
        foreach ($list2 as $market) {
            $url = getMarketUrl($coin, $market->name);
            echo "<a href='$url' target=_blank>$market->name</a> ";
        }*/
        ?>

          </div>
        </div>
    </div>

    <?php

    }

    $total = count($coins);
?>

</div> <!-- ./ row -->

<div class="row">
    <?php
    echo "<b>$total coins, $total_installed installed, $total_active running </b>";
    echo '<b> | <a href="/coin/create">Add a new coin</a></b>';
    ?>
</div> <!-- ./ row -->
