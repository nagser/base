<?php

/*
 * Дебагер переменной
 * */
function dump_arr($arr)
{
    return '<pre>' . print_r($arr, TRUE) . '</pre>';
}

/*
 * Дебагер переменной только для админов с выходом
 * */
function debug($arr, $return = FALSE)
{
    $dump = dump_arr($arr);
    if (!$return) {
        exit($dump);
    }
    return $dump;
}


/*
 * Новая версия get_value(get_property)
 * */
function v($obj, $key = 'id')
{
    $obj = (array)$obj;
    if (isset($obj[$key])) {
        return $obj[$key];
    } else {
        return FALSE;
    }
}

/*
 * Возвращает первый аргумент
 * */
function value()
{
    $args = func_get_args();
    foreach ($args as $name => $value) {
        if($value) return $value;
    }
    return null;
}

/*
 * Продвинутый экспорт переменных в текстовый вид
 * */
function var_export_min($var, $return = false)
{
    if (is_array($var)) {
        $toImplode = array();
        foreach ($var as $key => $value) {
            $toImplode[] = var_export($key, true) . '=>' . var_export_min($value, true);
        }
        $code = 'array(' . implode(',', $toImplode) . ')';
        if ($return) return $code;
        else echo $code;
    } else {
        return str_replace('\\\\', '\\', var_export($var, $return));
    }
}

/*
 * Помошник в установке языка
 * */
function correctUserLanguage($event, $languagesList)
{

}