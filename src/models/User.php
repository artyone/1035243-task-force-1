<?php


namespace app\models;


class User
{
    private $email;
    private $password_hash;
    private $name;
    private $creation_time;
    private $avatar;

    static public function isExecutor(int $user): bool
    {
        $tempArrayExecutor = [5, 6, 7, 8];
        if (in_array($user, $tempArrayExecutor)) {
            return true;
        }

        return false;

    }

    static public function isCustomer(int $user): bool
    {
        $tempArrayCustomer = [1, 2, 3, 4];
        if (in_array($user, $tempArrayCustomer)) {
            return true;
        }

        return false;

    }
}
