<?php

namespace nagser\base\components;

use yii\base\Component;

class ConsoleManager extends Component
{

    /**
     * Директория в которой будет выполнена команда
     * @var string
     * */
    public $executePath;

    public function init()
    {
        parent::init();
        if (!$this->executePath) {
            $this->executePath = \Yii::getAlias('@app');
        }
    }

    /**
     * Перейти в директорию $this->path и выполнить команду с параметрами
     * @param $command string
     * @param $params array
     * @return string
     * */
    public function run($command, $params = [])
    {
        return shell_exec('cd ' . $this->executePath . ' && ' . $command . ' ' . implode(' ', $this->parseParams($params)));
    }

    /**
     * Подготовка параметров для передачи в коммандную строку
     * @param $params array|object
     * @return array
     * */
    private function parseParams($params)
    {
        $results = [];
        if ((array)$params) {
            foreach ($params as $key => $value) {
                $results[] = '--' . $key . '=' . $value;
            }
        }
        return $results;
    }

}