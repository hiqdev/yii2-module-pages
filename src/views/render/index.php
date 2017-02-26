<?php

use hiqdev\themes\hyde\widgets\LinkPager;
use yii\helpers\Html;
use yii\widgets\ListView;

$this->title = Yii::$app->name;

?>

<?php if ($dataProvider) : ?>
    <?= ListView::widget([
        'layout' => "{items}\n{pager}",
        'options' => [
            'class' => 'posts',
        ],
        'itemOptions' => [
            'class' => 'post',
        ],
        'dataProvider' => $dataProvider,
        'pager' => [
            'class' => LinkPager::class,
            'prevPageLabel' => Yii::t('hiqdev:com', 'Newer'),
            'nextPageLabel' => Yii::t('hiqdev:com', 'Older'),
        ],
        'itemView' => function ($model, $key, $item, $widget) {
            $out = Html::tag('h1', Html::a($model->title, ['/pages/render/index', 'page' => $model->path]), ['class' => 'post-title']);
            $out .= Html::tag('span', Yii::$app->formatter->asDate($model->date), ['class' => 'post-date']);

            return $out . $model->render();
        },
    ]) ?>
<?php endif ?>

