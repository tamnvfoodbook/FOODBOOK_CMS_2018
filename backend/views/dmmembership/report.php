<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;
use kartik\grid\EditableColumn;

use backend\assets\AppAsset;

AppAsset::register($this);
$this->registerJsFile('plugins/jQuery/jQuery-2.1.4.min.js', ['position' => \yii\web\View::POS_HEAD]);

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OrderonlinelogSearch */
/* @var $allPosMap backend\controllers\OrderonlinelogController */
/* @var $dateRanger backend\controllers\OrderonlinelogController */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Danh sách khách hàng';
$this->params['breadcrumbs'][] = $this->title;

$importExcel = Html::a('Thêm khách hàng từ Excel',null, ['class' => 'btn btn-success','id' => 'uploadExcel']);

// Check nếu như có App thì sẽ hiển thị POPUP thông báo lên.
if(@$posparentModel->APP_ID){
    $pushApp = Html::a('Gửi thông báo qua App',null, ['class' => 'btn btn-success','id' => 'pushApp']);
}else{
    $pushApp = '';
}

$pushApp = Html::a('Gửi thông báo qua App',null, ['class' => 'btn btn-success','id' => 'pushApp']);


//echo '<pre>';
//var_dump($dataProvider);
//echo '</pre>';
//die();
$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],

//    'membership_id',
//    'Id',
    [
        'attribute' => 'membership_id',
        'format' => 'raw',
        'value' => function ($model){
            return '<p>'.$model->Id.'</p>'.@$model->Member_Name;
        },
        'label' => 'Khách hàng'
    ],
    [
        'attribute' => 'Sex',
        'label' => 'Giới tính',
        'value' => function ($model){

            return $model->Sex ? "Nam" : "Nữ";
        },
    ],
    [
        'attribute' => 'birthday',
        'label' => 'Sinh nhật ',
        'value' => function ($model){
            if(@$model->Birthday){
                return date(Yii::$app->params['DATE_FORMAT'],strtotime(@$model->Birthday));
            }
        },
    ],
    [
        'attribute' => 'user_group',
        'format' => 'raw',
        'label' => 'Nhóm khách',
        'value' => function ($model) use($groupMember){
            return @$groupMember[$model->user_group];
        },
    ],
    [
        'label' => 'Thành phố',
        'format' => 'raw',
        'value' => function ($model) use($allCityMap){
            return @$allCityMap[$model->City_Id];
        },
    ],
    [
        'attribute' => 'Eat_Count',
        'label' => 'Số lần ăn',
    ],
    [
        'attribute' => 'Payment_Amount',
        'format'=>['decimal',0],
        'label' => 'Đã tiêu',
    ],
    [
        'attribute' => 'Point',
        'label' => 'Tích điểm',
    ],
    [
        'attribute' => 'Eat_Last_Date',
        'label' => 'Lần cuối ăn',
        'value' => function ($model){
            if(@$model->Eat_Last_Date){
                return date(Yii::$app->params['DATE_FORMAT'],strtotime(@$model->Eat_Last_Date));
            }
        },
    ],

    [
        'label' => 'Số ngày chưa trở lại',
        'value' => function ($model){

            //Our dates
            if(@$model->Eat_Last_Date){
                $date1 = $model->Eat_Last_Date;
                $date2 = date('Y-m-d 00:00:00');

                //Convert them to timestamps.
                $date1Timestamp = strtotime($date1);
                $date2Timestamp = strtotime($date2);

                //Calculate the difference.
                $difference = $date2Timestamp - $date1Timestamp;
                $days = floor($difference / (60*60*24) );
                $daysComeback =  number_format($days);
            }

            return @$daysComeback;
        },
    ],
    [
        'label' => 'Đã kết nối',
        'format' => 'raw',
        'value' => function ($model){
            /*echo '<pre>';
            var_dump($model);
            echo '</pre>';*/
            $listused = '<button type="button" onclick="sendGiftZalo('.$model->Id.')" style="border: 0; background: transparent"><img src="/images/icon-logo/sms-logo-30x30.png"></button>';
            if(@$model->Zalo_Id){
                $zaloId = "'".@$model->Zalo_Id."'" ;

                if(@$model->Zalo_Id){
                    $zalo_logo = '<button type="button" onclick="sendGiftZalo('.$model->Id.','.$zaloId.')" style="border: 0; background: transparent" ><img src="/images/icon-logo/zalo-logo-30x30.png"></button>';
                    $listused = $listused.' '.$zalo_logo;
                }
            }
            if(@$model->Facebook_Mes_Id){
                $faceId = "'".@$model->Facebook_Mes_Id."'" ;
                if(@$model->Facebook_Mes_Id){
                    $face_logo = '<button type="button" onclick="sendGiftZalo('.$model->Id.','.$faceId.')" style="border: 0; background: transparent" ><img src="/images/icon-logo/fb-logo-30x30.png"></button>';
                    $listused = $listused.' '.$face_logo;
                }
            }


            return @$listused;
        },
    ],

];

