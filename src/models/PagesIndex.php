<?php
/**
 * Yii2 Pages Module.
 *
 * @link      https://github.com/hiqdev/yii2-module-pages
 * @package   yii2-module-pages
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2017, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\yii2\modules\pages\models;

use Yii;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

class PagesIndex
{
    protected $pages = [];

    public static function getStorage()
    {
        /// TODO get it properly
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
        ArrayHelper::multisort($this->pages, 'basename', SORT_DESC);

        $data = [];
        foreach ($this->pages as $file) {
            if ($file['basename'][0] === '.') {
                continue;
            }

            $data[] = AbstractPage::createFromFile($file['path']);
        }

        return new ArrayDataProvider(['allModels' => $data]);
    }
}
