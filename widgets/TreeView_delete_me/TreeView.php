<?php

namespace app\base\widgets\TreeView;

use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class TreeView extends Widget
{

	public $options = [];
	public $contextMenu = [];

	public function init()
	{
		parent::init();
	}

	public function getId()
	{
		return ArrayHelper::getValue($this->options, 'id', 'fancy-tree');
	}

	public function run()
	{
		$view = $this->getView();
		TreeViewAsset::register($view);
		$this->options and $view->registerJs('$("#' . $this->getId() . '").fancytree( ' . Json::encode($this->options) . ')');
		$this->contextMenu and $view->registerJs('$("#' . $this->getId() . '").contextmenu( ' . Json::encode($this->contextMenu) . ')');
		return $this->render('treeView', [
			'id' => $this->getId()
		]);
	}

}