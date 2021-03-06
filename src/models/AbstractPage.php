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

use Yii;
use hiqdev\yii2\modules\pages\interfaces\PageInterface;
use hiqdev\yii2\modules\pages\storage\FileSystemStorage;
use hiqdev\yii2\modules\pages\interfaces\StorageInterface;
use Symfony\Component\Yaml\Yaml;
use yii\base\BaseObject;

abstract class AbstractPage extends BaseObject implements PageInterface
{
    /** @var \yii\web\View */
    protected $view;

    public $layout;

    /** @var string */
    public $title;

    /** @var null|string */
    protected $path;

    /** @var string */
    protected $text;

    /** @var array */
    protected $data = [];

    /** @var string */
    protected string $url;

    /** @var null|string */
    protected $featuredImageUrl;

    /** @var null|string */
    protected $slug;

    /** @var null|string */
    protected $keywords;

    /** @var null|string */
    protected $description;

    /** @var null|string */
    protected $canonical;

    const META_DATA = ['keywords', 'description', 'canonical'];

    /** @var StorageInterface */
    protected $storage;

    public function __construct($path = null, StorageInterface $storage = null, $config = [])
    {
        if ($path) {
            $this->storage = $storage;
            [$data, $text] = $this->extractData($path);

            $this->path = $path;
            $this->text = $text;
            $this->setData($data);
        }

        $this->view = Yii::$app->view;
        parent::__construct($config);
    }

    public function setData($data)
    {
        if (!is_array($data)) {
            return;
        }
        $this->data = $data;
        foreach (['title', 'layout', 'url'] as $key) {
            if (isset($data[$key])) {
                $this->{$key} = $data[$key];
            }
        }
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getDate()
    {
        return $this->data['date'];
    }

    public function getUrl()
    {
        return $this->url ?: ['/pages/render/index', 'page' => $this->getPath()];
    }

    public static function createFromFile($path, FileSystemStorage $storage)
    {
        $extension = pathinfo($path)['extension'];
        $class = $storage->findPageClass($extension);

        return new $class($path, $storage);
    }

    public function extractData($path)
    {
        $lines = $this->storage->readArray($path);
        $yaml = $this->readQuotedLines($lines, '/^---$/', '/^---$/');
        if (empty($yaml)) {
            $data = [];
            $text = $lines;
        } else {
            $data = $this->readYaml($yaml);
            $text = array_slice($lines, count($yaml));
        }

        return [$data, implode("\n", $text)];
    }

    public function readFrontMatter($lines)
    {
        $yaml = $this->readQuotedLines($lines, '/^---$/', '/^---$/');
        if (empty($yaml)) {
            return [];
        }

        return empty($yaml) ? [] : $this->readYaml($yaml);
    }

    public function readYaml($lines)
    {
        $data = Yaml::parse(implode("\n", $lines));
        if (is_int($data['date'])) {
            $data['date'] = date('c', $data['date']);
        }

        return $data;
    }

    public function readQuotedLines($lines, $headMarker, $tailMarker)
    {
        $line = array_shift($lines);
        if (!preg_match($headMarker, $line, $matches)) {
            return null;
        }
        $res[] = ltrim(substr($line, strlen($matches[0])));
        while ($line) {
            $line = array_shift($lines);
            if (preg_match($tailMarker, $line, $matches)) {
                $res[] = rtrim(substr($line, 0, -strlen($matches[0])));
                break;
            }
            $res[] = $line;
        }

        return $res;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function setMetaData(): void
    {
        foreach (self::META_DATA as $tag) {
            if (is_null($this->{$tag})) {
                continue;
            }
            $this->view->registerMetaTag([
                'name' => $tag,
                'content' => $this->{$tag},
            ]);
        }
    }

    /**
     * @param null|string $slug
     */
    public function setSlug(?string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @param null|string $keywords
     */
    public function setKeywords(?string $keywords): void
    {
        $this->keywords = $keywords;
    }

    /**
     * @param null|string $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @param null|string $featuredImageUrl
     */
    public function setFeaturedImageUrl(?string $featuredImageUrl): void
    {
        $this->featuredImageUrl = $featuredImageUrl;
    }

    /**
     * @param null|string $canonical
     */
    public function setCanonical(?string $canonical): void
    {
        $this->canonical = $canonical;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }
}
