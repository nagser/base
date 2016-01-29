<?php

namespace nagser\base\components;

use yii\base\Component;
use yii\helpers\ArrayHelper;

class MigrationsManager extends Component
{

    /**
     * Можно передать опции доступные для миграций
     * */
    public $options = [];
    public $env = 'test';

    public function init()
    {
        parent::init();
        $this->options = ArrayHelper::merge(['interactive' => '0'], $this->options);
    }

    /**
     * Выполнить все миграции в директории
     * */
    public function upAllMigrationsRecursive()
    {
        $console = new ConsoleManager();
        return $console->run('php yii-'. $this->env .' migrate', $this->options);
    }

    /**
     * Откатить миграции
     * @param $count integer - Кол-во последних миграций для отмены. По-умолчанию 1
     * @return string
     * */
    public function downAllMigrationsRecursive($count = 1)
    {
        $console = new ConsoleManager();
        return $console->run('php yii-' . $this->env . ' migrate/down ' . (int)$count, $this->options);
    }
}