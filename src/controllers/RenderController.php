<?php

namespace hiqdev\yii2\modules\pages\controllers;

use cebe\markdown\GithubMarkdown;
use Symfony\Component\Yaml\Yaml;
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

        $extension = pathinfo($path)['extension'];
        if (!isset($this->module->handlers[$extension])) {
            throw new InvalidConfigException('not handled extension:' . $extension);
        }
        $handler = $this->module->handlers[$extension];

        return call_user_func([$this, $handler], $path);
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

    public function renderMarkdown($path)
    {
        list($data, $md) = $this->extractData($path);

        $parser = new GithubMarkdown();
        $html = $parser->parse($md);

        return $this->renderHtml($html, $data);
    }

    public function renderHtml($html, array $data)
    {
        if (!empty($data['layout'])) {
            $this->layout = $data['layout'];
        }

        if (!empty($data['title'])) {
            $this->view->title = Html::encode($data['title']);
        }

        $this->view->params = $data;

        return $this->renderContent($html);
    }

    public function extractData($path)
    {
        $lines = $this->module->readArray($path);
        $marker = "---";
        $line = array_shift($lines);
        if ($line === $marker) {
            $meta = '';
            while (true) {
                $line = array_shift($lines);
                if ($line === $marker) {
                    break;
                }
                $meta .= "\n" . $line;
            }
            $line = '';
            $data = Yaml::parse($meta);
        } else {
            $data = [];
        }

        return [$data, $line . join("\n", $lines)];
    }
}
