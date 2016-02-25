<?php

namespace nagser\base\assets\vendors;

use yii\web\AssetBundle;

class MustacheAsset extends AssetBundle
{
	public $sourcePath = '@nagser/base/assets/web/js/plugins/mustache';
	public $js = [
		'mustache.js',
	];
	public $depends = [
	];

}
