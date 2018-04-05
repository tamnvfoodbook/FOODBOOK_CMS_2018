<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use backend\assets\AppAsset;
use kartik\widgets\SwitchInput;
use kartik\date\DatePicker;

AppAsset::register($this);
//$this->registerJsFile('js/jquery-1.9.1.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('js/jquery-2.1.1.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('https://maps.googleapis.com/maps/api/js?key=AIzaSyC3dpfQQg9YAinYUz8ifmVHlous9WGiD6s&libraries=places', ['position' => \yii\web\View::POS_HEAD]);


?>
<br/>

<div class="grid-view"><div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> <?= $this->title ?></h3>
    </div>

    <div class="clearfix"></div>

    <div class="rc-handle-container">
        <div class="box-body">
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);?>
            <div class="col-md-6 no-padding">
                <?= $form->field($model, 'POS_NAME')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'PHONE_NUMBER')->widget(\yii\widgets\MaskedInput::className(), [
                    'mask' => ['999-999-9999', '9999-999-9999']
                ]) ?>

                <?= $form->field($model, 'CURRENCY')->widget(Select2::classname(), [
                    'data' => $allCurrencyMap,
                    'options' => ['placeholder' => 'Chọn ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>

                <?= $form->field($model, 'LOCALE_ID')->widget(Select2::classname(), [
                    'data' => $country_codes,
                    'options' => ['placeholder' => 'Chọn Mã vùng...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>

                <?= $form->field($model, 'ACTIVE')->widget(Select2::classname(), [
                    'data' => ['1' => 'Active', '0' => 'Deactive' ],
                ]);
                ?>


            </div>
            <div class="col-md-6 ">
                <?= $form->field($model, 'TIME_END')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'Ngày hết hạn...'],
                    'pluginOptions' => [
                        'autoclose'=>true
                    ]
                ]);
                ?>

                <?= $form->field($model, 'DECIMAL_NUMBER')->textInput() ?>
                <?= $form->field($model, 'DECIMAL_MONEY')->textInput() ?>

                <?= $form->field($model, 'CITY_ID')->widget(Select2::classname(), [
                    'data' => $cityMap,
                    'options' => ['placeholder' => 'Chọn ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
                <?= $form->field($model, 'POS_ADDRESS')->textInput() ?>

                <br>
                <div class="pull-right">
                    <?= Html::submitButton($model->isNewRecord ? 'Tạo mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div><!-- /.box-body -->
    </div>
</div>





<script>
    // Script gent Merchange Id
    function myFunction() {
        var RandomString = '';
        if (confirm("Bạn có chắc chắn muốn sinh mã Merchent Id không ?") == true) {
            var RandomString = stringGen(32); //32 length string
            document.getElementById("merchant_id_txt").value = RandomString;
        } else {
            return false;
        }
    }

    function stringGen(len)
    {
        var text = "IPOS" + "<?= $model->POS_PARENT ?>" + "<?= $model->ID ?>";
        console.log(text.length);
        var num_base_length = text.length;
        var text_gen_length = len - num_base_length;
        if(text_gen_length > 0){
            var charset = "abcdefghijklmnopqrstuvwxyz0123456789";
            for( var i=0; i < text_gen_length; i++ )
                text += charset.charAt(Math.floor(Math.random() * charset.length));
        }else{
            text = text.substring(1, 32);
        }

        return text.toUpperCase();
    }

    // !.Script gent Merchange Id

</script>



<style>
    .controls {
        margin-top: 10px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
    }

    #input-add {
        background-color: #fff;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 300px;
    }

    #input-add:focus {
        border-color: #4d90fe;
    }


    #type-selector label {
        font-size: 13px;
        font-weight: 300;
    }
    #map-canvas{
        width: 100%;
        height: 300px;
    }

</style>

<script>
    var map = new google.maps.Map(document.getElementById('map-canvas'), {
        center: {lat: 20.986102, lng: 105.846498},
        zoom: 15,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    // Create the search box and link it to the UI element.
    var input = document.getElementById('input-add');
    var searchBox = new google.maps.places.SearchBox(input);
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    // Bias the SearchBox results towards current map's viewport.
    map.addListener('bounds_changed', function() {
        searchBox.setBounds(map.getBounds());
    });

    var markers = [];
    // [START region_getplaces]
    // Listen for the event fired when the user selects a prediction and retrieve
    // more details for that place.
    searchBox.addListener('places_changed', function() {
        var places = searchBox.getPlaces();

        if (places.length == 0) {
            return;
        }

        // Clear out the old markers.
        markers.forEach(function(marker) {
            marker.setMap(null);

        });
        markers = [];

        // For each place, get the icon, name and location.
        var bounds = new google.maps.LatLngBounds();
        places.forEach(function(place) {
            var icon = {
                url: place.icon,
                size: new google.maps.Size(71, 71),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(17, 34),
                scaledSize: new google.maps.Size(25, 25)
            };

            // Create a marker for each place.
            var marker = new google.maps.Marker({
                map: map,
                //icon: icon,
                title: place.name,
                position: place.geometry.location,
                draggable: true
            });

            //console.log(place.formatted_address);
            $('#dmpos-pos_address').val(place.formatted_address);
            $('#dmpos-pos_latitude').val(place.geometry.location.lat()); //show  Latitude lên textInput sau khi kéo thả
            $('#dmpos-pos_longitude').val(place.geometry.location.lng()); //show  Long lên textInput sau khi kéo thả



            markers.push(marker);

            if (place.geometry.viewport) {
                // Only geocodes have viewport.
                bounds.union(place.geometry.viewport);
            } else {
                bounds.extend(place.geometry.location);
            }


            google.maps.event.addListener(marker, 'dragend', function() {
                geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            //console.log(results[0]);
                            $('#dmpos-pos_address').val(results[0].formatted_address);
                            $('#dmpos-pos_latitude').val(results[0].geometry.location.lat()); //show  Latitude lên textInput sau khi kéo thả
                            $('#dmpos-pos_longitude').val(results[0].geometry.location.lng()); //show  Long lên textInput sau khi kéo thả
                        }
                    }
                });
            });



        });
        map.fitBounds(bounds);
    });


    var geocoder = new google.maps.Geocoder();
    //var myLatlng = new google.maps.LatLng(lat, long);

    //Chặn phím Enter submit form.
    $('form input').on('keypress', function(e) {
        return e.which !== 13;
    });

</script>

