<?php

namespace app\base\widgets\SerialColumn;

use yii\grid\SerialColumn;

class AdminSerialColumn extends SerialColumn {

	public $headerOptions = [
		'class' => 'minWidth hidden-xs',
	];
	public $contentOptions = [
		'class' => 'minWidth hidden-xs',
	];
}