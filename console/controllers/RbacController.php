<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
/**
 * Инициализатор RBAC выполняется в консоли yii rbac/init
 */
class RbacController extends Controller {

    public function actionInit() {
        
        $auth = Yii::$app->authManager;
        
        $auth->removeAll(); //На всякий случай удаляем старые данные из БД...
        
        // Создадим роли админа и редактора новостей
        $admin = $auth->createRole('admin');
        $manager = $auth->createRole('manager');
        
        // запишем их в БД
        $auth->add($admin);
        $auth->add($manager);
       
        // Создаем разрешения.
        $fullAccess = $auth->createPermission('fullAccess');
        $fullAccess->description = 'Полный доступ';

        $deleteContact = $auth->createPermission('deleteContact');
        $deleteContact->description = 'Удаление заявки';

        $updateContact = $auth->createPermission('updateContact');
        $updateContact->description = 'Редактирование заявки';

        $moderateContact = $auth->createPermission('moderateContact');
        $moderateContact->description = 'Модерация заявки';

        $viewContact = $auth->createPermission('viewContact');
        $viewContact->description = 'Просмотр заявки';
        
        $baseAccess = $auth->createPermission('baseAccess');
        $baseAccess->description = 'Базовые разрешения';

        // Запишем эти разрешения в БД
        $auth->add($fullAccess);
        $auth->add($baseAccess);
        $auth->add($viewContact);
        $auth->add($deleteContact);
        $auth->add($updateContact);
        $auth->add($moderateContact);

        // Определим роуты
        $indexRoute = $auth->createPermission('/site/index');
        $logoutRoute = $auth->createPermission('/site/logout');
        $errorRoute = $auth->createPermission('/site/error');
        $viewContactRoute = $auth->createPermission('/contact/default/view');
        $deleteContactRoute = $auth->createPermission('/contact/default/delete');
        $updateContactRoute = $auth->createPermission('/contact/default/update');
        $moderateContactRoute = $auth->createPermission('/contact/default/moderate');
        $indexContactRoute = $auth->createPermission('/contact/default/index');
        $fullRoute = $auth->createPermission('/*');

        // Запишем роуты в БД
        $auth->add($indexRoute);
        $auth->add($errorRoute);
        $auth->add($viewContactRoute);
        $auth->add($deleteContactRoute);
        $auth->add($updateContactRoute);
        $auth->add($moderateContactRoute);
        $auth->add($indexContactRoute );
        $auth->add($fullRoute);
        $auth->add($logoutRoute);
        
        // Добавим роуты к разрешениям
        $auth->addChild($fullAccess, $fullRoute);

        $auth->addChild($baseAccess, $indexRoute);
        $auth->addChild($baseAccess, $errorRoute);
        $auth->addChild($baseAccess, $logoutRoute);

        $auth->addChild($viewContact, $viewContactRoute);
        $auth->addChild($viewContact, $indexContactRoute);

        $auth->addChild($deleteContact, $deleteContactRoute);
        $auth->addChild($updateContact, $updateContactRoute);
        $auth->addChild($moderateContact, $moderateContactRoute);



        // Теперь добавим наследования. Для роли admin мы добавим разрешение fullAccess,
        // а для manager добавим наследование от роли editor и еще добавим собственное разрешение viewAdminPage

        // админ
        $auth->addChild($admin, $fullAccess);

        // Роли «Менеджер» присваиваем разрешения
        $auth->addChild($manager, $baseAccess);
        $auth->addChild($manager, $moderateContact);
        $auth->addChild($manager, $viewContact);


        
        // Назначаем роль admin пользователю с ID 1
        $auth->assign($admin, 1); 
        
        // Назначаем роль manager пользователю с ID 2
        $auth->assign($manager, 2);
    }
}