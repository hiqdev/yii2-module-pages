<?php

namespace hiqdev\yii2\modules\pages\models;

use hipanel\helpers\Url;

class RenderedPage extends AbstractPage
{
    /** @var null|string */
    private $featuredImageUrl;

    /** @var null|string */
    private $slug;

    /** @var null|string */
    private $keywords;

    /** @var null|string */
    private $description;

    public function render(array $params = [])
    {
        $this->view->registerMetaTag([
            'name' => 'keywords',
            'content' => $this->keywords,
        ]);

        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => $this->description,
        ]);

        return $this->text;
    }

    public function renderMiniature()
    {
        $url = Url::to('/pages/' . $this->slug);

        return <<<HTML
<a href="$url"><h1>$this->title</h1></a>
<img src="$this->featuredImageUrl" alt="">
$this->text
HTML;
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
}
