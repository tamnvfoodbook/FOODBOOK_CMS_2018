/**
 * Created by Tamnv on 7/27/2016.
 */


function startBasicDataTable(div_id){
    $(div_id).DataTable({
        "language": {
            "lengthMenu": "Hiển thị _MENU_ kết quả",
            "zeroRecords": "Không có kết quả",
            "info": "Trang _PAGE_ trong tổng số  _PAGES_ trang",
            "infoEmpty": "Không có kết quả",
            "infoFiltered": "(lọc từ _MAX_ tổng số bản ghi)",
            "sSearch": "Tìm kiếm",
            "oPaginate": {
                "sFirst": "Trang đầu",
                "sLast": "Trang cuối",
                "sNext": "Trang tiếp",
                "sPrevious": "Trang trước"
            }
        }
    });
}

/* Formatting function for row details - modify as you need */
function format ( d ) {
    var table = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
        '<tr><td></td>'+
        '<td><select class="form-control" id="DISCOUNT_TYPE'+d._id+'"><option value="1">Phiếu giảm giá</option><option value="2">Voucher giảm giá</option> </select></td>'+
        '<td>' +
        '<input type="text" value="10000" name="DISCOUNT" style="width:100px" class="form-control" id="DISCOUNT'+ d._id+'">' +
        '</td>'+
        '<td width="435px"><input type="text" maxlength="100" readonly="true" value="'+ d.pos_parent +' tang ban phieu giam gia " name="VOUCHER_DESCRIPTION" style="width:430px" class="form-control" id="VOUCHER_DESCRIPTION'+ d._id+'"></td>'+
        '<td><input type="button" class="btn btn-primary" value="Tặng quà" id="btn_'+ d._id +'" onclick=setGift("'+ d._id +'","'+d.member_id+'") ></td>'+
        '</tr>'+
        '<tr><td colspan="4"><div class="help-block" id="help_info'+ d._id+'" ></div></td>'+
        '</tr>'+
        '</table>';

    // `d` is the original data object for the row
    return table;
}


function validate_copoun ( d ) {
    $("#DISCOUNT_TYPE"+ d._id).on("change", function() {
        $("#help_info"+ d._id).html("");
        var a = $("#DISCOUNT_TYPE"+ d._id+" option:selected").val();
        var iput_discount =  $("#DISCOUNT"+ d._id);

        var VOUCHER_DESCRIPTION =  $("#VOUCHER_DESCRIPTION"+ d._id);
        if(a ==2){
            iput_discount.val(10);
            VOUCHER_DESCRIPTION.val("" + d.pos_parent+ " tặng Voucher giảm giá " + iput_discount.val()+ "%");
            iput_discount.keyup(function() {
                this.value = this.value.replace(/[^0-9\.]/g,'');
                if ((iput_discount.val() < 0 || iput_discount.val() > 100)) {
                    $("#help_info"+ d._id).html("Voucher giảm giá không vượt quá 100%");
                    $("#help_info"+d._id).addClass('warning_text');
                }else{
                    $("#help_info"+ d._id).html("");
                }

                if(!this.value){
                    $("#help_info"+ d._id).html("Không được để trống trường này");
                    $("#help_info"+d._id).addClass('warning_text');
                }
                VOUCHER_DESCRIPTION.val("" + d.pos_parent+ " tặng Voucher giảm giá " + iput_discount.val()+ "%");
            });
        }else{

            var default_discount = 10000;
            iput_discount.val(default_discount);
            VOUCHER_DESCRIPTION.val("" + d.pos_parent+ " tặng phiếu giảm giá " + iput_discount.val()+ "đ");
            iput_discount.keyup(function() {
                this.value = this.value.replace(/[^0-9\.]/g,'');
                if ((iput_discount.val() < 1000 || iput_discount.val() > 1000000)) {
                    $("#help_info"+ d._id).html("Voucher giảm giá từ 1.000đ đến 1.000.000 đ");
                    $("#help_info"+d._id).addClass('warning_text');

                }else{
                    $("#help_info"+ d._id).html("");
                }

                if(!this.value){
                    $("#help_info"+ d._id).html("Không được để trống trường này");
                    $("#help_info"+d._id).addClass('warning_text');
                }
                VOUCHER_DESCRIPTION.val("" + d.pos_parent+ " tặng phiếu giảm giá " + iput_discount.val()+ "đ");
            });
        }
    }).trigger("change");

    // `d` is the original data object for the row
    return true;
}



