<?php
/**
 * @package simpleCMS
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 28.02.15
 */

namespace simpleCMS\controllers;

use simpleCMS\auth\TNeedAuth;
use simpleCMS\model\UserFiles;

/**
 * Получение списка файлов
 * @package simpleCMS\controllers
 */
class GetFilesList extends AController
{
    
    use TNeedAuth;

    /**
     * Выполнение контроллера
     * @return string
     * @throws \Exception в случае ошибки
     */
    public function execute()
    {
        $account = $this->appHelper->getComponent('authAgent')->getAuthenticatedUserInfo();
        $filesModel = new UserFiles();

        $this
            ->setVariable('filesUploadedCount', $filesModel->getUserFilesCount($account->id))
            ->setVariable('filesList', $filesModel->getUserFiles($account->id));
        
        return $this->render('files-list.twig', false);
    }
}
