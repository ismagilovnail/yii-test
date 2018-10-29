<div class="row">
	<div class="col-md-6">
		<ul class="list-group">
			<li class="list-group-item">ID: <?=\Yii::$app->user->identity->id?></li>
			<li class="list-group-item">Пользователь: <?=\Yii::$app->user->identity->username?></li>
			<li class="list-group-item">E-mail: <?=\Yii::$app->user->identity->email?></li>
			<li class="list-group-item">Дата регистрации: <?=Yii::$app->formatter->asDateTime(\Yii::$app->user->identity->created_at)?></li>
			
		</ul>
		
	</div>
</div>