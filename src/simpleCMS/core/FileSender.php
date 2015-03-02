<?php
/**
 * @package simpleCMS
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 02.03.15
 */

namespace simpleCMS\core;

/**
 * Отправка файлов браузеру как бинарных файлов
 */
class FileSender
{

    /**
     * @var string файл, который нужно отдать
     */
    protected $filename;

    /**
     * @var string|null новое имя файла. Если null - отдавать под старым именем.
     */
    protected $newFilename;

    /**
     * @var string mimetype
     */
    protected $mimeType = 'application/octet-stream';


    /**
     * Отправка файла
     */
    public function send()
    {
        if (file_exists($this->filename) and $f = @fopen($this->filename, 'rb')) {
            $filesize = filesize($this->filename);
            ignore_user_abort(true);
            $from = $to = 0;
            $cr = null;
            if (array_key_exists('HTTP_RANGE', $_SERVER)) {
                $range = substr($_SERVER['HTTP_RANGE'], strpos($_SERVER['HTTP_RANGE'], '=') + 1);
                $from = strtok($range, '-');
                $to = strtok('/');
                if ($to > 0) $to++;
                if ($to) $to -= $from;
                header('HTTP/1.1 206 Partial Content');
                $cr = 'Content-Range: bytes ' . $from . '-' . ($to ? $to . '/' . $to + 1 : $filesize);
            } else {
                header('HTTP/1.1 200 Ok');
            }
            
            header('Accept-Ranges: bytes');
            header('Content-Length: ' . ($filesize - $to + $from));
            if ($cr) {
                header($cr);
            }
            
            header('Content-Type: ' . $this->mimeType);
            header('Content-Disposition: attachment; filename="' . $this->getFilenameToOutput() . '";');
            header('Content-Transfer-Encoding: binary');
            header('Last-Modified: ' . gmdate('r', filemtime($this->filename)));
            if ($from) {
                fseek($f, $from, SEEK_SET);
            }
            
            while (!feof($f) and !connection_status()) {
                echo fread($f, 16384);
            }
            fclose($f);
            ignore_user_abort(false);

            return true;
        }

        return false;
    }

    /**
     * Устанавливает файл для выдачи
     * @param string $filename
     * @return $this
     */
    public function setFilename($filename)
    {
        if (!empty($filename)) $this->filename = $filename;

        return $this;
    }

    /**
     * Устанавливает новое имя файла
     * @param string $filename
     * @return $this
     */
    public function setNewFilename($filename)
    {
        if (!empty($filename)) $this->newFilename = $filename;

        return $this;
    }

    /**
     * Устанавливает mimetype
     * @param string $mimeType
     * @return $this
     */
    public function setMimeType($mimeType)
    {
        if (!empty($mimeType)) $this->mimeType = $mimeType;

        return $this;
    }

    /**
     * Формирует имя файла для отдачи браузеру
     * @return null|string
     */
    public function getFilenameToOutput()
    {
        if (!empty($this->newFilename)) return $this->newFilename; else return basename($this->filename);
    }
}