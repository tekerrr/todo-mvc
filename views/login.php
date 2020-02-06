<?php

include VIEW_DIR . '/layout/header.php';

?>

<section class="auth">
    <form class="custom-form" method="POST" action="/login">
        <h1>Авторизация</h1>
        <label for="email">Логин:</label>
        <input type="text" name="login" id="email" value="" autocomplete="username">
        <br>
        <label for="password">Пароль:</label>
        <input type="password" name="password" id="password" value="" autocomplete="current-password">
        <br>
        <input class="button" type="submit" value="Войти">
    </form>
</section>

<?php

include VIEW_DIR . '/layout/footer.php';

?>
