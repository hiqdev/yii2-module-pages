<?php

namespace hiqdev\yii2\modules\pages\models;

use Symfony\Component\Yaml\Yaml;
use Yii;

abstract class AbstractPage extends \yii\base\Object
{
    public $layout;

    public $title;

    protected $data = [];

    protected $text;

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

    public function __construct(array $data, $text)
    {
        $this->setData($data);
        $this->text = $text;
    }

    static public function getModule()
    {
        /// XXX think
        return Yii::$app->getModule('pages');
    }

    static public function createFromFile($path)
    {
        $extension = pathinfo($path)['extension'];

        if (!isset(static::getModule()->handlers[$extension])) {
            throw new InvalidConfigException('not handled extension:' . $extension);
        }
        $class = static::getModule()->handlers[$extension];
        
        list($data, $text) = static::extractData($path);

        return new $class($data, $text);
    }

    static public function extractData($path)
    {
        $lines = static::getModule()->readArray($path);
        $marker = "---";
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
     * @access public
     * @return void
     */
    abstract public function render(array $params = []);
}