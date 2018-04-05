<?php
namespace common\models;

use Yii;
use yii\base\Model;
use  yii\web\Session;

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
            [['username', 'password','pos_parent'], 'required'],
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
            if($user){
                \Yii::$app->session->set('pos_parent',$user['POS_PARENT']);
                \Yii::$app->session->set('pos_id_list',$user['POS_ID_LIST']);
                \Yii::$app->session->set('username',$user['USERNAME']);
                \Yii::$app->session->set('user_id',$user['ID']);
                \Yii::$app->session->set('type_acc',$user['TYPE']);
                \Yii::$app->session->set('callcenter_ext',$user['CALLCENTER_EXT']);
                \Yii::$app->session->set('callcenter_short',$user['CALLCENTER_SHORT']);

                $password_validate = $user['USERNAME'].$user['POS_PARENT'].'YG4BQ0FYMD'.$this->password;
                if (!$user || !$user->validatePassword($password_validate)) {
                    $this->addError($attribute, 'Sai mật khẩu.');
                }
            }else{
                $this->addError($attribute, Yii::t('yii', 'Sai tên đăng nhập'));
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
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
//            echo '<pre>';
//            var_dump($this->pos_parent);
//            echo '</pre>';
//            die();
            $this->_user = User::findByUsername($this->username,$this->pos_parent);

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