?>
<br>
<div>
    <?= $this->render('_search_report', [
        'model' => $searchModel,
//    'allMemberMap' => $allMemberMap,
//    'allMemberMapPhone' => $allMemberMapPhone,
        'groupMember' => $groupMember,
        'allCityMap' => $allCityMap,
        'allMemberTypeMap' => $allMemberTypeMap,
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

<?php
$form = ActiveForm::begin([
    'id' => 'sendPushAppForm',
]);

Modal::begin([
    'header' => '<h4>Tin nhắn thông báo trên App </h4>',
    'footer' => '<input type="button" value="Gửi thông báo" class="btn btn-success" id="btn_sendPushApp" >',
    'id' => 'pushAppModal',
]);

echo '<div class="form-group" id="sendpushapp_content_mess">
    <label>Nội dung tin nhắn</label>
    <textarea class="form-control" name="messPushApp" id="mes_content" maxlength="146"></textarea>
</div>';

echo '<div class="form-group" id="sendpushapp_link_mess">
    <label>Đường dẫn URL</label>
    <input class="form-control" name="link_mess" id="link_mess" maxlength="146">
</div>';

echo '<div class="form-group" id="sendpushapp_link_mess">
    <label>Số điện thoại test trước (nếu nhiều số thì các số điện thoại ngăn cách nhau bởi dấu phẩy )</label>
    <input class="form-control" name="phone_mess">
</div>';

echo '<div id="messeagepush_p" style="display: none;line-height: 2em; padding-left: 10px" class="help-messeage"></div>';

echo Html::hiddenInput('predata',json_encode($paramData));

Modal::end();

ActiveForm::end();
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
        $pushApp,
//        '{toggleData}',
        '{export}',
        //$fullExportMenu,
    ]

]);
?>
<?php
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

    $('#mes_content').on('input',function(e){
        var content = $(this).val().length;
        var url = $("#link_mess").val().length;
        var sub = content + url;
        var messhelp = $('#messeagepush_p');
        if(sub > 146){
            $('#btn_sendPushApp').prop('disabled', true);
            var maxlengFail = 'Thông báo của bạn không được vượt quá 146 kí tự';
            messhelp.html(maxlengFail).addClass('alert-danger');
            messhelp.show();

        }else{
            $('#btn_sendPushApp').prop('disabled', false);
            messhelp.hide();
        }
    });

    $('#link_mess').on('input',function(e){
        var url = $(this).val().length;
        var content = $("#mes_content").val().length;
        var sub = content + url;

        var messhelp = $('#messeagepush_p');
        if(sub > 146){
            $('#btn_sendPushApp').prop('disabled', true);
            var maxlengFail = 'Thông báo của bạn không được vượt quá 146 kí tự';
            messhelp.html(maxlengFail).addClass('alert-danger');
            messhelp.show();

        }else{
            $('#btn_sendPushApp').prop('disabled', false);
            messhelp.hide();
        }
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


    $(function(){
        $('#btn_sendPushApp').click(function(){
            var dataForm = getFormObj('sendPushAppForm');
            $.ajax({type: "POST",
                    url: "<?= Url::toRoute('/dmmembership/pushmess')?>",
                    data: { messPushApp : dataForm.messPushApp, urlPushApp : dataForm.link_mess, preData : dataForm.predata, phone : dataForm.phone_mess },

                    beforeSend: function() {
                        //that.$element is a variable that stores the element the plugin was called on
                        $("#sendpushapp_content_mess").addClass("fb-grid-loading");
                    },
                    complete: function() {
                        //$("#modalButton").removeClass("loading");
                        $("#sendpushapp_content_mess").removeClass("fb-grid-loading");
                    },

                    success:function(result){
                        console.log(result);
                        var obj = JSON.parse(result);
                        var messhelp = $('#messeagepush_p');

                        if(obj.status == 1){
                            messhelp.html(obj.message).addClass('alert-success');
                        }else{
                            messhelp.html(obj.message).addClass('alert-danger');
                        }

                        messhelp.show();
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
        $('.close').click(function(){
            $('.help-messeage').hide();
        });
    });

    $(function(){
        $('#uploadExcel').click(function(){
            $('#modal2').modal('show');
//                .find('#orderdetailContent')
//                .load($(this).attr('value'));
        });
    });

    $(function(){
        $('#pushApp').click(function(){
            $('#pushAppModal').modal('show');
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
