<?php
// bản backup này được tạo trước khi làm món ăn kèm
use backend\assets\AppAsset;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use yii\bootstrap\Modal;
if($isBooking){
    $this->title = 'Tạo đặt bàn';
}else{
    $this->title = 'Tạo đơn hàng';
}
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
            var attrProductPrice = "pprice"; // Product Price attribute
            var attrProductDiscount = "pdiscount"; // Product Price attribute
            var attrProductImage = "pimage"; // Product Image attribute
            var attrCategoryName = "pcategory";
            var attrIsEatWith = "piseatwith";
            var attrEatWith = "peatwith";

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
            var elmBottomSubtotalText = $('<label>'+labelTotal+':</label>').addClass("scLabelSubtotalText col-md-8");
            var elmBottomSubtotalValue = $('<span>'+getMoneyFormatted(subTotal)+'</span>').addClass("scLabelSubtotalValue col-md-2 no-padding");


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
            var elmBottomPhoneText = $('<label>'+labelPhone+':</label>').addClass("scLabelSubtotalText col-md-5");
            var elmBottomPhoneValue = $('<input name="textPhone" value="<?= $phoneNumber ?>" id="textPhone">').addClass(" col-md-6 no-padding controls_detail required");
            elmShowPayment.append(elmBottomPhoneText).append(elmBottomPhoneValue);

            // Show Info Name
            var elmBottomInfoText = $('<label>'+labelInfo+':</label>').addClass("scLabelSubtotalText col-md-5 ");
            var elmBottomInfoValue = $('<input name="textName" value="<?= @$model->username ?>" id="textName">').addClass(" col-md-6 no-padding controls_detail");
            elmShowPayment.append(elmBottomInfoText).append(elmBottomInfoValue);

            // Show address Customer
            var elmBottomAddressText = $('<label>'+labelAddres+':</label>').addClass("scLabelSubtotalText col-md-5");
            var elmBottomAddressValue = $('<input name="addressTxt" value="<?= @$model->to_address ?>"  id="addressTxt">').addClass(" col-md-6 no-padding controls_detail");



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
                                            ]);?>').addClass(" col-md-6 no-padding controls_detail");

            // Show address Customer
            var elmBottomNumberPeopleText = $('<label>'+labelNumberPeople+':</label>').addClass("scLabelSubtotalText col-md-5");
            var elmBottomNumberPeopleValue = $('<?= \yii\widgets\MaskedInput::widget([
                                                    'name' => 'Number_People',
                                                    'id' => 'numberPeopleTxt',
                                                    'mask' => '9',
                                                    'clientOptions' => ['repeat' => 10, 'greedy' => false]
                                                ]);?>').addClass("col-md-6 no-padding controls_detail").removeClass('form-control');


            if(!isBookking){
                elmShowPayment.append(elmBottomAddressText).append(elmBottomAddressValue);
            }else{
                elmShowPayment.append(elmBottomTimeText).append(elmBottomTimeValue);
                elmShowPayment.append(elmBottomNumberPeopleText).append(elmBottomNumberPeopleValue);
            }

            var elmBottomFeeText = $('<label>'+labelFee+':</label>').addClass("scLabelSubtotalText col-md-5");
            var elmBottomFeeValue = $('<input name="feeTxt">').addClass(" col-md-6 no-padding controls_detail");
            if(!isBookking){
                elmShowPayment.append(elmBottomFeeText).append(elmBottomFeeValue);
            }

            // Show Note
            var elmBottomNoteText = $('<label>'+labelNote+':</label>').addClass("scLabelSubtotalText col-md-5 ");
            var elmBottomNoteValue = $('<input name="noteTxt" >').addClass("col-md-6 no-padding controls_detail");
            elmShowPayment.append(elmBottomNoteText).append(elmBottomNoteValue);


            var elmBottomPosSelect = $('<label>'+labelPosSelect+':</label>').addClass("col-md-5");
            var posMap = <?= json_encode($allPosMap); ?>; // output php string here

            var optionSel = '';
            var tempPos = 0;
            $.each(posMap, function(key, value) {
                //get Lat long tu array php
                optionSel = '<option value="'+key+'">'+value+'</option>'+optionSel;
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

            $(function(){
                $('#btn_creatoderlater').click(function(){
                    $('#modal').modal('show')
                        .find('#modalContent')
                        .load($(this).attr('value'));
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
            elmBottomBar.append(elmBottomSubtotalText).append(elmBottomSubtotalValue).append(elmShowPayment).append(elmDivButton);


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

            function addToCart(i,qty){
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
                    var pName = $(addProduct).attr(attrProductName);
                    var pPrice = $(addProduct).attr(attrProductPrice);
                    var pDiscount = $(addProduct).attr(attrProductDiscount);
                    var pIsEatWith = $(addProduct).attr(attrIsEatWith);
                    var pEatWith = $(addProduct).attr(attrEatWith);


                    // Check wheater the item is already added
                    //var productItem = elmProductSelected.children("option[rel=" + i + "]");


//                    var countProductItem = elmProductSelected.children().length;
                    //var newIndex = countProductItem + 1;


                    var newIndex = idGen.getId();
                    console.log(newIndex);
                    //console.log(elmProductSelected.children().length);
                    /*if(productItem.length > 0){
                     // Item already added, update the quantity and total
                     var curPValue =  productItem.attr("value");
                     var valueArray = curPValue.split('|');
                     var prdId = valueArray[0];
                     var prdQty = valueArray[1];
                     prdQty = (prdQty-0) +  (qty-0);
                     var newPValue =  prdId + '|' + prdQty + '|';
                     productItem.attr("value",newPValue).attr('selected', true);
                     if(pDiscount > 0){
                     var prdTotal = getMoneyFormatted(pPrice * prdQty * pDiscount);
                     }else{
                     var prdTotal = getMoneyFormatted(pPrice * prdQty);
                     }

                     // Now go for updating the design
                     var lalQuantity =  $('#lblQuantity'+i).val(prdQty);
                     var lblTotal =  $('#lblTotal'+i).html(prdTotal);
                     // show product quantity updated message
                     showHighlightMessage(messageQuantityUpdated);
                     }else{*/
                    // This is a new item so create the list
                    var prodStr = pId + '|' + qty + '|' + '|' + i+'|' + '|'+ pEatWith; // 0 Id, 1 số lượng ,2 ghi chú, 3 id in cart, 4 giảm giá, 5 EatWith
                    var productItem = $('<option></option>').attr("rel",newIndex).attr("value",prodStr).attr('selected', true).html(pName);
                    elmProductSelected.append(productItem);
                    addCartItemDisplay(addProduct,qty,newIndex);
                    // show product added message
                    showHighlightMessage(messageItemAdded);
                    /*}*/
                    // refresh the cart
                    refreshCartValues();
                    // calling onAdded event; not expecting a return value
                    if($.isFunction(options.onAdded)) {
                        options.onAdded.call(this,$(addProduct),qty);
                    }
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


            function addCartItemDisplay(objProd,Quantity,newIndex){
                //console.log(objProd);
                var pId = $(objProd).attr(attrProductId);
                //var pIndex = products.index(objProd);
                console.log(newIndex);
                var pIndex = newIndex;
                var pName = $(objProd).attr(attrProductName);
                var pPrice = $(objProd).attr(attrProductPrice);
                var pDiscount = $(objProd).attr(attrProductDiscount);
                var prodImgSrc = $(objProd).attr(attrProductImage);
                var prodEatWith = $(objProd).attr(attrEatWith);

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
                var elmCPContent = $('<div></div>').html(phtml).attr("title",pTitle);

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
                console.log(idx);
                console.log(elmProductSelected);
//                console.log(productItem);
//                var pValue = $(productItem).attr("value");
//                var valueArray = pValue.split('|');
//                var pCurI = valueArray[3];
//
//                var pObj = products.eq(pCurI);
                //var pObj = products.eq(idx);

                //var pName = $(pObj).attr(attrProductName);
                //var removeMsg = messageConfirmRemove.replace('_PRODUCTNAME_',pName); // display default
                //Bỏ vòng if để bỏ qua confirm khi xóa
                //if(confirm(removeMsg)){
//                if($.isFunction(options.onRemove)) {
//                    // calling onRemove event; expecting a return value
//                    // will start remove if returned true and cancel remove if returned false
//                    if(!options.onRemove.call(this,$(pObj))){
//                        return false;
//                    }
//                }


//                            var productItem = elmProductSelected.children("option[rel=" + idx + "]");
//                            var pValue = $(productItem).attr("value");
//                            var valueArray = pValue.split('|');
//                            var pQty = valueArray[1];
//                            var pCurI = valueArray[3];
                //console.log(pCurI);
                $('#eatWith'+idx).remove();
                productItem.remove();

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

                $.each(listItem, function( key, value ){
                    if(jQuery.inArray(value.Item_Id, arrEatWith) != -1) {
                        if(jQuery.inArray(value.Item_Id, arrSelected) != -1) {
                            var checkedItem = 'checked';
                        }else{
                            checkedItem = '';
                        }
                        $('<div class="funkyradio-primary">' +
                            '<input type="checkbox" name="eatWith" id="'+value.Item_Id+'"  value="'+value.Item_Id+'_*_'+ value.Ta_Price+'_*_' +value.Item_Name+'" '+checkedItem+'/>' +
                            '<label for="'+value.Item_Id+'">'+ value.Item_Name +'</label>' +
                        '</div>').appendTo(checkboxEatWith);
                    }
                });

                var btnEatWith = $('<input type="button" value="'+ labelAddEatWith +'" >').addClass("col-md-offset-9 col-md-3 col-sm-6  col-xs-8  btn btn-success ");

                checkboxEatWith.append(btnEatWith);

                $(btnEatWith).bind("click", function(e){
                    var slEatWith = '';
                    $('input[name="eatWith"]:checked').each(function() {
                            if(slEatWith == ''){
                                slEatWith = this.value;
                            }else{
                                slEatWith = slEatWith +','+ this.value;
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
                var sumEatWith = fnSumEatWith(csledEatWith,qty,cdisCount,idx);


                var pObj = products.eq(curI);
                var pPrice = $(pObj).attr(attrProductPrice);
                var pDiscount = $(pObj).attr(attrProductDiscount);

                if($.isFunction(options.onUpdate)) {
                    // calling onUpdate event; expecting a return value
                    // will start Update if returned true and cancel Update if returned false
                    if(!options.onUpdate.call(this,$(pObj),qty)){
                        $('#lblQuantity'+idx).val(curQty);
                        return false;
                    }
                }


                var newPValue =  prdId + '|' + qty + '|' + curNote + '|' + curI+ '|' + cdisCount + '|' + cEatWith+ '|' + csledEatWith;
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

                var productItem = elmProductSelected.children("option[rel=" + idx + "]");
                var pValue = $(productItem).attr("value");
                var valueArray = pValue.split('|');
                var prdId = valueArray[0];
                var curQty = valueArray[1];
                var curNote = valueArray[2];
                var curI = valueArray[3];
                var cdisCount = valueArray[4];
                var cEatWith = valueArray[5];
                var pObj = products.eq(curI);
                var pPrice = $(pObj).attr(attrProductPrice);
                var pDiscount = $(pObj).attr(attrProductDiscount);

                var sumEatWith = fnSumEatWith(sledEatWith,curQty,cdisCount,idx);
                var newPValue =  prdId + '|' + curQty + '|' + curNote + '|' + curI+ '|' + cdisCount + '|' + cEatWith + '|' + sledEatWith ;

                $(productItem).attr("value",newPValue).attr('selected', true);
                var prdTotal = getMoneyFormatted((pPrice * curQty) - (pPrice*curQty*(cdisCount/100)) + sumEatWith);

                //console.log(valueArray);
                // Now go for updating the design
                var lblTotal =  $('#lblTotal'+idx).html(prdTotal);

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
                    var eatWithContent = $('<div></div>').addClass("col-md-11 col-md-ofset-1");
                    $.each(arrEatWith, function( key, value ){
                        var arrOneEatWith = value.split('_*_'); // 0 La Id, 1 la gia, 2 la ten mon
                        var eatWithPrice = arrOneEatWith[1];
                        sumEatWith =  sumEatWith +  ((eatWithPrice * curQty)  - (eatWithPrice*curQty*(cdisCount/100))) ;

                        var eatWithElment = $('<div></div>');
                        var ewPrice = $('<div>'+arrOneEatWith[1]+'</div>').addClass("col-md-3");
                        var ewName = $('<div> + '+arrOneEatWith[2]+'</div>').addClass("col-md-5");
                        eatWithElment.append(ewName).append(ewPrice);
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
                        var arrOneEatWith = value.split('_*_'); // 0 La Id, 1 la gia, 2 la ten mon
                        var eatWithPrice = arrOneEatWith[1];
                        sumEatWith =  sumEatWith +  ((eatWithPrice * curQty)  - (eatWithPrice*curQty*(cdisCount/100))) ;
                    });
                }
//                console.log(sumEatWith);
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
                //var sumEatWith = fnSumEatWith(csledEatWith,curQty,discount,idx);

                var pObj = products.eq(curI);
                var pPrice = $(pObj).attr(attrProductPrice);


                if($.isFunction(options.onUpdate)) {
                    // calling onUpdate event; expecting a return value
                    // will start Update if returned true and cancel Update if returned false
                    if(!options.onUpdate.call(this,$(pObj),note)){
                        $('#lblNote'+idx).val(curNote);
                        return false;
                    }
                }

                var newPValue =  prdId + '|' + curQty + '|' + note + '|' + curI+ '|' + cdisCount+ '|' + cEatWith+ '|' + csledEatWith;
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
                var sumEatWith = fnSumEatWith(csledEatWith,curQty,discount,idx);

                var pObj = products.eq(curI);
                var pPrice = $(pObj).attr(attrProductPrice);


                if($.isFunction(options.onUpdate)) {
                    // calling onUpdate event; expecting a return value
                    // will start Update if returned true and cancel Update if returned false
                    if(!options.onUpdate.call(this,$(pObj),discount)){
                        $('#lblDiscount'+idx).val(curDiscount);
                        return false;
                    }
                }

                var newPValue =  prdId + '|' + curQty + '|' + curNote + '|' + curI+ '|' + discount+ '|' + cEatWith + '|' + csledEatWith;
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
                    //console.log(pEatWithSelected);

                    var sumEatWith = fnOnlySumEatWith(pEatWithSelected,pQty,pDiscount,pI);

                    //var pObj = products.eq(pIdx);
                    var pObj = products.eq(pI);

                    var pPrice =  $(pObj).attr(attrProductPrice);
                    if(!pDiscount){
                        pDiscount =  $(pObj).attr(attrProductDiscount);
                    }

                    sTotal = sTotal + (((pPrice - 0) * (pQty - 0)) - ((pPrice - 0) * (pQty - 0) * (pDiscount/100))) + sumEatWith;

                    cProductCount++;
                    cItemCount = cItemCount + (pQty-0);
                });
                subTotal = sTotal;
                cartProductCount = cProductCount;
                cartItemCount = cItemCount;
                elmBottomSubtotalValue.html(getMoneyFormatted(subTotal));


                cartMenu = labelCartMenuName.replace('_COUNT_',cartProductCount);
                cartMenuTooltip = labelCartMenuNameTooltip.replace('_PRODUCTCOUNT_',cartProductCount).replace('_ITEMCOUNT_',cartItemCount);
                btShowCart.html(cartMenu).attr("title",cartMenuTooltip);

                // Get shipValue;

//                var url = "<?//= \yii\helpers\Url::to(['/ajaxapi'])?>//" + "&pos_id=" + "<?//= $posId?>//" + "&amount=" + subTotal + "&address=" + "<?///*= $address*/?>//";
//
//                $.ajax({
//                    url : url,
//                    dataType:"jsonp",
//                    jsonp:"mycallback",
//                    success:function(data)
//                    {
//                        var shipValue =  data.feeValue;
//                        var distanceValue =  data.distanceValue;
//                        elmBottomFeeValue.html(shipValue);
//                        elmBottomFeeDisValue.html(distanceValue);
//                        if(shipValue > 0){
//                            elmBottomPaymentValue.html(getMoneyFormatted(subTotal + shipValue));
//                        }else{
//                            elmBottomPaymentValue.html(getMoneyFormatted(subTotal));
//                        }
//
//                    }
//                });

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
                    addCartItemDisplay(objProd[0],prdQty);
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
                                addToCart(idx,qty);
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

                        var elmProds = $('<div"></div>').addClass(" col-md-3 col-lg-3 btn btn-default");

                        elmProds/*.append(elmProdDiv1).append(elmProdDiv2)*/.append(elmProdDiv3);
                        elmPLProducts.append(elmProds);
                    }
                });

                if(productCount <= 0){
                    showMessage(messageProductEmpty,elmPLProducts);
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
    productItemTemplate:'<div><div class="prductName col-md-12 no-padding"><%=pname%><br/><%=pprice%></div></div>',
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
//            echo '<pre>';
//            var_dump($pos);
//            echo '</pre>';
//            die();
            if(!$pos->Is_Eat_With){
                $mDiscount = @$pos->Discount_Ta_Price * 100;
                if(!isset($pos->Item_Image_Path_Thumb)){
                    $pos->Item_Image_Path_Thumb = 'http://image.foodbook.vn/images/fb/items/item-default.png';
                }
                $itemName = mb_strimwidth(@$pos->Item_Name,0,20,'...','utf-8');
                echo '<input type="hidden" pimage="'.$pos->Item_Image_Path_Thumb.'" pprice="'.$pos->Ta_Price.'" pdiscount="'.$mDiscount.'" piseatwith="'.@$pos->Is_Eat_With.'" peatwith="'.@$pos->Item_Id_Eat_With.'"  pname="'.$itemName.'" pcategory="'.$pos->Item_Type_Id.'" pdesc="'.@$pos->Description.'"  pid="'.$pos->Id.'">';
            }
        }
    }
    ?>
</div>

<?php
Modal::begin([
    'header' => '<h4>Chọn thời gian giao sau</h4>',
    'footer' => '<input id= "btn_creatoder" type="submit" value="Tạo đơn" class="btn btn-success">',
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
    'header' => '<h4>Chọn món ăn kèm</h4>',
//    'footer' => '<input id= "btn_seteatwith" type="submit" value="Chọn" class="btn btn-success">',
    'footer' => '',
    'id' => 'modalIdEatWith',
]);
echo '<div id="modalContentEatWith">';?>
<?php echo '</div>';
Modal::end();
?>


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
</script>
<script>


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

    //    function autosaveCookie(){
    //        var form = $("#shortForm");
    //        var formData = form.serialize();
    //        var txtPhone = $('#textPhone');
    //        //var keyDataCookie = txtPhone;
    //        if(txtPhone.val() !== 'undefined'){
    //            console.log(txtPhone.val());
    //            checkCookie(txtPhone.val(),JSON.stringify(formData));
    //        }
    //    }
    //
    //    autosaveCookie(); // This will run on page load
    //    setInterval(function(){
    //        autosaveCookie() // this will run after every 5 seconds
    //    }, 5000);

</script>


<style>

    .funkyradio div {
        clear: both;
        overflow: hidden;
    }

    .funkyradio label {
        width: 100%;
        border-radius: 3px;
        border: 1px solid #D1D3D4;
        font-weight: normal;
    }

    .funkyradio input[type="radio"]:empty,
    .funkyradio input[type="checkbox"]:empty {
        display: none;
    }

    .funkyradio input[type="radio"]:empty ~ label,
    .funkyradio input[type="checkbox"]:empty ~ label {
        position: relative;
        line-height: 2.5em;
        text-indent: 3.25em;
        margin-top: 2em;
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    .funkyradio input[type="radio"]:empty ~ label:before,
    .funkyradio input[type="checkbox"]:empty ~ label:before {
        position: absolute;
        display: block;
        top: 0;
        bottom: 0;
        left: 0;
        content: '';
        width: 2.5em;
        background: #D1D3D4;
        border-radius: 3px 0 0 3px;
    }

    .funkyradio input[type="radio"]:hover:not(:checked) ~ label,
    .funkyradio input[type="checkbox"]:hover:not(:checked) ~ label {
        color: #888;
    }

    .funkyradio input[type="radio"]:hover:not(:checked) ~ label:before,
    .funkyradio input[type="checkbox"]:hover:not(:checked) ~ label:before {
        content: '\2714';
        text-indent: .9em;
        color: #C2C2C2;
    }

    .funkyradio input[type="radio"]:checked ~ label,
    .funkyradio input[type="checkbox"]:checked ~ label {
        color: #777;
    }

    .funkyradio input[type="radio"]:checked ~ label:before,
    .funkyradio input[type="checkbox"]:checked ~ label:before {
        content: '\2714';
        text-indent: .9em;
        color: #333;
        background-color: #ccc;
    }

    .funkyradio input[type="radio"]:focus ~ label:before,
    .funkyradio input[type="checkbox"]:focus ~ label:before {
        box-shadow: 0 0 0 3px #999;
    }

    .funkyradio-default input[type="radio"]:checked ~ label:before,
    .funkyradio-default input[type="checkbox"]:checked ~ label:before {
        color: #333;
        background-color: #ccc;
    }

    .funkyradio-primary input[type="radio"]:checked ~ label:before,
    .funkyradio-primary input[type="checkbox"]:checked ~ label:before {
        color: #fff;
        background-color: #337ab7;
    }

    .funkyradio-success input[type="radio"]:checked ~ label:before,
    .funkyradio-success input[type="checkbox"]:checked ~ label:before {
        color: #fff;
        background-color: #5cb85c;
    }

    .funkyradio-danger input[type="radio"]:checked ~ label:before,
    .funkyradio-danger input[type="checkbox"]:checked ~ label:before {
        color: #fff;
        background-color: #d9534f;
    }

    .funkyradio-warning input[type="radio"]:checked ~ label:before,
    .funkyradio-warning input[type="checkbox"]:checked ~ label:before {
        color: #fff;
        background-color: #f0ad4e;
    }

    .funkyradio-info input[type="radio"]:checked ~ label:before,
    .funkyradio-info input[type="checkbox"]:checked ~ label:before {
        color: #fff;
        background-color: #5bc0de;
    }

</style>