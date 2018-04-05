<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use backend\assets\AppAsset;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\widgets\DetailView;



AppAsset::register($this);
//$this->registerJsFile('js/jquery-1.9.1.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('js/jquery-2.1.1.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('js/stepsForm.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('https://maps.googleapis.com/maps/api/js?key=AIzaSyC3dpfQQg9YAinYUz8ifmVHlous9WGiD6s&libraries=places', ['position' => \yii\web\View::POS_HEAD]);
//$this->registerCssFile('css/bwizard.min.css', ['position' => \yii\web\View::POS_HEAD]);
$this->registerCssFile('css/stepsForm.css', ['position' => \yii\web\View::POS_HEAD]);

$this->title = 'Tạo đơn hàng';


if(isset($model->user_id)){
    $phoneNumber = $model->user_id;
}

//echo '<pre>';
//var_dump($model);
//echo '</pre>';
//die();

?>

<script>
    var selectChanged = 0;
</script>
<!--STEPS FORM START ------------ -->
<div class="stepsForm">
    <?php $form = ActiveForm::begin([
            'id' => 'search-form',
            'method' => 'post',
            'action' => ['orderonlinelog/pro']
        ]
    ); ?>
    <div class="sf-steps">
        <div class="sf-steps-content">
            <div>
                <span>1</span> Chọn địa chỉ
            </div>
            <div>
                <span>2</span> Chọn món ăn
            </div>

        </div>
    </div>
    <div class="sf-steps-form sf-radius">
        <ul class="sf-content"> <!-- form step one -->
            <li>
                <div class="col-md-6">
                    <div class="box box-success box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Bản đồ</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <input id="pac-input" class="controls" type="text" placeholder="Gõ địa chỉ tìm kiếm..."  name="mapAdress" data-required="true" value="<?=$model->to_address?>" autofocus>
                            <div id="map-canvas" style="float: left"></div>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div>

                <div id="json_data" class="col-md-6">

                    <div class="box box-success box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Địa chỉ - Nhà hàng</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body addressPos">
                            <div class="input-group">
                                <?= $form->field($model, 'to_address',[
                                    'options' => [
                                        'data-required' =>'true',
                                    ]
                                ])?>

                                <span class="input-group-btn" style="padding-top: 19px">
                                    <button class="btn btn-primary btn-flat" type="button" id="btn_reuse_adress">Sử dụng địa chỉ cũ</button>
                                </span>
                            </div>

                            <input type="hidden" id="latitude" name="newLatAdress" placeholder="Latitude" value="<?=$model->longitude?>" class="form-control" />

                            <input type="hidden" id="longitude" name="newLongAdress" placeholder="Longitude"  value="<?=$model->latitude?>" class="form-control"/>

                            <?= $form->field($model,'paymentInfo')->hiddenInput(['value' => 'PAYMENT_ON_DELIVERY'])->label(false) ?>

                            <?= $form->field($model,'user_id')->hiddenInput(['value'=> $phoneNumber])->label(false)?>

                            <input type="hidden" name="userName" value="<?=$nameMember?>"/>


                            <?= $form->field($model, 'pos_id')->widget(Select2::classname(), [
                                'data' => $allPosMap,
                                'options' => [
                                    'data-required' => true,
                                    'prompt'=>'Chọn nhà hàng...',
                                    'onchange'=>'
                                                    $.get( "'.\yii\helpers\Url::toRoute('/orderonlinelog/subcat1').'", { id: $(this).val(),longitude : $("#longitude").val(),latitude : $("#latitude").val(),address : $("#orderonlinelog-to_address").val(),user_id : $("#orderonlinelog-user_id").val(), } )
                                                        .done(function( data ) {
                                                            $( "#smart_cart" ).html(data);
                                                        }
                                                    );
                                                    ',
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                ],
                            ])
                            ?>

                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div>
            </li>
        </ul>

        <ul class="sf-content"> <!-- form step two -->
            <li>
                <!--Phần 2 -->
                <div>
                    <div id="smart_cart"></div>
                </div>
            </li>

        </ul>
    </div>

    <!--<div class="sf-steps-navigation sf-align-right">
        <span id="sf-msg" class="sf-msg-error"></span>
        <button id="sf-prev" type="button" class="sf-button">Quay lại</button>
        <button id="sf-next" type="button" class="sf-button">Tiếp tục</button>
    </div>-->
    <?php ActiveForm::end(); ?>
