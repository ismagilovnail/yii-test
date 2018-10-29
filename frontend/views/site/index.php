<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
$this->title = 'My Yii Application';
?>
<div class="site-index">
    <div class="jumbotron">
        <h1>My Yii2 Application</h1>
        <p class="lead">My Yii2 Application</p>
        <p><a class="btn btn-lg btn-success" href="<?=Url::to(['site/contact']);?>">Оставить заявку</a></p>
    </div>
</div>
