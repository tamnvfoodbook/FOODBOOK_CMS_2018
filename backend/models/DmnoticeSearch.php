<?php

namespace backend\models;

use backend\controllers\ApiController;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Dmnotice;
use yii\data\ArrayDataProvider;

/**
 * DmnoticeSearch represents the model behind the search form about `backend\models\Dmnotice`.
 */
class DmnoticeSearch extends Dmnotice
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'IS_ALL_POS'], 'integer'],
            [['TITLE', 'CONTENT', 'CREATED_BY', 'CREATED_AT', 'FULL_CONTENT_URL', 'POS_PARENT', 'LIST_POS'], 'safe'],
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
        $query = Dmnotice::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $apiPath = Yii::$app->params['CMS_API_PATH_IPOS_MOBILE'];
        $nameNotice = 'manager/get_notice';
        $param = array();

        $notices = ApiController::getLalaApiByMethod($nameNotice,$apiPath,$param,'GET');
        /*echo '<pre>';
        var_dump($notices);
        echo '</pre>';
        die();*/

        $dataProvider = new ArrayDataProvider([
            'allModels' => @$notices->data,
        ]);


        return $dataProvider;
    }
}
