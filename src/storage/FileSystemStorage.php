<?php

namespace hiqdev\yii2\modules\pages\storage;

use creocoder\flysystem\Filesystem;
use hiqdev\yii2\collection\BaseObject;
use hiqdev\yii2\modules\pages\models\AbstractPage;
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
    ];

    public function getPage(string $page): ?AbstractPage
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
                return AbstractPage::createFromFile($path);
            }
        }

        return null;
    }

    public function isDir($page)
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
     * @return Filesystem
     * @throws \yii\base\InvalidConfigException
     */
    private function getFileSystem(): Filesystem
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
