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

class HtmlPage extends AbstractPage
{
    /**
     * @param array $params
     * @return string
     */
    public function render(array $params = []): string
    {
        $this->setMetaData();

        return $this->text;
    }

    /**
     * Renders miniature version of page for list
     * @return string
     */
    public function renderMiniature(): string
    {
        $img = $this->featuredImageUrl ?
               "<img src=\"$this->featuredImageUrl\" alt=\"$this->slug\">" :
               '';

        return <<<HTML
<h1 class="post-title"><a href="$this->url">$this->title</a></h1>
$img
$this->text
HTML;
    }
}
