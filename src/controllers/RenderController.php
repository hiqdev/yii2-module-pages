<?php
/**
 * Yii2 Pages Module
 *
 * @link      https://github.com/hiqdev/yii2-module-pages
 * @package   yii2-module-pages
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2017, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\yii2\modules\pages\controllers;

use hiqdev\yii2\modules\pages\models\AbstractPage;
use Yii;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;


class RenderController extends \yii\web\Controller
{
    public function getViewPath()
    {
        return dirname(__DIR__) . '/views/render';
    }

    /**
     * Index action.
     * @param string|null $page
     * @return string rendered page
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionIndex(string $page = null): string
    {
        if (!$page) {
            $page = $this->getPageName();
        }

        $page = $this->module->find($page);

        if ($page === null) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        return $this->renderPage($page);
    }

    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    private function getPageName(): string
    {
        preg_match('/^.+pages\/(?<pageName>.+)$/', Yii::$app->request->getUrl(), $matches);

        return trim($matches['pageName'], '/') ?: 'index';
    }

    /**
     * @param AbstractPage $page
     * @param array $params
     * @return string
     */
    private function renderPage(AbstractPage $page, array $params = []): string
    {
        if ($page->layout) {
            $this->layout = $page->layout;
        }
        if ($page->title) {
            $this->view->title = Html::encode($page->title);
        }
        $this->view->params = $page->getData();
        $params['controller'] = $this;

        return $this->render('@hipanel/site/views/themes/dataserv/articles/single', ['model' => $page]);
    }

    /**
     * @param string|null $listName
     * @return string
     */
    public function actionList(string $listName = null): string
    {
        $list = $this->module->findList($listName);

        return $this->render('@hipanel/site/views/themes/dataserv/articles/category', ['dataProvider' => $list->getDataProvider()]);
    }
}
