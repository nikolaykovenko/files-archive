<?php
/**
 * @package simpleCMS
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 28.02.15
 */

namespace simpleCMS\model;

use simpleCMS\auth\IdentifyInterface;
use simpleCMS\exceptions\ValidationException;

/**
 * Модель пользователей
 * @package simpleCMS\model
 */
class Users extends AModel implements IdentifyInterface
{

    /**
     * Возвращает название таиблицы в БД
     * @return string
     */
    public function getTableName()
    {
        return 'users';
    }

    /**
     * Параметры, которые можно присваивать в матоматическом режиме
     * @return array
     */
    public function attributes()
    {
        return [
            'login' => ['required'],
            'password' => ['required'],
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => [],
            'tel' => [],
            'birth_date' => [],
        ];
    }

    /**
     * Поиск аккаунта пользователя по логину и паролю
     * @param string $login
     * @param string $password
     * @return \stdClass
     */
    public function findByLoginAndPass($login, $password)
    {
        return $this->findOne(
            "`login` = :login and `password` = :password",
            ['login' => $login, 'password' => md5($password)]
        );
    }

    /**
     * Возвращает информацию о пользователе по ID
     * @param int $userId
     * @return array|false
     */
    public function findById($userId)
    {
        $item = $this->findOne("`id` = :id", ['id' => $userId]);
        if (empty($item)) {
            return false;
        }
        
        return $item;
    }

    /**
     * @inheritdoc
     */
    public function insert(\stdClass $instance)
    {
        $this->validatePasswords($instance);
        
        if ($this->findOne('login = :login', ['login' => $instance->login])) {
            throw new ValidationException('К сожалению, логин ' . $instance->login . ' уже занят');
        }
        
        if (!empty($instance->password)) {
            $instance->password = md5($instance->password);
        }
        
        return parent::insert($instance);
    }

    /**
     * @inheritdoc
     */
    public function updateItem(\stdClass $instance)
    {
        $this->validatePasswords($instance);
        
        if (!empty($instance->password)) {
            $instance->password = md5($instance->password);
        }
        
        $oldInstance = $this->findOne("`id` = :id", ['id' => $instance->id]);
        $instance->login = $oldInstance->login;
        
        return parent::updateItem($instance);
    }
    


    /**
     * Валидация паролей
     * @param \stdClass $instance
     * @return bool
     * @throws ValidationException
     */
    private function validatePasswords(\stdClass $instance)
    {
        if ($instance->password != $instance->password_repeat) {
            throw new ValidationException('Пароли не совпадают');
        }
        
        return true;
    }

    /**
     * Параметр, отвечающий за хранение всей истории записей модели в специальной таблице
     * @return bool
     */
    public function saveDataHistory()
    {
        return true;
    }
}
