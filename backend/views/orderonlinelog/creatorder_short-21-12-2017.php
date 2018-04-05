<?php
// bản backup này được tạo trước khi làm món ăn kèm
use backend\assets\AppAsset;
//use yii\widgets\ActiveForm;
use kartik\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use yii\bootstrap\Modal;
use kartik\widgets\Select2;
use yii\widgets\MaskedInput;
use yii\helpers\Url;
use kartik\widgets\SwitchInput;

//$this->registerJsFile('https://maps.googleapis.com/maps/api/js?key=AIzaSyC3dpfQQg9YAinYUz8ifmVHlous9WGiD6s&libraries=places', ['position' => \yii\web\View::POS_HEAD]);
//$this->registerJsFile('js/orderonlinemap.js', ['position' => \yii\web\View::POS_HEAD]);


AppAsset::register($this);
//$this->registerJsFile('js/jquery-1.9.1.min.js', ['position' => \yii\web\View::POS_HEAD]);
//$this->registerJsFile('js/jquery-2.1.1.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('https://maps.googleapis.com/maps/api/js?key=AIzaSyC3dpfQQg9YAinYUz8ifmVHlous9WGiD6s&libraries=places&language=vi', ['position' => \yii\web\View::POS_HEAD]);
//$this->registerCssFile('css/bwizard.min.css', ['position' => \yii\web\View::POS_HEAD]);

if($isBooking){
    $this->title = 'Tạo đặt bàn';
}else{
    $this->title = 'Tạo đơn hàng';
}

$purposeMap = [
    '1' => 'Sinh Nhật',
    '2' => 'Ăn vặt',
    '3' => 'Biếu tặng'
];

//echo '<pre>';
//var_dump($listItems);
//echo '</pre>';
//die();
AppAsset::register($this);
$this->registerJsFile('plugins/jQuery/jQuery-2.1.4.min.js', ['position' => \yii\web\View::POS_HEAD]);
?>
<link href="css/smart_short_cart.css" rel="stylesheet" type="text/css">

<script type="text/javascript">

var d = new Date();
var timeTmp = d.getTime();

