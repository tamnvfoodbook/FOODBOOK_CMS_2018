
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">

<?php

use yii\helpers\Html;
use yii\grid\GridView;
//use maksyutin\duallistbox\Widget;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Permisson Users';
$this->params['breadcrumbs'][] = $this->title;
?>

<script>
  $(function() {
    $( "ul.droptrue" ).sortable({
      connectWith: "ul"
    });
 
    $( "ul.dropfalse" ).sortable({
      connectWith: "ul",
      dropOnEmpty: false
    });
 
    $( "#sortable1, #sortable2, #sortable3" ).disableSelection();
  });
  </script>



<div class="user-index">
    <div class="menu_simple" style="float: left">       
        <ul>
            <?php
                foreach ($user as $key => $value) {
                    echo '<li><a href="#">'.$value.'</a></li>';
                }
            ?>
        </ul>
    </div>

    <div style="float: left">
      <div style="float: left">
        <?php 
            foreach ($pos as $key => $value) {
                echo '<input type="checkbox" name="pos[]" value="'.$key.'">'.$value.'<br/>';
            }
        ?>
      </div>
      <div style="float: left">
          <button type="submit">Add</button>
      </div style="float: left">
        Danh sách nhà hàng đang quản lý
    </div>
</div>