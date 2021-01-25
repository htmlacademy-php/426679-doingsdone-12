<section class="content__side">
    <h2 class="content__side-heading">Проекты</h2>
    <nav class="main-navigation">
        <ul class="main-navigation__list">
            <?php foreach ($projects as $project): ?>
                <li class="main-navigation__list-item">
                    <!-- Выводим проекты -->
                    <a class="main-navigation__list-item-link <?= $project['id'] == $sort ? 'main-navigation__list-item--active' : '' ?>" href="<?=add_Link($project);?>"><?= $project['title_project']; ?></a>
                    <span class="main-navigation__list-item-count"><?= countElements($project, $tasks) ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <a class="button button--transparent button--plus content__side-button"
        href="pages/form-project.html" target="project_add">Добавить проект</a>
</section>
<main class="content__main">
    <h2 class="content__main-heading">Список задач</h2>
        <form class="search-form" action="index.php" method="post" autocomplete="off">
            <input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">
            <input class="search-form__submit" type="submit" name="" value="Искать">
        </form>
    <div class="tasks-controls">
        <nav class="tasks-switch">
            <a href="/" class="tasks-switch__item tasks-switch__item--active">Все задачи</a>
            <a href="/" class="tasks-switch__item">Повестка дня</a>
            <a href="/" class="tasks-switch__item">Завтра</a>
            <a href="/" class="tasks-switch__item">Просроченные</a>
        </nav>
        <label class="checkbox">
                <input class="checkbox__input visually-hidden show_completed"
                type="checkbox" <?php echo $show_complete_tasks == 1 ? 'checked' : '' ?> >
            <span class="checkbox__text">Показывать выполненные</span>
        </label>
    </div>
    <table class="tasks">
        <?php foreach($tasks_sort as $task): ?>
        <?php if ($task['st_check'] && $show_complete_tasks == 0) : ?>
        <?php continue; ?>
        <?php else: ?>
        <tr class="tasks__item task <?php echo $task['st_check'] ? 'task--completed' : ''?>
        <!-- Считаем часы до завершения -->
        <?php if ($task['dt_end'] == 'null' || $task['st_check']) : ?>
            ''
        <?php elseif(date_complit($task['dt_end']) <= 24)  : ?>
            task--important
        <?php endif ?>">
            <td class="task__select">
                <label class="checkbox task__checkbox">
                    <input class="checkbox__input visually-hidden" type="checkbox" checked>
                    <span class="checkbox__text"><?= filterEsc($task['title_task']); ?></span>
                </label>
            </td>
            <td class="task__file">
                <?php if (!empty($task['dl_file'])):?>
                    <a href="/uploads/<?=$task['dl_file']?>">
                        <img src="img\download-link.png" alt="Файл задачи">
                    </a>
                <?php endif; ?>
            </td>
            <td class="task__date"><?php echo $task['st_check'] != 'null' ? $task['dt_end'] : ''; ?></td>
            <td class="task__controls"></td>
        </tr>
        <?php endif; ?>
        <?php endforeach; ?>
        </table>
    </main>
</div>