$(document).ready(function(){
    var isBookking = '<?= $isBooking?>';
    //(function($){

    //Script Edit Note
    $.fn.inlineEdit = function(replaceWith, connectWith) {

        $(this).hover(function() {
            $(this).addClass('hover');
        }, function() {
            $(this).removeClass('hover');
        });

        $(this).click(function() {

            var elem = $(this);
            elem.hide();
            elem.after(replaceWith);
            replaceWith.focus();

            replaceWith.blur(function() {

                if ($(this).val() != "") {
                    connectWith.val($(this).val()).change();
                    elem.text($(this).val());
                }

                $(this).remove();
                elem.show();
            });
        });
    };




    $.fn.inlineEditTest = function(replaceWith, connectWith) {

        $(this).hover(function() {
            $(this).addClass('hover');
        }, function() {
            $(this).removeClass('hover');
        });

        $(this).click(function() {

            var elem = $(this);


            elem.hide();
            elem.after(replaceWith);
            replaceWith.focus();

            replaceWith.blur(function() {

                if ($(this).val() != "") {
                    connectWith.val($(this).val()).change();
                    elem.text($(this).val());
                }

                $(this).remove();
                elem.show();
            });
        });
    };






    $.fn.smartCart = function(options) {
        var options = $.extend({}, $.fn.smartCart.defaults, options);

        return this.each(function() {
            var obj = $(this);
            // retrive all products
            var products = $("input[type=hidden]",obj);
            var resultName = options.resultName;
            var cartItemCount = 0;
            var cartProductCount = 0; // count of unique products added
            var subTotal = 0;
            var toolMaxImageHeight = 200;

            // Attribute Settings
            // You can assign the same you have given on the hidden elements
            var attrProductId = "pid";  // Product Id attribute
            var attrProductName = "pname"; // Product Name attribute
            var attrProductFullName = "pfullname"; // Product Full Name attribute
            var attrProductPrice = "pprice"; // Product Price attribute
            var attrProductDiscount = "pdiscount"; // Product Price attribute
            var attrProductImage = "pimage"; // Product Image attribute
            var attrCategoryName = "pcategory";
            var attrIsEatWith = "piseatwith";
            var attrEatWith = "peatwith";
            var attrCombo = "pcomboex";
            var attrComboItemId = "pcomboid";
            var attrIsNomalCombo = "pisnomalcb";
            var attrItemId = "pitemid";

            // Labels & Messages
            var labelCartMenuName = 'My Cart (_COUNT_)';  // _COUNT_ will be replaced with cart count
            var labelCartMenuNameTooltip = "Cart | Total Products: _PRODUCTCOUNT_ | Total Quantity: _ITEMCOUNT_";
            var labelProductMenuName = 'Products';
            var labelSearchButton = "Search";
            var labelSearchText = "Search";
            var labelCategoryText = "Category";
            var labelClearButton = "Clear";
            var labelAddToCartButton = "Thêm món";
            var labelQuantityText = "Số lượng";
            var labelProducts = 'Tên món ăn';
            var labelPrice = 'Giá';
            var labelSubtotal = 'Thành tiền';
            var labelTotal = 'Tổng';
            var labelFeeDis = 'Quãng đường (km)';
            var labelFee = 'Phí vận chuyển';
            var labelPayment = 'Thanh toán';
            var labelPhone = 'Số điện thoại';
            var labelInfo = 'Tên khách hàng';
            var labelAddres = 'Địa chỉ';
            var labelTime = 'Thời gian';
            var labelNumberPeople = 'Số người';
            var labelNote = 'Ghi chú';
            var labelPosSelect = 'Nhà hàng';

            var labelRemove = 'Remove';

            var labelAddEatWith = 'Tạo ăn kèm';
            var labelAddCombo = 'Tạo combo';
            var labelCheckout = 'Tạo đơn giao ngay';
            var labelCheckoutLater = 'Tạo đơn giao sau';
            var labelBooking = 'Đặt bàn';

            var messageConfirmRemove = 'Bạn có chắc chắn bỏ món "_PRODUCTNAME_" ?'; //  _PRODUCTNAME_ will be replaced with actula product name
            var messageCartEmpty = "Đơn hàng trống";
            var messageProductEmpty = "Có 0 kết quả";
            var messageProductAddError = "Product cannot add";
            var messageItemAdded = 'Product added to the cart';
            var messageItemRemoved = 'Product removed from the cart';
            var messageQuantityUpdated = 'Product quantity updated';
            var messageQuantityErrorAdd = 'Invalid quantity. Product cannot add';
            var messageQuantityErrorUpdate = 'Invalid quantity. Quantity cannot update';

            //Create Main Menu
            cartMenu = labelCartMenuName.replace('_COUNT_','0'); // display default
            var btShowCart = $('<a>'+cartMenu+'</a>').attr("href","#scart");
            var btShowProductList = $('<a>'+labelProductMenuName+'</a>').attr("href","#sproducts");
            var msgBox2 = $('<div></div>').addClass("scMessageBar2").hide();

            var elmProductMenu = $("<li></li>").append(btShowProductList);
            var elmCartMenu = $("<li></li>").append(btShowCart);
            var elmMsgBox = $("<li></li>").append(msgBox2);
            var elmMenuBar = $('<ul></ul>').addClass("scMenuBar").append(elmProductMenu).append(elmCartMenu).append(elmMsgBox);
            //obj.prepend(elmMenuBar);

            // Create Search Elements
            var elmPLSearchPanel = $('<div></div>').addClass("scSearchPanel");
            if(options.enableSearch){
                var btSearch = $('<a>'+labelSearchButton+'</a>').attr("href","#").addClass("btn btn-block btn-success btn-xs scSearch").attr("title","Search Product");
                $(btSearch).click(function() {
                    var searcStr = $(txtSearch).val();
                    populateProducts(searcStr);
                    return false;
                });
                var btClear = $('<a>'+labelClearButton+'</a>').attr("href","#").addClass("btn btn-block btn-success btn-xs scSearch").attr("title","Clear Search");
                $(btClear).click(function() {
                    $(txtSearch).val('');
                    populateProducts('');
                    return false;
                });
                var txtSearch = $('<input type="text" placeholder="Tìm kiếm món ăn"/>').attr("value","").addClass("scTxtSearch controls")
                $(txtSearch).keyup(function() {
                    var searcStr = $(this).val();
                    populateProducts(searcStr);
                });
                //var lblSearch = $('<label>'+labelSearchText+':</label>').addClass("scLabelSearch");
                elmPLSearchPanel/*.append(lblSearch)*/.append(txtSearch)/*.append(btSearch).append(btClear)*/;
            }
            // Create Category filter
            if(options.enableCategoryFilter){
                var lblCategory = $('<label>'+labelCategoryText+':</label>').addClass("scLabelCategory ");
                var elmCategory = $("<select></select>").addClass("scSelCategory controls");
                elmPLSearchPanel/*.append(lblCategory)*/.append(elmCategory);
                fillCategory();
            }


            // Create Product List
            var elmPLContainer = $('<div></div>').addClass("toolBar").hide();

            elmPLContainer.prepend(elmPLSearchPanel);

            var elmPLProducts = $('<div></div>').addClass("box-body scProductList");

            elmPLContainer.append(elmPLProducts);

            var proContain = $('<div></div>').addClass("col-md-7 col-sm-7 col-xs-7 productContain");
            var elmProStyle = $('<div></div>').addClass("box box-success box-solid");
            var elmProBox = $('<div></div>').addClass("box-header with-border");
            var elmProTitle = $('<div>Thực đơn </div>').addClass("box-title");
            var elmProBody = $('<div></div>').addClass("");

            elmProBody.append(elmPLContainer);
            elmProBox.append(elmProTitle);
            elmProStyle.append(elmProBox).append(elmProBody);
            proContain.append(elmProStyle);


            // Create Cart
            var elmCartContainer = $('<div></div>').addClass("productList").hide();
            var elmCartHeader = $('<div></div>').addClass("scCartHeader");
            var elmCartHeaderTitle1 = $('<label >'+labelProducts+'</label>').addClass("col-md-5 col-sm-5 col-xs-5 no-padding");
            var elmCartHeaderTitle2 = $('<label>'+labelPrice+'</label>').addClass("col-md-2 col-sm-2 col-xs-2");
            var elmCartHeaderTitle3 = $('<label>'+labelQuantityText+'</label>').addClass("col-md-2 col-sm-2 col-xs-2 no-padding");
            var elmCartHeaderTitle4 = $('<label >'+labelSubtotal+'</label>').addClass("col-md-2 col-sm-2 col-xs-2 no-padding scCartTitle4");
            //var elmCartHeaderTitle5 = $('<label></label>').addClass("scCartTitle scCartTitle5");
            elmCartHeader.append(elmCartHeaderTitle1).append(elmCartHeaderTitle2).append(elmCartHeaderTitle3).append(elmCartHeaderTitle4)/*.append(elmCartHeaderTitle5)*/;

            var elmCartList = $('<div></div>').addClass("col-md-12 col-sm-12 col-xs-12 scCartList");
            elmCartContainer.append(elmCartHeader).append(elmCartList);

            var CartMenu = $('<div></div>').addClass("col-md-5 col-sm-5 col-xs-5  no-padding");
            var elmCartStyle = $('<div></div>').addClass("box box-success box-solid");
            var elmCartBox = $('<div></div>').addClass("box-header with-border");
            if(isBookking){
                var elmCartTitle = $('<div>Bàn đặt</div>').addClass("box-title addressText");
            }else{
                elmCartTitle = $('<div>Đơn hàng</div>').addClass("box-title addressText");
            }
            var elmCartBody = $('<div></div>').addClass("box-body no-padding cartBody");

            // Create Bottom bar
            var elmBottomBar = $('<div></div>').addClass("scBottomBar");
            var elmCash = $('<div></div>').addClass("row col-md-12");
            var elmBottomSubtotalText = $('<label>'+labelTotal+':</label>').addClass("scLabelSubtotalText col-md-7");
            var elmBottomCountValue = $('<span>'+cartProductCount+'</span>').addClass("countTotal col-md-2");
            var elmBottomSubtotalValue = $('<span>'+getMoneyFormatted(subTotal)+'</span>').addClass("scLabelSubtotalValue col-md-2");
            var elmBottomCalculate = $('<span><button class="btn btn-primary" id="btn_calcu" type="button"><span class="fa fa-calculator"></span></button><span>').addClass("col-md-1");
            elmCash.append(elmBottomSubtotalText).append(elmBottomCountValue).append(elmBottomSubtotalValue).append(elmBottomCalculate);



            // Create Div show Distance

            // Show quãng đường
//            var elmBottomFeeDisText = $('<label>'+labelFeeDis+':</label>').addClass(" col-md-7");
//            var elmBottomFeeDisValue = $('<span>'+getMoneyFormatted(subTotal)+'</span>').addClass("scLabelShipValue col-md-3 no-padding");
//            elmShowDisFee.append(elmBottomFeeDisText).append(elmBottomFeeDisValue);

            // Create Div show Payment
            var elmShowPayment = $('<div></div>').addClass("scDetailOrder");
            // Show Payment
//            var elmBottomPaymentText = $('<label>'+labelPayment+':</label>').addClass("scLabelSubtotalText col-md-8");
//            var elmBottomPaymentValue = $('<label>'+getMoneyFormatted(subTotal)+'</label>').addClass("scTotalValue col-md-2 no-padding");
//            elmShowPayment.append(elmBottomPaymentText).append(elmBottomPaymentValue);


//            var elmInfo = $('<div></div>').addClass("scDetailOrder");




            // Show Info Customer
            var elmBottomPhone = $('<div></div>').addClass("txtPhone form-group");
            var elmBottomPhoneText = $('<label>'+labelPhone+':</label>').addClass("scLabelSubtotalText col-md-5");
            var elmGroupContent = $('<div></div>').addClass('col-md-6 no-padding');
            var elmGroup = $('<div class="input-group"><input type="text" class="form-control" name="textPhone" value="<?= $phoneNumber ?>" id="textPhone" ><span class="input-group-btn"><button class="btn btn-default" id="checkPhone" type="button"><span class="glyphicon glyphicon-search"></span></button><button class="btn btn-primary" id="btn_history" type="button"><span class="glyphicon glyphicon-time"></span></button></span></div>');
            elmGroupContent.append(elmGroup);
//            elmGroup.append(elmBottomPhoneValue).append(elmGroupBtn);
//            var elmHistoryBtn = $('<div><button class="btn btn-primary btn-sm" id="btn_history" type="button"><span class="glyphicon glyphicon-time"></span></button></div>').addClass("col-md-1");
            elmBottomPhone.append(elmBottomPhoneText).append(elmGroupContent)/*.append(elmHistoryBtn)*/;
            elmShowPayment.append(elmBottomPhone);

            // Show Info Name
            var elmBottomInfoText = $('<label>'+labelInfo+':</label>').addClass("scLabelSubtotalText col-md-5 ");
            var elmBottomInfoName = $('<div></div>').addClass("col-md-6  no-padding");
//            var elmBottomInfoValue = $('<input name="textName" value="<?//= @$model->username ?>//" id="textName">').addClass("form-control");
            var elmInfoGroup = $('<div class="input-group"><input type="text" class="form-control" name="textName" value="<?= @$model->username ?>" id="textName" ><span class="input-group-btn"><button class="btn btn-primary" id="btn_updateprofile" type="button"><span class="glyphicon glyphicon-user"></span></button></span></div>');
            elmBottomInfoName.append(elmInfoGroup);
//            var elmProfileEditBtn = $('<div><button class="btn btn-primary btn-sm" id="btn_updateprofile" type="button"><span class="glyphicon glyphicon-user"></span></button></div>').addClass("col-md-1");
            elmShowPayment.append(elmBottomInfoText).append(elmBottomInfoName)/*.append(elmProfileEditBtn)*/;

            // Show address Customer
            var elmBottomAddressText = $('<label>'+labelAddres+':</label>').addClass("scLabelSubtotalText col-md-5");
            var elmBottomAddressValueDiv = $('<div></div>').addClass("col-md-6 no-padding");
            var elmAddressGroup = $('<div class="input-group"><input type="text" class="form-control" name="addressTxt" value="<?= @$model->to_address ?>" id="addressTxt" ><span class="input-group-btn"><a href="#myMapModal" class="btn btn-primary" data-toggle="modal" ><span class="glyphicon glyphicon-map-marker"></span></a></span></div>');
            elmBottomAddressValueDiv.append(elmAddressGroup);

            // Show Time Booking
            var elmBottomTimeText = $('<label>'+labelTime+':</label>').addClass("scLabelSubtotalText col-md-5");
            var elmBottomTimeValue = $('<?= DateTimePicker::widget([
                                                'name' => 'bookingTimeTxt',
                                                'id' => 'bookingTimeTxt',
                                                'layout' => '{input}{remove}{picker}',

                                                //'value' => '23-Feb-1982 10:10',
                                                'pluginOptions' => [
                                                    'pickerPosition' => 'top-left',
                                                    'minuteStep' => 30,
                                                    'autoclose'=>true,
                                                    'format' => 'dd-mm-yyyy hh:ii',
                                                ]
                                            ]);?>').addClass("col-md-6 no-padding");

            // Show address Customer
            var elmBottomNumberPeopleText = $('<label>'+labelNumberPeople+':</label>').addClass("scLabelSubtotalText col-md-5");
            var elmNumberPeopleValueDiv = $('<div></div>').addClass('col-md-6 no-padding');
            var elmBottomNumberPeopleValue = $('<?= \yii\widgets\MaskedInput::widget([
                                                    'name' => 'Number_People',
                                                    'id' => 'numberPeopleTxt',
                                                    'mask' => '9',
                                                    'clientOptions' => ['repeat' => 10, 'greedy' => false]
                                                ]);?>');
            elmNumberPeopleValueDiv.append(elmBottomNumberPeopleValue);


            if(!isBookking){
                elmShowPayment.append(elmBottomAddressText).append(elmBottomAddressValueDiv);
            }else{
                elmShowPayment.append(elmBottomTimeText).append(elmBottomTimeValue);
                elmShowPayment.append(elmBottomNumberPeopleText).append(elmNumberPeopleValueDiv);
            }

            var elmBottomFeeText = $('<label>'+labelFee+':</label>').addClass("Feelabel col-md-5");
            var elmBottomFeeValueDiv = $('<div></div>').addClass("col-md-6 no-padding");
            var elmBottomFeeValue = $('<input name="feeTxt">').addClass("form-control");
            elmBottomFeeValueDiv.append(elmBottomFeeValue);
            if(!isBookking){
                elmShowPayment.append(elmBottomFeeText).append(elmBottomFeeValueDiv);
            }

            // Show Note
            var elmBottomNoteText = $('<label>'+labelNote+':</label>').addClass("scLabelSubtotalText col-md-5 ");
            var elmBottomNoteValueDiv = $('<div></div>').addClass("col-md-6 no-padding");
            var elmBottomNoteValue = $('<input name="noteTxt" >').addClass("form-control").attr('maxlength','200');
            elmBottomNoteValueDiv.append(elmBottomNoteValue);
            elmShowPayment.append(elmBottomNoteText).append(elmBottomNoteValueDiv);


            var elmBottomPosSelect = $('<label>'+labelPosSelect+':</label>').addClass("col-md-5");
            var posMap = <?= json_encode($allPosMap); ?>; // output php string here

            var optionSel = '';
            var tempPos = 0;
            var tmpPosId = null;
            $.each(posMap, function(key, value) {
                //get Lat long tu array php
                optionSel = '<option value="'+key+'">'+value+'</option>'+optionSel;
                tmpPosId = key.toString();
                tempPos++;
            });

            if(tempPos > 1){
                var elmBottomPosValue = $('<select name="posSelect" id="posSelect" onchange="getval(this);">'+'<option value="">Chọn nhà hàng</option>'+optionSel+'</select>').addClass("col-md-6 no-padding controls_detail");
            }else{
                var elmBottomPosValue = $('<select name="posSelect" id="posSelect">'+optionSel+'</select>').addClass("col-md-6 no-padding controls_detail");
            }





            elmShowPayment.append(elmBottomPosSelect).append(elmBottomPosValue);

            var elmDivButton = $('<div></div>').addClass("scCheckoutDiv col-md-12 col-sm-12 col-xs-12 ");
            if(!isBookking){
                //var btCheckout = $('<button id= "btn_creatoder" >'+ labelCheckout +'</button>').addClass("col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-8 col-xs-offset-2 btn btn-success ");
                var btCheckout = $('<input id= "btn_creatoder" type="submit" value="'+ labelCheckout +'">').addClass("col-md-offset-1 col-md-5 col-sm-6  col-xs-8  btn btn-success ");
                var btCheckoutLater = $('<input id= "btn_creatoderlater" type="button" value="'+ labelCheckoutLater +'" style="margin-left: 5px">').addClass("col-md-5 col-sm-6 col-xs-8 btn btn-primary ");
                if(tempPos == 1){
                    getvalstart(tmpPosId);
                }

            }else{
                btCheckout = $('<button id= "btn_booking" >'+ labelBooking +'</button>').addClass("col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-8 col-xs-offset-2 btn btn-success ");
                //var btCheckout = $('<input id= "btn_booking" type="submit" value="'+ labelBooking +'">').addClass("col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-8 col-xs-offset-2 btn btn-success ");
            }

            $(btCheckout).click(function() {
                if($.isFunction(options.onCheckout)) {
                    // calling onCheckout event;
                    options.onCheckout.call(this,elmProductSelected);
                }else{
                    validateAndSubmit();
                }
                return false;
            });

            $('#btn_creatoder_later').click(function() {
                if($.isFunction(options.onCheckout)) {
                    // calling onCheckout event;
                    options.onCheckout.call(this,elmProductSelected);
                }else{
                    validateAndSubmit();
                }
                return false;
            });


            $(function(){
                $('#btn_creatoderlater').click(function(){
                    $('#modal').modal('show')
                        .find('#modalContent')
                        .load($(this).attr('value'));
                });
            });


/*            $('#textPhone').on('paste', function (e) {
                var $this = $(this);
                setTimeout(function (e) {
                    if (($this.val()).match(/[^0-9]/g))
                    {
                        $("#errormsg").html("Only Numerical Characters allowed").show().delay(2500).fadeOut("slow");
                        setTimeout(function (e) {
                            $this.val(null);
                        },2500);
                    }
                }, 5);
            });*/

            $('input[name="feeTxt"]').keyup(function(e)
            {
                if (/\D/g.test(this.value))
                {
                    // Filter non-digits from input value.
                    this.value = this.value.replace(/\D/g, '');
                }
            });




            $(function(){

                $('#textPhone').keypress(function(event) {
                    if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                        event.preventDefault();
                    }
                });

                $('input[name="feeTxt"]').keypress(function(event) {
                    if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                        event.preventDefault();
                    }
                });



                $('#checkPhone').click(function(){
                    var phone = $('#textPhone').val();

                    $.ajax({type: "POST",
                        url: "<?= \yii\helpers\Url::to(['getdatauser'])?>",
                        data: { user_id : phone},

                        beforeSend: function() {
                            //that.$element is a variable that stores the element the plugin was called on
                            $("#textPhone").addClass("fb-grid-loading");
                        },
                        complete: function() {
                            //$("#modalButton").removeClass("loading");
                            $("#textPhone").removeClass("fb-grid-loading");
                        },
                        success:function(result){
                            console.log(result);
                            if(result != false){
                                var obj = JSON.parse(result);
                                if (typeof obj.user_info != 'undefined'){
                                    if (typeof obj.user_info.Member_Name != 'undefined'){
                                        $('#textName').val(obj.user_info.Member_Name);
                                    }
                                    try{
                                        $('#addressTxt').val(obj.order_online_history[0].to_address);
                                    }catch(e){
                                        try{
                                            $('#addressTxt').val(obj.user_info.Address_List[0].full_address);
                                        }catch(e){
                                            console.log("Không tồn tại địa chỉ",e)
                                        }
                                    }


                                }
                            }else{
                                $('#textName').val('');
                                $('#addressTxt').val('');
                            }
                        }
                    });

                });
            });



            function validateAndSubmit(){

                var error_free = true;
                var txtPhone = $('#textPhone');
                var txtName = $('#textName');
                var addressTxt = $('#addressTxt');
                var bookingTimeTxt = $('#bookingTimeTxt');
                var numberPeopleTxt = $('#numberPeopleTxt');
                var posSelect = $('#posSelect');

                if(txtPhone.val() === ''){
                    //$(this).focus();
                    txtPhone.focus();
                    txtPhone.addClass("has-error");
                    return false;
                }else{
                    txtPhone.removeClass("has-error");
                }

                if(txtName.val() === ''){
                    //$(this).focus();
                    txtName.focus();
                    txtName.addClass("has-error");
                    return false;
                }else{
                    txtName.removeClass("has-error");
                }
                if(!isBookking){
                    if(addressTxt.val() === ''){
                        //$(this).focus();
                        addressTxt.focus();
                        addressTxt.addClass("has-error");
                        return false;
                    }else{
                        addressTxt.removeClass("has-error");
                    }
                }else{
                    if(bookingTimeTxt.val() === ''){
                        //$(this).focus();
                        bookingTimeTxt.focus();
                        bookingTimeTxt.addClass("has-error");
                        return false;
                    }else{
                        bookingTimeTxt.removeClass("has-error");
                    }

                    if(numberPeopleTxt.val() === ''){
                        numberPeopleTxt.focus();
                        numberPeopleTxt.addClass("has-error");
                        return false;
                    }else{
                        numberPeopleTxt.removeClass("has-error");
                    }
                }

                if(posSelect.val() === ''){
                    //$(this).focus();
                    posSelect.focus();
                    posSelect.addClass("has-error");
                    return false;
                }else{
                    posSelect.removeClass("has-error");
                }


                var form = $("#shortForm");
                var formData = form.serialize();

                //var keyDataCookie = txtPhone;
                checkCookie(txtPhone.val(),JSON.stringify(formData));


                $.ajax({
                    url: form.attr('action'),
                    type: 'post',
                    data: form.serialize(),

                    beforeSend: function() {

                        //that.$element is a variable that stores the element the plugin was called on
                        $("#btn_creatoder").addClass("fb-grid-loading");
                        $("#btn_creatoder_later").addClass("fb-grid-loading");
                        $("#btn_booking").addClass("fb-grid-loading");
                    },

                    success: function (response) {
                        delete_cookie(txtPhone.val()+"_"+timeTmp);
                        if(response == 200){
                            window.location.replace("index.php?r=orderonlinelog");
                        }else{
                            //console.log(response);
                            alert(response);
                        }
                        $("#btn_creatoder").removeClass("fb-grid-loading");
                        $("#btn_creatoder_later").removeClass("fb-grid-loading");

                        $("#btn_booking").removeClass("fb-grid-loading");
                        //$("#resetContent").removeClass("fb-grid-loading");
                        //if(response == 300){
                        return false;
                        //}
                        // do something with response
                    }
                });

            }




            elmDivButton.append(btCheckout).append(btCheckoutLater);
            elmBottomBar.append(elmCash).append(elmShowPayment).append(elmDivButton);


            elmCartBody.append(elmCartContainer);
            elmCartBody.append(elmBottomBar);
            elmCartBox.append(elmCartTitle);
            elmCartStyle.append(elmCartBox).append(elmCartBody);
            CartMenu.append(elmCartStyle);


            obj.append(proContain).append(CartMenu);


            // Create Tooltip
            var tooltip = $('<div></div>').addClass('tooltip').hide();
            obj.append(tooltip);
            obj.bind("mousemove",function(){
                tooltip.hide();
                return true;
            });

            // Create SelectList
            var elmProductSelected = $('select[name="'+resultName+'"]',obj);
            if(elmProductSelected.length <= 0){
                elmProductSelected = $("<select></select>").attr("name",resultName).attr("multiple","multiple").attr("id","proSelected").hide();
                refreshCartValues();
            }else{
                elmProductSelected.attr("multiple","multiple").hide();
                populateCart(); // pre-populate cart if there are selected items
            }
            obj.append(elmProductSelected);



            // prepare the product list
            populateProducts();

            if(options.selected == '1'){
                showCart();
            }else{
                showProductList();
            }

            $(btShowProductList).bind("click", function(e){
                showProductList();
                return false;
            });

            $(btShowCart).bind("click", function(e){
                showCart();
                return false;
            });

            function showCart(){
                $(btShowProductList).removeClass("sel");
                $(btShowCart).addClass("sel");
                $(elmPLContainer).hide();
                $(elmCartContainer).show();
            }

            function showProductList(){
                $(btShowProductList).addClass("sel");
                $(btShowCart).removeClass("sel");
                $(elmCartContainer).show();
                $(elmPLContainer).show();
            }

            function addToCart(i,qty,idCombo){
                var addProduct = products.eq(i);

                if(addProduct.length > 0){
                    if($.isFunction(options.onAdd)) {
                        // calling onAdd event; expecting a return value
                        // will start add if returned true and cancel add if returned false
                        if(!options.onAdd.call(this,$(addProduct),qty)){
                            return false;
                        }
                    }
                    var pId = $(addProduct).attr(attrProductId);
                    var pItemId = $(addProduct).attr(attrItemId);
                    var pCombo = $(addProduct).attr(attrCombo);
                    var pComboItemId = $(addProduct).attr(attrComboItemId);
                    var pIsnomalCombo = $(addProduct).attr(attrIsNomalCombo);

                    if(pCombo){
                        if(pIsnomalCombo == 1){
                            addToCartNomalCombo(pItemId,qty,pCombo);
                        }else{
                            addToCartExtraCombo(pId,qty,pCombo,pComboItemId);
                        }

                    }else{
                        addToCartNomal(pItemId,qty,null);
                    }

                }else{
                    showHighlightMessage(messageProductAddError);
                }
            }

            function addToCartNomal(itemId,qty,packetId,priceCombo){
                console.log('priceCombo',priceCombo);

                var dataJson = '<?= json_encode(\Yii::$app->session->get('items_map')) ?>';

                var dataItem = JSON.parse(dataJson);

                var addProduct = dataItem[itemId];
                var productArray = addProduct.split('_*_');


                if(addProduct.length > 0){
                    var pId = productArray[1];
                    var pName = productArray[3];
                    var pPrice = productArray[4];
                    var pDiscount = 0;
                    var pIsEatWith = 0;
                    var pEatWith = productArray[5];
                    if(packetId){
                        pEatWith = null;
                    }
                    if(priceCombo !== undefined ){
                        pPrice = priceCombo;
                        productArray[4] = pPrice;
                    }


                    /*console.log('productArray',productArray);
                    console.log('pPrice',pPrice);*/

                    var newIndex = idGen.getId();

                    // This is a new item so create the list

                    var prodStr = pId + '|' + qty + '|' + '|' + i+'|' + pDiscount + '|'+ pEatWith + '|'+ '|'+ pPrice + '|'+ packetId ; // 0 Id, 1 số lượng ,2 ghi chú, 3 id in cart, 4 giảm giá, 5 EatWith , 7 Gía
                    var productItem = $('<option></option>').attr("rel",newIndex).attr("value",prodStr).attr("combo",packetId).attr('selected', true).html(pName);

                    elmProductSelected.append(productItem);

                    addCartItemDisplay(productArray,qty,newIndex,packetId);

                    // show product added message
                    showHighlightMessage(messageItemAdded);
                    /*}*/
                    // refresh the cart
                    refreshCartValues();
                    // calling onAdded event; not expecting a return value
                    if($.isFunction(options.onAdded)) {
                        options.onAdded.call(this,$(addProduct),qty);
                    }

                    return newIndex;


                }else{
                    showHighlightMessage(messageProductAddError);
                }
            }

            function addToCartNomalCombo(itemId,qty,combo){

                var dataJson = '<?= json_encode(\Yii::$app->session->get('items_map')) ?>';
                var dataItem = JSON.parse(dataJson);
                var addProduct = dataItem[itemId];
                var productArray = addProduct.split('_*_');

                var comboOb = JSON.parse(combo);

                var idx = $(this).attr("rel");
                popupComboNomal(comboOb,null);
                return false;

            }

            function addToCartExtraCombo(itemId,qty,combo,comboItemId){

                var comboOb = JSON.parse(combo);

                var idx = $(this).attr("rel");
                popupComboExtra(comboOb,comboItemId);
                return false;

            }

            function addToCartCombo(itemId,qty,packetId){

                var dataJson = '<?= json_encode(\Yii::$app->session->get('items_map')) ?>';
                var dataItem = JSON.parse(dataJson);
                var addProduct = dataItem[itemId];
                var productArray = addProduct.split('_*_');

                if(addProduct.length > 0){

                    var pId = productArray[2];
                    var pName = productArray[1];
                    var pPrice = productArray[3];
                    var pDiscount = 0;
                    var pIsEatWith = 0;
                    var pEatWith = '';
//                    var pCombo = $(addProduct).attr(attrCombo);
//                    var pComboItemId = $(addProduct).attr(attrComboItemId);
//                    var pIsnomalCombo = $(addProduct).attr(attrIsNomalCombo);

                    var newIndex = idGen.getId();


                    // This is a new item so create the list

                    var prodStr = pId + '|' + qty + '|' + '|' + i+'|' + '|'+ pEatWith + '|'+ '|'+ pPrice  + '|'+ packetId ;  // 0 Id, 1 số lượng ,2 ghi chú, 3 id in cart, 4 giảm giá, 5 EatWith , 6 Gía, 7 Dis count
                    var productItem = $('<option></option>').attr("rel",newIndex).attr("value",prodStr).attr("combo",idCombo).attr('selected', true).html(pName);

                    elmProductSelected.append(productItem);

                    addComboCartItemDisplay(productArray,qty,newIndex);

                    // show product added message
                    showHighlightMessage(messageItemAdded);
                    /*}*/
                    // refresh the cart
                    refreshCartValues();
                    // calling onAdded event; not expecting a return value
                    if($.isFunction(options.onAdded)) {
                        options.onAdded.call(this,$(addProduct),qty);
                    }

                    return newIndex;


                }else{
                    showHighlightMessage(messageProductAddError);
                }
            }



            function Generator() {};
            Generator.prototype.rand =  Math.floor(Math.random() * 26) + Date.now();
            Generator.prototype.getId = function() {
                return this.rand++;
            };
            var idGen =new Generator();



            function display(){
                elmCartList = $('<div></div>').addClass("col-md-12 col-sm-12 col-xs-12 scCartList");
                $.each(elmProductSelected, function( key, value ){
                    console.log(value);
                    addCartItemDisplay(value,1,key);
                });
            }


            function addCartItemDisplay(objProd,Quantity,newIndex,packetId){
                var pId = objProd[1];
                var pItemId = objProd[2];
                //var pIndex = products.index(objProd);
                var pIndex = newIndex;
                var pName = objProd[3];
                var pPrice = objProd[4];
                var pDiscount = 0;
                var prodImgSrc = '';
                var prodEatWith = objProd[5];
                console.log('pPrice addCartItemDisplay',pPrice);
                if(packetId){
                    prodEatWith = null;
                }
                var prodCombo = $(objProd).attr(attrCombo);
                var prodComboItemId = $(objProd).attr(attrComboItemId);
                var prodIsNomalCombo = $(objProd).attr(attrIsNomalCombo);

                try {
                    var comboOb = JSON.parse(prodCombo);
//                    console.log(comboOb);
                    var idx = $(this).attr("rel");

                    popupCombo(pId,comboOb,prodComboItemId);
                    return false;

                }catch(err) {

                }

                if(pDiscount >0 ){
                    var pTotal = ((pPrice - 0) * (Quantity - 0)) - ((pPrice - 0) * (Quantity - 0) * (pDiscount - 0)/100);
                }else{
                    pTotal = (pPrice - 0) * (Quantity - 0);
                }



                pTotal = getMoneyFormatted(pTotal);
                // Now Go for creating the design stuff

                $('.scMessageBar',elmCartList).remove();

                var elmCPTitle1 = $('<div></div>').addClass("col-md-5 no-padding");
                var prodImg = $("<img></img>").attr("src",prodImgSrc).addClass("scProductImageSmall");
                if(prodImgSrc && options.enableImage && prodImgSrc.length>0){

                    if(prodImg && options.enableImageTooltip){
                        prodImg.bind("mouseenter mousemove",function(){
                            showTooltip($(this));
                            return false;
                        });
                        prodImg.bind("mouseleave",function (){
                            tooltip.hide();
                            return true;
                        });
                    }
                    //elmCPTitle1.append(prodImg);
                }else{
                    prodImgSrc = 'https://image.foodbook.vn/images/fb/items/item-default.png';
                    if(prodImg && options.enableImageTooltip){
                        prodImg.bind("mouseenter mousemove",function(){
                            showTooltip($(this));
                            return false;
                        });
                        prodImg.bind("mouseleave",function (){
                            tooltip.hide();
                            return true;
                        });
                    }
                }
                var elmCP = $('<div></div>').attr("id","divCartItem"+pIndex).addClass("scCartItem clearfix");



                var pTitle =  pName;
                var elmCPContent = $('<div><b>'+pTitle+'</b></div>').attr("title",pTitle);

                var elmCPNote = $('<p>Ghi chú....</p>').attr("id","phiddenField" + pIndex).addClass("textNote");
                var replaceWith  = $('<input name="temp"'+ pIndex +' type="text" />');
                var connectWith = $('<input type="hidden"/>').attr("name","hiddenField"+pIndex).attr("id","lblNote"+pIndex).attr("rel",pIndex);



                //Kiem tra neu nhu truong note thay doi thi cap nhat
                $(connectWith).bind("change", function(e){
                    var newNote = $(this).val();
                    var prodIdx = $(this).attr("rel");
                    //if(validateNumber(newNote)){
                    updateCartNote(prodIdx,newNote);
                    /*}else{
                     var productItem = elmProductSelected.children("option[rel=" + prodIdx + "]");
                     var pValue = $(productItem).attr("value");
                     var valueArray = pValue.split('|');
                     var pQty = valueArray[1];
                     $(this).val(pQty);
                     showHighlightMessage(messageQuantityErrorUpdate);
                     }*/
                    return true;
                });


                elmCPContent.append(elmCPNote);
                elmCPTitle1.append(elmCPContent);


                //var elmDiscount = $('<p>'+pDiscount+'</p>').attr("id","discounthiddenField" + pIndex).addClass("textNote");
                var elmCPTitle2 = $('<span>'+pPrice+'<br/> <span class="priceDown" >(&darr;<span id="discounthiddenField'+pIndex+'" class="inputDiscount">'+ pDiscount + '</span> %)</span></span>').addClass("col-md-2 no-padding");
                var replaceDiscountWith  = $('<input name="disTem"'+ pIndex +' type="text" class="discountTxt"/>');
                if(packetId){
                    replaceDiscountWith.attr('disabled','disabled');
                }
                var connectDiscountWith = $('<input type="hidden"/>').attr("name","hiddenDisField"+pIndex).attr("id","lblDiscount"+pIndex).attr("rel",pIndex);

                //Kiem tra neu nhu truong Discount thay doi thi cap nhat
                $(connectDiscountWith).bind("change", function(e){
                    var newDiscount = $(this).val();
                    var prodIdx = $(this).attr("rel");
                    if(validateDiscount(newDiscount)){
                        updateCartDiscount(prodIdx,newDiscount);
                    }else{
                        var productItem = elmProductSelected.children("option[rel=" + prodIdx + "]");
                        var pValue = $(productItem).attr("value");
                        var valueArray = pValue.split('|');
                        var pDiscount = valueArray[4];
                        if (pDiscount.length == 0) {
                            replaceDiscountWith.val('0');
                        }else{
                            replaceDiscountWith.val(pDiscount);
                        }
//                             showHighlightMessage(messageQuantityErrorUpdate);
                    }
                    return true;
                });


                var inputQty = $('<input type="text" value="'+Quantity+'" />').attr("id","lblQuantity"+pIndex).attr("rel",pIndex).addClass("scTxtQuantity2");
                if(packetId){
                    inputQty.attr('disabled','disabled');
                }

                //var inputNote = $('<input type="text" value="" />').attr("id","lblNote"+pIndex).attr("rel",pIndex).addClass("scTxtNote");

                //elmCPContent.append(inputNote);

                $(inputQty).bind("change", function(e){
                    var newQty = $(this).val();
                    var prodIdx = $(this).attr("rel");
                    newQty = newQty - 0;
                    if(validateNumber(newQty)){
                        updateCartQuantity(prodIdx,newQty);
                    }else{
                        var productItem = elmProductSelected.children("option[rel=" + prodIdx + "]");
                        var pValue = $(productItem).attr("value");
                        var valueArray = pValue.split('|');
                        var pQty = valueArray[1];
                        $(this).val(pQty);
                        showHighlightMessage(messageQuantityErrorUpdate);
                    }
                    return true;
                });



                var elmCPTitle3 = $('<div></div>').append(inputQty).addClass("col-md-2");

                var elmCPTitle4 = $('<span>'+pTotal+'</span>').attr("id","lblTotal"+pIndex).addClass("col-md-2 no-padding");
                var btRemove = $('<a><span class="glyphicon glyphicon-remove btn-red"></span></a>').attr("rel",pIndex).attr("href","#").addClass("scRemove").attr("title","Remove from Cart");
                var btAddEatWith = $('<a><span class="glyphicon glyphicon-paperclip btn-blue"></span></a>').attr("rel",pIndex).attr("href","#").addClass("scRemove").attr("title","EatWith");
                $(btRemove).bind("click", function(e){
                    var idx = $(this).attr("rel");
                    removeFromCart(idx);
                    return false;
                });

                $(btAddEatWith).bind("click", function(e){
                    var idx = $(this).attr("rel");
                    popupEatWith(idx,prodEatWith);
                    return false;
                });

                var elmCPTitle5 = $('<div></div>').addClass("col-md-1 no-padding scCartItemTitle5");

                if(prodEatWith){
                    elmCPTitle5.append(btAddEatWith).append(btRemove);
                }else{
                    elmCPTitle5.append(btRemove);
                }

                elmCPTitle1.append(elmCPContent);
                elmCP.append(elmCPTitle1).append(elmCPTitle2).append(elmCPTitle3).append(elmCPTitle4).append(elmCPTitle5);


                var elEatWith = $('<div></div>').attr("id","eatWith"+pIndex).addClass(""); // Them div hiển thị món ăn kèm


                elmCartList.append(elmCP).append(elEatWith);

                $('#phiddenField' + pIndex).inlineEditTest(replaceWith, connectWith);
                $('#discounthiddenField' + pIndex).inlineEditTest(replaceDiscountWith, connectDiscountWith);

            }

            function addComboCartItemDisplay(objProd,Quantity,newIndex){
                console.log('objProd',objProd);

                var pId = objProd[2];
                //var pIndex = products.index(objProd);
                var pIndex = newIndex;
                var pName = objProd[1];
                var pPrice = objProd[4];
                var pDiscount = 0;
                var prodImgSrc = '';
                var prodEatWith = '';
                var prodCombo = '';
                var prodComboItemId = '';
                var prodIsNomalCombo = '';

                var comboOb = JSON.parse(prodCombo);
//                    console.log(comboOb);
                var idx = $(this).attr("rel");

                popupCombo(pId,comboOb,prodComboItemId);
                return false;


                if(pDiscount >0 ){
                    var pTotal = ((pPrice - 0) * (Quantity - 0)) - ((pPrice - 0) * (Quantity - 0) * (pDiscount - 0)/100);
                }else{
                    pTotal = (pPrice - 0) * (Quantity - 0);
                }


                pTotal = getMoneyFormatted(pTotal);


                // Now Go for creating the design stuff

                $('.scMessageBar',elmCartList).remove();

                var elmCPTitle1 = $('<div></div>').addClass("col-md-5 no-padding");
                var prodImg = $("<img></img>").attr("src",prodImgSrc).addClass("scProductImageSmall");
                if(prodImgSrc && options.enableImage && prodImgSrc.length>0){

                    if(prodImg && options.enableImageTooltip){
                        prodImg.bind("mouseenter mousemove",function(){
                            showTooltip($(this));
                            return false;
                        });
                        prodImg.bind("mouseleave",function (){
                            tooltip.hide();
                            return true;
                        });
                    }
                    //elmCPTitle1.append(prodImg);
                }else{

                    prodImgSrc = 'https://image.foodbook.vn/images/fb/items/item-default.png';
                    if(prodImg && options.enableImageTooltip){
                        prodImg.bind("mouseenter mousemove",function(){
                            showTooltip($(this));
                            return false;
                        });
                        prodImg.bind("mouseleave",function (){
                            tooltip.hide();
                            return true;
                        });
                    }
                }
                var elmCP = $('<div></div>').attr("id","divCartItem"+pIndex).addClass("scCartItem clearfix");



                var pTitle =  pName;
                var phtml = formatTemplate(options.cartItemTemplate, $(objProd));
                var elmCPContent = $('<div><b>'+pTitle+'</b></div>').attr("title",pTitle);

                var elmCPNote = $('<p>Ghi chú....</p>').attr("id","phiddenField" + pIndex).addClass("textNote");
                var replaceWith  = $('<input name="temp"'+ pIndex +' type="text" />');
                var connectWith = $('<input type="hidden"/>').attr("name","hiddenField"+pIndex).attr("id","lblNote"+pIndex).attr("rel",pIndex);

                //Kiem tra neu nhu truong note thay doi thi cap nhat
                $(connectWith).bind("change", function(e){
                    var newNote = $(this).val();
                    var prodIdx = $(this).attr("rel");
                    //if(validateNumber(newNote)){
                    updateCartNote(prodIdx,newNote);

                    return true;
                });


                elmCPContent.append(elmCPNote);
                elmCPTitle1.append(elmCPContent);


                //var elmDiscount = $('<p>'+pDiscount+'</p>').attr("id","discounthiddenField" + pIndex).addClass("textNote");
                var elmCPTitle2 = $('<span>'+pPrice+'<br/> <span class="priceDown" >(&darr;<span id="discounthiddenField'+pIndex+'" class="inputDiscount">'+ pDiscount + '</span> %)</span></span>').addClass("col-md-2 no-padding");
                var replaceDiscountWith  = $('<input name="disTem"'+ pIndex +' type="text" class="discountTxt"/>');


                var connectDiscountWith = $('<input type="hidden"/>').attr("name","hiddenDisField"+pIndex).attr("id","lblDiscount"+pIndex).attr("rel",pIndex);

                //Kiem tra neu nhu truong Discount thay doi thi cap nhat
                $(connectDiscountWith).bind("change", function(e){
                    var newDiscount = $(this).val();
                    var prodIdx = $(this).attr("rel");
                    if(validateDiscount(newDiscount)){
                        updateCartDiscount(prodIdx,newDiscount);
                    }else{
                        var productItem = elmProductSelected.children("option[rel=" + prodIdx + "]");
                        var pValue = $(productItem).attr("value");
                        var valueArray = pValue.split('|');
                        var pDiscount = valueArray[4];
                        if (pDiscount.length == 0) {
                            replaceDiscountWith.val('0');
                        }else{
                            replaceDiscountWith.val(pDiscount);
                        }
//                             showHighlightMessage(messageQuantityErrorUpdate);
                    }
                    return true;
                });


                var inputQty = $('<input type="text" value="'+Quantity+'" />').attr("id","lblQuantity"+pIndex).attr("rel",pIndex).addClass("scTxtQuantity2");

                //var inputNote = $('<input type="text" value="" />').attr("id","lblNote"+pIndex).attr("rel",pIndex).addClass("scTxtNote");

                //elmCPContent.append(inputNote);

                $(inputQty).bind("change", function(e){
                    var newQty = $(this).val();
                    var prodIdx = $(this).attr("rel");
                    newQty = newQty - 0;
                    if(validateNumber(newQty)){
                        updateCartQuantity(prodIdx,newQty);
                    }else{
                        var productItem = elmProductSelected.children("option[rel=" + prodIdx + "]");
                        var pValue = $(productItem).attr("value");
                        var valueArray = pValue.split('|');
                        var pQty = valueArray[1];
                        $(this).val(pQty);
                        showHighlightMessage(messageQuantityErrorUpdate);
                    }
                    return true;
                });



                var elmCPTitle3 = $('<div></div>').append(inputQty).addClass("col-md-2");

                var elmCPTitle4 = $('<span>'+pTotal+'</span>').attr("id","lblTotal"+pIndex).addClass("col-md-2 no-padding");
                var btRemove = $('<a><span class="glyphicon glyphicon-remove btn-red"></span></a>').attr("rel",pIndex).attr("href","#").addClass("scRemove").attr("title","Remove from Cart");
                var btAddEatWith = $('<a><span class="glyphicon glyphicon-paperclip btn-blue"></span></a>').attr("rel",pIndex).attr("href","#").addClass("scRemove").attr("title","EatWith");
                $(btRemove).bind("click", function(e){
                    var idx = $(this).attr("rel");
                    removeFromCart(idx);
                    return false;
                });

                $(btAddEatWith).bind("click", function(e){
                    var idx = $(this).attr("rel");

                    popupEatWith(idx,prodEatWith);
                    return false;
                });

                var elmCPTitle5 = $('<div></div>').addClass("col-md-1 no-padding scCartItemTitle5");
                if(prodEatWith){
                    elmCPTitle5.append(btAddEatWith).append(btRemove);
                }else{
                    elmCPTitle5.append(btRemove);
                }

                elmCPTitle1.append(elmCPContent);
                elmCP.append(elmCPTitle1).append(elmCPTitle2).append(elmCPTitle3).append(elmCPTitle4).append(elmCPTitle5);


                var elEatWith = $('<div></div>').attr("id","eatWith"+pIndex).addClass(""); // Them div hiển thị món ăn kèm


                elmCartList.append(elmCP).append(elEatWith);

                $('#phiddenField' + pIndex).inlineEditTest(replaceWith, connectWith);
                $('#discounthiddenField' + pIndex).inlineEditTest(replaceDiscountWith, connectDiscountWith);

            }


            function removeFromCart(idx){
                var productItem = elmProductSelected.children("option[rel=" + idx + "]");
                var comboId = $(productItem).attr("combo");

                console.log('productItem',productItem);

                $('#eatWith'+idx).remove();
                productItem.remove();


                if(comboId != undefined){
                    var productItemCombo = elmProductSelected.children("option[combo=" + comboId + "]");
                    $.each(productItemCombo, function( key, value ){
                        var pValueCombo = $(value).attr("rel");
                        console.log('pValueCombo',pValueCombo);
                        var productItemRemoveValue = elmProductSelected.children("option[rel=" + pValueCombo + "]");
                        console.log('productItemRemoveValue',productItemRemoveValue);
                        $('#eatWith'+idx).remove();
                        productItemRemoveValue.remove();

                        $("#divCartItem"+pValueCombo,elmCartList).slideUp("slow",function(){$(this).remove();

                        });

                    });

                }



                $("#divCartItem"+idx,elmCartList).slideUp("slow",function(){$(this).remove();
                    showHighlightMessage(messageItemRemoved);
                    //Refresh the cart

                    refreshCartValues();
                });
                /*if($.isFunction(options.onRemoved)) {
                 // calling onRemoved event; not expecting a return value
                 options.onRemoved.call(this,$(pObj));
                 }*/
                //}
            }

            function popupEatWith(idx,prodEatWith){
                // Lấy các món ăn kèm đã được chọn từ trước
                var productItem = elmProductSelected.children("option[rel=" + idx + "]");

                var pValue = $(productItem).attr("value");
                var valueArray = pValue.split('|');
                var sledEatWith = valueArray[6];
                var arrSelected = [];

                if(typeof sledEatWith != 'undefined' && sledEatWith != 'undefined'){
                    var arrslEatWith = sledEatWith.split(',');
                    $.each(arrslEatWith, function( key, value ){
                        var arrOneEatWith = value.split('_*_'); // 0 La Id, 1 la gia, 2 la ten mon
                        arrSelected.push(arrOneEatWith[0]);
                    });
                }
//                console.log(arrSelected);


                // Get the modal
                var listItem = <?= json_encode($listItems)?>;
                var arrEatWith = prodEatWith.split(',');
                var checkboxEatWith = $('<div class="funkyradio" ></div>');
                var headerEatwith = $('<div class="header-eawith"><input type="checkbox"/></div>');

                $.each(listItem, function( key, value ){

                    if(jQuery.inArray(value.Item_Id, arrEatWith) != -1) {
                        if(jQuery.inArray(value.Item_Id, arrSelected) != -1) {
                            var checkedItem = 'checked';
                        }else{
                            checkedItem = '';
                        }

                        var inputQty = $('<select></select>').attr("id","eatWithQty"+value.Item_Id).attr("name","eatWithQty"+value.Item_Id).attr("selid",+value.Item_Id).addClass("form-control");
                        for (i=1;i<100;i++){
                            if(i == 1){
                                inputQty.append($('<option selected></option>').val(i).html(i));
                            }else{
                                inputQty.append($('<option></option>').val(i).html(i));
                            }
                        }

                        var eatWithelm = $('<div class="funkyradio-primary">' +
                        '<input type="checkbox" name="eatWith" id="'+value.Item_Id+'"  value="'+value.Item_Id+'_*_'+ value.Ta_Price+'_*_' +value.Item_Name+'" '+checkedItem+'/>' +
                        '<label for="'+value.Item_Id+'">'+ value.Item_Name +'</label> ' +
                        '</div>');
                        inputQty.appendTo(eatWithelm);
                        eatWithelm.appendTo(checkboxEatWith)
                    }

                });


                var btnEatWith = $('<input type="button" value="'+ labelAddEatWith +'" style="margin-top: 25px">').addClass("col-md-offset-9 col-md-3 col-sm-6  col-xs-8  btn btn-success ");

                checkboxEatWith.append(btnEatWith);


                $(btnEatWith).bind("click", function(e){
                    var slEatWith = '';
                    $('input[name="eatWith"]:checked').each(function() {
                        var qTyEw = $('#eatWithQty'+ this.id ).find('option:selected').val();
                        var txtQtyEw = '_*_'+qTyEw;

                        if(slEatWith == ''){
                            slEatWith = this.value + txtQtyEw;
                        }else{
                            slEatWith = slEatWith +','+ this.value + txtQtyEw;
                        }
                    });


                    updateEatWith(idx,slEatWith);

                    $('#modalIdEatWith').modal('hide');
                    return false;
                });

//                var productItem = elmProductSelected.children("option[rel=" + idx + "]");
//                console.log(productItem);

                $('#modalIdEatWith').modal('show')
                    .find('#modalContentEatWith').html(checkboxEatWith);
                /*.load($(this).attr('value'))*/
            }



            function popupComboNomal(combo,comboItemId){

                var dataJson = '<?= json_encode(\Yii::$app->session->get('items_map')) ?>';
                var dataMainItemJson = '<?= json_encode(\Yii::$app->session->get('main_items_map')) ?>';
                var dataEatwithJson = '<?= json_encode(\Yii::$app->session->get('items_eatwith_map')) ?>';


                var dataItem = JSON.parse(dataJson);
                var dataMainItem = JSON.parse(dataMainItemJson);
                var dataItemEatwith = JSON.parse(dataEatwithJson);


                var checkboxEatWith = $('<div class="funkyradio" ></div>');
                var headerEatwith = $('<div class="header-eawith"><input type="checkbox"/></div>');

                var tmpGroup = 1;

                if(comboItemId){
                    try{
                        var comboIndexArray = dataItem[comboItemId].split('_*_');
                    }catch(e){
                        /*alert(e);
                         return false;*/
                    }
                }


                $.each(combo, function( key, value ){

                    var comboGroup = $('<div></div>').addClass("combo-group");
                    var comboGroupHeader = $('<div>Groupp '+ tmpGroup +' - Số lượng yêu cầu : '+ value.quantity +'</div>').addClass("combo-group-header");

                    if(value.item_id_list) {
                        var item_id_list = value.item_id_list;
                        var itemArray = item_id_list.split(',');
                        comboGroup.append(comboGroupHeader);

                        $.each(itemArray, function( keyItem, itemId ){

                            try{
                                var itemComboDetail = dataItem[itemId].split('_*_');
                            }catch(e){

                            }




                            var inputQty = $('<select></select>').attr("id","comboQty"+tmpGroup+itemComboDetail[0]).attr("name","comboQty"+itemComboDetail[0]).addClass("form-control");
                            for (i=1;i<= value.quantity ;i++){
                                if(i == 1){
                                    inputQty.append($('<option selected></option>').val(i).html(i));
                                }else{
                                    inputQty.append($('<option></option>').val(i).html(i));
                                }
                            }

                            if(comboItemId){
                                var eatWithelm = $('<div class="funkyradio-primary">' +
                                '<input type="checkbox" name="comboCheckbox" id="'+tmpGroup+itemId+'"  value="'+dataItemEatwith[itemId] +'" comboid="'+itemComboDetail[0]+'" groupid="'+ tmpGroup +'" groupmax ="'+value.quantity+'" />' +
                                '<label for="'+tmpGroup+itemId+'">'+ itemComboDetail[1] +'</label> ' +
                                '</div>');
                            }else{
                                eatWithelm = $('<div class="funkyradio-primary">' +
                                '<input type="checkbox" name="comboCheckbox" id="'+tmpGroup+itemId+'"  value="'+itemComboDetail[0]+'" comboid="'+itemComboDetail[0]+'" groupid="'+ tmpGroup +'" groupmax ="'+value.quantity+'" />' +
                                '<label for="'+itemId+'">'+ itemComboDetail[1] +'</label> ' +
                                '</div>');

                            }

                            inputQty.appendTo(eatWithelm);
                            eatWithelm.appendTo(comboGroup);
                        });
                        checkboxEatWith.append(comboGroup);


                    }else{
                        var itemComboDetail = dataItem[value.item_id].split('_*_');

                        var eatWithelm = $('<div class="funkyradio-primary">' + '<label >'+ itemComboDetail[3] +' - '+ value.quantity +' </label> ' + '</div>');

                        eatWithelm.appendTo(comboGroup);

                        checkboxEatWith.append(comboGroup);
                    }

                });


                var elementSelCbQty = $('<div></div>');


                var lbelSelCbQty = ('<label>Số lượng</label>');
                var inputComboQty = $('<select></select>').attr("name","cbQty").attr("id","cbQty").addClass("form-control col-md-6");
                for (i=1;i<= 99 ;i++){
                    if(i == 1){
                        inputComboQty.append($('<option selected></option>').val(i).html(i));
                    }else{
                        inputComboQty.append($('<option></option>').val(i).html(i));
                    }
                }


                elementSelCbQty.append(lbelSelCbQty).append(inputComboQty);

                var btnEatWith = $('<input type="button" value="'+ labelAddCombo +'" style="margin-top: 25px" id="creat_combo" data-dismiss="modal">').addClass("col-md-offset-9 col-md-3 col-sm-6  col-xs-8  btn btn-success ");

                checkboxEatWith.append(elementSelCbQty).append(btnEatWith);

                $('#header-popup').html('Chọn món Combo');

                $('#modalIdEatWith').modal('show')
                    .find('#modalContentEatWith').html(checkboxEatWith);

                $('#creat_combo').click(function(){

                    var qTycb = $('#cbQty').find('option:selected').val();
                    var packetId = idGen.getId();
                    $.each(combo, function( key, value ){
                        addToCartNomal(value.item_id,qTycb*value.quantity,packetId,value.fix);
                    });

                });

            }

            function popupComboExtra(combo,comboItemId){

                var dataJson = '<?= json_encode(\Yii::$app->session->get('items_map')) ?>';

                var dataItem = JSON.parse(dataJson);


                var checkboxEatWith = $('<div class="funkyradio" ></div>');
                var headerEatwith = $('<div class="header-eawith"><input type="checkbox"/></div>');

                var tmpGroup = 1;

                if(comboItemId){
                    try{
                        var comboIndexArray = dataItem[comboItemId].split('_*_');
                    }catch(e){
                        /*alert(e);
                         return false;*/
                    }
                }

                var tmpGroupId = [];
                var tmpGroupMax = [];

                $.each(combo, function( key, value ){

                    var comboGroup = $('<div></div>').addClass("combo-group");
                    var comboGroupHeader = $('<div>Groupp '+ tmpGroup +' - Số lượng yêu cầu : '+ value.quantity +'</div>').addClass("combo-group-header");


                    var item_id_list = value.item_id_list;
                    var itemArray = item_id_list.split(',');
                    comboGroup.append(comboGroupHeader);

                    tmpGroupMax[tmpGroup] = value.quantity ;

                    var ots_price = value.ots_price;

                    if(value.price_by_menu == 1){
                        ots_price = null;
                    }




                    $.each(itemArray, function( keyItem, itemId ){
                        try{
                            var itemComboDetail = dataItem[itemId].split('_*_');
                        }catch(e){

                        }

                        console.log('itemId',itemId);
                        console.log('dataItem[itemId]',dataItem[itemId]);
                        console.log('dataItem',dataItem);



                        var inputQty = $('<select></select>').attr("id","comboQty"+tmpGroup+itemId ).attr("name","comboQty").attr("groupid",tmpGroup).attr("ots_price",ots_price).attr("groupmax",value.quantity).attr("comboid",itemComboDetail[0]).addClass("form-control");

                        if(tmpGroupId[tmpGroup] === undefined){
                            tmpGroupId[tmpGroup] = [];
                            tmpGroupId[tmpGroup].push(itemId);
                        }else{
                            tmpGroupId[tmpGroup].push(itemId);
                        }

                        for (i=0;i<= value.quantity ;i++){
                            if(i == 0){
                                inputQty.append($('<option selected></option>').val(i).html(i));
                            }else{
                                inputQty.append($('<option></option>').val(i).html(i));
                            }
                        }

                        if(comboItemId){
                            var eatWithelm = $('<div class="funkyradio-primary">' +
                            '<label for="'+tmpGroup+itemId+'">'+ itemComboDetail[3] +'</label> ' +
                            '</div>');
                        }else{
                            eatWithelm = $('<div class="funkyradio-primary">' +
                            '<label for="'+itemId+'">'+ itemComboDetail[3] +'</label> ' +
                            '</div>');

                        }

                        inputQty.appendTo(eatWithelm);
                        eatWithelm.appendTo(comboGroup);


                    });
                    checkboxEatWith.append(comboGroup);
                    tmpGroup++;
                });


                var elementSelCbQty = $('<div></div>');

                var lbelSelCbQty = ('<label>Số lượng</label>');
                var inputComboQty = $('<select></select>').attr("name","cbQty").attr("id","cbQty").addClass("form-control col-md-6");
                for (i=1;i<= 99 ;i++){
                    if(i == 1){
                        inputComboQty.append($('<option selected></option>').val(i).html(i));
                    }else{
                        inputComboQty.append($('<option></option>').val(i).html(i));
                    }
                }


                elementSelCbQty.append(lbelSelCbQty).append(inputComboQty);

                var btnEatWith = $('<input type="button" value="'+ labelAddCombo +'" style="margin-top: 25px" id="creat_combo" data-dismiss="modal">').addClass("col-md-offset-9 col-md-3 col-sm-6  col-xs-8  btn btn-success ");

                checkboxEatWith.append(elementSelCbQty).append(btnEatWith);

                $('#modalIdEatWith').modal('show')
                    .find('#modalContentEatWith').html(checkboxEatWith);

                $('#creat_combo').click(function(){

                    var groupCombo = [];

                    var groupCheckCombo = [];
                    var groupComboWithItemId = [];
                    var checkFail = 0;
                    var isNomal = 0;

                    var tmpCbItem = 0;

                    $.each(tmpGroupId, function( key, value ) {
                        if(key != 0){

                            $.each(value, function( keyDetail, valueItemId) {

                                $('#comboQty'+key+valueItemId+'  :selected').each(function(){

                                    var groupId = key;
                                    var groupComboMax = tmpGroupMax[key];
                                    var itemId = valueItemId;



                                    var element = $("#comboQty"+key+valueItemId);
                                    var ots_price = element.attr("ots_price");


                                    var qTycb = $(this).val();
                                    tmpCbItem = qTycb + tmpCbItem;

                                    if(comboItemId){
                                        var dataItemId = dataItem[valueItemId].split('_*_');
                                        if(ots_price != null){
                                            var itemIdPre = valueItemId+'_*_'+ots_price+'_*_'+dataItemId[3];
                                        }else{
                                            itemIdPre = valueItemId+'_*_'+dataItemId[4]+'_*_'+dataItemId[3];
                                        }


                                        if(qTycb > 0){
                                            groupComboWithItemId.push(itemIdPre + '_*_' + qTycb );
                                        }
                                    }

                                    if( groupCombo[groupId] === undefined ) {
                                        // do something
                                        groupCombo[groupId] = [];
                                        groupCombo[groupId].push(groupComboMax);
                                        groupCombo[groupId].push(groupId);
                                        groupCombo[groupId].push(itemId+'*'+qTycb+'*'+ots_price);

                                    }else{
                                        groupCombo[groupId].push(itemId+'*'+qTycb+'*'+ots_price);
                                    }


                                });
                            });


                        }

                    });



                    $.each( groupCombo, function( key, value ) {
                        if(value  !== undefined){
                            var maxCheck =  0;
                            var tmpSumQty = 0;
                            $.each( value, function( keyCheckcombo, valueCheckcombo ) {
                                if(value  !== undefined){
                                    if(keyCheckcombo == 0){
                                        maxCheck =  parseInt(valueCheckcombo);
                                    }else{
                                        if(keyCheckcombo !== 1){
                                            var valueArray = valueCheckcombo.split('*');

                                            tmpSumQty = tmpSumQty + parseInt(valueArray[1]);
                                        }
                                    }
                                }
                            });

                            if(tmpSumQty !== maxCheck){

                                checkFail = 1;
                            }
                        }
                    });


                    if(checkFail){
                        alert("Kiểm tra lại số lượng yêu cầu");
                        return false;
                    }else{

                        var packetId = idGen.getId();
                        console.log('packetId',packetId);

                        if(comboItemId){
                            var slEatWith = '';

                            $.each( groupComboWithItemId, function(key,value){
                                if(slEatWith == ''){
                                    slEatWith = value
                                }else{
                                    slEatWith = slEatWith +','+ value;
                                }
                            });

                            var totalQty = $('#cbQty').find('option:selected').val();
                            var itemId = addToCartNomal(comboItemId,totalQty,packetId);
                            updateEatWith(itemId,slEatWith);

                        }else{

                            $.each( groupCombo, function( key, value ) {
                                if(value  !== undefined){
                                    $.each( value, function( keyCheckcombo, valueCheckcombo ) {
                                        if(value  !== undefined){
                                            if(keyCheckcombo !== 0 && keyCheckcombo !== 1){
                                                var valueArray = valueCheckcombo.split('*');
                                                var totalQty = $('#cbQty').find('option:selected').val();
                                                if(valueArray[1] > 0){
                                                    console.log('valueArray[3]',valueArray);
                                                    if(valueArray[2] != 'null'){
                                                        addToCartNomal(valueArray[0],valueArray[1]*totalQty,packetId,valueArray[2]);
                                                    }else{
                                                        addToCartNomal(valueArray[0],valueArray[1]*totalQty,packetId);
                                                    }

                                                }
                                            }
                                        }
                                    });
                                }
                            });
                        }

                    }


                    if(tmpCbItem == 0){
                        alert('Bạn cần phải chọn món cho combo');
                        return false;
                    }

                });

            }

            function popupCombo(combo,comboItemId){

                var dataJson = '<?= json_encode(\Yii::$app->session->get('items_map')) ?>';
                var dataMainItemJson = '<?= json_encode(\Yii::$app->session->get('main_items_map')) ?>';
                var dataEatwithJson = '<?= json_encode(\Yii::$app->session->get('items_eatwith_map')) ?>';


                var dataItem = JSON.parse(dataJson);
                var dataMainItem = JSON.parse(dataMainItemJson);
                var dataItemEatwith = JSON.parse(dataEatwithJson);


                var checkboxEatWith = $('<div class="funkyradio" ></div>');
                var headerEatwith = $('<div class="header-eawith"><input type="checkbox"/></div>');

                var tmpGroup = 1;

                if(comboItemId){
                    try{
                        var comboIndexArray = dataItem[comboItemId].split('_*_');
                    }catch(e){
                        /*alert(e);
                         return false;*/
                    }
                }


                $.each(combo, function( key, value ){

                    var comboGroup = $('<div></div>').addClass("combo-group");
                    var comboGroupHeader = $('<div>Groupp '+ tmpGroup +' - Số lượng yêu cầu : '+ value.quantity +'</div>').addClass("combo-group-header");


                    if(value.item_id_list) {
                        var item_id_list = value.item_id_list;
                        var itemArray = item_id_list.split(',');
                        comboGroup.append(comboGroupHeader);

                        $.each(itemArray, function( keyItem, itemId ){

                            try{
                                var itemComboDetail = dataItem[itemId].split('_*_');
                            }catch(e){

                            }


                            var inputQty = $('<select></select>').attr("id","comboQty"+tmpGroup+itemComboDetail[0]).attr("name","comboQty"+itemComboDetail[0]).addClass("form-control");
                            for (i=1;i<= value.quantity ;i++){
                                if(i == 1){
                                    inputQty.append($('<option selected></option>').val(i).html(i));
                                }else{
                                    inputQty.append($('<option></option>').val(i).html(i));
                                }
                            }

                            if(comboItemId){
                                var eatWithelm = $('<div class="funkyradio-primary">' +
                                '<input type="checkbox" name="comboCheckbox" id="'+tmpGroup+itemId+'"  value="'+dataItemEatwith[itemId] +'" comboid="'+itemComboDetail[0]+'" groupid="'+ tmpGroup +'" groupmax ="'+value.quantity+'" />' +
                                '<label for="'+tmpGroup+itemId+'">'+ itemComboDetail[1] +'</label> ' +
                                '</div>');
                            }else{
                                eatWithelm = $('<div class="funkyradio-primary">' +
                                '<input type="checkbox" name="comboCheckbox" id="'+tmpGroup+itemId+'"  value="'+itemComboDetail[0]+'" comboid="'+itemComboDetail[0]+'" groupid="'+ tmpGroup +'" groupmax ="'+value.quantity+'" />' +
                                '<label for="'+itemId+'">'+ itemComboDetail[1] +'</label> ' +
                                '</div>');

                            }

                            inputQty.appendTo(eatWithelm);
                            eatWithelm.appendTo(comboGroup);
                        });
                        checkboxEatWith.append(comboGroup);


                    }else{
                        var itemComboDetail = dataItem[value.item_id].split('_*_');

                        var eatWithelm = $('<div class="funkyradio-primary">' + '<label >'+ itemComboDetail[3] +' - '+ value.quantity +' </label> ' + '</div>');

                        eatWithelm.appendTo(comboGroup);

                        checkboxEatWith.append(comboGroup);
                    }

                });


                var elementSelCbQty = $('<div></div>');

                var lbelSelCbQty = ('<label>Số lượng</label>');
                var inputComboQty = $('<select></select>').attr("name","cbQty").attr("id","cbQty").addClass("form-control col-md-6");
                for (i=1;i<= 99 ;i++){
                    if(i == 1){
                        inputComboQty.append($('<option selected></option>').val(i).html(i));
                    }else{
                        inputComboQty.append($('<option></option>').val(i).html(i));
                    }
                }


                elementSelCbQty.append(lbelSelCbQty).append(inputComboQty);

                var btnEatWith = $('<input type="button" value="'+ labelAddCombo +'" style="margin-top: 25px" id="creat_combo" data-dismiss="modal">').addClass("col-md-offset-9 col-md-3 col-sm-6  col-xs-8  btn btn-success ");

                checkboxEatWith.append(elementSelCbQty).append(btnEatWith);

                $('#modalIdEatWith').modal('show')
                    .find('#modalContentEatWith').html(checkboxEatWith);

                $('#creat_combo').click(function(){

                    var groupCombo = [];

                    var groupCheckCombo = [];
                    var groupComboWithItemId = [];
                    var checkFail = 0;
                    var isNomal = 0;

                    var tmpCbItem = 0;

                    $('input[name="comboCheckbox"]:checked').each(function() {
                        tmpCbItem++;

                        var groupId = $(this).attr("groupid");
                        var groupComboMax = $(this).attr("groupmax");
                        var idCombo = $(this).attr("comboid");
                        var itemId = $(this).attr("itemid");

                        if(groupComboMax === undefined){
                            isNomal = 1;
                            var qTycb = $('#comboQty'+ idCombo ).find('option:selected').val();
                            groupId = idCombo;
                        }else{
                            var qTycb = $('#comboQty'+groupId+ idCombo ).find('option:selected').val();
                        }


//                        var idCombo = this.value;
                        if(comboItemId){
                            groupComboWithItemId.push(this.value + '_*_' +qTycb );
                        }

                        console.log('this.value',this.value);
                        console.log('idCombo',idCombo);

                        if( groupCombo[groupId] === undefined ) {
                            // do something
                            groupCombo[groupId] = [];
                            groupCombo[groupId].push(groupComboMax);
                            groupCombo[groupId].push(groupId);
                            groupCombo[groupId].push(itemId+'*'+qTycb);
                        }else{
                            groupCombo[groupId].push(itemId+'*'+qTycb);
                        }


                    });

                    $.each( groupCombo, function( key, value ) {
                        if(value  !== undefined){
                            var maxCheck =  0;
                            var tmpSumQty = 0;
                            $.each( value, function( keyCheckcombo, valueCheckcombo ) {
                                if(value  !== undefined){
                                    if(keyCheckcombo == 0){
                                        maxCheck =  parseInt(valueCheckcombo);
                                    }else{
                                        if(keyCheckcombo !== 1){
                                            var valueArray = valueCheckcombo.split('*');

                                            tmpSumQty = tmpSumQty + parseInt(valueArray[1]);
                                        }
                                    }
                                }
                            });

                            if(tmpSumQty !== maxCheck){

                                checkFail = 1;
                            }
                        }
                    });
                    if(isNomal == 1){
                        checkFail = 0;
                    }

                    if(checkFail){
                        alert("Kiểm tra lại số lượng yêu cầu");
                        return false;
                    }else{
                        if(comboItemId){
                            var slEatWith = '';

                            $.each( groupComboWithItemId, function(key,value){
                                if(slEatWith == ''){
                                    slEatWith = value
                                }else{
                                    slEatWith = slEatWith +','+ value;
                                }
                            });

                            var itemId = addToCart(comboIndexArray[0],1,null);

                            updateEatWith(itemId,slEatWith);

                        }else{

                            if(isNomal ==1 ){
                                $.each( groupCombo, function( key, value ) {

                                    if(value  !== undefined ){
                                        $.each( value, function( keyCheckcombo, valueCheckcombo ) {
                                            var idgroupCb = value[1];
                                            if(value  !== undefined){
                                                if(keyCheckcombo !== 0 && keyCheckcombo !== 1){
                                                    var valueArray = valueCheckcombo.split('*');
                                                    addToCartCombo(valueArray[0],valueArray[1],idgroupCb);
                                                }
                                            }
                                        });
                                    }
                                });

                            }else{
                                $.each( groupCombo, function( key, value ) {
                                    if(value  !== undefined){
                                        $.each( value, function( keyCheckcombo, valueCheckcombo ) {
                                            var idgroupCb = value[1];
                                            if(value  !== undefined){
                                                if(keyCheckcombo !== 0 && keyCheckcombo !== 1){
                                                    var valueArray = valueCheckcombo.split('*');
                                                    addToCartCombo(valueArray[0],valueArray[1],idgroupCb);
                                                }
                                            }
                                        });
                                    }
                                });
                            }
                        }

                    }


                    if(tmpCbItem == 0){
                        alert('Bạn cần phải chọn món cho combo');
                        return false;
                    }

                });

            }


            function updateCartQuantity(idx,qty){
                var productItem = elmProductSelected.children("option[rel=" + idx + "]");
                var pValue = $(productItem).attr("value");
                var valueArray = pValue.split('|');
                var prdId = valueArray[0];
                var curQty = valueArray[1];
                var curNote = valueArray[2];
                var curI = valueArray[3];
                var cdisCount = valueArray[4];
                var cEatWith = valueArray[5];
                var csledEatWith = valueArray[6];
                var pPrice = valueArray[7];
                var sumEatWith = fnSumEatWith(csledEatWith,qty,cdisCount,idx);

                var pObj = products.eq(curI);

                if($.isFunction(options.onUpdate)) {
                    // calling onUpdate event; expecting a return value
                    // will start Update if returned true and cancel Update if returned false
                    if(!options.onUpdate.call(this,$(pObj),qty)){
                        $('#lblQuantity'+idx).val(curQty);
                        return false;
                    }
                }


                var newPValue =  prdId + '|' + qty + '|' + curNote + '|' + curI+ '|' + cdisCount + '|' + cEatWith+ '|' + csledEatWith + '|' + pPrice ;
                $(productItem).attr("value",newPValue).attr('selected', true);
                var prdTotal = getMoneyFormatted((pPrice * qty) - (pPrice*qty*(cdisCount/100)) + sumEatWith);

                //console.log(valueArray);
                // Now go for updating the design
                var lblTotal =  $('#lblTotal'+idx).html(prdTotal);

                showHighlightMessage(messageQuantityUpdated);
                //Refresh the cart
                refreshCartValues();
                if($.isFunction(options.onUpdated)){
                    // calling onUpdated event; not expecting a return value
                    options.onUpdated.call(this,$(pObj),qty);
                }
            }

            function updateEatWith(idx,sledEatWith){

                /*console.log(idx);
                console.log(sledEatWith);*/

                var productItem = elmProductSelected.children("option[rel=" + idx + "]");
                var pValue = $(productItem).attr("value");
                var valueArray = pValue.split('|');
                var prdId = valueArray[0];
                var curQty = valueArray[1];
                var curNote = valueArray[2];
                var curI = valueArray[3];
                var cdisCount = valueArray[4];
                var cEatWith = valueArray[5];
//                var pObj = products.eq(curI);
                var pPrice = valueArray[7];
                var pPacket = valueArray[8];

//                var pDiscount = $(pObj).attr(attrProductDiscount);


                var sumEatWith = fnSumEatWith(sledEatWith,curQty,cdisCount,idx);
                var newPValue =  prdId + '|' + curQty + '|' + curNote + '|' + curI+ '|' + cdisCount + '|' + cEatWith + '|' + sledEatWith + '|'+  pPrice+ '|'+  pPacket;

                $(productItem).attr("value",newPValue).attr('selected', true);
                var prdTotal = getMoneyFormatted((pPrice * curQty) - (pPrice*curQty*(cdisCount/100)) + sumEatWith);

                //console.log(valueArray);
                // Now go for updating the design
//                var lblTotal =  $('#lblTotal'+idx).html(prdTotal);

                if(sledEatWith == ''){
                    $('#eatWith'+ idx).html('');
                }

                //Refresh the cart
                refreshCartValues();
                if($.isFunction(options.onUpdated)){
                    // calling onUpdated event; not expecting a return value
                    options.onUpdated.call(this,$(pObj),curQty);
                }


            }

            //Sum total of EatWith and  value
            function fnSumEatWith(sledEatWith,curQty,cdisCount,pIdx){
                var sumEatWith = 0;

                if(typeof sledEatWith != 'undefined' && sledEatWith != 'undefined' && sledEatWith != ''){
                    var arrEatWith = sledEatWith.split(',');
                    var eatWithContent = $('<div></div>').addClass("row");
                    $.each(arrEatWith, function( key, value ){
                        var arrOneEatWith = value.split('_*_'); // 0 La Id, 1 la gia, 2 la ten mon 3 là số lượng
                        var eatWithPrice = arrOneEatWith[1];
                        var eatWithQty = arrOneEatWith[3];
                        var eatWithSub = ((eatWithPrice * curQty * eatWithQty)  - (eatWithPrice * curQty * eatWithQty * (cdisCount/100)));
//                        sumEatWith =  sumEatWith /*+  eatWithSub*/;

                        var eatWithElment = $('<div></div>').addClass('row');
                        var ewName = $('<div> + '+arrOneEatWith[2]+'</div>').addClass("col-md-4 col-md-offset-1");
                        var ewPrice = $('<div>'+getMoneyFormatted(parseInt(arrOneEatWith[1]))+'</div>').addClass("col-md-2");
                        if(curQty>1){
                            ewQty = $('<div>'+arrOneEatWith[3]+'x' + curQty + '</div>').addClass("col-md-1 no-padding text-center");
                        }else{
                            var ewQty = $('<div>'+arrOneEatWith[3]+'</div>').addClass("col-md-1");
                        }

                        var ewTotal = $('<div>'+ getMoneyFormatted(eatWithSub) +'</div>').addClass("col-md-3 text-center");
                        eatWithElment.append(ewName).append(ewPrice).append(ewQty).append(ewTotal);
                        eatWithContent.append(eatWithElment);
                    });
                    $('#eatWith'+pIdx).html(eatWithContent);
//                                    console.log('#eatWith'+pIdx);
                }

                return sumEatWith;
            }

            //Sum only total of EatWith value
            function fnOnlySumEatWith(sledEatWith,curQty,cdisCount,pIdx){
                var sumEatWith = 0;
                if(typeof sledEatWith != 'undefined' && sledEatWith != 'undefined' && sledEatWith != ''){
                    var arrEatWith = sledEatWith.split(',');
                    $.each(arrEatWith, function( key, value ){

                        var arrOneEatWith = value.split('_*_'); // 0 La Id, 1 la gia, 2 la ten mon , 3 là Quanlity
                        var eatWithPrice = arrOneEatWith[1];
                        var eatWithQty = parseInt(arrOneEatWith[3]);
                        sumEatWith =  sumEatWith +  ((eatWithPrice * curQty * eatWithQty)  - (eatWithPrice*curQty*(cdisCount/100))) ;
                    });
                }
                return sumEatWith;
            }

            function updateCartNote(idx,note){
                //var pObj = products.eq(idx);
                var productItem = elmProductSelected.children("option[rel=" + idx + "]");
                //var pPrice = $(pObj).attr(attrProductPrice);
                var pValue = $(productItem).attr("value");
                var valueArray = pValue.split('|');
                var prdId = valueArray[0];
                var curQty = valueArray[1];
                var curNote = valueArray[2];
                var curI = valueArray[3];
                var cdisCount = valueArray[4];
                var cEatWith = valueArray[5];
                var csledEatWith = valueArray[6];
                var pPrice = valueArray[7];
                var pPacketId = valueArray[8];
                //var sumEatWith = fnSumEatWith(csledEatWith,curQty,discount,idx);


                if($.isFunction(options.onUpdate)) {
                    // calling onUpdate event; expecting a return value
                    // will start Update if returned true and cancel Update if returned false
                    if(!options.onUpdate.call(this,$(pObj),note)){
                        $('#lblNote'+idx).val(curNote);
                        return false;
                    }
                }

                var newPValue =  prdId + '|' + curQty + '|' + note + '|' + curI+ '|' + cdisCount+ '|' + cEatWith+ '|' + csledEatWith + '|' + pPrice +'|'+ pPacketId;
                $(productItem).attr("value",newPValue).attr('selected', true);
                //var prdTotal = getMoneyFormatted(pPrice * qty);
                //    // Now go for updating the design
                //var lblTotal =  $('#lblTotal'+idx).html(prdTotal);
                showHighlightMessage(messageQuantityUpdated);
                //Refresh the cart
                refreshCartValues();
                if($.isFunction(options.onUpdated)){
                    // calling onUpdated event; not expecting a return value
                    options.onUpdated.call(this,$(pObj),qty);
                }
            }

            function updateCartDiscount(idx,discount){
                //var pObj = products.eq(idx);
                var productItem = elmProductSelected.children("option[rel=" + idx + "]");
                //var pPrice = $(pObj).attr(attrProductPrice);
                var pValue = $(productItem).attr("value");
                var valueArray = pValue.split('|');
                var prdId = valueArray[0];
                var curQty = valueArray[1];
                var curNote = valueArray[2];
                var curI = valueArray[3];
                var curDiscount = valueArray[4];
                var cEatWith = valueArray[5];
                var csledEatWith = valueArray[6];
                var pPrice = valueArray[7];
                var sumEatWith = fnSumEatWith(csledEatWith,curQty,discount,idx);


                if($.isFunction(options.onUpdate)) {
                    // calling onUpdate event; expecting a return value
                    // will start Update if returned true and cancel Update if returned false
                    if(!options.onUpdate.call(this,$(pObj),discount)){
                        $('#lblDiscount'+idx).val(curDiscount);
                        return false;
                    }
                }

                var newPValue =  prdId + '|' + curQty + '|' + curNote + '|' + curI+ '|' + discount+ '|' + cEatWith + '|' + csledEatWith + '|' + pPrice;
                $(productItem).attr("value",newPValue).attr('selected', true);
                var prdTotal = getMoneyFormatted((pPrice * curQty) - (pPrice * curQty *discount/100) + sumEatWith);
                //    // Now go for updating the design
                var lblTotal =  $('#lblTotal'+idx).html(prdTotal);
                showHighlightMessage(messageQuantityUpdated);
                //Refresh the cart
                refreshCartValues();

                if($.isFunction(options.onUpdated)){
                    // calling onUpdated event; not expecting a return value
                    options.onUpdated.call(this,$(pObj),curQty);
                }
            }


            function refreshCartValues(){
                var sTotal = 0;
                var cProductCount = 0;
                var cItemCount = 0;
                elmProductSelected.children("option").each(function(n) {
                    var pIdx = $(this).attr("rel");
                    var pValue = $(this).attr("value");
                    var valueArray = pValue.split('|');
                    var prdId = valueArray[0];
                    var pQty = valueArray[1];
                    var pI = valueArray[3];
                    var pDiscount = valueArray[4];
                    var pEatWith = valueArray[5];
                    var pEatWithSelected = valueArray[6];
                    var pPrice = valueArray[7];


                    var sumEatWith = fnOnlySumEatWith(pEatWithSelected,pQty,pDiscount,pI);

                    var pObj = products.eq(pI);

                    sTotal = sTotal + (((pPrice - 0) * (pQty - 0)) - ((pPrice - 0) * (pQty - 0) * (pDiscount/100))) + sumEatWith;


                    cProductCount = parseInt(cProductCount) + parseInt(pQty);
                    cItemCount = cItemCount + (pQty-0);
                });
                subTotal = sTotal;
                cartProductCount = cProductCount;
                cartItemCount = cItemCount;
                elmBottomCountValue.html(cartProductCount);
                elmBottomSubtotalValue.html(getMoneyFormatted(subTotal));

                setCookie('total',subTotal,1); // Lưu lại tổng vào Cokice



                cartMenu = labelCartMenuName.replace('_COUNT_',cartProductCount);
                cartMenuTooltip = labelCartMenuNameTooltip.replace('_PRODUCTCOUNT_',cartProductCount).replace('_ITEMCOUNT_',cartItemCount);
                btShowCart.html(cartMenu).attr("title",cartMenuTooltip);

                // .!Get shipValue;
                if(cProductCount <= 0){
                    $('input[type="submit"]').attr('disabled','disabled');
                    $('input[type="button"]').prop('disabled', 'disabled');
                    showMessage(messageCartEmpty,elmCartList);
                }else{
                    $('input[type="submit"]').prop('disabled', false);
                    $('.scMessageBar',elmCartList).remove();
                }
            }



            function populateCart(){
                elmProductSelected.children("option").each(function(n) {
                    var curPValue =  $(this).attr("value");
                    var valueArray = curPValue.split('|');
                    var prdId = valueArray[0];
                    var prdQty = valueArray[1];
                    if(!prdQty){
                        prdQty = 1; // if product quantity is not present default to 1
                    }
                    var objProd = jQuery.grep(products, function(n, i){return ($(n).attr(attrProductId) == prdId);});
                    var prodIndex = products.index(objProd[0]);
                    var prodName = $(objProd[0]).attr(attrProductName);
                    $(this).attr('selected', true);
                    $(this).attr('rel', prodIndex);
                    $(this).html(prodName);
                    cartItemCount++;
                    addCartItemDisplay(objProd[0],prdQty,null);
                });
                // Reresh the cart
                refreshCartValues();
            }

            function fillCategory(){
                var catCount = 0;
                var catItem = $('<option></option>').attr("value",'').attr('selected', true).html('Tất cả');
                elmCategory.prepend(catItem);
                $(products).each(function(i,n){
                    var pCategory = $(this).attr(attrCategoryName);
                    if(pCategory && pCategory.length>0){
                        var objProd = jQuery.grep(elmCategory.children('option'), function(n, i){return ($(n).val() == pCategory);});
                        if(objProd.length<=0){
                            catCount++;
                            var catItem = $('<option></option>').attr("value",pCategory).html(pCategory);
                            elmCategory.append(catItem);
                        }
                    }

                });
                if(catCount>0){
                    $(elmCategory).bind("change", function(e){
                        $(txtSearch).val('');
                        populateProducts();
                        return true;
                    });
                }else{
                    elmCategory.hide();
                    lblCategory.hide();
                }
            }


            function populateProducts(searchString){
                var isSearch = false;
                var productCount = 0;
                var selectedCategory = $(elmCategory).children(":selected").val();
                // validate and prepare search string
                if(searchString){
                    searchString = trim(searchString);
                    if(searchString.length>0){
                        isSearch = true;
                        searchString = searchString.toLowerCase();
                    }
                }
                // Clear the current items on product list
                elmPLProducts.html('');
                // Lets go for dispalying the products
                $(products).each(function(i,n){
                    var productName = $(this).attr(attrProductName);
                    var productCategory = $(this).attr(attrCategoryName);
                    var isValid = true;
                    var isCategoryValid = true;
                    if(isSearch){
                        if(productName.toLowerCase().indexOf(searchString) == -1) {
                            isValid = false;
                        }else{
                            isValid = true;
                        }
                    }
                    // Category filter
                    if(selectedCategory && selectedCategory.length>0){
                        selectedCategory = selectedCategory.toLowerCase();
                        if(productCategory.toLowerCase().indexOf(selectedCategory) == -1) {
                            isCategoryValid = false;
                        }else{
                            isCategoryValid = true;
                        }
                    }

                    if(isValid && isCategoryValid) {
                        productCount++;
                        var productPrice = $(this).attr(attrProductPrice);
                        var prodImgSrc = $(this).attr(attrProductImage);

                        var elmProdDiv1 = $('<div></div>').addClass("col-md-12 no-padding");
                        if(prodImgSrc && options.enableImage && prodImgSrc.length>0){
                            var prodImg = $("<img></img>").attr("src",prodImgSrc).addClass("scProductImage");
                            elmProdDiv1.append(prodImg);
                        }else{
                            prodImgSrc = 'http://image.foodbook.vn/images/fb/items/item-default.png';
                            var prodImg = $("<img></img>").attr("src",prodImgSrc).addClass("scProductImageSmall");
                            elmProdDiv1.append(prodImg);
                        }
                        var elmProdDiv2 = $('<div></div>').addClass("scPDiv2"); // for product name, desc & price
                        var productHtml = formatTemplate(options.productItemTemplate, $(this));
                        //elmProdDiv2.html(productHtml);

                        var elmProdDiv3 = $('<div></div>').addClass(""); // for button & qty
                        var btAddToCart = $('<a></a>').attr("href","#").attr("rel",i).attr("title",labelAddToCartButton).addClass("");
                        btAddToCart.prepend(elmProdDiv1);
                        btAddToCart.append(productHtml);
                        $(btAddToCart).bind("click", function(e){
                            var idx = $(this).attr("rel");
                            var qty = $(this).siblings("input").val();
                            if(validateNumber(qty)){
                                addToCart(idx,qty,null);
                                //display();
                            }else{
                                $(this).siblings("input").val(1);
                                showHighlightMessage(messageQuantityErrorAdd);
                            }
                            return false;
                        });
                        var inputQty = $('<input type="hidden" value="1" />').addClass("");
                        var labelQty = $('<label>'+labelQuantityText+':</label>').addClass("");
                        elmProdDiv3/*.append(labelQty)*/.append(inputQty).append(btAddToCart);

                        var elmProds = $('<div"></div>').addClass(" col-md-3 col-lg-3 btn btn-default proMenu");

                        elmProds/*.append(elmProdDiv1).append(elmProdDiv2)*/.append(elmProdDiv3);
                        elmPLProducts.append(elmProds);
                    }
                });

                if(productCount <= 0){
                    showMessage(messageProductEmpty,elmPLProducts);
                }
            }


            function setCookie(c_name,value,exdays)
            {
                var exdate=new Date();
                exdate.setDate(exdate.getDate() + exdays);
                var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
                document.cookie=c_name + "=" + c_value;
            }

            function getCookie(c_name)
            {
                var i,x,y,ARRcookies=document.cookie.split(";");
                for (i=0;i<ARRcookies.length;i++)
                {
                    x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
                    y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
                    x=x.replace(/^\s+|\s+$/g,"");
                    if (x==c_name)
                    {
                        return unescape(y);
                    }
                }
            }

            // Display message
            function showMessage(msg, elm){
                var elmMessage = $('<div></div>').addClass("scMessageBar").hide();
                elmMessage.html(msg);
                if(elm){
                    elm.append(elmMessage);
                    elmMessage.show();
                }
            }



            function showHighlightMessage(msg){
                msgBox2.html(msg);
                msgBox2.fadeIn("fast", function() {
                    setTimeout(function() { msgBox2.fadeOut("fast"); }, 2000);
                });
            }


            // Show Image tooltip
            function showTooltip(img) {
                var height = img.height();
                var width = img.height();
                var imgOffsetTop = img.offset().top;
                /*jQuery.log(img.offset());
                 jQuery.log(img.position());
                 jQuery.log("--------------");*/
                tooltip.html('');
                var tImage = $("<img></img>").attr('src',$(img).attr('src'));
                tImage.height(toolMaxImageHeight);
                tooltip.append(tImage);
                var top = imgOffsetTop - height ;
                var left = width + 10;
                tooltip.css({'top':top, 'left':left});
                tooltip.show("fast");
            }

            function validateNumber(num){
                var ret = false;
                if(num){
                    num = num - 0;
                    if(num && num > 0){
                        ret = true;
                    }
                }

                return ret;
            }
            function validateDiscount(num){
                var ret = false;
                if(num != 0 && num <=100){
                    num = num - 0;
                    if(num && num > 0){
                        ret = true;
                    }
                }

                return ret;
            }





            // Get the money formatted for display
            function getMoneyFormatted(val){

                n = val.toFixed(0)
                while (true) {
                    var n2 = n.replace(/(\d)(\d{3})($|,|\.)/g, '$1,$2$3')
                    if (n == n2) break
                    n = n2
                }
                return n;

                //return val.toFixed(0);
            }
            // Trims the blankspace
            function trim(s){
                var l=0; var r=s.length -1;
                while(l < s.length && s[l] == ' ')
                {	l++; }
                while(r > l && s[r] == ' ')
                {	r-=1;	}
                return s.substring(l, r+1);
            }
            // format the product template
            function formatTemplate(str, objItem){
                resStr =str.split("<%=");
                      var finalStr = '';
                      for(i=0;i<resStr.length;i++){
                        var tmpStr = resStr[i];
                        valRef = tmpStr.substring(0, tmpStr.indexOf("%>"));
                if(valRef!='' || valRef!=null){
                    var valRep = objItem.attr(valRef); //n[valRef];
                    if(valRep == null || valRep == 'undefined'){
                        valRep = '';
                    }
                    tmpStr = tmpStr.replace(valRef+'%>',valRep);
                    finalStr += tmpStr;
                }else{
                    finalStr += tmpStr;
                }
            }
            return finalStr;
        }

    });
};

