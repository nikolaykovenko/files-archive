<?php
/**
 * @package simpleCMS
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 28.02.15
 */

namespace simpleCMS\controllers;
use simpleCMS\auth\AuthAgent;


/**
 * Контроллер авторизаци пользователя
 * @package simpleCMS\controllers
 */
class Login extends AController
{

    /**
     * Выполнение контроллера
     * @return string
     * @throws \Exception в случае ошибки
     */
    public function execute()
    {
        if (!empty($_POST)) {
            /** @var AuthAgent $authAgent */
            $authAgent = $this->appHelper->getComponent('authAgent');
            if ($authAgent->auth($_POST['login'], $_POST['password'])) {
                $this->redirect('index.php');
            }
            
            $this->setVariable('error', 'Ошибка авторизации');
        }
        
        $this->setVariable('pageCaption', 'Авторизация');
        return $this->render('forms/login.twig');
    }
}
