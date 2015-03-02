<?php
/**
 * @package simpleCMS
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 02.03.15
 */

namespace simpleCMS\controllers;

use simpleCMS\core\FileSender;

/**
 * Скачивание файла
 * @package simpleCMS\controllers
 */
class FileDownload extends AFileItem
{

    /**
     * Выполнение контроллера
     * @return string
     * @throws \Exception в случае ошибки
     */
    public function execute()
    {
        $item = $this->getItem();
        
        /** @var fileSender $fileSender */
        $fileSender = $this->appHelper->getComponent('fileSender');
        
        $fileSender
            ->setFilename($this->appHelper->getConfigParam('filesDir') . $item->file)
            ->setNewFilename($item->file_name);
        
        $this->appHelper->getConfigParam('filesDir' . $item->file);
        
        if (!$fileSender->send()) {
            throw new \Exception('unknown error');
        }
        
        return true;
    }
}
