<?php


namespace b4djo\vk\app;

/**
 * Class AutoLoader
 * @package app\lib
 */
class AutoLoader {

    /**
     * Ассоциативный массив
     * Ключи содержат префикс пространства имён,
     * значение — массив базовых директорий для классов в этом пространстве имён
     *
     * @var array
     */
    protected $prefixToPath = [];

    /**
     * Регистрируем автозагрузчик
     * @return void
     */
    public function register()
    {
        spl_autoload_register([$this, 'loadClass'], true);
    }

    /**
     * Добавляем соответствующие префиксам базовые директории
     * @param $prefix
     * @param $base_dir
     * @param bool|false $prepend
     * @return void
     */
    public function addNamespace($prefix, $base_dir, $prepend = false)
    {
        $prefix = trim($prefix, '\\') . '\\';
        $base_dir = rtrim($base_dir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        if (isset($this->prefixToPath[$prefix]) === false) {
            $this->prefixToPath[$prefix] = array();
        }
        if ($prepend) {
            array_unshift($this->prefixToPath[$prefix], $base_dir);
        } else {
            array_push($this->prefixToPath[$prefix], $base_dir);
        }
    }

    /**
     * Загружаем файл, соответствющий классу
     * @param $class
     * @return bool|string
     */
    public function loadClass($class)
    {
        $prefix = '';
        $arr = explode('\\', $class);
        while (count($arr) > 0) {
            $prefix .= array_shift($arr) . '\\';
            $file = $this->loadMappedFile($prefix, $arr);
            if ($file) {
                return $file;
            }
        }
        return false;
    }

    /**
     * @param $prefix
     * @param $arr
     * @return bool|string
     */
    protected function loadMappedFile($prefix, $arr)
    {
        if (isset($this->prefixToPath[$prefix]) === false) {
            return false;
        }
        foreach ($this->prefixToPath[$prefix] as $base_dir) {
            $file = $base_dir . implode($arr, DIRECTORY_SEPARATOR) . '.php';
            if ($this->requireFile($file)) {
                return $file;
            }
        }
        return false;
    }

    /**
     * @param $file
     * @return bool
     */
    protected function requireFile($file)
    {
        if (file_exists($file)) {
            require_once $file;
            return true;
        }
        return false;
    }
}