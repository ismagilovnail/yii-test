<?php

namespace common\models;

use Yii;
use common\models\User;
use yii\helpers\Html;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "contacts".
 *
 * @property int $id
 * @property string $title
 * @property string $body
 * @property string $file
 * @property string $user_id
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class Contacts extends \yii\db\ActiveRecord
{

    const UPLOAD_FILE = 'web/uploads';
    public $manager;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contacts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'body', 'user_id'], 'required'],
            [['body'], 'string'],
            [['status','user_id'], 'integer'],
            [['title', 'file'], 'string', 'max' => 255],
        ];
    }

    public function behaviors()
    {
        return [
            'class'=>TimestampBehavior::className()
        ];
    }
    
    // Связь заявок с пользователями
    public function getUser(){
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID заявки',
            'title' => 'Заголовок',
            'body' => 'Текст',
            'file' => 'Прикрепленный файл',
            'user_id' => 'Пользователь',
            'status' => 'Статус заявки',
            'created_at' => 'Дата заявки',
            'updated_at' => 'Дата обновления',
            'moderator' => 'Одобрил заявку',
        ];
    }
    

    /**
     * Генерация вида статусов модерации
     */
    public function getStatusView(){
        return !$this->status ? '<span class="label label-danger">Не просмотрено<span>' : '<span class="label label-success">Одобрено<span>';
    }

    /**
     * Директория файла
     *
     * @return mixed 
     */
    public function getFilePath()
    {
        $bucket = Yii::$app->fileStorage->getBucket('files');
        $file = Yii::$app->urlManagerFrontend->baseUrl.$bucket->getFileUrl($this->file);
        return file_exists($file) ? $file : false;
    }

    /**
     * Генерация вида прикрепленного файла
     */
    public function getFileUrl(){
        return !$this->filePath ? '<span class="label label-primary">Нет файла<span>' : Html::a('Скачать файл', $this->filePath, ['target' => '_blank']);
    }



}
