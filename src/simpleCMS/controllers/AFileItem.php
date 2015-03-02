<?php
/**
 * @package simpleCMS
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 02.03.15
 */

namespace simpleCMS\controllers;

use simpleCMS\auth\TNeedAuth;
use simpleCMS\exceptions\Exception404;
use simpleCMS\model\AModel;
use simpleCMS\model\UserFiles;

/**
 * Абстрактный конттроллер для выполнения действия над файлами
 * @package simpleCMS\controllers
 */
abstract class AFileItem extends AController
{

    use TNeedAuth;

    /**
     * @var AModel
     */
    protected $model;

    /**
     * Получение элемента файла
     * @param null|int $id
     * @return \stdClass
     * @throws Exception404
     */
    protected function getItem($id = null)
    {
        $account = $this->appHelper->getComponent('authAgent')->getAuthenticatedUserInfo();
        
        if (is_null($id)) {
            if (!isset($_GET['id'])) {
                throw new Exception404();
            }
            $id = $_GET['id'];
        }

        $item = $this->getModel()->findOne("`id` = :id and `user_id` = :user_id", ['id' => $id, 'user_id' => $account->id]);
        if (empty($item)) {
            throw new Exception404();
        }
        
        return $item;
    }

    /**
     * Возвращает модель файлов
     * @return AModel
     */
    protected function getModel()
    {
        if (empty($this->model)) {
            $this->model = new UserFiles();
        }
        
        return $this->model;
    }
}
