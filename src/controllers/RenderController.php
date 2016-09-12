<?php

namespace hiqdev\yii2\modules\pages\controllers;

use cebe\markdown\GithubMarkdown;
use Symfony\Component\Yaml\Yaml;
use Yii;
use yii\web\NotFoundHttpException;

class RenderController extends \yii\web\Controller
{
    use \hiqdev\yii2\modules\pages\GetModuleTrait;

    public function actionIndex($page = null)
    {
        if (!$page) {
            $page = 'index';
        }

        $path = $this->getModule()->find($page);

        if ($path === null) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        return $this->renderMarkdown($path);
    }

    public function renderMarkdown($path)
    {
        $lines = file($path);
        list($data, $md) = $this->extractData($lines);

#var_dump(compact('data', 'md')); die();

        $parser = new GithubMarkdown();
        $html = $parser->parse($md);

        return $this->renderHtml($html, $data);
    }

    public function renderHtml($html, $data)
    {
        if (!empty($data['layout'])) {
            $this->layout = $data['layout'];
        }
        $data['params'] = $data;
        $data['html'] = $html;

        return $this->render('html', $data);
    }

    public function extractData(array $lines)
    {
        $marker = "---\n";
        $line = array_shift($lines);
        if ($line === $marker) {
            $meta = '';
            while (true) {
                $line = array_shift($lines);
                if ($line === $marker) {
                    break;
                }
                $meta .= $line;
            }
            $line = '';
            $data = Yaml::parse($meta);
        } else {
            $data = [];
        }

        return [$data, $line . join("\n", $lines)];
    }
}
