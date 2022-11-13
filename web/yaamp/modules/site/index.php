<?php

include_once "/home/yiimp-data/yiimp/site/web/yaamp/AdminLTE/function.php";
include_once "/home/yiimp-data/yiimp/site/web/yaamp/AdminLTE/content.php";

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

if ( YAAMP_ADIM_LTE ) 
{ 
  openMainContent(); 
} else { 
          $height = '240px'; 
          ?>
          <div id='resume_update_button' style='color: #ffffff; background-color: #41464b; border: 1px solid #7d7d7d;
              padding: 10px; margin-left: 20px; margin-right: 20px; margin-top: 15px; cursor: pointer; display: none;'
              onclick='auto_page_resume();' align=center>
              <b>Auto Refresh Is Paused - Click Here To Resume</b></div>

          <table cellspacing=20 width=100%>
          <tr><td valign=top width=50%>
          <?php
       } // else 

if ( YAAMP_ADIM_LTE )
{
  echo'<div class="row">';
  echo '<div class="col-lg-6">';
  openCard('card-primary','Important announcement');
}
else
{
  echo '<div class="main-left-box">
        <div class="main-left-title">Important announcement</div>
        <div class="main-left-inner">';
}
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

if ( !YAAMP_ADIM_LTE ) { echo '</div></div><br>'; }

if ( YAAMP_ADIM_LTE )
{
  echo '</div></div>'; //close card Important announcement

  ?>
  <td valign=top>
  <!--  -->

  <div id='pool_current_results'>
  <br><br><br><br><br><br><br><br><br><br>
  </div>

  <div id='pool_history_results'>
  <br><br><br><br><br><br><br><br><br><br>
  </div>

  </td></tr></table>

  <br><br><br><br><br><br><br><br><br><br>
  <br><br><br><br><br><br><br><br><br><br>
  <br><br><br><br><br><br><br><br><br><br>
  <br><br><br><br><br><br><br><br><br><br>

<?php 

  echo '</div>'; // col-lg-6 close
  echo '</div>'; // row close

  echo'<div class="row">';
  echo '<div class="col-lg-6">';

  openCard('card-primary', YAAMP_SITE_URL);
}
else
{
  echo '<div class="main-left-box">
        <div class="main-left-title">'.YAAMP_SITE_URL.'</div>
        <div class="main-left-inner">';
}
?>

<center>
<ul>
    <li><b>Welcome to your new mining pool, domain !</b></li>
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
<?php if ( !YAAMP_ADIM_LTE ) { echo '</div></div>'; } ?>
</center>
<br/>

<!-- Stratum Auto generation code, will automatically add coins when they are enabled and auto ready -->

<?php
if ( YAAMP_ADIM_LTE )
{
  echo '</div></div>'; //close card Welcome
  openCard('card-primary','Worker Configurator');
}
else
{
  echo '<div class="main-left-box">
        <div class="main-left-title">Worker Configurator</div>
        <div class="main-left-inner">';
}
?>

<center><table>
	<thead>
		<tr>
			<th>Stratum Location</th>
			<th>Choose Coin</th>
			<th>Your Wallet Address</th>
			<th>Rig (opt.)</th>
                        <th>Solo Mine</th>
                        <th>Start Mining</th>
		</tr>
	</thead>

<tbody>
	<tr>
		<td>
			<select id="drop-stratum" colspan="2" style="min-width: 140px; border-style:solid; padding: 3px; font-family: monospace; border-radius: 5px;">

      <!-- Add your stratum locations here -->
      <option value="usa">USA</option>
      <option value="asia.">Asia</option>
			<!-- <option value="us.west.">USA</option>
			<option value="aus.">AUS Stratum</option>
			<option value="cad.">CAD Stratum</option>
			<option value="uk.">UK Stratum</option> -->
		</select>
	</td>

	<td>
			<select id="drop-coin" style="border-style:solid; padding: 3px; font-family: monospace; border-radius: 5px;">
        <?php
        $list = getdbolist('db_coins', "enable and visible and auto_ready order by algo asc");

        $algoheading="";
        $count=0;
        foreach($list as $coin)
        			{
        			$name = substr($coin->name, 0, 18);
        			$symbol = $coin->getOfficialSymbol();
                  $id = $coin->id;
                  $algo = $coin->algo;

        $port_count = getdbocount('db_stratums', "algo=:algo and symbol=:symbol", array(
        ':algo' => $algo,
        ':symbol' => $symbol
        ));

        $port_db = getdbosql('db_stratums', "algo=:algo and symbol=:symbol", array(
        ':algo' => $algo,
        ':symbol' => $symbol
        ));

        if ($port_count >= 1){$port = $port_db->port;}else{$port = '0.0.0.0';}
        if($count == 0){ echo "<option disabled=''>$algo";}elseif($algo != $algoheading){echo "<option disabled=''>$algo</option>";}
        echo "<option data-port='$port' data-algo='-a $algo' data-symbol='$symbol'>$name ($symbol)</option>";

        $count=$count+1;
        $algoheading=$algo;
        }
        ?>
			</select>
		</td>

		<td>

