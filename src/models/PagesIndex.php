<?php

namespace hiqdev\yii2\modules\pages\models;

use Yii;

class PagesIndex
{
    protected $pages = [];

    public static function getStorage()
    {
        /// TODO ...
        return Yii::$app->getModule('pages')->getStorage();
    }

    public static function createFromDir($path)
    {
        $list = static::getStorage()->listContents($path);
        var_dump($list);die();
        $index = new static();

        return $index;
    }

    public function getDataProvider()
    {
    }
}
