<?php

namespace Messenger\User;

use Messenger\User\User;

class UserService
{
    /**
     * @var UserService
     */
    protected static $instance;

    /**
     * @var User[]
     */
    protected $users;
    /**
     * @var string
     */
    protected $pathToTemp;

    /**
     * Service constructor.
     *
     * @param $pathToTemp
     */
    protected function __construct($pathToTemp)
    {
        $this->pathToTemp = $pathToTemp;
        $this->initUsers();
    }


    /**
     * Возвращает список сущностей Юзеров.
     *
     * @return array
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Возвращает список сущностей Юзеров.
     *
     * @return array
     */
    public function getUsersNames()
    {
        return array_keys($this->users);
    }

    /**
     * Возвращает пользователя по нику.
     *
     * @param $name
     *
     * @return User
     */
    public function getUserByName($name)
    {
        $users = $this->users;

        return $users[$name];
    }


    /**
     * Инициализирует всех доступных пользователей.
     */
    protected function initUsers()
    {
        $this->users = array();
        $fileBody    = file_get_contents($this->pathToTemp . "/info.json");
        $userInfo    = json_decode($fileBody, true);
        foreach ($userInfo as $userData) {

            $user                   = new User($userData);
            $userName               = $userData["name"];
            $this->users[$userName] = $user;
        }
    }

    /**
     * @param $pathToTemp
     *
     * @return UserService
     */
    public static function getInstance($pathToTemp)
    {
        if (is_null(self::$instance)) {
            self::$instance = new self($pathToTemp);
        }

        return self::$instance;
    }
}
