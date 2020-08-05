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

use creocoder\flysystem\Filesystem;
use hiqdev\yii2\collection\BaseObject;
use hiqdev\yii2\modules\pages\interfaces\PageInterface;
use hiqdev\yii2\modules\pages\interfaces\StorageInterface;
use hiqdev\yii2\modules\pages\models\AbstractPage;
use hiqdev\yii2\modules\pages\models\PagesList;
use Yii;

class FileSystemStorage extends BaseObject implements StorageInterface
{
    /** @var string|Filesystem */
    private $fileSystem;

    /** @var string */
    private $path;

    private $pageClasses = [
        ''      => \hiqdev\yii2\modules\pages\models\OtherPage::class,
        'md'    => \hiqdev\yii2\modules\pages\models\MarkdownPage::class,
        'php'   => \hiqdev\yii2\modules\pages\models\PhpPage::class,
        'twig'  => \hiqdev\yii2\modules\pages\models\TwigPage::class,
        'feature' => \hiqdev\yii2\modules\pages\models\OtherPage::class,
    ];

    /**
     * @param string $page
     * @return AbstractPage|null
     * @throws \yii\base\InvalidConfigException
     */
    public function getPage(string $page): ?PageInterface
    {
        if ($this->isDir($page)) {
            foreach (['index', 'README'] as $name) {
                $index = $this->getPage($page . '/' . $name);
                if ($index) {
                    return $index;
                }
            }
        }

        foreach (array_keys($this->pageClasses) as $extension) {
            $path = $page . '.' . $extension;
            if ($this->getFileSystem()->has($path)) {
                return AbstractPage::createFromFile($path, $this);
            }
        }

        return null;
    }

    public function getList(string $path = null): ?PagesList
    {
        if (!is_null($path) && $this->isDir($path)) {
            return PagesList::createFromDir($path, $this);
        }

        return null;
    }

    /**
     * @param string $page
     * @return bool|null
     * @throws \yii\base\InvalidConfigException
     */
    public function isDir(string $page): ?bool
    {
        if (!$this->getFileSystem()->has($page)) {
            return null;
        }
        $meta = $this->getMetadata($page);

        return $meta['type'] === 'dir';
    }

    /**
     * @param $page
     * @return array|false
     * @throws \yii\base\InvalidConfigException
     */
    public function getMetadata($page)
    {
        return $this->getFileSystem()->getMetadata($page);
    }

    /**
     * @param mixed $fileSystem
     */
    public function setFileSystem($fileSystem): void
    {
        $this->fileSystem = $fileSystem;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @return null|string
     * @throws \yii\base\InvalidConfigException
     */
    public function read(string $path): ?string
    {
        return $this->getFileSystem()->read($path);
    }

    /**
     * @param string $extension
     * @return string
     */
    public function findPageClass(string $extension): string
    {
        if (empty($this->pageClasses[$extension])) {
            $extension = '';
        }

        return $this->pageClasses[$extension];
    }

    /**
     * Reads given path as array of already rtrimmed lines.
     * @param string $path
     * @return false|string[]
     */
    public function readArray(string $path)
    {
        return preg_split("/((\r?\n)|(\r\n?))/", $this->fileSystem->read($path));
    }

    /**
     * @param $filePath
     * @return string
     */
    public function getLocalPath($filePath): string
    {
        return $this->path . '/' . $filePath;
    }

    /**
     * @return Filesystem
     * @throws \yii\base\InvalidConfigException
     */
    public function getFileSystem(): Filesystem
    {
        if (!is_object($this->fileSystem)) {
            $this->fileSystem = Yii::createObject([
                'class' => $this->fileSystem,
                'path' => $this->path,
            ]);
        }

        return $this->fileSystem;
    }
}
