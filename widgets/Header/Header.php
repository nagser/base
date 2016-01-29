<?php

namespace app\base\widgets\Header;

use kartik\widgets\Widget;

class Header extends Widget
{

    public $options = [];
    public $branding = '';
    public $brandingOptions = [];


    public function init()
    {
        parent::init();
        ob_start();
    }

    public function run()
    {
        $content = ob_get_clean();
        return $this->render('header', [
            'content' => $content,
            'options' => $this->options,
            'branding' => $this->branding,
            'brandingOptions' => $this->brandingOptions,
        ]);
    }

}