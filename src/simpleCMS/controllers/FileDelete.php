<?php
/**
 * @package simpleCMS
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 02.03.15
 */

namespace simpleCMS\controllers;

/**
 * Удаление файлов
 * @package simpleCMS\controllers
 */
class FileDelete extends AFileItem
{

    /**
     * Выполнение контроллера
     * @return string
     * @throws \Exception в случае ошибки
     */
    public function execute()
    {
        $item = $this->getItem();
        
        try {
            $this->getModel()->deleteItem($item->id);
            $this->setVariable('status', 'ok');
            
        } catch (\Exception $e) {
            $this->setVariable('status', 'error');
            $this->setVariable('message', $e->getMessage());
        }
        
        return $this->render('json-result.twig');
    }
}
