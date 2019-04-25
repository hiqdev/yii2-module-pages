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
    /** @var null|string */
    private $featuredImageUrl;

    /** @var null|string */
    private $slug;

    /** @var null|string */
    private $keywords;

    /** @var null|string */
    private $description;

    /** @var null|string */
    private $canonical;

    const META_DATA = ['keywords', 'description', 'canonical'];

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

    private function setMetaData(): void
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
}
