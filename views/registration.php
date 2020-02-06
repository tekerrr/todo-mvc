<?php

include VIEW_DIR . '/layout/header.php';

?>

<section class="auth">
    <form class="custom-form" method="POST" action="/registration">
        <h1>Регистрация</h1>
        <label for="email">Логин:</label>
        <input type="text" name="login" id="email" value="" autocomplete="username">
        <br>
        <label for="password">Пароль:</label>
        <input type="password" name="password" id="password" value="" autocomplete="new-password">
        <br>
        <input class="button" type="submit" value="Зарегистрироваться">
    </form>
</section>

<?php

include VIEW_DIR . '/layout/footer.php';

?>
