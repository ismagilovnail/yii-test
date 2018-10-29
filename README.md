# Тестовое приложение на Yii2

Приложение для сбора заявок (форма обратной связи)
## Получить исходный код через Composer
    composer create-project --prefer-dist --stability=dev ismagilovnail/yii-test
### Настройка приложения
1. Настройка конфигурации БД
    - Файл /common/config/main-local.php
	```
	'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=database',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
	```
    
2. Настройка веб - сервера
     - Прописываем свой baseUrl Фронденда файл /backend/config/main.php
	```
	        'urlManagerFrontend' => [
            'class' => 'yii\web\UrlManager',
            'baseUrl' => '',
        ],
	```
    - В конфиге вебсервера указать пути (домена/поддомена) к папкам:
    ```
    Для админ-панели /backend/web/
    Для клиентской части /frontend/web/
    ```

    
3. Запустите последовательно консольные команды на все вопросы отвечаем "Yes"
- Инициализируем в режиме "dev"
``init``

``yii migrate``

- Создание админа
``yii admin/create``

- Создание менеджера
``yii manager/create``

- Инициализация прав доступа
``yii manager/create``

4. Настройка почтового клиента
     - Прописываем свои данные. файл /backend/config/main.php
	```
    'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.yandex.ru',
                'username' => 'yandex@yandex.ru',
                'password' => 'pass',
                'port' => '465',
                'encryption' => 'ssl',
            ],
        ],
	```

