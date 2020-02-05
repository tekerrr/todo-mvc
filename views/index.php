<?php

include VIEW_DIR . '/layout/header.php';

?>

<section class="todoapp">
    <header class="header">
        <h1>todos</h1>
        <input class="new-todo" placeholder="What needs to be done?" autofocus>
    </header>
    <section class="main">
        <input id="toggle-all" class="toggle-all" type="checkbox">
        <label for="toggle-all">Mark all as complete</label>
        <ul class="todo-list"></ul>
    </section>
    <footer class="footer"></footer>
</section>
<section class="message"><p id="message"></p></section>

<script id="todo-template" type="text/x-handlebars-template">
    {{#this}}
    <li {{#if is_completed}}class="completed"{{/if}} data-id="{{id}}">
    <div class="view">
        <input class="toggle" type="checkbox" {{#if is_completed}}checked{{/if}}>
        <label>{{body}}</label>
        <button class="destroy"></button>
    </div>
    <input class="edit" value="{{title}}">
    </li>
    {{/this}}
</script>
<script id="footer-template" type="text/x-handlebars-template">
    <span class="todo-count"><strong>{{activeStepCount}}</strong> item left</span>
    <ul class="filters">
        <li>
            <a {{#eq filter 'all'}}class="selected"{{/eq}} href="<?=$url ?? ''?>/">All</a>
        </li>
        <li>
            <a {{#eq filter 'active'}}class="selected"{{/eq}}href="<?=$url ?? ''?>/active">Active</a>
        </li>
        <li>
            <a {{#eq filter 'completed'}}class="selected"{{/eq}}href="<?=$url ?? ''?>/completed">Completed</a>
        </li>
    </ul>
    {{#if completedSteps}}<button class="clear-completed">Clear completed</button>{{/if}}
</script>

<?php

include VIEW_DIR . '/layout/footer.php';

?>
