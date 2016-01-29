<?php

namespace app\base\assets\vendors;

use yii\web\AssetBundle;

class PNotifyAsset extends AssetBundle
{
	public $sourcePath = '@app/base/assets/web/js/plugins/pnotify';
	public $js = [
		'pnotify.js',
	];
    public $css = [
        'pnotify.css',
    ];

}
