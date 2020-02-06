<section class="navbar">
    <ul>
        <li><a href="/">Главная</a></li>
        <?php if ($user = \App\Auth\Auth::getInstance()->getUser()): ?>
            <li><a href="/todos">Свои списки</a></li>
            <li><a href="/logout">Выйти</a></li>
        <?php else: ?>
            <li><a href="/login">Войти</a></li>
            <li><a href="/registration">Регистрация</a></li>
        <?php endif; ?>
    </ul>
</section>


