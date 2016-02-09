<?php

namespace nagser\base\assets\vendors;

use yii\web\AssetBundle;

class NprogressAsset extends AssetBundle
{
	public $sourcePath = '@bower/nprogress';
	public $js = [
		'nprogress.js',
	];
    public $css = [
        'nprogress.css'
    ];

}
