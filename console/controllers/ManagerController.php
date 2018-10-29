<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\models\User;
use yii\console\Exception;
use yii\helpers\Console;

/**
 *  admin console commands
 */
class ManagerController extends Controller {

    /**
     *  admin help
     */
    public function actionIndex()
    {
        echo 'yii manager/create' . PHP_EOL;
        echo 'yii manager/remove' . PHP_EOL;
    }

    /**
     *  admin create
     */
    public function actionCreate() {
        $model = new User();
        $this->readValue($model, 'username');
        $this->readValue($model, 'email');
        $model->setPassword($this->prompt('Password:', [
            'required' => true,
            'pattern' => '#^.{6,255}$#i',
            'error' => 'More than 6 symbols',
        ]));
        $model->generateAuthKey();
        $this->log($model->save());
    }

    /**
     *  admin remove
     */
    public function actionRemove() {
        $username = $this->prompt('Username:', ['required' => true]);
        $model = $this->findModel($username);
        $this->log($model->delete());
    }

    

    /**
     * @param string $username
     * @throws \yii\console\Exception
     * @return User the loaded model
     */
    private function findModel($username)
    {
        if (!$model = User::findOne(['username' => $username])) {
            throw new Exception('User not found');
        }
        return $model;
    }



        /**
     * @param Model $model
     * @param string $attribute
     */
    private function readValue($model, $attribute) {
        $model->$attribute = $this->prompt(mb_convert_case($attribute, MB_CASE_TITLE, 'utf-8') . ':', [
            'validator' => function ($input, &$error) use ($model, $attribute) {
                $model->$attribute = $input;
                if ($model->validate([$attribute])) {
                    return true;
                } else {
                    $error = implode(',', $model->getErrors($attribute));
                    return false;
                }
            },
        ]);
    }


    /**
     * @param bool $success
     */
    private function log($success) {
        if ($success) {
            $this->stdout('Success!', Console::FG_GREEN, Console::BOLD);
        } else {
            $this->stderr('Error!', Console::FG_RED, Console::BOLD);
        }
        echo PHP_EOL;
    }


}