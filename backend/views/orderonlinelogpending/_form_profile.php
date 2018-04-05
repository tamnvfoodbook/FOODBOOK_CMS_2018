<?php
use kartik\widgets\Select2;

    $groupMember = [
            '0' => 'Công ty',
            '1' => 'Nhà riêng',
            '2' => 'Trường học',
            '3' => 'Cửa hàng',
            '4' => 'Khách sạn',
            '5' => 'Khách du lịch',
            '6' => 'Ngân hàng',
            '7' => 'Doanh nghiệp',
            '8' => 'Bệnh Viện',
    ];

    echo '<label class="control-label">Nhóm khách hàng</label>';
    echo Select2::widget([
        'name' => 'group_member',
        'data' => $groupMember,
        'options' => [
            'placeholder' => 'Chọn nhóm ...',
//            'multiple' => true
        ],
    ]);

    echo '<br/>';
    echo '<label class="control-label">Giới tính</label>';
    echo Select2::widget([
        'name' => 'sex_member',
        'data' => [0 => 'Nữ',1 => 'Nam'],
        'options' => [
            'placeholder' => 'Chọn giới tính ...',
//            'multiple' => true
        ],
    ]);

    echo '<br/>';
    echo '<label class="control-label">Ngày sinh</label>';


?>

<?= \kartik\widgets\DatePicker::widget([
    'name' => 'birthday_member',
    'id' => 'bookingTimeTxt2',
    'layout' => '{input}{remove}{picker}',

    //'value' => '23-Feb-1982 10:10',
    'pluginOptions' => [
        'pickerPosition' => 'bottom-left',
        'autoclose'=>true,
        'format' => 'dd-mm-yyyy',
    ]
]);?>