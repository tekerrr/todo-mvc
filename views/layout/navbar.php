<?php if ($user = \App\Auth\Auth::getInstance()->getUser()): ?>
    <p><?=$user->login?><a href="/logout">Выйти</a></p>
<?php else: ?>
    <p><a href="/login">Войти</a></p>
<?php endif; ?><?php
