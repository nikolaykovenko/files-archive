<?php
/**
 * @package simpleCMS
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 02.03.15
 */

namespace simpleCMS\core;

/**
 * Компонент для определения размеров файлов
 * @package simpleCMS\core
 */
class FileSize
{

    /**
     * Возвращает размер файла в понятном пользователю виде
     * @param string $fileName
     * @param string|null $dir
     * @return bool|int
     */
    public static function getPrettyFileSize($fileName, $dir = null)
    {
        $result = static::getFileSize($fileName, $dir);
        if ($result !== false) {
            if ($result > 1024 * 1024) {
                $result = round($result / 1024 / 1024, 2) . ' MB'; 
            } elseif ($result > 1024) {
                $result = round($result / 1024) . ' KB';
            }
        }
        
        return $result;
    }

    /**
     * Возвращает размер файла в байтах
     * @param string $fileName
     * @param string|null $dir
     * @return bool|int
     */
    public static function getFileSize($fileName, $dir = null)
    {
        if (is_null($dir)) {
            $dir = static::getAppHelper()->getConfigParam('filesDir');
        }
        
        if (mb_substr($dir, -1, 1, 'utf-8') != '/') {
            $dir .= '/';
        }
        
        $file = $dir . $fileName;
        if (filesize($file)) {
            return filesize($file);
        }
        
        return false;
    }

    /**
     * Возвращает элемент ApplicationHelper
     * @return ApplicationHelper
     */
    protected static function getAppHelper()
    {
        return ApplicationHelper::getInstance();
    }
}
