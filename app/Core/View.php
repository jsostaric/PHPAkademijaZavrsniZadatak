<?php


namespace App\Core;


class View
{
    protected const VIEW_PATH = BP . DIRECTORY_SEPARATOR . 'view';

    public function render($name, $args = [])
    {
        $viewFile = $this->getViewFile($name);

        ob_start();

        extract($args);
        include $viewFile;

        echo $content = ob_get_clean();

        return $this;
    }

    protected function getViewFile($name)
    {
        return self::VIEW_PATH . DIRECTORY_SEPARATOR . $name . '.phtml';
    }
}