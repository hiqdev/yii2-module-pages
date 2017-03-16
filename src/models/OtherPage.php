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

class OtherPage extends AbstractPage
{
    public function render(array $params = [])
    {
        $fullPath = Module::getInstance()->getLocalPath($this->path);
        $mimeType = mime_content_type($fullPath);

        if ($mimeType === 'text/plain') {
            $text = Module::getInstance()->getStorage()->read($this->path);
            return "<pre>$text</pre>";
        }

        $response = Yii::$app->response;
        $response->format = $response::FORMAT_RAW;
        $response->headers->set('Content-Type', $mimeType);
        readfile($fullPath);
        Yii::$app->end();
    }

    public function extractData($path)
    {
        return [];
    }
}