// Default options
$.fn.smartCart.defaults = {
    selected: 0,  // 0 = produts list, 1 = cart
    resultName: 'products_selected[]',
    enableImage: true,
    enableImageTooltip: true,
    enableSearch: true,
    enableCategoryFilter: true,
    /*productItemTemplate:'<strong><%=pname%></strong><br />Category: <%=pcategory%><br /><small><%=pdesc%></small><br /><strong>Price: <%=pprice%></strong>',*/
    productItemTemplate:'<div class="fullname"><div class="text-box"><%=pfullname%></div></div> <div ><div class="prductName col-md-12 no-padding"><%=pname%><br/><%=pprice%></div></div>',
    cartItemTemplate:'<strong><%=pname%></strong><br />',
    // Events
    onAdd: null,      // function(pObj,quantity){ return true; }
    onAdded: null,    // function(pObj,quantity){ }
    onRemove: null,   // function(pObj){return true;}
    onRemoved: null,  // function(pObj){ }
    onUpdate: null,   // function(pObj,quantity){ return true; }
    onUpdated: null,  // function(pObj,quantity){ }
    onCheckout: null  // function(Obj){ }
};


//})(jQuery);

// Call Smart Cart
$('#SmartCart').smartCart();
});


</script>
<!-- Smart Cart HTML Starts -->

