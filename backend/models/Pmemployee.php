<?php

namespace backend\models;

use backend\controllers\DmpositemController;
use Yii;
use yii\helpers\Html;
use kartik\checkbox\CheckboxX;

/**
 * This is the model class for table "PM_EMPLOYEE".
 *
 * @property string $ID
 * @property string $POS_PARENT
 * @property string $NAME
 * @property string $POS_ID
 * @property string $PASSWORD
 * @property string $CREATED_AT
 * @property string $PERMISTION
 */
class Pmemployee extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'PM_EMPLOYEE';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NAME','POS_ID'], 'required'],
            [['POS_ID', 'PERMISTION'], 'integer'],
            [['CREATED_AT'], 'safe'],
            //[['NAME'], 'unique'],
            [['POS_PARENT', 'NAME'], 'unique', 'targetAttribute' => ['POS_PARENT', 'NAME'], 'message' => 'The combination of Pos  ID and Item  ID has already been taken.'],
            [['POS_PARENT', 'NAME', 'PASSWORD'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'Mã',
            'POS_PARENT' => 'Thương hiệu',
            'NAME' => 'Tài khoản',
            'POS_ID' => 'Nhà hàng',
            'PASSWORD' => 'Mật khẩu',
            'CREATED_AT' => 'Ngày tạo',
            'PERMISTION' => 'Quyền hạn',
        ];
    }

    public function getPos()
    {
        return $this->hasOne(Dmpos::className(), ['ID' => 'POS_ID']);
    }
    public function getPermis()
    {
        $permitArray = DmpositemController::DecToBin($this->PERMISTION,7); // 4 QUYỀN
        $perMis = '';
//        echo '<pre>';
//        var_dump($permitArray);
//        echo '</pre>';
//        die();

        foreach((array)$permitArray as $per){

            switch ($per) {
                case 1:
                    $label = 'Thêm loại món ';
                    break;
                case 2:
                    $label = 'Thêm món ';
                    break;
                case 3:
                    $label = 'Thêm khách hàng ';
                    break;
                case 4:
                    $label = 'Hủy hóa đơn';
                    break;
                case 5:
                    $label = 'Kiểm kê';
                    break;
                case 6:
                    $label = 'Nhập kho';
                    break;
                case 7:
                    $label = 'Đặt hàng';
                    break;
                default:
                    $label = 'Sai quyền';
            }

            $checkBox = '<div class="col-md-9">
                    <label class="cbx-label" for="kv-adv-8">
                    '.CheckboxX::widget([
                    "name" => "kv-adv-8",
                    "value"=>1,
                    "initInputType" => CheckboxX::INPUT_CHECKBOX,
                    "pluginOptions" => [
                        "theme" => "krajee-flatblue",
                        "enclosedLabel" => true,
                        "threeState"=>false,
                        "disabled"=>true
                    ]
                ]).$label.'
                    </label>
                </div>';
            $perMis = $perMis.$checkBox;
        }

        return  $perMis;

    }

    public function getPermisforcontrol($permistion)
    {
        $permitArray = DmpositemController::DecToBin($permistion,7); // 4 QUYỀN
        $perMis = '';

        foreach((array)$permitArray as $per){

            switch ($per) {
                case 1:
                    $label = 'Thêm loại món ';
                    break;
                case 2:
                    $label = 'Thêm món ';
                    break;
                case 3:
                    $label = 'Tạo khách hàng ';
                    break;
                case 4:
                    $label = 'Trả lại ';
                    break;
                case 5:
                    $label = 'Kiểm kê';
                    break;
                case 6:
                    $label = 'Nhập kho';
                    break;
                case 7:
                    $label = 'Đặt hàng';
                    break;
                default:
                    $label = 'Sai quyền';
            }
            if($perMis){
                $perMis = $perMis.' - '.$label;
            }else{
                $perMis = $perMis.$label;
            }
        }

        return  $perMis;

    }


    public function getResetpassword()
    {
        $button1 =  Html::a('Đặt lại', 'index.php?r=pmemployee/resetpassword&NAME='.$this->NAME.'&EM_ID='.$this->ID,
            [
                'class' => 'btn btn-success',
            ]
        );
        return $button1;
    }
}
