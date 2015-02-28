<?php
/**
 * @package simpleCMS
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 28.02.15
 */

namespace simpleCMS\controllers;

use simpleCMS\auth\TNeedAuth;

/**
 * Страница редактирования информации о клиенте
 * @package simpleCMS\controllers
 */
class ProfileEdit extends AController
{
    
    use TNeedAuth;

    /**
     * Выполнение контроллера
     * @return string
     * @throws \Exception в случае ошибки
     */
    public function execute()
    {
        $this
            ->setVariable('pageCaption', 'Персональная информация')
            ->setVariable('account', $this->appHelper->getComponent('authAgent')->getAuthenticatedUserInfo());
        
        return $this->render('forms/edit-profile.twig');
    }
}
