<?= \kartik\datetime\DateTimePicker::widget([
    'name' => 'bookingTimeLaterTxt',
    'id' => 'bookingTimeTxt1',
    'layout' => '{input}{remove}{picker}',

    //'value' => '23-Feb-1982 10:10',
    'pluginOptions' => [
        'pickerPosition' => 'bottom-left',
        'minuteStep' => 30,
        'autoclose'=>true,
        'format' => 'dd-mm-yyyy hh:ii',
    ]
]);?>
