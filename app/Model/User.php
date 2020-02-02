<?php

namespace App\Model;

class User extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['login', 'password'];

    public static function createUser(string $login, string $password): ?User
    {
        if (self::where('login', $login)->exists()) {
            return null;
        }

        return self::create([
            'login' => $login,
            'password' => self::getPasswordHash($password),
        ]);
    }

    public static function login(string $login, string $password): ?User
    {
        if (($user = self::where('login', $login)->first()) && $user->passwordVerify($password)) {
            return $user;
        }

        return null;
    }

    private static function getPasswordHash(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    private function passwordVerify(string $password): bool
    {
        return password_verify($password, $this->password);
    }
}
