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

use Symfony\Component\Yaml\Yaml;
use Yii;
use yii\base\InvalidConfigException;

abstract class AbstractPage extends \yii\base\Object
{
    public $layout;

    public $title;

    protected $path;

    protected $text;

    protected $data = [];

    public function setData(array $data)
    {
        $this->data = $data;
        foreach (['title', 'layout'] as $key) {
            if (isset($data[$key])) {
                $this->{$key} = $data[$key];
            }
        }
    }

    public function getData()
    {
        return $this->data;
    }

    public function __construct($path, $text, array $data = [])
    {
        $this->path = $path;
        $this->text = $text;
        $this->setData($data);
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getDate()
    {
        return $this->data['date'];
    }

    public static function getModule()
    {
        /// XXX think
        return Yii::$app->getModule('pages');
    }

    public static function createFromFile($path)
    {
        $extension = pathinfo($path)['extension'];

        if (!isset(static::getModule()->handlers[$extension])) {
            throw new InvalidConfigException('not handled extension:' . $extension);
        }
        $class = static::getModule()->handlers[$extension];

        list($data, $text) = static::extractData($path);

        return new $class($path, $text, $data);
    }

    public static function extractData($path)
    {
        $lines = static::getModule()->readArray($path);
        $marker = '---';
        $line = array_shift($lines);
        if ($line === $marker) {
            $meta = '';
            while (true) {
                $line = array_shift($lines);
                if ($line === $marker) {
                    break;
                }
                $meta .= "\n" . $line;
            }
            $line = '';
            $data = Yaml::parse($meta);
            if (is_int($data['date'])) {
                $data['date'] = date('c', $data['date']);
            }
        } else {
            $data = [];
        }

        return [$data, $line . join("\n", $lines)];
    }

    /**
     * Renders the page with given params.
     *
     * @param array $params
     * @abstract
     */
    abstract public function render(array $params = []);
}
