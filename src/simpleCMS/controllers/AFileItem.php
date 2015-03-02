<?php
/**
 * @package simpleCMS
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 02.03.15
 */

namespace simpleCMS\controllers;

use simpleCMS\auth\TNeedAuth;
use simpleCMS\exceptions\Exception404;
use simpleCMS\model\UserFiles;

/**
 * Абстрактный конттроллер для выполнения действия над файлами
 * @package simpleCMS\controllers
 */
abstract class AFileItem extends AController
{

    use TNeedAuth;

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

        $model = new UserFiles();
        $item = $model->findOne("`id` = :id and `user_id` = :user_id", ['id' => $id, 'user_id' => $account->id]);
        if (empty($item)) {
            throw new Exception404();
        }
        
        return $item;
    }
}
