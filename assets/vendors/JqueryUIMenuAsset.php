<?php

namespace app\base\assets\vendors;

use yii\web\AssetBundle;

class JqueryUIMenuAsset extends AssetBundle
{
	public $sourcePath = '@app/vendor/bower/ui-contextmenu';
	public $css = [
	];
	public $js = [
		'jquery.ui-contextmenu.min.js',
	];
	public $depends = [
		'yii\web\YiiAsset',
		'app\base\assets\vendors\JqueryUIAsset', //jQuery UI
	];
}
