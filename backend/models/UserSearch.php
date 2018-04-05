<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\User;
use yii\helpers\ArrayHelper;

/**
 * UserSearch represents the model behind the search form about `backend\models\User`.
 */
class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'ACTIVE', 'CREATED_AT', 'UPDATED_AT','TYPE'], 'integer'],
            [['USERNAME', 'AUTH_KEY', 'PASSWORD_HASH', 'EMAIL', 'POS_PARENT', 'POS_ID_LIST','CALLCENTER_EXT'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = User::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->ID,
            'status' => $this->ACTIVE,
            'created_at' => $this->CREATED_AT,
            'updated_at' => $this->UPDATED_AT,
        ]);

        $posId = \Yii::$app->session->get('pos_id_list');
        $posParentSession = \Yii::$app->session->get('pos_parent');
        $typeAcc = \Yii::$app->session->get('type_acc');
        //var_dump($typeAcc);
//        die();
        if ($typeAcc == 2) {
                $query
                    ->where(['TYPE' => [3]])
                    ->andWhere(['=', 'POS_PARENT', $posParentSession])
                    ->andFilterWhere(['=', 'USERNAME', $this->USERNAME])
                    //->andFilterWhere(['like', 'AUTH_KEY', $this->AUTH_KEY])
                    //->andFilterWhere(['like', 'PASSWORD_HASH', $this->PASSWORD_HASH])
                    //->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
                    ->andFilterWhere(['=', 'EMAIL', $this->EMAIL])
                    //->andFilterWhere(['like', 'POS_PARENT', $this->POS_PARENT])
                    //->andFilterWhere(['like', 'POS_ID_LIST', $this->POS_ID_LIST])
                    ->andFilterWhere(['=', 'CALLCENTER_EXT', $this->CALLCENTER_EXT]);

        }elseif ($typeAcc == 3) {
            if(!$posId){
                $query
                    ->where(['TYPE' => 3])
                    ->andFilterWhere(['=', 'POS_PARENT', $posParentSession])
                    ->andFilterWhere(['=', 'USERNAME', $this->USERNAME])
                    //->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
                    ->andFilterWhere(['=', 'EMAIL', $this->EMAIL])
                    //->andFilterWhere(['like', 'POS_PARENT', $this->POS_PARENT])
//                    ->andFilterWhere(['like', 'CALLCENTER_EXT', $this->CALLCENTER_EXT])
                ;
            }else{
                $query->where(['USERNAME' => \Yii::$app->session->get('username')]);
            }

        }else {
            $query
            ->andFilterWhere(['like', 'USERNAME', $this->USERNAME])
            ->andFilterWhere(['like', 'EMAIL', $this->EMAIL])
            ->andFilterWhere(['like', 'POS_PARENT', $this->POS_PARENT]);
            //->andFilterWhere(['=', 'POS_ID_LIST', $this->POS_ID_LIST])
            //->andFilterWhere(['like', 'CALLCENTER_EXT', $this->CALLCENTER_EXT]);
        }


        return $dataProvider;
    }

    public function searchLala($params)
    {
        $query = User::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->ID,
            'status' => $this->ACTIVE,
            'TYPE' => 3,
            //'created_at' => $this->CREATED_AT,
            //'updated_at' => $this->UPDATED_AT,
        ]);

        $posParentSession = \Yii::$app->session->get('lala_pos_parent');
//        $username = \Yii::$app->session->get('username');
        $query
//            ->where(['=', 'USERNAME', $username])
            ->andWhere(['=', 'POS_PARENT', $posParentSession])
            //->andFilterWhere(['like', 'AUTH_KEY', $this->AUTH_KEY])
            //->andFilterWhere(['like', 'PASSWORD_HASH', $this->PASSWORD_HASH])
            //->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['=', 'EMAIL', $this->EMAIL]);


        return $dataProvider;
    }

    public function searchAllUser(){
        $userObj = Dmmembership::find()
            ->select(['ID','MEMBER_NAME','PHONE_NUMBER'])
            ->asArray()
            ->all();
        return $userObj;
    }
    public function searchAllUserById($id){
        $userData = User::find()
            ->select(['ID','USERNAME'])
            ->where(['ID' =>$id ])
            ->asArray()
            ->all();
        return $userData;
    }

    public function searcUserById($id){
        $user = User::find()
            ->where(['ID' =>$id ])
            ->one();
        return $user;
    }
    public function searchAllUseRootByPosparent($posparent){
        $user = User::find()
            ->where(['POS_PARENT' =>$posparent])
            ->andWhere(['TYPE' =>2])
            //->asArray()
            ->all();
        return $user;
    }

    public function searchUserbyPPandUser($posParent,$username){
        $userData = User::find()
            ->where(['POS_PARENT' =>$posParent])
            ->andWhere(['USERNAME' =>$username])
            ->one();
        return $userData;
    }
    public function searchUserbyPPandPermis(){

        $typeAcc = \Yii::$app->session->get('type_acc');
        $posParent = \Yii::$app->session->get('pos_parent');
        $userId = \Yii::$app->session->get('user_id');
        $user = array();
        if($typeAcc == 2){
            $user = User::find()
                ->select(['USERNAME','ID'])
                ->where(['POS_PARENT' =>$posParent])
                ->asArray()
                ->all();
        }else{
            $user = User::find()
                ->select(['USERNAME','ID'])
                ->where(['ID' =>$userId])
                ->asArray()
                ->all();
        }
        $allUserMap = ArrayHelper::map($user,'ID','USERNAME');
        return $allUserMap;
    }

    public function searchUserbyPPandUserEmail($posParent,$username,$email){
        $userData = User::find()
            ->where(['POS_PARENT' =>$posParent])
            ->andWhere(['USERNAME' =>$username])
            ->andWhere(['EMAIL' =>$email])
            ->one();
        return $userData;
    }

}