<?php $form = ActiveForm::begin([
    'action' => ['createshortorder'],
    'id' => 'shortForm'
]); ?>
<div id="SmartCart" class="scMain clearfix">
    <?php
    if($listItems){
        foreach($listItems as $pos){
            /*echo '<pre>';
            var_dump($listItems);
            echo '</pre>';
            die();*/
            if(!$pos->Is_Eat_With){
                $mDiscount = @$pos->Discount_Ta_Price * 100;
                if(!isset($pos->Item_Image_Path_Thumb)){
                    $pos->Item_Image_Path_Thumb = 'https://image.foodbook.vn/images/fb/items/item-default.png';
                }
                $itemName = mb_strimwidth(@$pos->Item_Name,0,20,'...','utf-8');
                echo '<input type="hidden" pimage="'.$pos->Item_Image_Path_Thumb.'" pfullname ="'.@$pos->Item_Name.'"  pprice="'.$pos->Ta_Price.'" pitemid="'.$pos->Item_Id.'" pdiscount="'.$mDiscount.'" piseatwith="'.@$pos->Is_Eat_With.'" peatwith="'.@$pos->Item_Id_Eat_With.'"  pname="'.$itemName.'" pcategory="'.@$itemTypeMap[$pos->Item_Type_Id].'" pdesc="'.@$pos->Description.'" pid="'.$pos->Id.'" pcomboid="'.@$pos->Combo_Item_Id.'" pisnomalcb="'.@$pos->Is_Nomal_Combo.'" pcomboex='.@$pos->combo_details.'>';
//                echo '<input type="hidden" pimage="'.$pos->Item_Image_Path_Thumb.'" pfullname ="'.@$pos->Item_Name.'"  pprice="'.$pos->Ta_Price.'" pdiscount="'.$mDiscount.'" piseatwith="'.@$pos->Is_Eat_With.'" peatwith="'.@$pos->Item_Id_Eat_With.'"  pname="'.$itemName.'" pcategory="'.@$itemTypeMap[$pos->Item_Type_Id].'" pdesc="'.@$pos->Description.'"  pid="'.$pos->Id.'">';
            }
        }
    }
    ?>
