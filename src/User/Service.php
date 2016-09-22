<?php

class Service
{
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
    public function __construct($pathToTemp)
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


    protected function initUsers()
    {
        $this->users = array();
        $userInfo    = json_decode(file_get_contents($this->pathToTemp . "info.json"), true);
        foreach ($userInfo as $userData) {
            $user                   = new User($userData);
            $userName               = $userData["name"];
            $this->users[$userName] = $user;
        }
    }
}