function setGift(order_id,member_id){
    var url = 'index.php?r=/ajaxapi/setgift';
    var input = document.getElementById('DISCOUNT'+ order_id);
    var select_campain_type = $("#DISCOUNT_TYPE"+order_id+" option:selected").val();

    if (!input.value) {
        input.focus();
        return false;
    }

    if(select_campain_type ==2){
        if ((input.value < 0 || input.value > 100)) {
            input.focus();
            return false;
        }
    }else{
        if ((input.value < 1000 || input.value > 1000000)) {
            input.focus();
            return false;
        }
    }

    if (confirm("Bạn có chắc chắn muốn tặng vourcher ?") == true) {
        $.ajax({
            type: "POST",
            url: url,
            data: {
                campain_desc: $("#VOUCHER_DESCRIPTION"+ order_id ).val(),
                campain_discount: $("#DISCOUNT"+order_id).val(),
                campain_discount_type: select_campain_type,
                member_id: member_id
            },

            beforeSend: function() {
                //that.$element is a variable that stores the element the plugin was called on
                //$("#btn_"+order_id).addClass("loading");
                $("#btn_"+order_id).button('loading');
            },
            complete: function() {
                //$("#modalButton").removeClass("loading");
                //$("#btn_"+order_id).removeClass("loading");
                $("#btn_"+order_id).button('reset');
            },
            success:function(result){
                $("#help_info"+order_id).removeClass("warning_text");
                $("#help_info"+order_id).addClass("text_success");
                $("#help_info"+order_id).html(result);
            }
        });
    } else {
        return false;
    }


}


function getMemberRating(member_id, pos_id,id)
{
    var url = 'index.php?r=/ajaxapi/getinfomember';

    $.ajax({
        type: "POST",
        url: url,
        data: {
            member_id: member_id,
            pos_id: pos_id
        },

        beforeSend: function() {
            //that.$element is a variable that stores the element the plugin was called on
            //$("#btn_"+order_id).addClass("loading");
            //$("#btn_"+order_id).button('loading');
        },
        complete: function() {
            //$("#modalButton").removeClass("loading");
            //$("#btn_"+order_id).removeClass("loading");
            //$("#btn_"+order_id).button('reset');
        },

        success:function(result){
            $("#div_info"+id).toggle('slow');
            $("#div_info"+id).html(result);

        }
    });
}

function getMemberBase(member_id, pos_id,id,name)
{
    var url = 'index.php?r=/ajaxapi/getinfomember';

    $.ajax({
        type: "POST",
        url: url,
        data: {
            member_id: member_id,
            pos_id: pos_id
        },

        beforeSend: function() {
            //that.$element is a variable that stores the element the plugin was called on
            //$("#btn_"+order_id).addClass("loading");
            //$("#btn_"+order_id).button('loading');
        },
        complete: function() {
            //$("#modalButton").removeClass("loading");
            //$("#btn_"+order_id).removeClass("loading");
            //$("#btn_"+order_id).button('reset');
        },

        success:function(result){
            $("#div_"+name+id).toggle('slow');
            $("#div_"+name+id).html(result);

        }
    });
}


function startDataTable(div_id,data){
    if(data != null){
        if(data.length >0){
            var table = $(div_id).DataTable( {
                "data" : data,
                "columns": [
                    {
                        "className":      'details-control',
                        "orderable":      false,
                        "data":           null,
                        "defaultContent": ''
                    },
                    { "data": "memberName" },
                    //{ "data": "member_id" },
                    {
                        //"title": "Order No.",
                        //"data": data,
                        "render": function (data, type, full, meta) {
                            return '<a href="#" OnClick="getMemberRating('+ full.member_id +','+ full.pos_id +',\''+ div_id.substr(1) + full._id + '\')" >' + full.member_id + '</a><div class ="info_member" id="div_info'+div_id.substr(1)+full._id+'"></div>';
                        }
                    },
                    { "data": "pos_name" },
                    { "data": "created_at" },
                    { "data": "reson_note"}

                ],
                "language": {
                    "lengthMenu": "Hiển thị _MENU_ kết quả",
                    "zeroRecords": "Không có kết quả",
                    "info": "Trang _PAGE_ trong tổng số  _PAGES_ trang",
                    "infoEmpty": "Không có kết quả",
                    "infoFiltered": "(lọc từ _MAX_ tổng số bản ghi)",
                    "sSearch": "Tìm kiếm",
                    "oPaginate": {
                        "sFirst": "Trang đầu",
                        "sLast": "Trang cuối",
                        "sNext": "Trang tiếp",
                        "sPrevious": "Trang trước"
                    }
                }
            } );


            // Add event listener for opening and closing details
            $(div_id+' tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row( tr );

                if ( row.child.isShown() ) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    // Open this row
                    row.child( format(row.data()) ).show();
                    row.child( validate_copoun(row.data()));
                    tr.addClass('shown');
                }
            } );
        }
    }
}