</div>

<?php
Modal::begin([
    'header' => '<h4>Chọn thời gian giao sau</h4>',
    'footer' => '<input id= "btn_creatoder_later" type="submit" value="Tạo đơn" class="btn btn-success">',
    'id' => 'modal',
]);
echo '<div id="modalContent">';?>
<?= $this->render('_form_timeorderlate', [
]) ?>
<?php echo '</div>';
Modal::end();
?>

<?php
Modal::begin([
    'header' => '<h4>Lịch sử giao dịch</h4>',
//    'footer' => '<input id= "btn_creatoder" type="submit" value="Tạo đơn" class="btn btn-success">',
    'id' => 'modalHistory',
    'size' => 'modal-lg',
]);
echo '<div id="historyContent">';?>
<?php echo '</div>';
Modal::end();
?>

<?php
Modal::begin([
    'header' => '<h4>Thuế và các thành phần phụ</h4>',
//    'footer' => '<input id= "btn_vat_cancel" type="button" value="Tạo đơn" class="btn btn-danger"> <input id= "btn_vat_ok" type="button" value="Tạo đơn" class="btn btn-success"> ',
    'id' => 'modalVat',
]);
?>
<div id="calContent">
    <div class="form-group">
        <label for="email">Thuế VAT(%):</label>
        <input name="txt-vat" class="form-control" id="input-vat" type="number">


        <label for="email">Phí dịch vụ (%)</label>
        <input name="txt-service_charge" class="form-control" id="input-charge" type="number">

        <?= $form->field($model, 'DISCOUNT_BILL', [
            'addon' => [
                'append' => [
                    'content' => $form->field($model, 'DISCOUNT_BILL_TYPE')->widget(SwitchInput::classname(), [
                        'pluginOptions' => [
                            'onText' => 'đ',
                            'offText' => '%',
                            'onColor' => 'primary',
                            'offColor' => 'success',
                        ],
                        'pluginEvents' => [
                            //"switchChange.bootstrapSwitch" => "function() { console.log('switchChange'); }",
                            "switchChange.bootstrapSwitch" => "function() {
                        checkswitch()
                        } ",
                        ]
                    ])->label(false),
                    'asButton' => true
                ]
            ]
        ])->widget(MaskedInput::className(), [
            'mask' => '9',
            'clientOptions' => ['repeat' => 10, 'greedy' => false]
        ])->label('Chiết khấu');
        ?>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal" id="btn_cancel_option">Hủy</button>
        <button type="button" class="btn btn-success" data-dismiss="modal" id="btn_update_option">Đồng ý</button>
    </div>

