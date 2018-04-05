<?php
namespace common\models;

use backend\models\Fbapi;
use Yii;
use yii\base\Model;
use yii\web\Session;
use backend\controllers\ApiController;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $pos_parent;
    public $rememberMe = true;

    private $_user = false;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password', 'pos_parent'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'pos_parent' => 'Thương hiệu',
            'username' => 'Tài khoản',
            'password' => 'Mật khẩu',
        ];
    }


    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            $param = [
                'pos_parent' => $this->pos_parent,
                'username' => $this->username,
                'password' => $this->password,
            ];
            $apiPath = Yii::$app->params['CMS_API_PATH_IPOS'];
            $type = 'auth/manager_login';
            $access_token = Yii::$app->params['ACCESS_TOKEN'];
            $dataCode = ApiController::actionCallApiByPost($param,$apiPath,$type,$access_token);

            if(isset($dataCode->error)){
                $this->addError($attribute,$dataCode->error->message);
            }else{
                $this->addError($attribute, 'Lỗi kết nối server.');
            }

//            \Yii::$app->session->set('pos_parent',$user['POS_PARENT']);
//            \Yii::$app->session->set('pos_id_list',$user['pos_id_list']);
//            \Yii::$app->session->set('username',$user['username']);
//            \Yii::$app->session->set('fullname',$user['full_name']);
//            \Yii::$app->session->set('type_acc',$user['type']);
//            \Yii::$app->session->set('callcenter_ext',$user['callcenter_ext']);
            //$this->addError($attribute, 'Sai tên hoặc mật khẩu.');
//            if (!$user || !$user->validatePassword($this->password)) {
//                $this->addError($attribute, 'Sai tên hoặc mật khẩu.');
//            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */

    /*public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }*/

    public function login()
    {

//        if ($this->validate()) {
//            // all inputs are valid
//        } else {
//            // validation failed: $errors is an array containing error messages
//            $errors = $this->errors;
//        }
//        echo '<pre>';
//        var_dump($this->errors);
//        echo '</pre>';
//        die();

        $param = [
            'pos_parent' => $this->pos_parent,
            'username' => $this->username,
            'password' => $this->password,
        ];

        Yii::error($param);

        $apiPath = Yii::$app->params['CMS_API_PATH_IPOS'];
        $type = 'auth/manager_login';
        $access_token = Yii::$app->params['ACCESS_TOKEN'];
        $dataCode = ApiController::actionCallApiByPost($param,$apiPath,$type,$access_token);
//            echo '<pre>';
//            var_dump($dataCode);
//            echo '</pre>';
//            die();

        if (isset($dataCode->data)) {
//            echo '<pre>';
//            var_dump($dataCode->data);
//            echo '</pre>';
//            die();
            \Yii::$app->session->set('pos_parent',$dataCode->data->pos_parent);
            \Yii::$app->session->set('type_acc',$dataCode->data->type);
            \Yii::$app->session->set('username',$dataCode->data->username);
            \Yii::$app->session->set('user_id',$dataCode->data->id);
            \Yii::$app->session->set('user_token',$dataCode->data->token);
            \Yii::$app->session->set('type_acc',$dataCode->data->type);
            \Yii::$app->session->set('pos_id_list',@$dataCode->data->pos_id_list);
            \Yii::$app->session->set('callcenter_ext',@$dataCode->data->call_center_ext);
            \Yii::$app->session->set('callcenter_short',@$dataCode->data->callcenter_short);
            \Yii::$app->session->set('ipcc_permission',@$dataCode->data->ipcc_permission);

            if($dataCode->data->type == 1){
                \Yii::$app->session->set('pos_id_list',NULL);
            }else{
//                echo '<pre>';
//                var_dump($dataCode->data);
//                echo '</pre>';
//                die();
                \Yii::$app->session->set('pos_id_list',@$dataCode->data->pos_id_list);
            }

            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            if ($this->validate()) {
                return false;
            } else {
                return false;
            }
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */

    public function getUser()
    {
        if ($this->_user === false) {
            $fisrtChar = substr($this->username,0,1); // Lấy kí tự đầu của chuỗi
            //Kiểm tra nếu đầu chuỗi là số 0 thì convert sang đầu 84
            if($fisrtChar === '0'){
                $this->username =  LoginForm::format_number($this->username);
            }

            //die();
            $this->_user = User::findByUsername($this->username);

        }
        return $this->_user;
    }

    //Convert SĐT local to internal
    function format_number($number)
    {
        //make sure the number is actually a number
        if(is_numeric($number)){

            //if number doesn't start with a 0 or a 4 add a 0 to the start.
            if($number[0] != 0 && $number[0] != 4){
                $number = "0".$number;
            }

            //if number starts with a 0 replace with 8
            if($number[0] == 0){
                $number[0] = str_replace("0","4",$number[0]);
                $number = "8".$number;
            }

            //remove any spaces in the number
            $number = str_replace(" ","",$number);

            //return the number
            return $number;

            //number is not a number
        } else {

            //return nothing
            return false;
        }
    }

}