</div>
<!--STEPS FORM END -------------- -->

<script>
    $(document).ready(function(e) {
        $(".stepsForm").stepsForm({
            width			:'100%',
            active			:0,
            errormsg		:'Bạn phải nhập địa chỉ vào ô gõ địa chỉ tìm kiếm',
            sendbtntext		:'Tạo đơn hàng',
            posturl			:'<?= \yii\helpers\Url::toRoute('/orderonlinelog/pro')?>',
            theme			:'green',
            selectChanged   :selectChanged
        });

        $(".container .themes>span").click(function(e) {
            $(".container .themes>span").removeClass("selectedx");
            $(this).addClass("selectedx");
            $(".stepsForm").removeClass().addClass("stepsForm");
            $(".stepsForm").addClass("sf-theme-"+$(this).attr("data-value"));
        });


    });
    //Check, neu nhuw khong cos
    var latOfLastOrder = '<?= @$lastOrder->latitude ?>';
    if(latOfLastOrder == ''){
        $('#btn_reuse_adress').removeClass('btn-primary');
        $('#btn_reuse_adress').addClass('btn-danger disabled ');
    }

    // When submit button reuse address, set lat, long, full adress text and value

    $('#btn_reuse_adress').on('click', function() {
        $('#orderonlinelog-to_address').val('<?= @$lastOrder->to_address ?>');
        $('#pac-input').val('<?= @$lastOrder->to_address ?>');
        $('#latitude').val('<?= @$lastOrder->latitude ?>');
        $('#longitude').val('<?= @$lastOrder->longitude ?>');
    });


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

    #pac-input {
        background-color: #fff;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 300px;
    }

    #pac-input:focus {
        border-color: #4d90fe;
    }

    .pac-container {
        /*font-family: Roboto;*/
    }

    #type-selector {
        color: #fff;
        background-color: #4d90fe;
        padding: 5px 11px 0px 11px;
    }

    #type-selector label {
        font-size: 13px;
        font-weight: 300;
    }
    #map-canvas{
        width: 100%;
        height: 400px;
    }

    .addressPos{
        width: 100%;
        height: 420px;
    }

</style>


