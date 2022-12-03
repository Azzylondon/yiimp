<?php

$mining = getdbosql('db_mining');
$defaultalgo = user()->getState('yaamp-algo');

$show_details = getparam('showdetails');

$user = getuserparam(getparam('address'));
if (!$user) return;

openCard('card-primary','Miners: ('.$user->username.')');

$refcoin = getdbo('db_coins', $user->coinid);
if (!$refcoin)
{
    if ($user->coinid != null) echo "<div style='color: red; padding: 10px; '>This wallet address is not valid.
			You will not receive payments using this address.</div>";

    $refcoin = getdbosql('db_coins', "symbol='BTC'");
}
elseif (!YAAMP_ALLOW_EXCHANGE && $user->coinid == 6 && $defaultalgo != 'sha256')
{
    echo "<div style='color: red; padding: 10px; '>This pool does not convert/trade currencies.
		You will not receive payments using this BTC address.</div>";
    return;
}

/*WriteBoxHeader('Notices to you');

        if (defined('URGEN_NOTE'))
        {
            foreach (URGEN_NOTE as $key => $value)
            {
                if($value[0] == 'ADDRESS' && $value[2] == $user->username)
                {
                 echo '<li style="color:'. $value[1] .'";>'. $value[3] .'</li>';
                }
            }
        }
echo '</ul></div></div><br>';*/

echo "<table class='table table-sm'>";
/*
echo "<thead>";
echo "<tr>";
echo "<th></th>";
echo "<th>Name</th>";
echo "<th align=right>Immature</th>";
echo "<th align=right>Confirmed</th>";
echo "<th align=right>Total</th>";
echo "<th align=right>Value*</th>";
echo "</tr>";
echo "</thead>";*/

$total_pending = 0;

if ($show_details)
{
    $t1 = microtime(true);

    $list = dbolist("select coinid from earnings where userid=$user->id group by coinid");
    if (!count($list)) echo "<tr><td></td><td colspan=5><i>-none-</i></td></tr>";

    else
    {
        // sort by value
        foreach ($list as $item)
        {
            $coin = getdbo('db_coins', $item['coinid']);
            if (!$coin) continue;

            $name = substr($coin->name, 0, 12);

            $confirmed = controller()
                ->memcache
                ->get_database_scalar("wallet_confirmed-$user->id-$coin->id", "select sum(amount) from earnings where status=1 and userid=$user->id and coinid=$coin->id");

            $unconfirmed = controller()
                ->memcache
                ->get_database_scalar("wallet_unconfirmed-$user->id-$coin->id", "select sum(amount) from earnings where status=0 and userid=$user->id and coinid=$coin->id");

            $total = $confirmed + $unconfirmed;
            //	$value = bitcoinvaluetoa($total * $coin->price / $refcoin->price);
            $value = bitcoinvaluetoa(yaamp_convert_amount_user($coin, $total, $user));

            $confirmed = altcoinvaluetoa($confirmed);
            $unconfirmed = altcoinvaluetoa($unconfirmed);
            $total = altcoinvaluetoa($total);

            echo "<tr class='ssrow'>";
            echo "<td width=18><img width=16 src='$coin->image'></td>";
            echo "<td><b><a href='/site/block?id=$coin->id' title='$coin->version'>$name</a></b><span style='font-size: .8em'> ($coin->algo)</span></td>";

            echo "<td align=right style='font-size: .8em;'>$unconfirmed</td>";
            echo "<td align=right style='font-size: .8em;'>$confirmed</td>";
            echo "<td align=right style='font-size: .8em;'>$total</td>";
            echo "<td align=right style='font-size: .8em;'>$value $refcoin->symbol</td>";

            echo "</tr>";
        }
    }

    $d1 = microtime(true) - $t1;
    controller()
        ->memcache
        ->add_monitoring_function('wallet_results-1', $d1);
}

//////////////////////////////////////////////////////////////////////////////
// $confirmed = bitcoinvaluetoa(controller()->memcache->get_database_scalar("wallet_confirmed-$user->id",
// 	"select sum(amount*price) from earnings where status=1 and userid=$user->id"))/$refcoin->price;
// $unconfirmed = bitcoinvaluetoa(controller()->memcache->get_database_scalar("wallet_unconfirmed-$user->id",
// 	"select sum(amount*price) from earnings where status=0 and userid=$user->id"))/$refcoin->price;
$confirmed = yaamp_convert_earnings_user($user, "status=1");
$unconfirmed = yaamp_convert_earnings_user($user, "status=0");

$total_unsold = bitcoinvaluetoa($confirmed + $unconfirmed);
$confirmed = $confirmed ? bitcoinvaluetoa($confirmed) : '';
$unconfirmed = $unconfirmed ? bitcoinvaluetoa($unconfirmed) : '';
//$total_usd = number_format($total_unsold*$mining->usdbtc*$refcoin->price, 3, '.', ' ');
$total_pending = bitcoinvaluetoa($total_pending);

// ////////////////////////////////////////////////////////////////////////////
$fees_notice = '';
if ($user->donation > 0)
{
    $fees_notice = 'Currently donating ' . $user->donation . ' % of the rewards.';
}
else if ($user->no_fees == 1)
{
    $fees_notice = 'Currently mining without pool fees.';
}
echo '<tr><td colspan="6" style="text-align:right; font-size: .8em;"><b>' . $fees_notice . '</b></td></tr>';

// ////////////////////////////////////////////////////////////////////////////
$balance = bitcoinvaluetoa($user->balance);
//$balance_usd = number_format($user->balance*$mining->usdbtc*$refcoin->price, 3, '.', ' ');

