# Project "Todo MVC"
## Backend
Реализовано:
- docker, проект [tekerrr/docker-for-todo-mvc](https://github.com/tekerrr/docker-for-todo-mvc)
- перенесены базовые классы MVC из [tekerrr/skillbox_blog](https://github.com/tekerrr/skillbox_blog)
- добавлен [Illuminate/database](https://github.com/illuminate/database)
- рефакторинг классов MVC
- аутентификацая, авторизацая, регистрацая пользователей
- todo список, привязанный к сессии
- списки пользователей

Не реализовано:
- правила валидация полей (требуется: время)
- "расшаривание" списков (требуется: время)
- права доступа к "расшаренным" спискам (требуется: время)
- тестирование php классов (требуется: время)
- кеширование (требуется: Redis или memcached, возможно Event/Listener, время)
## Frontend
Реализовано:
- клиентская часть основного TODO (адаптация верстки + ajax) на основе [данного примера](http://todomvc.com/examples/jquery/)
