<?php
$statusArray = [
    'WAIT_CONFIRM'=>'CHỜ XÁC NHẬN',
    'ASSIGNING'=>'TÌM XẾ',
    'ACCEPTED'=>'XẾ ĐÃ NHẬN',
    'CONFIRMED'=>'N-HÀNG ĐÃ NHẬN',
    'IN PROCESS'=>'ĐANG GIAO HÀNG',
    'COMPLETED'=>'HOÀN THÀNH',
    'CANCELLED'=>'ĐÃ HỦY',
    'FAILED'=>'XẾ ĐÃ HỦY',
];

$purposeMap = [
    '1' => 'Sinh Nhật',
    '2' => 'Ăn vặt',
    '3' => 'Biếu tặng'
];

$daysOfWeek = [
    2 =>'Thứ 2',
    3 =>'Thứ 3',
    4 =>'Thứ 4',
    5 =>'Thứ 5',
    6 =>'Thứ 6',
    7 =>'Thứ 7',
    8 =>'Chủ nhật',
];

$specialType = [
    '0' =>'Món thường',
    '1' =>'Món Combo'
];

$country_codes = array(
    'sq_AL' => "Albania" ,
    'ar_DZ' => "Algeria" ,
    'ar_BH' => "Bahrain" ,
    'ar_EG' => "Egypt" ,
    'ar_IQ' => "Iraq" ,
    'ar_JO' => "Jordan" ,
    'ar_KW' => "Kuwait" ,
    'ar_LB' => "Lebanon" ,
    'ar_LY' => "Libya" ,
    'ar_MA' => "Morocco" ,
    'ar_OM' => "Oman" ,
    'ar_QA' => "Qatar" ,
    'ar_SA' => "Saudi Arabia" ,
    'ar_SD' => "Sudan" ,
    'ar_SY' => "Syria" ,
    'ar_TN' => "Tunisia" ,
    'ar_AE' => "United Arab Emirates",
    'ar_YE' => "Yemen",
    'be_BY' => "Belarus",
    'bg_BG' => "Bulgaria",
    'ca_ES' => "Spain",
    'zh_CN' => "China",
    'zh_SG' => "Singapore",
    'zh_HK' => "Hong Kong",
    'zh_TW' => "Taiwan",
    'cs_CZ' => "Czech Republic",
    'da_DK' => "Denmark",
    'nl_BE' => "Belgium",
    'nl_NL' => "Netherlands",
    'en_AU' => "Australia",
    'en_CA' => "Canada",
    'en_IN' => "India",
    'en_IE' => "Ireland",
    'en_MT' => "Malta",
    'en_NZ' => "New Zealand",
    'en_PH' => "Philippines",
    'en_SG' => "Singapore",
    'en_ZA' => "South Africa",
    'en_GB' => "United Kingdom",
    'en_US' => "United States",
    'et_EE' => "Estonia",
    'fi_FI' => "Finland",
    'fr_BE' => "Belgium",
    'fr_CA' => "Canada",
    'fr_FR' => "France",
    'fr_LU' => "Luxembourg",
    'fr_CH' => "Switzerland",
    'de_AT' => "Austria",
    'de_DE' => "Germany",
    'de_LU' => "Luxembourg",
    'de_CH' => "Switzerland",
    'el_CY' => "Cyprus",
    'el_GR' => "Greece",
    'iw_IL' => "Israel",
    'hi_IN' => "India",
    'hu_HU' => "Hungary",
    'is_IS' => "Iceland",
    'in_ID' => "Indonesia",
    'ga_IE' => "Ireland",
    'it_IT' => "Italy",
    'it_CH' => "Switzerland",
    'ja_JP' => "Japan",
    'ja_JP_JP' => "Japan-JP",
    'ko_KR' => "South Korea",
    'lv_LV' => "Latvia",
    'lt_LT' => "Lithuania",
    'mk_MK' => "Macedonia",
    'ms_MY' => "Malaysia",
    'mt_MT' => "Malta",
    'no_NO' => "Norway",
    'no_NO_NY' => "Norway NY",
    'pl_PL' => "Poland",
    'pt_BR' => "Brazil",
    'pt_PT' => "Portugal",
    'ro_RO' => "Romania",
    'ru_RU' => "Russia",
    'sr_BA' => "Bosnia and Herzegovina",
    'sr_ME' => "Montenegro",
    'sr_RS' => "Serbia",
    'sr_Latn_BA' => "Bosnia and Herzegovina",
    'sr_Latn_ME' => "Montenegro",
    'sr_Latn_RS' => "Serbia",
    'sk_SK' => "Slovakia",
    'sl_SI' => "Slovenia",
    'es_AR' => "Argentina",
    'es_BO' => "Bolivia",
    'es_CL' => "Chile",
    'es_CO' => "Colombia",
    'es_CR' => "Costa Rica",
    'es_DO' => "Dominican Republic",
    'es_EC' => "Ecuador",
    'es_SV' => "El Salvador",
    'es_GT' => "Guatemala",
    'es_HN' => "Honduras",
    'es_MX' => "Mexico",
    'es_NI' => "Nicaragua",
    'es_PA' => "Panama",
    'es_PY' => "Paraguay",
    'es_PE' => "Peru",
    'es_PR' => "Puerto Rico",
    'es_ES' => "Spain",
    'es_US' => "United States",
    'es_UY' => "Uruguay",
    'es_VE' => "Venezuela",
    'sv_SE' => "Sweden",
    'th_TH' => "Thailand",
    'tr_TR' => "Turkey",
    'uk_UA' => "Ukraine",
    'vi_VN' => "Vietnam",
);

