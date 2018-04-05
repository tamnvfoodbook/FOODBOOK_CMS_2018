/**
 * Created by Administrator on 11/2/2015.
 */
// Script Popup Rating
$(function(){
    $('#modalButton').click(function(){
        $('#modal').modal('show')
            .find('#modalContent')
            .load($(this).attr('value'));
    });
});

// Script Popup Price Detail
$(function(){
    $('#buttonPriceDetail').click(function(){
        $('#modal2').modal('show')
            .find('#memberdetailContent')
            .load($(this).attr('value'));
    });
});

// Script Popup Price Detail
$(function(){
    $('#buttonOrderDetail').click(function(){
        $('#modal1').modal('show')
            .find('#orderdetailContent')
            .load($(this).attr('value'));
    });
});

// Script Popup shareFB Detail
$(function(){
    $('#buttonshareDetail').click(function(){
        $('#modal3').modal('show')
            .find('#sharefbdetailContent')
            .load($(this).attr('value'));
    });
});

// Script Popup shareFB Detail
$(function(){
    $('#buttonTopDetail').click(function(){
        $('#modaltop').modal('show')
            .find('#topContent')
            .load($(this).attr('value'));
    });
});

// Script Popup Least
$(function(){
    $('#buttonLeastDetail').click(function(){
        $('#modalleast').modal('show')
            .find('#leastContent')
            .load($(this).attr('value'));
    });
});

// Script Popup xem theo thời gian
$(function(){
    $('#buttonTimeDetail').click(function(){
        $('#modaltime').modal('show')
            .find('#timeContent')
            .load($(this).attr('value'));
    });
});


// Script Popup So sánh
$(function(){
    $('#buttonCompareDetail').click(function(){
        $('#modalcompare').modal('show')
            .find('#timeContent')
            .load($(this).attr('value'));
    });
});

// Script hiện lựa chọn Top
function popupTopFunction() {
    $('#topdiv').fadeIn('slow'); // Hien
    $('#bottomdiv').hide();
}

// Script hiện lựa chọn Bottom
function popupBottomFunction() {
    $('#bottomdiv').fadeIn('slow'); // Hien
    $('#topdiv').hide();
}