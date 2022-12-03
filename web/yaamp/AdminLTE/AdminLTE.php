<?php

include "function.php";
include "content.php";

class adminLTE 
{
  //public $card;

  public static function openCard($card, $title) 
  {
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

  }

//function ProgressBars ($posicion='horizontal', $tipo=1, $color='', $tamano, $dato){
public static function ProgressBars ($posicion, $tipo, $txt, $datos=array(), $porcentaje) {

    if($posicion=='horizontal' && $tipo == 1){
      echo '<div class="progress">
              <div class="progress-bar bg-success progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: '.$porcentaje.'%">
                <span class="sr-only">40% Complete (success)</span>
              </div>
            </div>';
    }
    
    if($porcentaje <=59 ){$bg="bg-warning";} else if ($porcentaje <=60){$bg="bg-primary";
    } else if ($porcentaje >= 99){$bg="bg-success";}else {$bg="bg-primary";}
  
    if($posicion=='horizontal' && $tipo == 2){
      echo '<div class="progress-group">
             <span class="progress-text">'.$txt. ' </span>
              <span class="float-right"><b> '.$datos[0].'</b>/'.$datos[1].'</span>
              <div class="progress progress-sm">
               <div class="progress-bar '.$bg.'" style="width: '.$porcentaje.'%"></div>
              </div>
            </div>';
    }
  
   //return $dato;
  }
  
}