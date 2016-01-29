<?php

namespace app\base\assets\vendors;

use yii\web\AssetBundle;

class JqueryUIAsset extends AssetBundle
{
	public $sourcePath = '@app/vendor/bower/jquery-ui';
	public $css = [
		'themes/smoothness/jquery-ui.min.css',
		'themes/smoothness/theme.css'
	];
	public $js = [
		'jquery-ui.min.js',
	];
	public $depends = [
		'yii\web\YiiAsset',
	];
}
