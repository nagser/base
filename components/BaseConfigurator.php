<?php

namespace nagser\base\components;

use app\base\components\MigrationsManager;
use yii\base\Component;
use yii\base\ErrorException;
use yii\db\Connection;
use yii\helpers\ArrayHelper;

class BaseConfigurator extends Component
{

    /**
     * Результат слияний нескольких конфигов(в том числе полученного из базы проекта) в 1 массив
     * Этот конфиг передаётся в Application при старте приложения
     * */
    public $config = [];

    /**
     * Базовый конфиг приложения из текстового файла
     * */
    public $textConfig = [];

    /**
     * Дополнительные надстройки подгружаемые при тестировании приложения
     * */
    public $testsConfig = [];

    /**
     * Конфиг из базы данных. Записывается в глобальный массив в свойство params.
     * Не перезаписывает исходный конфиг, только дополняет его
     * */
    public $configFromDb = [];

    public function init()
    {
        parent::init();
        $this->textConfig = $this->getTextConfig();
        if (YII_ENV === 'test') {
            //Иногда нужно переписать стандартный конфиг при тестировании
            $this->testsConfig = $this->getTestsConfig();
            //Если нужно вернуть начальный вид БД при тестировании
            isset($_GET['migrate']) and $_GET['migrate'] === '1' and $this->prepareForTheTest();
        }
        $this->configFromDb = $this->getConfigFromDb();
        $this->config = $this->getResultConfig();
    }

    /**
     * Построение $this->config
     * */
    private function getResultConfig()
    {
        //Объединение текстового конфига с конфигом из БД. Из БД может быть перезаписан только массив "params"
        return ArrayHelper::merge($this->textConfig, $this->testsConfig, ['params' => $this->configFromDb]);
    }

    /**
     * Базовый конфиг @app/config/web.php
     * */
    private function getTextConfig()
    {
        return require(__DIR__ . '/../../../../config/web.php');
    }

    /**
     * Конфиг для тестирования @app/config/tests.php
     * */
    private function getTestsConfig()
    {
        return require(__DIR__ . '/../../../../config/test.php');
    }

    /**
     * Конфиг полученный из БД
     * */
    private function getConfigFromDb()
    {
        $dbConfig = $this->textConfig['components']['db'];
        $connection = new Connection([
                'dsn' => $dbConfig['dsn'],
                'username' => $dbConfig['username'],
                'password' => $dbConfig['password'],
            ]
        );
        $connection->open();
        $config = $connection->createCommand('SELECT * FROM settings')->queryAll();
        return ArrayHelper::map($config, 'name', 'value', function ($array) {
            return ArrayHelper::getValue($array, 'category');
        });
    }

    /**
     * Подготовить приложение к тестированию
     * */
    private function prepareForTheTest()
    {
        require_once('MigrationsManager.php');
        //Дополнительная проверка на окружение
        if (YII_ENV !== 'test') {
            throw new ErrorException('Invalid environment setup to start migration!');
        }
        //Выполнить миграции необходимые для тестирования
        $migrationsManager = new MigrationsManager();
        //Откатить миграции
        $res = $migrationsManager->downAllMigrationsRecursive(1000);
        //Накатить миграции
        $res = $migrationsManager->upAllMigrationsRecursive();
    }


}