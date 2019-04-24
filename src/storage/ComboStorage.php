<?php
/**
 * Yii2 Pages Module
 *
 * @link      https://github.com/hiqdev/yii2-module-pages
 * @package   yii2-module-pages
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2017, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\yii2\modules\pages\storage;

use hiqdev\yii2\modules\pages\models\AbstractPage;
use Yii;
use yii\base\BaseObject;

class ComboStorage extends BaseObject implements StorageInterface
{
    /** @var StorageInterface[] */
    private $storages;

    public function init()
    {
        parent::init();

        foreach ($this->storages as $name => $config) {
            $this->storages[$name] = Yii::createObject($config);
        }
    }

    /**
     * @param string $pageName
     * @return AbstractPage|null
     */
    public function getPage(string $pageName): ?AbstractPage
    {
        foreach ($this->storages as $storage) {
            if (!is_null($page = $storage->getPage($pageName))) {
                return $page;
            }
        }

        return null;
    }

    /**
     * @param StorageInterface[] $storages
     */
    public function setStorages(array $storages): void
    {
        $this->storages = $storages;
    }
}
