<?php

namespace hiqdev\yii2\modules\pages\models;

use Yii;
use yii\data\ArrayDataProvider;

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
        $index = new static();
        $index->pages = $list;

        return $index;
    }

    public function getDataProvider()
    {
        $data = [];
        foreach ($this->pages as $fileData) {
            list($params) = AbstractPage::extractData($fileData['path']);
            $data[] = array_merge($params, $fileData);
        }

        return new ArrayDataProvider(['allModels' => $data]);
    }
}
