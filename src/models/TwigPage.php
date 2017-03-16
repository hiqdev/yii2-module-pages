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

class TwigPage extends AbstractPage
{
    public function render(array $params = [])
    {
        $path = Module::getInstance()->getLocalPath($this->path);

        return Yii::$app->getView()->renderFile($path);
    }

    public function extractData($path)
    {
        $lines = static::getModule()->readArray($path);
        $matterLines = $this->readQuotedLines($lines, '/^{#/', '/#}$/');
        if (empty($matterLines)) {
            $data = [];
            $text = $lines;
        } else {
            $data = $this->readFrontMatter($matterLines);
            $text = array_slice($lines, count($matterLines));
        }

        return [$data, implode("\n", $text)];
    }

}
