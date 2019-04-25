<?php

use yii\widgets\LinkPager;
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
            'prevPageLabel' => Yii::t('hiqdev:pages', 'Newer'),
            'nextPageLabel' => Yii::t('hiqdev:pages', 'Older'),
        ],
        'itemView' => function ($model, $key, $item, $widget) {
            return  method_exists($model, 'renderMiniature') ?
                    $model->renderMiniature() :
                    $model->render();
        },
    ]) ?>
<?php endif ?>