</div>
<?php
Modal::end();
?>

<?php
Modal::begin([
    'header' => '<h4>Cập nhật hồ sơ khách hàng</h4>',
    'footer' => '<button type="button" class="btn btn-success" data-dismiss="modal">Đóng</button>',
    'id' => 'modalProfile',
]);
echo '<div id="profileContent">';?>
<?= $this->render('_form_profile', [
]) ?>
<?php echo '</div>';
Modal::end();
?>

<?php
Modal::begin([
    'header' => '<h4>Cập nhật địa chỉ</h4>',
    'footer' => '<input  type="submit" value="Cập nhật" class="btn btn-success">',
    'id' => 'modalAddress',
    'size'=>'modal-lg',
]);
echo '<div id="addressContent">';?>


<?php echo '</div>';
Modal::end();
?>



<?php
Modal::begin([
    'header' => '<h4 id="header-popup">Chọn món ăn kèm</h4>',
//    'footer' => '<input id= "btn_seteatwith" type="submit" value="Chọn" class="btn btn-success">',
    'footer' => '',
    'id' => 'modalIdEatWith',
]);
echo '<div id="modalContentEatWith">';?>
<?php echo '</div>';
Modal::end();
?>


<!-- modal -->
<div class="modal fade" id="myMapModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Cập nhật địa chỉ</h4>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <input id="pac-input" class="controls" type="text" placeholder="Gõ địa chỉ tìm kiếm..."   size="50" name="mapAdress" data-required="true" value="<?=@$model->to_address?>" autofocus>
                        <input type="hidden" id="txtcity" name="txtcity">
                        <input type="hidden" id="txtstate" name="txtstate">
                        <div id="map-canvas" class=""></div>
                        <?php
                            echo '<label class="control-label">Mục đích</label>';
                            echo '<div style="width: 400px">';
                            echo Select2::widget([
                                'name' => 'purpose',
                                'data' => $purposeMap,
                                'options' => [
                                    'placeholder' => 'Chọn mục đích ...',
                                ],

                            ]);
                            echo '</div>';
                        ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="btn_update_add">Đóng</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<?php ActiveForm::end(); ?>

