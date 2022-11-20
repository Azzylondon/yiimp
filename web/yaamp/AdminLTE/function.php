<?php

// Menú horizontal
function showItem_Header($selected, $url, $name) {
  if ($selected)
       $selected_text = "class='selected'";
  else
      $selected_text = '';

  echo "<li class='nav-item d-none d-sm-inline-block'><a class='nav-link' href='$url'>$name</a></li>";
}

// Menú vertical
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

function openCard($card, $title){

    if ($card = 'card-primary') 
    {
        echo '<div class="card">
        <div class="card-header">
          <h3 class="card-title">'.$title.'</h3>

          <div class="card-tools">
           
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0">';    
    }

?>