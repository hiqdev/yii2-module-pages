<?php

namespace hiqdev\yii2\modules\pages\controllers;

use hiqdev\yii2\modules\pages\models\AbstractPage;
use hiqdev\yii2\modules\pages\models\PagesIndex;
use Yii;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use yii\base\InvalidConfigException;

class RenderController extends \yii\web\Controller
{
    public function getViewPath()
    {
        return Yii::$app->getViewPath();
    }

    /**
     * Index action.
     * @param string $page
     * @return string rendered page
     */
    public function actionIndex($page = null)
    {
        if (!$page) {
            $page = 'index';
        }

        $path = $this->module->find($page);

        if ($path === null) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        $meta = $this->module->getMetadata($page);

        if ($meta['type'] === 'dir') {
            $index = PagesIndex::createFromDir($path);

            return $this->render('index', $index);
        } else {
            $page = AbstractPage::createFromFile($path);

            return $this->renderPage($page);
        }
    }

    public function renderTwig($path)
    {
        throw new InvalidConfigException('not implemented twig handler');
    }

    public function renderPhp($path)
    {
        $content = $this->renderFile($this->module->localPath($path));
        return $this->renderContent($content);
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
