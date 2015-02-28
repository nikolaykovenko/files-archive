<?php
/**
 * @package simpleCMS
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 28.02.15
 */

namespace simpleCMS\auth;

use simpleCMS\core\ApplicationHelper;
use simpleCMS\exceptions\UserNotAuthenticatedException;

/**
 * Трейт для контроллера, который должен быть доступным только для авторизированого пользователя
 * @package simpleCMS\auth
 */
trait TNeedAuth
{

    /**
     * Проверка авторизации пользователя
     * @return true
     * @throws UserNotAuthenticatedException в случае отсутствия авторизации
     */
    public function testAuth()
    {
        /** @var AuthAgent $authAgent */
        $authAgent = ApplicationHelper::getInstance()->getComponent('authAgent');
        $user = $authAgent->getAuthenticatedUserInfo();
        if ($user === false) {
            throw new UserNotAuthenticatedException('not authenticated');
        }
        
        return true;
    }
}
