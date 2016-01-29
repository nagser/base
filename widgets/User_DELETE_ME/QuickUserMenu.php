<?php

namespace app\base\widgets\User;

use kartik\base\Widget;
use yii\base\InvalidParamException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class QuickUserMenu extends Widget
{

    public $items = [];
    public $container = 'li';
    public $containerOptions = [];

    public function run()
    {
        $content = '';
        if (is_array($this->items) and count($this->items)) {
            foreach ($this->items as $item) {
                $content .= $item;
            }
        } else {
            throw new InvalidParamException();
        }
        return Html::tag($this->container, $this->render('quickUserMenu', ['content' => $content]), $this->containerOptions);
    }
}