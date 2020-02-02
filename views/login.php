<?php

include VIEW_DIR . '/layout/header.php';

?>

<form method="POST" action="/login">
    <label for="email">Логин:</label>
    <input type="text" name="login" id="email" value="" autocomplete="username">
    <br>
    <label for="password">Пароль:</label>
    <input type="password" name="password" id="password" value="" autocomplete="current-password">
    <br>
    <input type="submit" value="Войти">
</form>

<?php

include VIEW_DIR . '/layout/footer.php';

?>
