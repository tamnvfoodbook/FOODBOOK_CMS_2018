<?php
/**
 * Template Name: Foodbook Custom
 *
 * A Fully Operational FOODBOOK Custom
 * @package WordPress
 */

get_header();

$parameter = $_SERVER['QUERY_STRING'];
//echo  $parameter;
//echo $_GET['ms'];
if(isset($_GET['ms'])){

//    echo $_GET['ms'];
    $apiName = 'partner/voucher_info';

    // $apiPath = Yii::$app->params['CMS_API_PATH_IPOS'];
    $apiPath = 'http://119.17.212.89:3332/ipos/ws/';

    $paramCommnet = array(
        'voucher_code' => $_GET['ms']
    );

    $data = ApiController::getApiByMethod($apiName,$apiPath,$paramCommnet,'POST');
    if(isset($data->data)){
        ?>
        <div style="margin: 0 auto; width: 500px">
        <div class="price_column  ">
        <ul>
        <li class="price_column_title">Chi tiết voucher <?= $data->data->voucher_code  ?></li>
        <?php
        if($data->data->pos_id == 0){
            echo '<li>Áp dụng cho toàn hệ thống '.$data->data->pos_parent .'</li>';
        }else{
            echo '<li>Áp dụng cho toàn hệ thống '.@$data->data->pos_name .'</li>';
        }
        ?>
        <?php
        //$dateStart = new DateTime(strtotime($data->data->date_start));
        $dateStart = new \DateTime($data->data->date_start);
        $dateEnd = new \DateTime($data->data->date_end);
        //echo $dateStart->format('d-m-Y');

        echo '<li>Áp dụng từ ngày: '. $dateStart->format('d-m-Y')  .' đến ngày: '. $dateEnd->format('d-m-Y').'</li>';

        if($data->data->is_all_item == 1){
            echo '<li>Áp dụng cho tất cả các món ăn.</li>';
        }else{
            echo '<li>Áp dụng cho các loại món sau: </li>';
            $tmp = 1;
            foreach($data->data->dm_item_types as $item){
                echo '<li>'.$tmp.' . '.$item->Item_Type_Name.'</li>';
                $tmp++;
            }
        }

    }
    ?>
    </ul>
    </div>
    </div>

    <?php

    // echo '<pre>';
    // var_dump($data);
    // echo '</pre>';

}

// Check Sidebar Layout
$sidebar_layout = boc_page_sidebar_layout();
$boc_content_top_margin = (get_post_meta($post->ID, 'boc_content_top_margin', true)!=='off'? true : false);
if($boc_content_top_margin){
    echo '<div class="h60"></div>';
}
?>

    <div class="contact_page_template container <?php echo (($sidebar_layout == 'left-sidebar') ? "has_left_sidebar" : (($sidebar_layout == 'right-sidebar') ? "has_right_sidebar" : "")); ?>">

        <div class="section">

            <?php
            // IF Sidebar Left
            if($sidebar_layout == 'left-sidebar'){
                get_sidebar();
            }

            if($sidebar_layout != 'full-width'){
                echo "<div class='post_content col span_3_of_4'>";
            }else {
                echo "<div class='post_content'>";
            }
            ?>

            <?php while (have_posts()) : the_post(); ?>
                <?php the_content() ?>
            <?php endwhile; ?>

            <?php
            // Close "post_content"
            echo "</div>";

            // IF Sidebar Right
            if($sidebar_layout == 'right-sidebar'){
                get_sidebar();
            }
            ?>
        </div>
    </div>

<?php get_footer();

class ApiController
{
    public static function getApiByMethod($name, $apiPath, $param, $method = 'POST')
    {
        //Set Header $apiPath = Yii::$app->params['CMS_API_PATH_IPOS'];
        $access_token = 'D0FBGS3NKZUUFZCIURBDKPR9N5RRML7K';
        //$user_token = \Yii::$app->session->get('user_token');
        $headers = array();
        $headers[] = 'access_token: ' . $access_token;
        //$headers[] = 'token: ' . $user_token;

        // Set body parameter

        $api_request_url = $apiPath . $name;

        /*
    Set the Request Url (without Parameters) here
    */
        /*
          Which Request Method do I want to use ?
          DELETE, GET, POST or PUT
        */
        $method_name = $method;


        /*
          Let's set all Request Parameters (api_key, token, user_id, etc)
        */
        $api_request_parameters = $param;


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        if ($method_name == 'DELETE') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($api_request_parameters));
        }

        if ($method_name == 'GET') {
            $api_request_url .= '?' . http_build_query($api_request_parameters);

        }

        if ($method_name == 'POST') {
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($api_request_parameters));
        }

        if ($method_name == 'PUT') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($api_request_parameters));
        }

        /*
          Here you can set the Response Content Type you prefer to get :
          application/json, application/xml, text/html, text/plain, etc
        */

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        /*echo '<pre>';
    var_dump($header);
    //var_dump($api_request_url);
    echo '</pre>';
    die();*/


        /*
          Let's give the Request Url to Curl
        */
        curl_setopt($ch, CURLOPT_URL, $api_request_url);

        /*
          Yes we want to get the Response Header
          (it will be mixed with the response body but we'll separate that after)
        */
        //curl_setopt($ch, CURLOPT_HEADER, TRUE);

        /*
          Allows Curl to connect to an API server through HTTPS
        */
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        /*
          Let's get the Response !
        */
        $api_response = curl_exec($ch);


        /*
          We need to get Curl infos for the header_size and the http_code
        */
        //$api_response_info = curl_getinfo($ch);

        /*
          Don't forget to close Curl
        */
        curl_close($ch);


        return json_decode($api_response);
    }
}

?>