<script>
    var map = new google.maps.Map(document.getElementById('map-canvas'), {
        center: {lat: 20.986102, lng: 105.846498},
        zoom: 15,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    // Create the search box and link it to the UI element.
    var input = document.getElementById('pac-input');
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
            $('#orderonlinelog-to_address').val(place.formatted_address);
            $('#latitude').val(place.geometry.location.lat()); //show  Latitude lên textInput sau khi kéo thả
            $('#longitude').val(place.geometry.location.lng()); //show  Long lên textInput sau khi kéo thả

            function removeOptions(selectbox)
            {
                var i;
                for(i=selectbox.options.length-1;i>=0;i--)
                {
                    selectbox.remove(i);
                }
            }

            var select = document.getElementById('orderonlinelog-pos_id');

            removeOptions(select); // Clear toàn bộ list
            // Tạo phần tử khởi đầu place hover
            opt = document.createElement("option");
            opt.value = '';
            opt.textContent = 'Chọn nhà hàng...';
            select.add(opt);
            $("#orderonlinelog-pos_id").select2("val","");


            // !. End Tạo phần tử khởi đầu place hover

//            if (!select.value || select.value == '') {
//                select.val = 'placeholdertext';
//            }

            var posMap = <?= json_encode($allPosToCheckDistanceMap); ?>; // output php string here

            var arr = [];

            $.each(posMap, function(key, value) {
                //get Lat long tu array php
                var arrayPos = value.split('._.');
                var distance = getDistance(arrayPos[2],arrayPos[1],place.geometry.location.lat(),place.geometry.location.lng());

                arr.push({
                    'key': key,
                    'distance': distance/1000, // chia cho 1000 để lấy theo km
                    'posName': arrayPos[0]
                });

                arr.sort(function(a, b) {
                    return a.distance - b.distance;
                });
            });


            $.each(arr, function(key, value) {
                //get Lat long tu array php
                //var arrayPos = value.split('._.');
                opt = document.createElement("option");
                opt.value = value.key;
                distance_convert = value.distance.toFixed(1).replace(/(\d)(?=(\d{3})+\.)/g, '$1,'); // convert số liệu theo chuẩn format Number
                opt.textContent = value.posName +  ' : ' + distance_convert + ' km';
                select.add(opt);
            });
            $('.field-orderonlinelog-to_address').addClass('has-success');


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
                            $('#orderonlinelog-to_address').val(results[0].formatted_address);
                            $('#latitude').val(results[0].geometry.location.lat()); //show  Latitude lên textInput sau khi kéo thả
                            $('#longitude').val(results[0].geometry.location.lng()); //show  Long lên textInput sau khi kéo thả

                            function removeOptions(selectbox)
                            {
                                var i;
                                for(i=selectbox.options.length-1;i>=0;i--)
                                {
                                    //console.log(i);
                                    selectbox.remove(i);
                                }
                            }

                            var select=document.getElementById('orderonlinelog-pos_id');



                            removeOptions(select); // Clear toàn bộ list
                            opt = document.createElement("option");
                            opt.value = '';
                            opt.textContent = 'Chọn nhà hàng...';
                            select.add(opt);
                            $("#orderonlinelog-pos_id").select2("val","");

                            var posMap = <?php echo  json_encode($allPosToCheckDistanceMap); ?>; // output php string here

                            var arr = [];

                            $.each(posMap, function(key, value) {
                                //get Lat long tu array php
                                var arrayPos = value.split('._.');

                                var distance = getDistance(arrayPos[2],arrayPos[1],results[0].geometry.location.lat(),results[0].geometry.location.lng());
                                //distance_convert = distance.toFixed(1).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');                                // Add option to dropdownlist

                                arr.push({
                                    'key': key,
                                    'distance': distance/1000,
                                    'posName': arrayPos[0]
                                });

                                arr.sort(function(a, b) {
                                    return a.distance - b.distance;
                                });

                            });

                            $.each(arr, function(key, value) {
                                //get Lat long tu array php
                                //var arrayPos = value.split('._.');
                                //console.log(value.key);
                                opt = document.createElement("option");
                                opt.value = value.key;
                                distance_convert = value.distance.toFixed(1).replace(/(\d)(?=(\d{3})+\.)/g, '$1,'); // convert số liệu theo chuẩn format Number
                                opt.textContent = value.posName +  ' : ' + distance_convert + 'km';
                                select.add(opt);
                            });
                            $('.field-orderonlinelog-to_address').addClass('has-success');



                        }
                    }
                });
            });



        });
        map.fitBounds(bounds);
    });


    var geocoder = new google.maps.Geocoder();
    //var myLatlng = new google.maps.LatLng(lat, long);


    var rad = function(x) {
        return x * Math.PI / 180;
    };

    var getDistance = function(lat1,long1,lat2,long2) {
        var R = 6378137; // Earth’s mean radius in meter
        var dLat = rad(lat2 - lat1);
        var dLong = rad(long2 - long1);
        var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos(rad(lat1)) * Math.cos(rad(lat2)) *
            Math.sin(dLong / 2) * Math.sin(dLong / 2);
        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        var d = R * c;
        return d; // returns the distance in meter
    };

    // Chặn phím Enter submit form.
    $('form input').on('keypress', function(e) {
        return e.which !== 13;
    });

</script>

