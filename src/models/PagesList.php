<?php
/**
 * Yii2 Pages Module
 *
 * @link      https://github.com/hiqdev/yii2-module-pages
 * @package   yii2-module-pages
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2017, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\yii2\modules\pages\models;

use hiqdev\yii2\modules\pages\storage\FileSystemStorage;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

class PagesList
{
    /** @var AbstractPage[]  */
    protected $pages = [];

    /**
     * PagesList constructor.
     * @param AbstractPage[] $pages
     */
    public function __construct(array $pages)
    {
        $this->pages = $pages;
    }

    /**
     * @param string $path
     * @param FileSystemStorage $storage
     * @return PagesList
     * @throws \yii\base\InvalidConfigException
     */
    public static function createFromDir(string $path, FileSystemStorage $storage): PagesList
    {
        $list = $storage->getFileSystem()->listContents($path);
        ArrayHelper::multisort($list, 'basename', SORT_DESC);

        $pages = [];
        foreach ($list as $file) {
            if ($file['type'] !== 'file' || $file['basename'][0] === '.') {
                continue;
            }
            $pages[] = AbstractPage::createFromFile($file['path'], $storage);
        }
        $index = new static($pages, $storage);

        return $index;
    }

    /**
     * @return ArrayDataProvider
     */
    public function getDataProvider(): ArrayDataProvider
    {
        return new ArrayDataProvider([
            'allModels' => $this->pages,
            'pagination' => [
                'pageSize' => 5,
            ]
        ]);
    }
}
