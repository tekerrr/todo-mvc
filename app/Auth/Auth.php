<?php

namespace App\Auth;

use App\Model\User;

class Auth // Singleton
{
    /*** @var Auth */
    private static $instance;

    private function __construct() {}
    private function __clone() {}
    private function __wakeup() {}

    public static function getInstance(): Auth
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public function run(): void
    {
        $this->startSession();

        if ($this->isAuthorized()) {
            $this->setLoginToCookies();
        } else {
            $this->logout();
        }
    }

    public function login(User $user): void
    {
        $this->setUserToSession($user);
        $this->setLoginToCookies();
    }

    public function logout(): void
    {
        $this->deleteUserFromSession();
        $this->deleteLoginFromCookies();
    }

    public function getUser(): ?User
    {
        return $this->getFromSession('user') ?? null;
    }

    private function isAuthorized(): bool
    {
        return ($login = $this->getFromSession('user.login'))
            && ($login2 = $this->getFromCookies('login'))
            && $login === $login2;
    }

    private function startSession()
    {
        ($session = new Session())->start();
    }

    private function getFromSession(string $request, $default = null)
    {
        return (new Session())->get($request, $default);
    }

    private function getFromCookies(string $request, $default = null)
    {
        return (new Cookies())->get($request, $default);
    }

    private function setLoginToCookies(): void
    {
        (new Cookies())->set('login', $this->getFromSession('user.login'));
    }

    private function setUserToSession(User $user)
    {
        $session = new Session();
        $session->clean();
        $session->put('user', $user);
    }

    private function deleteLoginFromCookies(): void
    {
        (new Cookies())->clean(['login']);
    }

    private function deleteUserFromSession()
    {
        (new Session())->delete('user');
    }
}
