<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;

use backend\assets\AppAsset;

AppAsset::register($this);
$this->registerJsFile('plugins/jQuery/jQuery-2.1.4.min.js', ['position' => \yii\web\View::POS_HEAD]);

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OrderonlinelogSearch */
/* @var $allPosMap backend\controllers\OrderonlinelogController */
/* @var $dateRanger backend\controllers\OrderonlinelogController */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lọc khách hàng';
$this->params['breadcrumbs'][] = $this->title;

$importExcel = Html::a('Thêm khách hàng từ Excel',null, ['class' => 'btn btn-success','id' => 'uploadExcel']);

//echo '<pre>';
//var_dump($dataProvider);
//echo '</pre>';
//die();

$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],

//    'membership_id',
    [
        'attribute' => 'membership_id',
        'format' => 'raw',
        'value' => function ($model) use($allMemberMap){
            return '<p>'.$model->membership_id.'</p>'.@$allMemberMap[$model->membership_id];
        },
        'label' => 'Khách hàng'
    ],
    [
        'attribute' => 'gender',
        'label' => 'Giới tính',
        'value' => function ($model){
            return $model->gender ? "Nam" : "Nữ";
        },
    ],
    [
        'attribute' => 'birthday',
        'label' => 'Sinh nhật',
        'value' => function ($model){
            if(@$model->birthday){
                return date(Yii::$app->params['DATE_FORMAT'],strtotime(@$model->birthday));
            }
        },
    ],
    [
        'attribute' => 'user_group',
        'label' => 'Nhón khách',
        'value' => function ($model) use($groupMember){
            return @$groupMember[$model->user_group];
        },
    ],
    [
        'attribute' => 'eat_count',
        'label' => 'Số lần ăn',
    ],
    [
        'attribute' => 'amount',
        'format'=>['decimal',0],
        'label' => 'Đã tiêu',
    ],
    [
        'attribute' => 'point',
        'label' => 'Tích điểm',
    ],
    [
        'attribute' => 'eat_last_date',
        'label' => 'Lần cuối ăn',
        'value' => function ($model){
            return date(Yii::$app->params['DATE_FORMAT'],strtotime(@$model->eat_last_date));
        },
    ],

    [
        'attribute' => 'days_last_visit',
        'label' => 'Số ngày chưa trở lại',
    ],
    [
        'attribute' => 'zalo_follow',
        'label' => 'Đã kết nối',
        'format' => 'raw',
        'value' => function ($model){
            $zaloId = "'".@$model->zalo_follow."'" ;
            $listused = '<button type="button" onclick="sendGiftZalo('.$model->membership_id.')" style="border: 0; background: transparent"><img src="/images/icon-logo/sms-logo-30x30.png"></button>';
            if(@$model->zalo_follow){
                $zalo_logo = '<button type="button" onclick="sendGiftZalo('.$model->membership_id.','.$zaloId.')" style="border: 0; background: transparent" ><img src="/images/icon-logo/zalo-logo-30x30.png"></button>';
                $listused = $listused.' '.$zalo_logo;
            }

            return $listused;
        },
    ],

];

?>
<br>
<div>
<?= $this->render('_search_report', [
    'model' => $searchModel,
    'timeRanger' => $timeRanger,
    'allMemberMap' => $allMemberMap,
//    'allMemberMapPhone' => $allMemberMapPhone,
    'groupMember' => $groupMember,
    ])?>
</div>


<?php
Modal::begin([
    'header' => '<h4>Tạo chiến dịch CSKH</h4>',
//    'footer' => '<input id= "btn_seteatwith" type="submit" value="Chọn" class="btn btn-success">',
    'footer' => '',
    'id' => 'creatCam',
]);
echo $this->render('../dmevent/_form_evoucher_follow', [
    'model' => $model,
    'campaginsMap' => $campaginsMap,
    'paramData' => $paramData,
]);
Modal::end();
?>


<?= GridView::widget([
    'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,
    'columns' => $gridColumns,
    'panel' => [
        'type' => GridView::TYPE_SUCCESS,
        'heading' => '<h3 class="panel-title">'.$this->title.'</h3>',
    ],
    'toolbar' => [
        Html::button("Tạo chiến dịch CSKH",['class' => 'btn btn-success','id' => 'creatVc']),
        $importExcel,
        '{toggleData}',
        '{export}',
        //$fullExportMenu,
    ]

]);



