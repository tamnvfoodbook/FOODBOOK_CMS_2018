var $txtLenLeft = $('.help-sms-content'); // lets cache this
var maxLen = 160;
$('.sms-content').keypress(function(e){
    var Length = $(this).val().length;
    var AmountLeft = maxLen - Length;
    if(Length > 0 ){
        var numberMes = Math.floor(Length/maxLen) + 1;
        var lengMes = 'Độ dài tin nhắn ' + Length + ' kí tự  - ' + numberMes + ' tin nhắn';
        $txtLenLeft.show();
        $txtLenLeft.html(lengMes);

    }else{
        $txtLenLeft.hide();
    }
    /*if(Length >= maxLen && e.keyCode != 8){
        e.preventDefault(); // will cancel the default action of the event
    }*/
});
