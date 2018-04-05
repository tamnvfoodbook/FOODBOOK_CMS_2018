<?php
use yii\bootstrap\Modal;
use backend\assets\AppAsset;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use \yii\helpers\Html;

$this->registerJsFile('plugins/jQuery/jQuery-2.1.4.min.js', ['position' => \yii\web\View::POS_HEAD]);



$this->title = 'Biểu đồ khách hàng';
//echo '<pre>';
//var_dump(json_encode(array_values($oldArr)));
//var_dump(json_encode(array_values($amountStatis)));
//echo '</pre>';
//die();

?>



<section class="container">
    <div class="card" >
        <div class="front">
            <div class="col-md-6">
                hello
            </div>
            <button onclick="flip()" class="btn btn-success">flip the card</button>
        </div>
        <div class="back">2
            <button onclick="flip()">flip the card</button></div>
    </div>
</section>

<script>
    function flip() {
        $('.card').toggleClass('flipped');
    }

</script>

<style>
    .container {
        width: 300px;
        height: 260px;
        position: relative;
        -webkit-perspective: 800px;
        -moz-perspective: 800px;
        -o-perspective: 800px;
        perspective: 800px;
    }
    .card {
        width: 100%;
        height: 100%;
        position: absolute;
        -webkit-transition: -webkit-transform 1s;
        -moz-transition: -moz-transform 1s;
        -o-transition: -o-transform 1s;
        transition: transform 1s;
        -webkit-transform-style: preserve-3d;
        -moz-transform-style: preserve-3d;
        -o-transform-style: preserve-3d;
        transform-style: preserve-3d;
        -webkit-transform-origin: 50% 50%;
    }
    .card div {
        display: block;
        height: 100%;
        width: 100%;
        color: white;
        text-align: center;
        font-weight: bold;

        position: absolute;
        -webkit-backface-visibility: hidden;
        -moz-backface-visibility: hidden;
        -o-backface-visibility: hidden;
        backface-visibility: hidden;
    }
    .card .front {
        background: red;
    }
    .card .back {
        background: blue;
        -webkit-transform: rotateY( 180deg );
        -moz-transform: rotateY( 180deg );
        -o-transform: rotateY( 180deg );
        transform: rotateY( 180deg );
    }
    .card.flipped {
        -webkit-transform: rotateY( 180deg );
        -moz-transform: rotateY( 180deg );
        -o-transform: rotateY( 180deg );
        transform: rotateY( 180deg );
    }

</style>
