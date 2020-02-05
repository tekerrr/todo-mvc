<?php

include VIEW_DIR . '/layout/header.php';

?>

<div><a href="/steps">Todo</a></div>

<form method="POST" action="/test">
    <input type="submit" value="Тест POST">
</form>

<form method="POST" action="/test">
    <input type="hidden" name="_method" value="PUT">
    <input type="submit" value="Тест PUT">
</form>

<form method="POST" action="/test">
    <input type="hidden" name="_method" value="DELETE">
    <input type="submit" value="Тест DELETE">
</form>

<?php

include VIEW_DIR . '/layout/footer.php';

?>