function dataTable_customer(div_id,data){
    if(data.length >0){

        var table = $(div_id).DataTable( {
            "data" : data,
            "columns": [
                {
                    "className":      'details-control',
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ''
                },
                { "data": "memberName" },
                {
                    "render": function (data, type, full, meta) {
                        //console.log(full);
                        return '<a href="#" OnClick="getMemberBase('+ full.member_id +','+ full.pos_id +',\'' + full.member_id + full.pos_id+'\',\'customer\')" >' + full.member_id + '</a><div class ="info_member" id="div_customer'+full.member_id+ full.pos_id +'"></div>';
                    }
                },
                { "data": "count"},
                { "data": "pos_name" },
                { "data": "type" }
            ],
            "language": {
                "lengthMenu": "Hiển thị _MENU_ kết quả",
                "zeroRecords": "Không có kết quả",
                "info": "Trang _PAGE_ trong tổng số  _PAGES_ trang",
                "infoEmpty": "Không có kết quả",
                "infoFiltered": "(lọc từ _MAX_ tổng số bản ghi)",
                "sSearch": "Tìm kiếm",
                "oPaginate": {
                    "sFirst": "Trang đầu",
                    "sLast": "Trang cuối",
                    "sNext": "Trang tiếp",
                    "sPrevious": "Trang trước"
                }
            }
        } );


        // Add event listener for opening and closing details
        $(div_id+' tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row( tr );

            if ( row.child.isShown() ) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            }
            else {
                // Open this row
                row.child( format(row.data()) ).show();
                row.child( validate_copoun(row.data()));
                tr.addClass('shown');
            }
        } );

    }
}
function dataTableCustomerBase(div_id,data,name){
    if(data != null){
        if(data.length >0){
            var table = $(div_id).DataTable( {
                "data" : data,
                "columns": [
                    {
                        "className":      'details-control',
                        "orderable":      false,
                        "data":           null,
                        "defaultContent": ''
                    },
                    { "data": "memberName" },
                    {
                        "render": function (data, type, full, meta) {
                            return '<a href="#" OnClick="getMemberBase('+ full.member_id +','+ full.pos_id +',\'' + full.member_id + '\',\'' + name + '\')" >' + full.member_id + '</a><div class ="info_member" id="div_'+name+full.member_id+'"></div>';
                        }
                    },
                    { "data": "pos_name"}
                ],
                "language": {
                    "lengthMenu": "Hiển thị _MENU_ kết quả",
                    "zeroRecords": "Không có kết quả",
                    "info": "Trang _PAGE_ trong tổng số  _PAGES_ trang",
                    "infoEmpty": "Không có kết quả",
                    "infoFiltered": "(lọc từ _MAX_ tổng số bản ghi)",
                    "sSearch": "Tìm kiếm",
                    "oPaginate": {
                        "sFirst": "Trang đầu",
                        "sLast": "Trang cuối",
                        "sNext": "Trang tiếp",
                        "sPrevious": "Trang trước"
                    }
                }
            } );


            // Add event listener for opening and closing details
            $(div_id+' tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row( tr );

                if ( row.child.isShown() ) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    // Open this row
                    row.child( format(row.data()) ).show();
                    row.child( validate_copoun(row.data()));
                    tr.addClass('shown');
                }
            } );

        }
    }
}
function dataTableCustomerComment(div_id,data,name){
    if(data != null){
        if(data.length >0){
            var table = $(div_id).DataTable( {
                "data" : data,
                "columns": [
                    {
                        "className":      'details-control',
                        "orderable":      false,
                        "data":           null,
                        "defaultContent": ''
                    },
                    { "data": "memberName" },
                    {
                        "render": function (data, type, full, meta) {
                            return '<a href="#" OnClick="getMemberBase('+ full.member_id +','+ full.pos_id +',\'' + full.member_id + '\',\'' + name + '\')" >' + full.member_id + '</a><div class ="info_member" id="div_'+name+full.member_id+'"></div>';
                        }
                    },
                    { "data": "pos_name"},
                    { "data": "reson_note"}
                ],
                "language": {
                    "lengthMenu": "Hiển thị _MENU_ kết quả",
                    "zeroRecords": "Không có kết quả",
                    "info": "Trang _PAGE_ trong tổng số  _PAGES_ trang",
                    "infoEmpty": "Không có kết quả",
                    "infoFiltered": "(lọc từ _MAX_ tổng số bản ghi)",
                    "sSearch": "Tìm kiếm",
                    "oPaginate": {
                        "sFirst": "Trang đầu",
                        "sLast": "Trang cuối",
                        "sNext": "Trang tiếp",
                        "sPrevious": "Trang trước"
                    }
                },
                "paging": false,
                "info":     false,
                "sDom": 'lfrtip'
            } );

            // Add event listener for opening and closing details
            $(div_id+' tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row( tr );

                if ( row.child.isShown() ) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    // Open this row
                    row.child( format(row.data()) ).show();
                    row.child( validate_copoun(row.data()));
                    tr.addClass('shown');
                }
            } );

        }
    }
}


