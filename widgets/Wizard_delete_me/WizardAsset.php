<?php

namespace app\base\widgets\Wizard;

use yii\web\AssetBundle;

class WizardAsset extends AssetBundle
{

	public $sourcePath = '@bower/twitter-bootstrap-wizard';
	public $js = [
		'jquery.bootstrap.wizard.min.js',
	];
	public $css = [
	];
	public $depends = [
		'yii\web\YiiAsset',
		'app\base\assets\vendors\AdminFormsAsset',
		'app\base\assets\vendors\AbsoluteAdminAsset',
	];

}