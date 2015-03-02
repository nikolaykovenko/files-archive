<?php
/**
 * @package simpleCMS
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 28.02.15
 */

namespace simpleCMS\controllers;

use simpleCMS\auth\TNeedAuth;

/**
 * Загрузка новых файлов
 * @package simpleCMS\controllers
 */
class Files extends AController
{
    
    use TNeedAuth;

    /**
     * Выполнение контроллера
     * @return string
     * @throws \Exception в случае ошибки
     */
    public function execute()
    {
        $this->setVariable('pageCaption', 'Управление файлами');
        return $this->render('files.twig');
    }
}
