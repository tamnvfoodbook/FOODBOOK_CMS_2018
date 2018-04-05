<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $EMAIL
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $pos_parent
 * @property string $pos_id_list
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public $oldpass;
    public  $newpass;
    public $repeatnewpass;

    public static function tableName()
    {
        return 'DM_USER_MANAGER';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ACTIVE', 'TYPE','MAX_POS_CREATE'], 'integer'],
            [['USERNAME', 'PASSWORD_HASH', 'EMAIL'], 'string', 'max' => 355],
            [['PHONE_NUMBER',], 'string', 'max' => 11],
            [['AUTH_KEY'], 'string', 'max' => 300],
            /*[['POS_PARENT'], 'string', 'max' => 10,'min' => 3],*/
            [['CREATED_AT', 'UPDATED_AT','POS_PARENT','SOURCE'], 'safe'],
            [['POS_ID_LIST','CALLCENTER_EXT','CALLCENTER_SHORT','IPCC_PERMISSION'], 'safe'],
            [['oldpass'], 'safe'],
            [[/*'oldpass',*/'newpass','repeatnewpass','USERNAME','POS_PARENT'],'required'],
//            ['oldpass','findPasswords'],
            ['repeatnewpass','compare','compareAttribute'=>'newpass'],
        ];
    }

    public function findPasswords($attribute, $params){

        $user = USER::find()->where([
            'USERNAME'=>Yii::$app->user->identity->USERNAME
        ])->one();
        $password = $user->password_hash;
        $hash = Yii::$app->getSecurity()->generatePasswordHash($password);
        if (Yii::$app->getSecurity()->validatePassword($password, $hash)) {
            echo $password;
        } else {
            $this->addError($attribute,'Mật khẩu cũ không đúng');
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'USERNAME' => 'Tài khoản',
            //'full_name' => 'Họ tên',
            'EMAIL' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'POS_ID_LIST' => 'Danh sách nhà hàng',
            'AUTH_KEY' => 'Mã xác nhận',
            'PASSWORD_HASH' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            //'oldpass'=>'Old Password',
            'oldpass'=>'Mật khẩu cũ',
            'newpass'=>'Mật khẩu',
            'repeatnewpass'=>'Nhắc lại mật khẩu',
            'callcenter_ext'=>'Số máy lẻ',
            'type'=>'Loại tài khoản',
            'POS_PARENT'=>'Tên thương hiệu',
            'ACTIVE'=>'Trạng thái',
            'MAX_POS_CREATE'=>'Giới hạn tạo nhà hàng',
            'CREATED_AT'=>'Thởi điểm tạo',
            'UPDATED_AT'=>'Thời điểm cập nhật',
            'TYPE'=>'Loại tài khoản',
            'PHONE_NUMBER'=>'Số điện thoại',
            'SOURCE'=>'Nguồn tạo',
            'CALLCENTER_SHORT'=>'Callcenter Mini',
            'IPCC_PERMISSION'=>'Quyền IPCC'
        ];
    }

    public function getIdToNamePos(){
        if($this->POS_ID_LIST){
            $integerIDs = array_map('intval', explode(',', $this->POS_ID_LIST));
            $searchPosModel = new DmposSearch();
            $allPos = $searchPosModel->searchAllPosById($integerIDs);
            $posList = null;
            foreach($allPos as $pos){
                if(!$posList){
                    $posList = $pos['POS_NAME'];
                }else{
                    $posList = $posList.' , '.$pos['POS_NAME'];
                }
            }
            return $posList;

        }else{
            return 'Quản lý hệ thống '.$this->POS_PARENT;
        }

    }

    public function getIdToNamePoslala(){
        if($this->pos_id_list){

            $integerIDs = array_map('intval', explode(',', $this->pos_id_list));


            $apiPath = Yii::$app->params['CMS_API_PATH_IPOS_MOBILE'];
            //Check Auto genagen Id
            $nameGetPosparent = 'manager/list_pos';
            $param = array();

            $pos = \ApiController::getLalaApiByMethod($nameGetPosparent,$apiPath,$param,'GET');

            echo '<pre>';
            var_dump($pos);
            echo '</pre>';
            die();

            $posList = null;
            foreach($allPos as $pos){
                if(!$posList){
                    $posList = $pos->pos_name;
                }else{
                    $posList = $posList.' , '.$pos->pos_name;
                }
            }
            return $posList;

        }else{
            return 'Quản lý hệ thống';
        }

    }
}
