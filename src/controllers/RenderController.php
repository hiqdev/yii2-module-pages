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
use hiqdev\yii2\modules\pages\models\PagesIndex;
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
     * @param string|null $pageName
     * @return string rendered page
     * @throws \yii\base\InvalidConfigException
     */
    public function actionIndex(string $pageName = null)
    {
        if (!$pageName) {
            $pageName = $this->getPageName();
        }
//        if (!$page) {
//            $page = 'posts';
//        }

        $page = $this->module->find($pageName);

        if ($page === null) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        return $this->renderPage($page);

//        $path = $this->module->find($page);
//
//        if ($path === null) {
//            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
//        }
//        if ($this->module->isDir($path)) {
//            $index = PagesIndex::createFromDir($path);
//
//            return $this->render('index', ['dataProvider' => $index->getDataProvider()]);
//        } else {
//            $page = AbstractPage::createFromFile($path);
//
//            return $this->renderPage($page);
//        }
    }

    private function getPageName()
    {
        preg_match('/^.+pages\/(?<pageName>.+)$/', Yii::$app->request->getUrl(), $matches);

        return trim($matches['pageName'], '/');
    }

    public function renderPage($page, array $params = [])
    {
        if ($page->layout) {
            $this->layout = $page->layout;
        }

        if ($page->title) {
            $this->view->title = Html::encode($page->title);
        }

        $this->view->params = $page->getData();

        $params['controller'] = $this;

        return $this->renderContent($page->render($params));
    }

    public function actionList()
    {
        $list = $this->module->findList();

        return $this->renderPage($list);
    }
}
