<?php

namespace nagser\base\helpers;

use yii\base\Exception;

class FileHelper extends \yii\helpers\FileHelper {

	private static $requiredFilesMap = [];

	/**
	 * @param $file string
	 * @param $params array
	 * @return array, string, boolean, file
	 * @throws Exception
	 * */
	public static function requireFile($file, $params = []){
		$defaultParams = [
			'strict' => true, // исключение в случае неудачи
			'return' => false, // сущность, возвращаемая в случае ошибки
		];
		$params = array_merge($defaultParams, $params);
		//обращение в кеш
		if(isset(self::$requiredFilesMap[$file])){
			return self::$requiredFilesMap[$file];
		} else {
			if(file_exists($file) and is_readable($file)){
				//подключение и запись в кеш
				self::$requiredFilesMap[$file] = require($file);
				return self::requireFile($file, $params);
			} else {
				if($params['strict']){
					throw new Exception('File not found: ' . $file);
				} else {
					switch (gettype($params['return'])){
						case 'array': return []; break;
						case 'string': return ''; break;
						default: return false; break;
					}
				}
			}
		}


	}

}