<?php
/**
 * @package default
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 28.02.15
 */

namespace simpleCMS\controllers;
use simpleCMS\model\Users;

/**
 * Обработчик формы
 * @package simpleCMS\controllers
 */
class RegisterPost extends AController
{

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
            $item = $model->initItem($params);
            $item->password_repeat = $params['password_repeat'];
            
            $model->insert($item);
            $this->appHelper->getComponent('authAgent')->auth($item->login, $params['password']);
            
            $this
                ->setVariable('status', 'ok')
                ->setVariable('message', 'Вы успешно зарегистрировались!');
            
        } catch (\Exception $e) {
            $this
                ->setVariable('status', 'error')
                ->setVariable('message', $e->getMessage());
        }
        
        return $this->render('json-result.twig', false);
        
    }
}
