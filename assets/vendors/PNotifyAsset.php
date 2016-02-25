<?php

namespace nagser\base\assets\vendors;

use yii\web\AssetBundle;

class PNotifyAsset extends AssetBundle
{
	public $sourcePath = '@nagser/base/assets/web/js/plugins/pnotify';
	public $js = [
		'pnotify.js',
	];
    public $css = [
        'pnotify.css',
    ];

}
