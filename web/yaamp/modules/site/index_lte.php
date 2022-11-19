<?php

$algo = user()->getState('yaamp-algo');

JavascriptFile("/extensions/jqplot/jquery.jqplot.js");
JavascriptFile("/extensions/jqplot/plugins/jqplot.dateAxisRenderer.js");
JavascriptFile("/extensions/jqplot/plugins/jqplot.barRenderer.js");
JavascriptFile("/extensions/jqplot/plugins/jqplot.highlighter.js");
JavascriptFile("/extensions/jqplot/plugins/jqplot.cursor.js");
JavascriptFile('/yaamp/ui/js/auto_refresh.js');

$min_payout = floatval(YAAMP_PAYMENTS_MINI);
$min_sunday = $min_payout / 10;
$payout_freq = (YAAMP_PAYMENTS_FREQ / 3600) . " hours";

openMainContent(); 
?>

<div class="alert alert-warning alert-dismissible">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <h5><i class="icon fas fa-exclamation-triangle"></i> Auto Refresh Is Paused </h5>
  
        <div id='resume_update_button' style='color: #ffffff; background-color: #41464b; border: 1px solid #7d7d7d;
          padding: 10px; margin-left: 20px; margin-right: 20px; margin-top: 15px; cursor: pointer; display: none;'
          onclick='auto_page_resume();' align=center>
          <b>Auto Refresh Is Paused - Click Here To Resume</b>
        </div>
</div>


<div class="row">
  <div class="col-lg-6">
    <?php
    openCard('card-primary','Important announcement');
      echo'<ul>';
              if (defined('URGEN_NOTE')) 
              {
                  foreach (URGEN_NOTE as $key => $value)
                  {
                      if($value[0] == 'HOME')
                      {
                      echo '<li style="color:'. $value[1] .'";>'. $value[3] .'</li>';
                      }
                  }
              }
    ?>
          </ul>

   <?php
   echo '</div></div>'; //close card Important announcement 
   openCard('card-primary', YAAMP_SITE_URL);
   ?>
    <center>
    <ul>
        <li><b>Welcome to your new mining pool, <?=YAAMP_SITE_URL ?> </b></li>
        <li>This installation was completed using the SabiasQue.Sapce Yiimp Server Installer.</li>
        <li>Any edits to this page should be made to, /home/yiimp-data/yiimp/site/web/yaamp/modules/site/index.php</li>
        <li>&nbsp;</li>
        <li>No registration is required, we do payouts in the currency you mine. Use your wallet address as the username.</li>
        <li>&nbsp;</li>
        <li>Payouts are made automatically every <?=$payout_freq ?> for all balances above <b><?=$min_payout ?></b>, or <b><?=$min_sunday ?></b> on Sunday.</li>
        <li>For some coins, there is an initial delay before the first payout, please wait at least 6 hours before asking for support.</li>
        <li>Blocks are distributed proportionally among valid submitted shares.</li>
        <br/>
    </ul>
    </center>
    <br/>

    <!-- Stratum Auto generation code, will automatically add coins when they are enabled and auto ready -->

   <?php
   echo '</div></div>'; //close card Welcome

   openCard('card-primary','Worker Configurator');
   ?>
   <!-- End new stratum generation code  -->
   <?php
   echo '</div></div>'; //close card Worker Configurator

   openCard('card-primary', YAAMP_SITE_URL.' Links');
   ?>
      <ul>
        <li><b>API</b> - <a href='/site/api'>http://<?=YAAMP_SITE_URL
        ?>/site/api</a></li>
        <li><b>Difficulty</b> - <a href='/site/diff'>http://<?=YAAMP_SITE_URL
        ?>/site/diff</a></li>
        <?php
        if (YIIMP_PUBLIC_BENCHMARK):
        ?>
        <li><b>Benchmarks</b> - <a href='/site/benchmarks'>http://<?=YAAMP_SITE_URL
        ?>/site/benchmarks</a></li>
        <?php
        endif;
        ?>

        <?php
        if (YAAMP_ALLOW_EXCHANGE):
        ?>
        <li><b>Algo Switching</b> - <a href='/site/multialgo'>http://<?=YAAMP_SITE_URL
        ?>/site/multialgo</a></li>
        <?php
        endif;
        ?>
        <br>
      </ul>
    <?php
    echo '</div></div>'; //close card  links
    openCard('card-primary', YAAMP_SITE_URL.' Support');
    ?>
    <ul class="social-icons">
        <li><a href="http://www.discord.com"><img src='/images/discord.png' /></a></li>
        <li><a href="http://www.twitter.com"><img src='/images/Twitter.png' /></a></li>
        <li><a href="mailto:"><img src='/images/email.png' /></a></li>
        <li><a href="http://www.youtube.com"><img src='/images/telegram.png' /></a></li>
        <li><a href="http://www.github.com"><img src='/images/Github.png' /></a></li>
    </ul>
    <?php echo '</div></div>'; //close card Support ?>

   </div> <!-- col-lg-6 close -->

   <div class="col-lg-6">
      <div id='pool_current_results'>
      <br><br><br><br><br><br><br><br><br><br>
      </div>

      <div id='pool_history_results'>
      <br><br><br><br><br><br><br><br><br><br>
      </div>

      <br><br><br><br><br><br><br><br><br><br>
      <br><br><br><br><br><br><br><br><br><br>
      <br><br><br><br><br><br><br><br><br><br>
      <br><br><br><br><br><br><br><br><br><br>
   </div> <!-- col-lg-6 close -->
</div> <!-- row close -->

<?php closeMainContent(); ?>

<script>

function page_refresh()
{
    pool_current_refresh();
    pool_history_refresh();
}

function select_algo(algo)
{
    window.location.href = '/site/algo?algo='+algo+'&r=/';
}

////////////////////////////////////////////////////

function pool_current_ready(data)
{
    $('#pool_current_results').html(data);
}

function pool_current_refresh()
{
    var url = "/site/current_results";
    $.get(url, '', pool_current_ready);
}

////////////////////////////////////////////////////

function pool_history_ready(data)
{
    $('#pool_history_results').html(data);
}

function pool_history_refresh()
{
    var url = "/site/history_results";
    $.get(url, '', pool_history_ready);
}

</script>

<script>
function getLastUpdated(){
    var stratum = document.getElementById('drop-stratum');
    var coin = document.getElementById('drop-coin');
    var solo = document.getElementById('drop-solo');
    var rigName = document.getElementById('text-rig-name').value;
    var result = '';

    result += coin.options[coin.selectedIndex].dataset.algo + ' -o stratum+tcp://';
    result += stratum.value + '<?=YAAMP_SITE_URL;?>:';
    result += coin.options[coin.selectedIndex].dataset.port + ' -u ';
    result += document.getElementById('text-wallet').value;
    if (rigName) result += '.' + rigName;
    result += ' -p c=';
    result += coin.options[coin.selectedIndex].dataset.symbol + solo.value;
    return result;
}
function generate(){
      var result = getLastUpdated()
        document.getElementById('output').innerHTML = result;
}
generate();
</script>
