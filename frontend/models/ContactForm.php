<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Contacts;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    
    public $subject;
    public $body;
    public $file;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // subject and body are required
            [['subject', 'body'], 'required'],
            [['file'], 'file'],
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @return bool whether the email was sent
     */
    public function sendEmail()
    {
        return Yii::$app->mailer->compose()
            ->setTo(Yii::$app->params['adminEmail'])
            ->setFrom([Yii::$app->user->identity->email => Yii::$app->user->identity->username])
            ->setSubject($this->subject)
            ->setTextBody($this->body)
            ->send();
    }
    
    /**
     * Save the information collected by this model.
     *
     * @return bool whether the save model
     */
    public function saveLeads(){
        if ($this->validate()) {
            $model = new Contacts;
            $model->user_id = Yii::$app->user->id;
            $model->title = $this->subject;
            $model->body = $this->body;
            $model->file = $this->saveFile();
            if ($model->save()) {
                return $this->sendEmail();
            }       
        }

    }


    public function saveFile(){
        $bucket = Yii::$app->fileStorage->getBucket('files');
        $process = $bucket->saveFileContent(
            $name = md5($this->file->name).'.'.$this->file->extension, 
            $this->file->tempName
        );
        if ($process) {
            return $name;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'subject' => 'Заголовок',
            'body' => 'Текст',
            'file' => 'Прикрепленный файл',
        ];
    }
}
