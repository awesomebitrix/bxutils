<?php
/**
 * Created by PhpStorm.
 * User: webconfig
 * Date: 09.02.2015
 * Time: 15:56
 */

namespace BTX;


class Utils {

    /**
     * Функция выводит print_r аргумента-объекта в блоке <pre> для отладки некоторых модулей/приложений
     *
     * @param $object
     */
    public static function p($object)
    {
        echo "<pre>=============================================================================================\n";
        print_r($object);
        echo "</pre>\n";
    }

    /**
     * Функция выводит var_dump аргумента-объекта в блоке <pre> для отладки некоторых модулей/приложений
     *
     * @param $object
     */
    public static function v($object)
    {
        echo "<pre>=============================================================================================\n";
        var_dump($object);
        echo "</pre>\n";
    }

    /**
     * Функция обрезает строку $string на заданное количество символов $limit до ближайшего пробела после $limit
     *
     * @param $string
     * @param $limit
     */
    public static function crop_str($string, $limit)
    {
        if (strlen($string) >= $limit ) {
            $substring_limited = substr($string,0, $limit);
            return substr($substring_limited, 0, strrpos($substring_limited, ' ' ));
        } else {
            //Если количество символов строки меньше чем задано, то просто возращаем оригинал
            return $string;
        }
    }

    /**
     * Функция удаляет в строке $string пробелы в начале и конце строки
     *
     * @param $string
     */
    public static function mb_trim( $string )
    {
        $string = preg_replace( "/(^\s+)|(\s+$)/us", "", $string );

        return $string;
    }

    /**
     * Функция проверяет папку по пути $pathToFolder на существование, и при необходимости создает данную папку по
     * указанному пути с правами $rules
     *
     * @param $string
     * @param $rules
     */
    public static function checkFolder($pathToFolder, $rules=0777) {
        if (!file_exists($pathToFolder)) {
            mkdir($pathToFolder, 0777, true);
        }
        return $pathToFolder;
    }

    public static function findIBlockItemsByProperty($iblock_id, $propertyCodes=array("property_code"=>"value")) {
        $arSelect = Array("ID", "IBLOCK_ID", "NAME", "DATE_ACTIVE_FROM","PROPERTY_*");//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
        $arFilter = Array("IBLOCK_ID"=>IntVal(31), "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", $propertyCodes);
        try {
            $res = \CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50), $arSelect);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
        $arResults = array();
//        $arFields = array();
//        $arProps = array();
        while($ob = $res->GetNextElement()){
            $arResults[] = array('FIELDS'=>$ob->GetFields(), 'PROPERTIES'=>$ob->GetProperties());
        }
//        self::p(        $arResults );
        if(count($arResults)==0) {
            return FALSE;
        } else {
            return $arResults;
        }
    }
}