<style>
    .has-error{
        border-color: #a94442;
        color: #a94442;
    }
</style>
<script>

    // bắt sự kiện của select nhà hàng để xem nhà hàng đó có cho phép giao sau hay không
    function getval(sel) {
        var posOrderLater = <?= json_encode($posMapOrder)?>;
        var numberProductSelected = document.getElementById("proSelected").options.length;
        if ($.inArray(sel.value, posOrderLater) > -1 && numberProductSelected > 0)  // Check phần tử tồn tại trong array hay không
        {
            $('input[type="button"]').prop('disabled', false);
        }else{
            $('input[type="button"]').prop('disabled', 'disabled');
        }
    }

    // Check order later khi vào
    function getvalstart(sel) {
        var posOrderLater = <?= json_encode($posMapOrder)?>;
        if ($.inArray(sel.value, posOrderLater) > -1)  // Check phần tử tồn tại trong array hay không
        {
            $('input[type="button"]').prop('disabled', false);
        }else{
            $('input[type="button"]').prop('disabled', 'disabled');
        }

    }



    function setCookie(cname,cvalue,exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        var expires = "expires=" + d.toGMTString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }


    function checkCookie(keyData,formData) {
        var order = getCookie("pendingOrder");
        if (order != ""){
            var data = JSON.parse(order);
            for (var i = 0; i < data.length; i++) {
                if (data[i]['keyData'] === keyData+"_"+timeTmp ) {
                    data.splice(i, 1);
                    data.push({keyData: keyData+"_"+timeTmp ,dataArray :formData});
                    setCookie("pendingOrder", JSON.stringify(data), 30);
                    i--;
                }
            }

        }else{
            data = [];
            data.push({keyData: keyData+"_"+timeTmp ,dataArray :formData});
            setCookie("pendingOrder", JSON.stringify(data), 30);
        }

    }

    var delete_cookie = function(name) {
        var order = getCookie("pendingOrder");
        if (order != ""){
            var data = JSON.parse(order);
            for (var i = 0; i < data.length; i++) {
                console.log(data[i]['keyData']);
                if (data[i]['keyData'] === name) {
                    data.splice(i, 1);
                    document.cookie = 'pendingOrder' + '=;expires=Thu, 01 Jan 1970 00:00:01 GMT;';
                    setCookie("pendingOrder", JSON.stringify(data), 30);
                    i--;
                }
            }
        }
    };


    $(function(){
        $('#btn_history').click(function(){
            var phone = $("#textPhone").val();

            $.ajax({type: "POST",
                url: "<?= \yii\helpers\Url::to(['getinfomembershortcallcenter'])?>",
                data: { user_id : phone},

                beforeSend: function() {
                    //that.$element is a variable that stores the element the plugin was called on
//                    $("#booking_order").addClass("fb-grid-loading");
                },
                complete: function() {
                    //$("#modalButton").removeClass("loading");
//                    $("#booking_order").removeClass("fb-grid-loading");
                },
                success:function(result){
                    //console.log(result);
                    $("#historyContent").html(result);
                }
            });

            $('#modalHistory').modal('show')
                .find('#historyContent')
                .load($(this).attr('value'));
        });
    });


    // Get the money formatted for display
    function getMoneyFormatted(val){

        n = val.toFixed(0)
        while (true) {
            var n2 = n.replace(/(\d)(\d{3})($|,|\.)/g, '$1,$2$3')
            if (n == n2) break
            n = n2
        }
        return n;

        //return val.toFixed(0);
    }

    $(function(){
        $('#btn_cancel_option').click(function(){
            $("#orderonlinelog-discount_bill").val("");
            $("#input-vat").val("");
            $("#input-charge").val("");

            var total = getCookie("total");
            $(".scLabelSubtotalValue").html(getMoneyFormatted(parseInt(total)));

        });
    });

    $(function(){
        $('#btn_update_option').click(function(){
            var vat = $("#input-vat").val();
            var discountBill = $("#orderonlinelog-discount_bill").val();
            var discountBillType = $("input[type='checkbox'][name='Orderonlinelog[DISCOUNT_BILL_TYPE]']");
            var discountType = 0;

            var charge = 0;
            charge = $("#input-charge").val();
            var total = getCookie("total");


            if(discountBillType.prop('checked')) {
                discountType = 1;
            }else{
                discountBill = total*discountBill/100;
            }


            var newTotal = parseInt(total) + parseInt(total*vat/100) + Number(charge) - discountBill ;

            $(".scLabelSubtotalValue").html(getMoneyFormatted(newTotal));


        });




        $("#orderonlinelog-discount_bill").change(function(){
            var discount_type = $("input[type='checkbox'][name='Dmvouchercampaign[DISCOUNT_TYPE]']");
            if(discount_type.prop('checked')) {
            } else {
                if($("#orderonlinelog-discount_bill").val() >= 100){
                    $("#orderonlinelog-discount_bill").val(100);
                }
            }
        });
        $("#input-vat").change(function(){
            if($("#input-vat").val() >= 100){
                $("#input-vat").val(100);
            }
        });

    });

    $(function(){
        $('#btn_calcu').click(function(){

            $('#modalVat').modal('show')
                .find('#historyContent')
                .load($(this).attr('value'));
        });
    });

    $(function(){
        $('#btn_updateprofile').click(function(){
            $('#modalProfile').modal('show')
                .find('#profileContent')
                .load($(this).attr('value'));
        });
    });

