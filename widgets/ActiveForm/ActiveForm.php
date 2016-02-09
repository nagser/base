<?php

namespace nagser\base\widgets\ActiveForm;

class ActiveForm extends \yii\widgets\ActiveForm {

    public $prepend = '';
    public $append = '';
    public $full = true;

    public function init(){
        if($this->full){
            echo $this->prepend;
        };
        parent::init();
    }

    public function run(){
        parent::run();
        if($this->append){
            echo $this->append;
        }
    }

}