$campainType = [
    1 => 'Sms',
    2 => 'Người dùng đăng kí App',
    3 => 'Voucher checkin',
    4 => 'Voucher booking',
    5 => 'Xuất mã hàng loạt',
    6 => 'Quay trúng thưởng',
//    7 => 'Quà tặng IPCC',
    7 => 'Tặng 1 Voucher cho 1 thành viên',
    8 => 'Chiến dịch CSKH',
    9 => 'Một mã sử dụng nhiều lần',
    10 => 'Đăng kí thành viên',
    11 => 'Zalo - Tặng hằng ngày',
    12 => 'Đổi điểm'
];

$campainTypeSelectCreat = [
//    7 => 'Quà tặng IPCC',
    7 => 'Tặng 1 Voucher cho 1 thành viên',
    8 => 'Chiến dịch CSKH',
    5 => 'Xuất mã hàng loạt',
    9 => 'Một mã sử dụng nhiều lần',
    10 => 'Đăng kí thành viên',
//    11 => 'Zalo - Tặng hàng ngày',
    2 => 'Người dùng đăng kí App',
];



$discountType = [
    1 => 'Loại gửi Voucher CSKH',
    2 => 'Loại gửi tin nhắn CSKH'
];
$genderMap = [
    -1 => 'Không xác định',
    0 => 'Nữ',
    1 => 'Nam'
];



$maxAmount = 999999999999;

$groupMember = [
    '10' => 'Công ty',
    '1' => 'Nhà riêng',
    '2' => 'Trường học',
    '3' => 'Cửa hàng',
    '4' => 'Khách sạn',
    '5' => 'Khách du lịch',
    '6' => 'Ngân hàng',
    '7' => 'Doanh nghiệp',
    '8' => 'Bệnh Viện',
];

$genderParam = [
    'Male' => 'Nam',
    'Female' => 'Nữ',
    'Unknown' => 'Không xác định',
];

$voucherLogStatus = [
    '1' => 'Không tồn tại',
    '2' => 'Đã sử dụng',
    '3' => 'Hết hạn',
    '4' => 'Chưa sử dụng',
];



