<?php

$showrental = (bool)YAAMP_RENTAL;

$algo_from_query_param = getparam('algo');
if ($algo_from_query_param)
{
    // Query param is set
    if ($algo_from_query_param != 'all')
    {
        $r_algo = array_map('trim', explode(',', $algo_from_query_param));
        $r_algo = preg_replace('/[^A-Za-z0-9\-]/', '', $r_algo);
    }
}
else
{
    // Filter out algo from user's preferences
    $algo_from_user_pref = user()->getState('yaamp-algo');
    if ($algo_from_user_pref != 'all')
    {
        $r_algo = array(
            $algo_from_user_pref
        );
    }
}

$count = getparam('count');
$count = $count ? $count : 50;

$algo_header = isset($r_algo) ? implode(',', $r_algo) : 'any algo';


$criteria = new CDbCriteria();
$criteria->condition = "t.category NOT IN ('stake','generated')";
$criteria->condition .= " AND IFNULL(coin.visible,1)=1"; // ifnull for rental
if (isset($r_algo))
{
    $criteria->addInCondition('t.algo', $r_algo);
}
$criteria->limit = $count;
$criteria->order = 't.time DESC';
$db_blocks = getdbolistWith('db_blocks', 'coin', $criteria);

openCard('card-primary',"Last $count Blocks ($algo_header)");

echo '<div class="card-body table-responsive p-0">';

echo <<<EOT

<style type="text/css">
span.block { padding: 2px; display: inline-block; text-align: center; min-width: 75px; border-radius: 3px; }
span.block.new       { color: white; background-color: #ad4ef0; }
span.block.orphan    { color: white; background-color: #d9534f; }
span.block.immature  { color: white; background-color: #f0ad4e; }
span.block.confirmed { color: white; background-color: #5cb85c; }
span.solo	     { padding: 2px; display: inline-block; text-align: center; min-width: 15px; border-radius: 3px; color: white; background-color: #4ca6b3; }
span.shared	     { padding: 2px; display: inline-block; text-align: center; min-width: 15px; border-radius: 3px; color: white; background-color: #4ca6b3; }

b.row a { font-size: 10pt; }
.ssrow td.row { font-size: .8em; }
td.right { text-align: right; }
</style>

<table class="table table-hover text-nowrap">
<thead>
<tr>
<td></td>
<th>Name</th>
<th>Amount</th>
<th>Difficulty</th>
<th>Block</th>
<th>Time</th>
<th>Type</th>
<th>Status</th>
</tr>
</thead>
EOT;


foreach ($db_blocks as $db_block)
{
    $d = datetoa2($db_block->time);
    if (!$db_block->coin_id)
    {
        if (!$showrental) continue;

        $reward = bitcoinvaluetoa($db_block->amount);

        echo '<tr class="ssrow">';
        echo '<td width="18px"><img width="16px" src="/images/btc.png"/></td>';
        echo '<td class="row"><b>Rental</b> (' . $db_block->algo . ')</td>';
        echo '<td class="row right"><b>' . $reward . ' BTC</b></td>';
        echo '<td class="row right"></td>';
        echo '<td class="row right"></td>';
        echo '<td class="row right">' . $d . ' ago</td>';
        echo '<td class="row right">';
        echo '<span class="block confirmed">Confirmed</span>';
        echo '</td>';
        echo '</tr>';

        continue;
    }

    $reward = round($db_block->amount, 3);
    $coin = $db_block->coin ? $db_block->coin : getdbo('db_coins', $db_block->coin_id);
    $difficulty = Itoa2($db_block->difficulty, 3);
    $height = number_format($db_block->height, 0, '.', ' ');

    $link = $coin->createExplorerLink($coin->name, array('hash' => $db_block->blockhash));

    $flags = $db_block->segwit ? '&nbsp;<img src="/images/ui/segwit.png" height="8px" valign="center" title="segwit"/>' : '';

    echo '<tr>';
    echo '<td width="18px"><img width="16px" src="'.$coin->image.'"></td>';
    //echo '<td class="row"><b class="row">'.$link.'</b> ('.$db_block->algo.')'.$flags.'</td>';
    echo '<td>'.$link.'</b> ('.$db_block->algo.')'.$flags.'</td>';
    echo '<td><b>'.$reward.' '.$coin->symbol_show.'</b></td>';
    echo '<td title="found '.$db_block->difficulty_user.'">'.$difficulty.'</td>';
    echo '<td>'.$height.'</td>';
    echo '<td>'.$d.' ago</td>';
    echo '<td></th>';
    echo '<td">';

    if($db_block->solo == '1')
    {
        //echo '<span class="solo" title="Block was found by solo miner">Solo</span>';
        echo '<span class="badge bg-primary" title="Block was found by solo miner"><span class="fas fa-user"> &nbsp;&nbsp;&nbsp; SOLO &nbsp;&nbsp;&nbsp; </span></span>';
    }
    else
    {
        //echo '<span class="shared" title="Block was found by shared miners">Shared</span>';
        echo '<span class="badge badge-info" title="Block was found by shared miners"><span class="fas fa-users"> SHARED</span></span>';
    }
    echo "</td>";

    echo '<td>';
    if ($db_block->category == 'orphan')
    {
        /*
        42Coin Hide orphaned blocks and suptituri per block without reward
        42Coin Ocultar bloques huerfanos y suptituri por bloque sin recompensa
        */
        if ($coin->symbol == 'C42' || $coin->symbol == '42')
             echo '<span class="badge bg-success">No Reward</span>';
        else
            echo '<span class="badge bg-danger">Orphan</span>';
    }
    else if ($db_block->category == 'immature')
    {
        $eta = '';
        if ($coin->block_time && $coin->mature_blocks)
        {
            $t = (int)($coin->mature_blocks - $db_block->confirmations) * $coin->block_time;
            $eta = "ETA: " . sprintf('%dh %02dmn', ($t / 3600) , ($t / 60) % 60);
        }
        //echo '<span class="block immature" title="' . $eta . '">Immature (' . $db_block->confirmations . ')</span>';
        $datos = array($db_block->confirmations, $coin->mature_blocks);
        ProgressBars ('horizontal', 2, 'Immature', $datos, $db_block->confirmations);
    }
    else if ($db_block->category == 'generate')
    {
        echo '<span class="badge bg-success">Confirmed</span>';
    }
    else if ($db_block->category == 'new')
    {
        //echo '<span class="block new">New</span>';
        echo '<span class="badge bg-primary">New</span>';
    }

    echo "</td>";
    echo "</tr>";
}

echo "</table>";

echo "<br></div></div><br>";
echo '<div>';// card-body table-responsive p-0