////////////////////////////////////////////////////////////////////////////
$total_unpaid = bitcoinvaluetoa($balance + $total_unsold);
//$total_unpaid_usd = number_format($total_unpaid*$mining->usdbtc*$refcoin->price, 3, '.', ' ');

////////////////////////////////////////////////////////////////////////////
$total_paid = controller()
    ->memcache
    ->get_database_scalar("wallet_total_paid-$user->id", "select sum(amount) from payouts where account_id=$user->id");

$total_paid = bitcoinvaluetoa($total_paid);
//$total_paid_usd = number_format($total_paid*$mining->usdbtc*$refcoin->price, 3, '.', ' ');
////////////////////////////////////////////////////////////////////////////
//$delay = 7*24*60*60;
$total_earned = bitcoinvaluetoa($total_unsold + $balance + $total_paid);
//$total_earned_usd = number_format($total_earned*$mining->usdbtc*$refcoin->price, 3, '.', ' ');

if ($refcoin->symbol == 'BTC')
{
    $usd = number_format($mining->usdbtc, 2, '.', ' ');
    echo '** bitstamp <b>' . $usd . '</b> USD/BTC';
}

?>

<div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-balanced"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Balance</span>
                <span class="info-box-number">
                  <?=$balance .' '. $refcoin->symbol?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <?php
          if ($refcoin->payout_min)
          {?>
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Minimum payout for this wallet is</span>
                <span class="info-box-number">
                  <?php
                    $datos = array( ( $balance + $unconfirmed ) , $refcoin->payout_min);
                    ProgressBars ('horizontal', 2, '%', $datos, ( $balance + $unconfirmed ) );
                  ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <?php } ?>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-thumbs-up"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Unpaid</span>
                <span class="info-box-number"><?=$total_unpaid. ' '.$refcoin->symbol?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

                    <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-cubes"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Unpaid</span>
                <span class="info-box-number"><?=$total_unpaid. ' '.$refcoin->symbol?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-wallet"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Paid</span>
                <span class="info-box-number"><?=$total_paid. ' '.$refcoin->symbol?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-wallet"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Earned</span>
                <span class="info-box-number"><?=$total_earned?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
      </div>

<?php

openCard('card-primary','Last 24 Hours Payouts');

$t = time() - 24 * 60 * 60;
$list = getdbolist('db_payouts', "account_id={$user->id} AND time>$t ORDER BY time DESC");

echo "<table  class='table table-sm'>";

echo "<thead>";
echo "<tr>";
echo "<th>Time</th>";
echo "<th>Amount</th>";
echo "<th>Tx</th>";
echo "</tr>";
echo "</thead>";

$total = 0;
$firstid = 999999999;
foreach ($list as $payout)
{
    $d = datetoa2($payout->time);
    $amount = bitcoinvaluetoa($payout->amount);
    $firstid = min($firstid, (int)$payout->id);

    echo '<tr class="ssrow">';
    echo '<td><b>' . $d . ' ago</b></td>';
    echo '<td><b>' . $amount . '</b></td>';

    $payout_tx = substr($payout->tx, 0, 36) . '...';
    $link = $refcoin->createExplorerLink($payout_tx, array(
        'txid' => $payout->tx
    ) , array() , true);

    echo '<td style="font-family: monospace;">' . $link . '</td>';
    echo '</tr>';

    $total += $payout->amount;
}

$amount = bitcoinvaluetoa($total);

// Search extra Payouts which were not in the db (yiimp payout check command)
// In this case, the id are greater than last 24h ones and the fee column is filled
$list_extra = getdbolist('db_payouts', "account_id={$user->id} AND id>$firstid AND fee > 0.0 ORDER BY time DESC");

if (!empty($list_extra))
{

  echo <<<end
	<tr class="ssrow" style="color: darkred;">
	<th colspan="3"><b>Extra payouts detected in the last 24H to explain negative balances (buggy Wallets)</b></th>
	</tr>
	<tr class="ssrow">
	<td colspan="3" style="font-size: .9em; padding-bottom: 8px;">
	Some wallets (UFO,LYB) have a problem and don't always confirm a transaction in the requested time.<br/>
	<!-- Please be honest and continue mining to handle these extra transactions sent to you. --><br/>
	</th>
	</tr>
	<tr class="ssrow">
	<th align="right">Time</th> <th align="right">Amount</th> <th>Tx</th>
	</tr>
end;


    $total = 0.0;
    foreach ($list_extra as $payout)
    {
        $d = datetoa2($payout->time);
        $amount = bitcoinvaluetoa($payout->amount);

        echo '<tr class="ssrow">';
        echo '<td align="right"><b>' . $d . ' ago</b></td>';
        echo '<td align="right"><b>' . $amount . '</b></td>';

        $payout_tx = substr($payout->tx, 0, 36) . '...';
        $link = $refcoin->createExplorerLink($payout_tx, array(
            'txid' => $payout->tx
        ) , array() , true);

        echo '<td style="font-family: monospace;">' . $link . '</td>';
        echo '</tr>';

        $total += $payout->amount;
    }

    $amount = bitcoinvaluetoa($total);

    echo <<<end
    <tr class="ssrow" style="color: darkred;">
    <td align="right">Total:</td>
    <td align="right"><b>{$amount}</b></td>
    <td></td>
    </tr>
    end;

}
?>

</table>
<div class="card-footer text-center">
Total: <?=$amount?>
</div>
</div></div><br>
