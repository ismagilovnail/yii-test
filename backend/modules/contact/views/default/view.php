<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
// Фильтры rbac
use mdm\admin\components\Helper;


/* @var $this yii\web\View */
/* @var $model backend\modules\contact\models\Contacts */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Заявки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contacts-view">

    <h1>Заявка от пользователя: <?= Html::encode($model->user->username) ?></h1>

    <p>
        <?


        ?>
<?if(!$model->status):?>
    <?if(Helper::checkRoute('update')):?>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?endif;?>
    <?if(Helper::checkRoute('delete')):?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    <?endif;?>
    <?if(Helper::checkRoute('moderate')):?>
         <?=Html::a('Одобрить', ['moderate', 'id' => $model->id], [
            'class' => 'btn btn-success',
            'data' => [
                'confirm' => 'Вы действительно хотите одобрить эту заявку?',
                'method' => 'post',
            ],
        ]);?>
    <?endif;?>
<?endif;?>

    </p>
 <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'body:ntext',
            [
                'attribute' => 'file',
                'value'=>function($model){
                    return $model->fileUrl;
                },
                'format' => 'raw'
            ],
            [
                'attribute' => 'user_id',
                'value' => function($model){return $model->user->username;}
            ],
            [
                'attribute' => 'status',
                'value' => function($model){return $model->statusView;},
                'format' => 'raw',
            ],
            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:d-m-Y H:i:s'],
            ],
             
        ],
    ]) ?>

</div>
