<?php

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