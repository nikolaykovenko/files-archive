<?php
/**
 * @package simpleCMS
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 23.02.15
 */

return [
    'db' => [
        'dsn' => 'mysql:host=localhost;dbname=files_archive',
        'user' => 'root',
        'pass' => '123',
        'charset' => 'utf8',
    ],
    'templatesPath' => __DIR__ . '/templates',
    'siteTitle' => 'Архив файлов',
    'mainNav' => [
        'files-upload' => 'Загрузить новый файл',
        'files-list' => 'Список загруженных файлов',
        'profile-edit' => 'Персональная информация',
        'logout' => 'Выйти',
    ],
    
    'maxFilesCount' => 20,
    'maxFileSize' => 1,
];