</script>



<style>
    #map-canvas  {
        margin: 0;
        padding: 0;
        height: 100%;
        width: 100%;
    }
    #map-canvas {
        width:500px;
        height:360px;
    }

    #pac-input{
        background-color: #FFF;
        z-index: 20;
        position: fixed;
        display: inline-block;
        float: left
    }
   /*.modal{
        z-index: 20;
    }
    .modal-backdrop{
        z-index: 10;
    }​*/

     div.pac-container {
         z-index: 1050 !important;
     }
</style>

<script>
    $( document ).ready(function() {
        var map;
        var myCenter=new google.maps.LatLng(53, -1.33);
        var marker=new google.maps.Marker({
            position:myCenter
        });



        function initialize() {
            var mapProp = {
                center: {lat: 20.986102, lng: 105.846498},
                zoom: 15,
                draggable: true,
                scrollwheel: true,
                mapTypeId:google.maps.MapTypeId.ROADMAP

            };

            map=new google.maps.Map(document.getElementById("map-canvas"),mapProp);

            // Create the search box and link it to the UI element.
            var input = document.getElementById('pac-input');
            var searchBox = new google.maps.places.SearchBox(input);
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

            // Bias the SearchBox results towards current map's viewport.
            map.addListener('bounds_changed', function() {
                searchBox.setBounds(map.getBounds());
            });


            marker.setMap(map);
            var markers = [];

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

                    var address  = getaddress(place);
                    //console.log(address);

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
                                    $('#pac-input').val(results[0].formatted_address);
                                }
                            }
                        });
                    });

                    $("#addressTxt").val($('#pac-input').val());
                });
                map.fitBounds(bounds);
            });

            var geocoder = new google.maps.Geocoder();

        };

        function getaddress(place){
            var loc1 = place;
            var county, city, state,address;
            console.log(loc1);
            $.each(loc1, function(k1,v1) {
                if (k1 == "address_components") {
                    //console.log(v1);
                    for (var i = 0; i < v1.length; i++) {
                        for (k2 in v1[i]) {
                            if (k2 == "types") {
                                var types = v1[i][k2];
//                                console.log(types);
                                if (types[0] =="sublocality_level_1") {
                                    county = v1[i].long_name;
                                    //alert ("county: " + county);
                                }
                                if (types[0] =="locality") {
                                    city = v1[i].long_name;
                                    $('#txtcity').val(city);
                                    //alert ("city: " + city);
                                }
                                if (types[0] =="administrative_area_level_2") {
                                    state = v1[i].short_name;
                                    $('#txtstate').val(state);
                                    //alert ("city: " + city);
                                }
                            }

                        }

                    }

                }
            });

            address = [city,state];


            return address;

        }

        google.maps.event.addDomListener(window, 'load', initialize);

        google.maps.event.addDomListener(window, "resize", resizingMap());

        $('#myMapModal').on('show.bs.modal', function() {
            //Must wait until the render of the modal appear, thats why we use the resizeMap and NOT resizingMap!! ;-)
            resizeMap();
        });

        function resizeMap() {
            if(typeof map =="undefined") return;
            setTimeout( function(){resizingMap();} , 400);
        }

        function resizingMap() {
            if(typeof map =="undefined") return;
            var center = map.getCenter();
            google.maps.event.trigger(map, "resize");
            map.setCenter(center);
        }
    });


    var rad = function(x) {
        return x * Math.PI / 180;
    };


    function resizeMap() {
        if(typeof map =="undefined") return;
        setTimeout( function(){resizingMap();} , 400);
    }

    function resizingMap() {
        if(typeof map =="undefined") return;
        var center = map.getCenter();
        google.maps.event.trigger(map, "resize");
        map.setCenter(center);
    }

//    $("#pac-input").change(function(){
//        $("#addressTxt").val($("#pac-input").val());
//    });


</script>


<style>

    .fullname {
        display: none;
        position: absolute;
        text-align: center;
        width: 137px;
        height: 120px;
        background-color: rgba(0,0,0,0.5);
        color: #fff;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        margin: auto;
    }

    .proMenu:hover .fullname{
        display: block;
    }

    .text-box {
        display: block; !important;
        position: absolute;
        height: 100%;
        text-align: center;
        width: 100%;

    }
    .text-box:before {
        content: '';
        display: inline-block;
        height: 100%;
        vertical-align: middle;
    }
    .scLabelSubtotalValue{
        color: red;
        font-weight: 800;
        margin-right: -29px;
        padding-left: 0px;
    }
    .countTotal{
        color: #0000ff;
        font-weight: 800;
        text-align: center;
    }

    .funkyradio-primary {
        border-top: 1px solid #fafafa;
        line-height: 3em;
    }

    .funkyradio-primary select {
        margin-right: 10px;
        float: right;
        margin-top: 6px;
        width: auto !important;
    }

    .funkyradio-primary input{
        margin-right: 10px;
    }

</style>