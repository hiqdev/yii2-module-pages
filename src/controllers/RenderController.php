<?php

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
     * @param string $page
     * @return string rendered page
     */
    public function actionIndex($page = null)
    {
        if (!$page) {
            $page = 'posts';
        }

        $path = $this->module->find($page);

        if ($path === null) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        $meta = $this->module->getMetadata($path);

        if ($meta['type'] === 'dir') {
            $index = PagesIndex::createFromDir($path);

            return $this->render('posts', ['dataProvider' => $index->getDataProvider()]);
        } else {
            $page = AbstractPage::createFromFile($path);

            return $this->renderPage($page);
        }
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

        return $this->renderContent($page->render($params));
    }

}
