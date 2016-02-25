<?php

namespace nagser\base\models;

use \yii\db\ActiveRecord;
use yii\helpers\StringHelper;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\QueryInterface;


class Model extends ActiveRecord
{

	/**
	 * @var array
	 * MultiLanguages fields in MySQL
	 * */
	public $multiLangAttributes = [];

	public function __construct($config = []){
		parent::__construct($config);
	}

	public static function tableName()
	{
		return StringHelper::basename(get_called_class());
	}

	/**
	 * Creates data provider instance with search query applied (for SearchModel)
	 * @param array $params
	 * @return ActiveDataProvider
	 */
	public function search($params)
	{
		$query = self::find();
		if($this->multiLangAttributes){
			$query = $query->joinWith('translation');
		}
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'sort'=> ['defaultOrder' => ['id' => SORT_DESC]],
		]);
		$this->load($params);
		if (!$this->validate()) {
			// uncomment the following line if you do not want to any records when validation fails
			// $query->where('0=1');
			return $dataProvider;
		}
		$this->filters($query);
		return $dataProvider;
	}

	/**
	 * Default filter for search
	 * @param QueryInterface $query
	 * */
	public function filters($query){
		$query->andFilterWhere([
			'id' => $this->id,
		]);
		$query->andFilterWhere(['like', 'id', $this->id]);
	}

	/**
	 * @param string $alias
	 * @return bool
	 * */
	public function isMultiLangField($alias){
		return in_array($alias, $this->multiLangAttributes);
	}
}