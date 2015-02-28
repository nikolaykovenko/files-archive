<?php
/**
 * @package NCMS
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 28.02.15
 */

namespace simpleCMS\controllers;

use simpleCMS\auth\TNeedAuth;
use simpleCMS\model\Users;

/**
 * Обработчик формы изменения профайла
 * @package simpleCMS\controllers
 */
class ProfileEditPost extends AController
{
    
    use TNeedAuth;

    /**
     * Выполнение контроллера
     * @return string
     * @throws \Exception в случае ошибки
     */
    public function execute()
    {
        parse_str($_POST['form'], $params);

        try {
            $model = new Users();
            $item = $model->initItem($params, $this->appHelper->getComponent('authAgent')->getAuthenticatedUserInfo());
            $item->password_repeat = $params['password_repeat'];

            $model->updateItem($item);

            $this
                ->setVariable('status', 'ok')
                ->setVariable('message', 'Изменения успешно внесены');

        } catch (\Exception $e) {
            $this
                ->setVariable('status', 'error')
                ->setVariable('message', $e->getMessage());
        }

        return $this->render('json-result.twig', false);
    }
}
