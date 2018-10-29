<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use mdm\admin\components\Helper;
use kartik\daterange\DateRangePicker;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\contact\models\search\ContactsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заявки';
$this->params['breadcrumbs'][] = $this->title;
$gridId = 'group-grid';
?>
<div class="contacts-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin([
        'id' => $gridId,
        'enablePushState' => false,
        'timeout' => false,
  ]); ?>

    <?= GridView::widget([
        'id' => $gridId,
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            'id',
            'title',
            //'body:ntext',
            //'file',
            [
                'attribute' => 'user_id',
                'value' => function($model){return $model->user->username;}
            ],
            [
                'attribute' => 'status',
                'value' => function($model){return $model->statusView;},
                'format' => 'raw',
                'filter'=>["0"=>"Не просмотрено","1"=>"Одобрено"],
            ],
            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:d-m-Y H:i:s'],
                'filter' => false,
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => Helper::filterActionColumn('{view} {delete} {update}'),
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
