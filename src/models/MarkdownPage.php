<?php

namespace hiqdev\yii2\modules\pages\models;

use cebe\markdown\GithubMarkdown;

class MarkdownPage extends AbstractPage
{
    public function render(array $params = [])
    {
        $parser = new GithubMarkdown();

        return $parser->parse($this->text);
    }
}
