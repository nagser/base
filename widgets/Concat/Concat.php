<?php

namespace nagser\base\widgets\concat;

use kartik\base\Widget;
use yii\base\InvalidParamException;
use yii\helpers\Html;

class Concat extends Widget
{
    public $items = [];
    public $container = 'li';
    public $containerOptions = [];
    private $content = '';

    public function init()
    {
        parent::init();
        if (is_array($this->items) and count($this->items)) {
            foreach ($this->items as $item) {
                $this->content .= $item;
            }
        } else {
            throw new InvalidParamException();
        }
    }

    public function getContent(){
        return $this->content;
    }

    public function run()
    {
        return Html::tag($this->container, $this->content, $this->containerOptions);
    }


}