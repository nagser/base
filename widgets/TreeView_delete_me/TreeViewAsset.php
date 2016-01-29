<?php

namespace app\base\widgets\TreeView;

use yii\web\AssetBundle;

class TreeViewAsset extends AssetBundle {

	public $sourcePath = "@bower/fancytree/dist";
	public $css = [
		'skin-win8/ui.fancytree.min.css'
	];
	public $js = [
		'jquery.fancytree-all.min.js'
	];
	public $depends = [
		'yii\web\YiiAsset',
		'app\base\assets\vendors\JqueryUIAsset', //jQuery UI
		'app\base\assets\vendors\JqueryUIMenuAsset', //jQuery UI
	];

}