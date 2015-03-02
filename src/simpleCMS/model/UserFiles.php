<?php
/**
 * @package simpleCMS
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 28.02.15
 */

namespace simpleCMS\model;

/**
 * Модель пользовательских файлов
 * @package simpleCMS\model
 */
class UserFiles extends AModel
{

    /**
     * Возвращает список файлов пользователя
     * @param int $userId
     * @return array
     */
    public function getUserFiles($userId)
    {
        return $this->findAll("`user_id` = :user_id", ['user_id' => $userId]);
    }
    
    /**
     * Возвращает количество загруженных файлов пользователя
     * @param int $userId
     * @return int
     * @throws \Exception
     */
    public function getUserFilesCount($userId)
    {
        $sth = $this->dbh->prepare(
            $query = "select count(`id`) as `count` from {$this->getTableName()} where `user_id` = :user_id and `deleted` = 0"
        );
        $sth->setFetchMode(\PDO::FETCH_OBJ);
        $this->execute($sth, ['user_id' => $userId]);
        
        return (int) $sth->fetch()->count;
    }

    /**
     * Возвращает название таиблицы в БД
     * @return string
     */
    public function getTableName()
    {
        return 'user_files';
    }

    /**
     * Параметры модели
     * Для валидации и автоматического присвоения
     * @return array
     */
    public function attributes()
    {
        return [
            'user_id' => ['required'],
            'file_name' => ['required'],
            'file' => ['required'],
            'deleted' => [],
        ];
    }

    /**
     * Параметр, отвечающий за хранение всей истории записей модели в специальной таблице
     * @return true
     */
    public function saveDataHistory()
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    public function deleteItem($itemId)
    {
        $item = $this->findOne("`id` = :id", ['id' => $itemId]);
        if (empty($item)) {
            throw new \Exception('Элемент не найден');
        }
        
        if (!empty($item->file)) {
            $file = $this->appHelper->getConfigParam('filesDir') . $item->file;
            if (file_exists($file)) {
                if (!unlink($file)) {
                    throw new \Exception('Не удалось удалить файл');
                }
            }
        }
        
        $item->deleted = 1;
        
        return $this->updateItem($item);
    }
    
    
    
    

    /**
     * @inheritdoc
     */
    protected function orderBy()
    {
        return "`deleted`, `id` desc";
    }
}
