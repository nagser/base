<?php

namespace app\base\models;

use app\modules\languages\Languages;
use yii\helpers\ArrayHelper;
use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use Yii;

class MultiLangRecordModel extends CustomRecordModel
{

	public function __construct($config = [])
	{
		parent::__construct($config);
	}

	public function behaviors()
	{
		return ArrayHelper::merge(parent::behaviors(), [
			'ml' => [ //MultiLanguages
				'class' => MultilingualBehavior::className(),
				'languages' => Languages::getAllowedLanguages(),
				'defaultLanguage' => Languages::getDefaultLanguage(),
				'langForeignKey' => 'item_id',
				'tableName' => "{{%" . $this->tableName() . "Lang}}",
				'attributes' => $this->multiLangAttributes
			],
		]);
	}

	public static function find()
	{
		return new MultilingualQuery(get_called_class());
	}


}