Modal::begin([
    'header'=>'Tải lên tệp tin Danh sách khách hàng Excel',
    'id' => 'modal2',
]);
$form1 = ActiveForm::begin([
    'options'=>['enctype'=>'multipart/form-data'], // important
    'action' => ['dmmembership/importexcel'],
]);

echo $form1->field($model, 'ID')->widget(FileInput::classname(), [
    'name'=>'kartiks_file',
    'pluginOptions' => [
        'showPreview' => false,
        'showCaption' => true,
        'showRemove' => true,
        'showUpload' => false
    ]
])->label(false);
echo '<br>';
echo Html::submitButton('Tải lên', ['class' => 'btn btn-success']);
$path = Yii::getAlias('@web') . '/excel';
$file = $path . '/Danh-sach-khach-hang.xls';
echo '<a href="'.$file.'" download class="btn btn-primary" style="margin-left: 2px">File excel mẫu</a>';

ActiveForm::end();
Modal::end();

?>

<?php
Modal::begin([
    'header' => '<h4>Gửi tin nhắn</h4>',
    'id' => 'zalomodal',
]);

$form2 = ActiveForm::begin([
    'action' => ['dmmembership/sendgiftzalo'],
    'id' => 'sendgiftForm',
]);
echo '<div id="zaloContent">';
    echo '<form action="">';
    echo '<input type="hidden" name="phone" id="phone">';
    echo '<input type="hidden" name="typegift" id="type">';
    echo '<input type="hidden" name="zaloId" id="zaloId">';
    echo '<label>Nội dung tin nhắn</label>';
    echo '<textarea rows="4" class="form-control" name="smscontent"></textarea>';
    echo '<br>';
    echo '<div id="messeage_p" style="display: none;line-height: 2em; padding-left: 10px"></div>';
echo '</div>';
echo '<br>';
echo Html::button('Tặng quà', ['class' => 'btn btn-success','id' => 'sendgift_btn']);
ActiveForm::end();
Modal::end();
?>

<script>

    function sendGiftZalo(phone,zaloId = null){
        console.log(phone);
        console.log(zaloId);
        $('#phone').val(phone);
        $('#zaloId').val(zaloId);
        if(zaloId){
            $('#type').val(2);
        }else{
            $('#type').val(1);
        }


        $('#zalomodal').modal('show')
            .find('#zaloContent')
            .load($(this).attr('value'));
    }


    $('.modal-dialog').on('hidden.bs.modal', function () {
        window.alert('hidden event fired!');
    });


    $(function(){
        $('#sendgift_btn').click(function(){
            var dataForm = getFormObj('sendgiftForm');
            $.ajax({type: "POST",
                    url: "<?= Url::toRoute('/dmmembership/sendgiftzalo')?>",
                    data: { phone: dataForm.phone ,typeGift : dataForm.typegift, smscontent : dataForm.smscontent,zaloId: dataForm.zaloId },

                    beforeSend: function() {
                        //that.$element is a variable that stores the element the plugin was called on
                        $("#zaloContent").addClass("fb-grid-loading");
                    },
                    complete: function() {
                        //$("#modalButton").removeClass("loading");
                        $("#zaloContent").removeClass("fb-grid-loading");
                    },

                    success:function(result){
                        console.log(result);
                        var obj = JSON.parse(result);
                        if(obj.status == 1){
                            $('#messeage_p').show();
                            $('#messeage_p').html(obj.message).addClass('alert-success');
                        }else{
                            $('#messeage_p').show();
                            $('#messeage_p').html(obj.message).addClass('alert-danger');
                        }
                    }}
            );
        });
    });

    function getFormObj(formId) {
        var formObj = {};
        var inputs = $('#'+formId).serializeArray();
        $.each(inputs, function (i, input) {
            formObj[input.name] = input.value;
        });
        return formObj;
    }


    $(function(){
        $('#creatVc').click(function(){
            $('#creatCam').modal('show')
                .find('#creatCamContent')
                .load($(this).attr('value'));
        });
    });

    $(function(){
        $('#uploadExcel').click(function(){
            $('#modal2').modal('show');
//                .find('#orderdetailContent')
//                .load($(this).attr('value'));
        });
    });



    var phone = $('#dmeventsearch-id').val();
    if(phone != ''){
        $('#creatVc').prop('disabled', true);
    }

</script>
<style>
    .suscess-mes{
        text-align: center;
        color: #01990f;
    }
    .danger-mes{
        text-align: center;
        color: #990e29;
    }
</style>
