<?php

namespace nagser\base\widgets\GridView;

use \Yii;

class GridView extends \kartik\grid\GridView {

    const FILTER_SELECT2 = 'nagser\base\widgets\Select2\Select2';

    public function init(){
        parent::init();
    }
}