function dataTableCustomerComment(div_id,data,name){
    if(data != null){
        if(data.length >0){
            var table = $(div_id).DataTable( {
                "data" : data,
                "columns": [
                    {
                        "className":      'details-control',
                        "orderable":      false,
                        "data":           null,
                        "defaultContent": ''
                    },
                    { "data": "memberName" },
                    {
                        "render": function (data, type, full, meta) {
                            return '<a href="#" OnClick="getMemberBase('+ full.member_id +','+ full.pos_id +',\'' + full.member_id + '\',\'' + name + '\')" >' + full.member_id + '</a><div class ="info_member" id="div_'+name+full.member_id+'"></div>';
                        }
                    },
                    { "data": "pos_name"},
                    { "data": "reson_note"}
                ],
                "language": {
                    "lengthMenu": "Hiển thị _MENU_ kết quả",
                    "zeroRecords": "Không có kết quả",
                    "info": "Trang _PAGE_ trong tổng số  _PAGES_ trang",
                    "infoEmpty": "Không có kết quả",
                    "infoFiltered": "(lọc từ _MAX_ tổng số bản ghi)",
                    "sSearch": "Tìm kiếm",
                    "oPaginate": {
                        "sFirst": "Trang đầu",
                        "sLast": "Trang cuối",
                        "sNext": "Trang tiếp",
                        "sPrevious": "Trang trước"
                    }
                },
                "paging": false,
                "info":     false,
                "sDom": 'lfrtip'
            } );

            // Add event listener for opening and closing details
            $(div_id+' tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row( tr );

                if ( row.child.isShown() ) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    // Open this row
                    row.child( format(row.data()) ).show();
                    row.child( validate_copoun(row.data()));
                    tr.addClass('shown');
                }
            } );

        }
    }
}


function dataTableDeatailcampaign(div_id,data,name){
    if(data != null){
        if(data.length >0){
            var table = $(div_id).DataTable( {
                "data" : data,
                "columns": [
                    {
                        "className":      'details-control',
                        "orderable":      false,
                        "data":           null,
                        "defaultContent": ''
                    },
                    { "data": "voucher_code" },
                    {
                        "render": function (data, type, full, meta) {
                            return '<a href="#" OnClick="getMemberBase('+ full.used_member_info +','+ full.used_pos_id +',\'' + full.used_member_info + '\',\'' + name + '\')" >' + full.used_member_info + '</a><div class ="info_member" id="div_'+name+full.used_member_info+'"></div>';
                        }
                    },
                    { "data": "used_pos_id"},
                    //{ "data": "voucher_campaign_name"},
                    { "data": "used_date"},
                    { "data": "used_discount_amount"},
                    { "data": "used_bill_amount"}
                ],
                "language": {
                    "lengthMenu": "Hiển thị _MENU_ kết quả",
                    "zeroRecords": "Không có kết quả",
                    "info": "Trang _PAGE_ trong tổng số  _PAGES_ trang",
                    "infoEmpty": "Không có kết quả",
                    "infoFiltered": "(lọc từ _MAX_ tổng số bản ghi)",
                    "sSearch": "Tìm kiếm",
                    "oPaginate": {
                        "sFirst": "Trang đầu",
                        "sLast": "Trang cuối",
                        "sNext": "Trang tiếp",
                        "sPrevious": "Trang trước"
                    }
                },
                "autoWidth": false, // Trường này sẽ quyết định cột của bảng
                "paging": false,
                "info":     false,
                "sDom": 'lfrtip',
                "columnDefs" : [
                    { width: 50, targets: 0 }
                ]
            } );

            // Add event listener for opening and closing details
            $(div_id+' tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row( tr );

                if ( row.child.isShown() ) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    // Open this row
                    row.child( format(row.data()) ).show();
                    row.child( validate_copoun(row.data()));
                    tr.addClass('shown');
                }
            } );

        }
    }
}
