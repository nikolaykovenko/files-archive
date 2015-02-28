<?php
/**
 * @package NCMS
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 28.02.15
 */

namespace simpleCMS\auth;


/**
 * Интерфейс для моделей, которые хранят данные о пользователях
 * @package simpleCMS\auth
 */
interface IdentifyInterface
{

    /**
     * Поиск аккаунта пользователя по логину и паролю
     * @param string $login
     * @param string $password
     * @return \stdClass
     */
    public function findByLoginAndPass($login, $password);

    /**
     * Возвращает информацию о пользователе по ID
     * @param int $userId
     * @return array|false
     */
    public function findById($userId);
}
