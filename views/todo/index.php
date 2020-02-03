<?php

include VIEW_DIR . '/layout/header.php';

?>

<div>
    <form method="POST" action="/steps">
        <input name="body">
        <input type="submit" value="Добавить шаг">
    </form>
</div>

<div>
    <ol>
        <?php foreach ($todo->steps as $step): ?>

            <li>
                <p><?=$step->body?></p>
                <p><?=$step->is_completed ? 'завершён' : 'незавершён'?></p>
                <form method="POST" action="/steps/<?=$step->id?>/<?=$step->is_completed ? 'uncomplete' : 'complete'?>">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="submit" value="<?=$step->is_completed ? 'незавершить' : 'завершить'?>">
                </form>
                <form method="POST" action="/steps/<?=$step->id?>">
                    <input type="hidden" name="_method" value="PUT">
                    <input name="body">
                    <input type="submit" value="Изменить">
                </form>
                <form method="POST" action="/steps/<?=$step->id?>">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="submit" value="Удалить">
                </form>
            </li>

        <?php endforeach; ?>
    </ol>
</div>

<?php

include VIEW_DIR . '/layout/footer.php';

?>
