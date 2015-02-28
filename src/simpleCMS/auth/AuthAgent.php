<?php
/**
 * @package simpleCMS
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 28.02.15
 */

namespace simpleCMS\auth;

/**
 * Агент для авторизации и идентификации пользователя
 * @package simpleCMS\auth
 */
class AuthAgent
{

    /**
     * @var IdentifyInterface модель пользователя
     */
    private $usersModel;

    /**
     * Конструктор
     * @param IdentifyInterface $usersModel
     */
    public function __construct(IdentifyInterface $usersModel)
    {
        $this->usersModel = $usersModel;
    }

    /**
     * Првоеряет авторизацию пользователя
     * @return bool|int возвращает id аккаунта пользователя или false
     */
    public function isAuthenticated() 
    {
        if (isset($_SESSION[$this->sessionKey()]) and !empty($_SESSION[$this->sessionKey()])) {
            return $_SESSION[$this->sessionKey()];
        }
        
        return false;
    }

    /**
     * Возвращает информацию об авторизированном пользователе
     * @return array|false
     */
    public function getAuthenticatedUserInfo()
    {
        $userId = $this->isAuthenticated();
        if (!$userId) {
            return false;
        }
        
        $userItem = $this->usersModel->findById($userId);
        if (empty($userItem)) {
            return false;
        }
        
        return $userItem;
    }

    /**
     * Авторизация пользователя
     * @param string $login
     * @param string $password
     * @return bool
     */
    public function auth($login, $password)
    {
        $user = $this->usersModel->findByLoginAndPass($login, $password);
        if (empty($user) or !isset($user->id) or empty($user->id)) {
            return false;
        }
        
        $_SESSION[$this->sessionKey()] = $user->id;
        return $user->id;
    }

    /**
     * Выход пользователя из системы
     * @return bool
     */
    public function logout()
    {
        if ($this->isAuthenticated()) {
            unset($_SESSION[$this->sessionKey()]);
            return true;
        }
        
        return false;
    }
    
    

    /**
     * Возвращает ключ хранения id пользователя
     * @return string
     */
    private function sessionKey()
    {
        return __CLASS__ . '_auth_user_id';
    }
}
