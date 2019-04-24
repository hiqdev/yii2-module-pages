<?php
/**
 * Yii2 Pages Module
 *
 * @link      https://github.com/hiqdev/yii2-module-pages
 * @package   yii2-module-pages
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2017, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\yii2\modules\pages\storage;

use Yii;
use hiqdev\yii2\modules\pages\models\AbstractPage;
use hiqdev\yii2\modules\pages\models\RenderedPage;
use Vnn\WpApiClient\Auth\WpBasicAuth;
use Vnn\WpApiClient\Http\GuzzleAdapter;
use Vnn\WpApiClient\WpClient;
use GuzzleHttp\Client as GuzzleClient;
use yii\base\BaseObject;
use yii\helpers\Url;

class WordPressApi extends BaseObject implements StorageInterface
{
    /** @var WpClient */
    private $client;

    /** @var string */
    private $url;

    /** @var string */
    private $login;

    /** @var string */
    private $password;

    public function getPage(string $pageName): ?AbstractPage
    {
        $language = \Yii::$app->language;
        $pageData = $this->getClient()->posts()->get(null, [
            'slug'  => $pageName,
        ]);

        if (empty($pageData)) {
            return null;
        }

        $pageData = $pageData[0];
        $translatedPage = $pageData['translation'][$language];
        if ($translatedPage && $language !== $pageData['lang']) {
            Yii::$app->response->redirect(Url::to('/pages/' . $translatedPage));
        }

        return Yii::createObject([
            'class' => RenderedPage::class,
            'title' => $pageData['title']['rendered'],
            'text' => $pageData['content']['rendered'],
            'keywords' => $pageData['seo']['keywords'],
            'description' => $pageData['seo']['description'],
        ]);
    }

    public function getList(): ?AbstractPage
    {
        $listData = $this->getClient()->posts()->get(null, [
            'lang'  => \Yii::$app->language,
        ]);

        if (empty($listData)) {
            return null;
        }

        $text = '';
        foreach ($listData as $pageData) {
            $text .= (Yii::createObject([
                'class' => RenderedPage::class,
                'title' => $pageData['title']['rendered'],
                'text' => $pageData['excerpt']['rendered'],
                'slug' => $pageData['slug'],
                'featuredImageUrl' => $pageData['featured_image_url'],
            ]))->renderMiniature();
        }

        return Yii::createObject([
            'class' => RenderedPage::class,
            'title' => 'List of Pages',
            'text' => $text,
        ]);
    }

    private function getClient(): WpClient
    {
        if (!$this->client) {
            $this->client = Yii::$container->get(WpClient::class, [
                Yii::$container->get(GuzzleAdapter::class, [
                    Yii::$container->get(GuzzleClient::class)
                ]),
                $this->url
            ]);

            $this->client->setCredentials(Yii::$container->get(WpBasicAuth::class, [
                $this->login,
                $this->password
            ]));
        }

        return $this->client;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @param string $login
     */
    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
}
