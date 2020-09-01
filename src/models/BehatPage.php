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

use hiqdev\yii2\modules\pages\Module;
use Yii;

class BehatPage extends AbstractPage
{
    /**
     * @param array $params
     * @return string
     * @throws \yii\base\ExitException
     * @throws \yii\base\InvalidConfigException
     */
    public function render(array $params = []): string
    {
        $fullPath = Module::getInstance()->getStorage()->getLocalPath($this->path);
        $mimeType = mime_content_type($fullPath);

        if ($mimeType !== 'text/plain') {
            throw new \Exception('unexpected mime type for behat feature file');
        }

        $text = Module::getInstance()->getStorage()->read($this->path);
        $text = preg_replace('/\b(Feature|Scenario|Background:)\b/', '<b class=behat-command>\1</b>', $text);
        $text = preg_replace('/(@\S+)\b/', '<b class=behat-tag>\1</b>', $text);
        $text = preg_replace('/\b(Given|And|When|Then)\b/', '<b class=behat-step>\1</b>', $text);

        return "<pre>$text</pre>";
    }

    public function extractData($path)
    {
        return [];
    }
}
