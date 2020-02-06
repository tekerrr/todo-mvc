<?php

include VIEW_DIR . '/layout/header.php';

?>

<form method="POST" action="/registration">
    <label for="email">Логин:</label>
    <input type="text" name="login" id="email" value="" autocomplete="username">
    <br>
    <label for="password">Пароль:</label>
    <input type="password" name="password" id="password" value="" autocomplete="new-password">
    <br>
    <input type="submit" value="Зарегистрироваться">
</form>

<?php

include VIEW_DIR . '/layout/footer.php';

?>
