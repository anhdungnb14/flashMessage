<?php

class flash
{
    const FLASH = 'FLASH_MESSAGES';
    const FLASH_ERROR = 'danger';
    const FLASH_WARNING = 'warning';
    const FLASH_INFO = 'info';
    const FLASH_SUCCESS = 'success';

    public function __construct()
    {
        session_start();
    }

    public function createFlashMessage($name = '', $message = '', $type = '')
    {
        if (isset($_SESSION[self::FLASH][$name])) {
            unset($_SESSION[self::FLASH][$name]);
        }
        $_SESSION[self::FLASH][$name] = ['message' => $message, 'type' => $type];
    }

    public function formatFlashMessage($flashMessage)
    {
        return "<div class='alert  alert-{$flashMessage['type']} d-flex justify-content-between align-items-center'
             role='alert'>
            <div>{$flashMessage['message']}</div>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
    }

    public function displayFlashMessage($name)
    {
        if (!isset($_SESSION[self::FLASH][$name])) {
            return;
        }
        $flash_message = $_SESSION[self::FLASH][$name];

        unset($_SESSION[self::FLASH][$name]);
        echo $this->formatFlashMessage($flash_message);
    }

    public function displayAllFlashMessage()
    {
        if (!isset($_SESSION[self::FLASH])) {
            return;
        }
        $flash_messages = $_SESSION[self::FLASH];
        unset($_SESSION[self::FLASH]);
        foreach ($flash_messages as $flash_message) {
            echo $this->formatFlashMessage($flash_message);

        }
    }

    public function flash($name = '', $message = '', $type = '')
    {
        if ($name !== '' && $message !== '' && $type !== '') {
            $this->createFlashMessage($name, $message, $type);
        } elseif ($name !== '' && $message === '' && $type === '') {
            $this->displayFlashMessage($name);
        } elseif ($name === '' && $message === '' && $type === '') {
            $this->displayAllFlashMessage();
        }
    }
}