<!-- Change your demo wallet here -->
			<input id="text-wallet" type="text" size="35" placeholder="RF9D1R3Vt7CECzvb1SawieUC9cYmAY1qoj" style="border-style:solid; border-width: thin; padding: 3px; font-family: monospace; border-radius: 5px;">
		</td>

		<td>
			<input id="text-rig-name" type="text" size="10" placeholder="001" style="border-style:solid; border-width: thin; padding: 3px; font-family: monospace; border-radius: 5px;">
		</td>

	  <td>
			<select id="drop-solo" colspan="2" style="min-width: 80px; border-style:solid; padding: 3px; font-family: monospace; border-radius: 5px;">
			<option value="">No</option>
			<option value=",m=solo">Yes</option>
			</select>
		</td>

		<td>
			<input id="Generate!" type="button" value="Create String" onclick="generate()" style="border-style:solid; padding: 3px; font-family: monospace; border-radius: 5px;">
		</td>
	</tr>
	<tr>
			<td colspan="7"><p class="main-left-box" style="padding: 3px; color: #000000; background-color: #ffffff; font-family: monospace;" id="output">-a  -o stratum+tcp://<?=YAAMP_SITE_URL;?>:0000 -u . -p c=</p>
		  </td>
	</tr>
</tbody></table>

<ul>
  <li><b>Your WALLET ADDRESS must be valid for the currency you mine !</b></li>
  <li><b>DO NOT USE a BTC address here, the auto exchange is disabled on these stratums !</b></li>
  <li>See the "domain Coins" area on the right for PORT numbers. You may mine any coin regardless if the coin is enabled or not for autoexchange. Payouts will only be made in that coins currency.</li>
  <br>
</ul>
<?php if ( !YAAMP_ADIM_LTE ) { echo '</div></div>'; } ?>
</center><br>

<!-- End new stratum generation code  -->

<?php
if ( YAAMP_ADIM_LTE )
{
  echo '</div></div>'; //close card Worker Configurator
  openCard('card-primary', YAAMP_SITE_URL.' Links');
}
else
{
  echo '<div class="main-left-box">
        <div class="main-left-title">'.YAAMP_SITE_URL.'</div>
        <div class="main-left-inner">';
}
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
  <?php if ( !YAAMP_ADIM_LTE ) { echo '</div></div><br>'; } ?>

<?php
if ( YAAMP_ADIM_LTE )
{
  echo '</div></div>'; //close card  links
  openCard('card-primary', YAAMP_SITE_URL.' Support');
}
else
{
  echo '<div class="main-left-box">
        <div class="main-left-title">'.YAAMP_SITE_URL.' Support</div>
        <div class="main-left-inner">';
}
?>

<ul class="social-icons">
    <li><a href="http://www.discord.com"><img src='/images/discord.png' /></a></li>
    <li><a href="http://www.twitter.com"><img src='/images/Twitter.png' /></a></li>
    <li><a href="mailto:"><img src='/images/email.png' /></a></li>
    <li><a href="http://www.youtube.com"><img src='/images/telegram.png' /></a></li>
    <li><a href="http://www.github.com"><img src='/images/Github.png' /></a></li>
</ul>

<?php if ( !YAAMP_ADIM_LTE ) { echo '</div></div><br></td>'; } ?>

<?php
if ( YAAMP_ADIM_LTE )
{
 echo '</div></div>'; //close card Support
 echo '</div>'; // col-lg-6 close
 echo '<div class="row">';
 echo '<div class="col-lg-6">';
} else {
?>
          <td valign=top>
          <!--  -->
          <div id='pool_current_results'>
          <br><br><br><br><br><br><br><br><br><br>
          </div>

          <div id='pool_history_results'>
          <br><br><br><br><br><br><br><br><br><br>
          </div>

          </td></tr></table>

          <br><br><br><br><br><br><br><br><br><br>
          <br><br><br><br><br><br><br><br><br><br>
          <br><br><br><br><br><br><br><br><br><br>
          <br><br><br><br><br><br><br><br><br><br>

        <?php 
        }

if ( YAAMP_ADIM_LTE ) 
{ 

  echo '</div>'; // col-lg-6 close
  echo '</div>'; // row close
  closeMainContent(); 
} 
?>

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
