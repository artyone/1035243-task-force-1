<?php


namespace app\models;


class User
{
    private $email;
    private $name;
    private $creationTime;
    private $role;

    static public function getRole(int $user): ?string
    {
        $tempArrayCustomer = [1, 2, 3, 4];
        $tempArrayExecutor = [5, 6, 7, 8];
        if (in_array($user, $tempArrayCustomer)) {
            return 'customer';
        }
        if (in_array($user, $tempArrayExecutor)) {
            return 'executor';
        }

        return null;

    }
}
