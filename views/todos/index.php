<?php

include VIEW_DIR . '/layout/header.php';

?>

<section class="todos">
    <h1>Свои списки</h1>
    <ul>
        <?php foreach ($todos as $todo): ?>
            <li>
                <form method="POST" action="/todos/<?=$todo->id?>">
                    <a href="/todos/<?=$todo->id?>"><?=$todo->name?></a>
                    <input type="hidden" name="_method" value="DELETE">
                    <input class="button-small" type="submit" value="[x]">
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
    <form class="custom-form" method="POST" action="/todos">
        <input type="text" name="name" value="">
        <br>
        <input class="button" type="submit" value="Создать">
    </form>
</section>

<?php

include VIEW_DIR . '/layout/footer.php';

?>
