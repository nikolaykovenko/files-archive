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
        'files' => 'Управление файлами',
        'profile-edit' => 'Персональная информация',
        'logout' => 'Выйти',
    ],
    
//    Директория для загрузки файлов
    'filesDir' => __DIR__ . '/upload_files/',
    
//    Максимальное количество файлов для одного пользователя
    'maxFilesCount' => 20,
    
//    Максимальный размер файла в байтах
    'maxFileSize' => 1 * 1024 * 1024,
];