$configZaloFunction = [
    'func_booking_online' => 'Đặt bàn',
    'message_booking_online' => 'Tin nhắn đặt bàn',

    'func_order_online' => 'Đặt giao hàng',
    'message_order_online' => 'Tin nhắn đặt hàng',
    'message_status_wait_confirm' => 'Tin nhắn chờ xác nhận',
    'message_status_confirm' => 'Tin nhắn đơn hàng xác nhận',
    'message_status_shipping' => 'Tin nhắn đơn hàng đang vận chuyển',
    'message_status_ship_with_delivery_partner' => 'Tin nhắn vận chuyển với đối tác vận chuyển',

    'func_register' => 'Đăng kí thành viên',
    'message_requied_register' => 'Tin nhắn yêu cầu đăng kí',
    'message_register_success' => 'Tin nhắn đăng kí thành công',
    'message_send_voucher_register' => 'Tin nhắn gửi voucher đăng kí',
    'message_limit_register_voucher_by_day' => 'Tin nhắn giới hạn đăng ký trong ngày',

    'func_order_offline' => 'Đặt món tại nhà hàng',
    'message_get_menu' => 'Tin nhắn lấy thực đơn',
    'message_token_order' => 'Tin nhắn lấy mã đặt món',

    'func_get_voucher' => 'Lấy Voucher',
    'message_no_campaign' => 'Tin nhắn không có mã giảm giá',
    'message_limit_daily_voucher' => 'Tin nhắn hết voucher',
    'message_already_receiver_voucher' => 'Tin nhắn nhận voucher',
    'message_voucher_log' => 'Thông tin voucher',
    'message_miss_daily_voucher' => 'Tin nhắn bỏ lỡ voucher',


    'func_membership_point' => 'Điểm thành viên',
    'message_no_policy' => 'Tin nhắn không có chính sách',
    'message_member_no_point' => 'Tin nhắn thành viên chưa có điểm',
    'message_member_has_point' => 'Tin nhắn thành viên có điểm',

    'func_get_pos' => 'Xem nhà hàng gần bạn',
    'message_get_pos' => 'Tin nhắn xem cửa hàng gần bạn',
    'message_no_pos_nearby' => 'Tin nhắn không có cửa hàng gần bạn',


    'func_order_history' => 'Lịch sử đơn hàng',
    'message_order_history' => 'Tin nhắn lịch sử đơn hàng',

    'func_get_avairable_voucher' => 'Lấy voucher khả dụng',
    'message_get_avairable_vouchers' => 'Tin nhắn voucher khả dụng',

    'func_checkin' => 'Checkin',
    'message_checkin' => 'Tin nhắn checkin',


    'func_rate' => 'Đánh giá đơn hàng',
    'message_requied_rate' => 'Tin nhắn yêu cầu đánh giá',
    'message_rate_success' => 'Tin nhắn đánh giá thành công',
    'message_requied_rate_order_online' => 'Tin nhắn yêu cầu đánh giá đặt hàng online',
    'message_requied_rate_order_offline' => 'Tin nhắn yêu cầu đánh giá đặt hàng tại cửa hàng',


];

return [
    'adminEmail' => 'tam.nguyen@foodbook.vn',

    //'CMS_API_CMS_PATH' => 'http://119.17.212.89:3332/ipos/ws/cms/sendmt';

    'statusArray' => $statusArray,
    'maxAmount' => 1000000000000,
    'maxEat' => 99999,
    'maxPoint' => 1000000000000,
    'daysOfWeek' => $daysOfWeek,
    'country_codes' => $country_codes,
    'campainType' => $campainType,
    'campainTypeSelectCreat' => $campainTypeSelectCreat,
    'purposeMap' => $purposeMap,
    'groupMember' => $groupMember,
    'genderParam' => $genderParam,
    'discountType' => $discountType,
    'genderMap' => $genderMap,
    'VOUCHER_LOG_STATUS' => $voucherLogStatus,
    'CONFIG_ZALO_FUNTION' => $configZaloFunction,

    'SPECIAL_TYPE' => $specialType,



    //Key Memcache
    'KEY_ALL_POS_MAP' => 'KEY_ALL_POS_MAP',
    'KEY_POS_MAP_ACTIVE' => 'KEY_POS_MAP_ACTIVE',
    'KEY_ALL_CITY' => 'KEY_ALL_CITY',
    'KEY_ALL_POS_MAP_NAME_NAME' => 'KEY_ALL_POS_MAP_NAME_NAME',
    'KEY_ALL_POSPARENT_MAP' => 'KEY_ALL_POSPARENT_MAP',
    'KEY_ALL_POSMASTER_MAP' => 'KEY_ALL_POSMASTER_MAP',


    'WAIT_CONFIRM'=>'WAIT_CONFIRM',
    'ASSIGNING'=>'ASSIGNING',
    'ACCEPTED'=>'ACCEPTED',
    'CONFIRMED'=>'CONFIRMED',
    'IN PROCESS'=>'IN PROCESS',
    'COMPLETED'=>'COMPLETED',
    'CANCELLED'=>'CANCELLED',
    'FAILED'=>'FAILED',
    'DATE_FORMAT' => 'd-m-Y',
    'DATE_TIME_FORMAT' => 'H:i:s d-m-Y',
    'DATE_TIME_FORMAT_2' => 'd-m-Y H:i:s',
    'DATE_TIME_FORMAT_3' => 'Y-m-d H:i:s'
];
