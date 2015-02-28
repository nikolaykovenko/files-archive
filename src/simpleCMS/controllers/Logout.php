<?php
/**
 * @package simpleCMS
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 28.02.15
 */

namespace simpleCMS\controllers;

/**
 * Контроллер для выхода из системы
 * @package simpleCMS\controllers
 */
class Logout extends AController
{

    /**
     * Выполнение контроллера
     * @return string
     * @throws \Exception в случае ошибки
     */
    public function execute()
    {
        $this->appHelper->getComponent('authAgent')->logout();
        $this->redirect('index.php');
    }
}
