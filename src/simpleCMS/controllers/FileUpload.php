<?php
/**
 * @package NCMS
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 28.02.15
 */

namespace simpleCMS\controllers;

use simpleCMS\auth\TNeedAuth;
use simpleCMS\core\FilesUploader;
use simpleCMS\model\UserFiles;

/**
 * Загрузка нового файла
 * @package simpleCMS\controllers
 */
class FileUpload extends AController
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
        
        $maxFilesCount = $this->appHelper->getConfigParam('maxFilesCount');
        if ($filesModel->getUserFilesCount($account->id) >= $maxFilesCount) {
            return $this->returnError('Вы не можете загрузить больше чем ' . $maxFilesCount . ' файлов');
        } 
        
        
        $uploader = new FilesUploader();
        $uploader->sizeLimit = $this->appHelper->getConfigParam('maxFileSize');
        $uploader->inputName = "qqfile";
        
        $result = $uploader->handleUpload($this->appHelper->getConfigParam('filesDir'));
        if (isset($result['error'])) {
            return $this->returnError($result['error']);
        }
        

        $instance = $filesModel->initItem([
            'user_id' => $account->id,
            'file_name' => $uploader->getName(),
            'file' => $uploader->getUploadName(),
        ]);
        try {
            $filesModel->insert($instance);
            $this
                ->setVariable('success', true)
                ->setVariable('message', 'Файл успешно загружен');
            
        } catch (\Exception $e) {
            $this->returnError($e->getMessage());
        }
        
        return $this->render('json-result.twig', false);
    }

    /**
     * Возвращает ошибку
     * @param string $errorMessage
     * @return string
     */
    private function returnError($errorMessage)
    {
        $this
            ->setVariable('success', false)
            ->setVariable('message', $errorMessage);
        
        return $this->render('json-result.twig', false);
    }
}
