<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\field\FieldRange;
//use kartik\field\Spinner;
use kartik\widgets\TouchSpin;


AppAsset::register($this);

$this->registerJsFile('js/jquery-1.11.3.min.js', ['position' => \yii\web\View::POS_HEAD]);


$FeeType = [
    -2 => 'Ahamove quyết định',
    -1 => 'Nhà hàng liên hệ sau',
    0 => 'Miễn phí',
    -3 => 'Set chi phí',
];

?>

<!--Style hidden Div Coupon Id -->
<style>
    #couponPos{
        display: none;
    }
</style>


<body>


<div class="dmitem-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>


    <?= $form->field($model, 'POS_ID')->widget(Select2::classname(), [
        'data' => $allPosMap,
        'language' => 'en',
        'options' => ['placeholder' => 'Chọn Nhà hàng...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);

    echo FieldRange::widget([
        'form' => $form,
        'model' => $model,
        'label' => 'Giá trị đơn hàng',
        'attribute1' => 'FROM_AMOUNT',
        'attribute2' => 'TO_AMOUNT',
        'type' => FieldRange::INPUT_SPIN,
        'widgetOptions1' =>[
            'pluginOptions' => [

                'min' => 0,
                'max' => 10000000,
                'step' => 1000,
                'decimals' => 0,
                'boostat' => 5,
                'maxboostedstep' => 10,
                'prefix' => '$',
            ],
        ],
        'widgetOptions2' =>[
            'pluginOptions' => [

                'min' => 0,
                'max' => 10000000,
                'step' => 1000,
                'decimals' => 0,
                'boostat' => 5,
                'maxboostedstep' => 10,
                'prefix' => '$',
            ],
        ]

    ]);

    echo FieldRange::widget([
        'form' => $form,
        'model' => $model,
        'label' => 'Khoảng cách',
        'attribute1' => 'FROM_KM',
        'attribute2' => 'TO_KM',
        'type' => FieldRange::INPUT_SPIN,

    ]);

    ?>

    <?= $form->field($model, 'FEE')->dropDownList($FeeType,['prompt'=>'Chọn loại...','class' => 'form-control couponlog-type']); ?>

    <div id="couponPos">
        <label>Phí vận chuyển</label>
        <?=
            \yii\widgets\MaskedInput::widget([
                'name' => 'fee',
                'mask' => '9',
                'clientOptions' => ['repeat' => 10, 'greedy' => false]
            ]);
        ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>



<!-- ./Style hidden Div Coupon Id -->

<script type="text/javascript">

    $(document).ready(function(){
        $('.couponlog-type').on('change', function() {
            if ( this.value == -3)
            {
                $('#couponPos').fadeIn('slow'); // Hien
            }else{
                $('#couponPos').fadeOut('slow'); // Ẩn
            }
        });

    });



</script>

