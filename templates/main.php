<section class="content__side">
    <h2 class="content__side-heading">Проекты</h2>
    <nav class="main-navigation">
        <ul class="main-navigation__list">
            <?php foreach ($projects as $project): ?>
                <li class="main-navigation__list-item">
                    <!-- Выводим проекты -->
                    <a class="main-navigation__list-item-link
                    <?php if (isset($project)) :?>
                        <?= $project['id'] == $sort ? 'main-navigation__list-item--active' : '' ?>
                        <?php endif; ?>" href="<?= isset($project)? add_Link($project) : ''?>">
                        <?= isset($project['title_project'])? $project['title_project']: '' ?></a>
                    <span class="main-navigation__list-item-count"><?= countElements($project, $tasks) ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <a class="button button--transparent button--plus content__side-button"
        href="project.php">Добавить проект</a>
</section>
<main class="content__main">
    <h2 class="content__main-heading">Список задач</h2>
        <form class="search-form" action=""  method="get" autocomplete="off">
            <input class="search-form__input" type="text" name="q" value="" placeholder="Поиск по задачам">
            <input class="search-form__submit" type="submit" name="" value="">
        </form>
    <div class="tasks-controls">
        <nav class="tasks-switch">
            <a href="/?sort_date=Все задачи" class="tasks-switch__item <?php if (isset($sort_date)) :?><?php echo ($sort_date == "Все задачи")? 'tasks-switch__item--active' : ''?><?php endif; ?>">Все задачи</a>
            <a href="/?sort_date=Повестка дня" class="tasks-switch__item <?php if (isset($sort_date)) :?><?php echo ($sort_date == "Повестка дня")? 'tasks-switch__item--active' : ''?><?php endif; ?>">Повестка дня</a>
            <a href="/?sort_date=Завтра" class="tasks-switch__item <?php if (isset($sort_date)) :?><?php echo ($sort_date == "Завтра")? 'tasks-switch__item--active' : ''?><?php endif; ?>">Завтра</a>
            <a href="/?sort_date=Просроченные" class="tasks-switch__item <?php if (isset($sort_date)) :?><?php echo ($sort_date == "Просроченные")? 'tasks-switch__item--active' : ''?><?php endif; ?>">Просроченные</a>
        </nav>
        <label class="checkbox">
            <input class="checkbox__input visually-hidden show_completed"
            type="checkbox" <?php if (isset($show_complete_tasks)) :?><?php echo $show_complete_tasks == 1 ? 'checked' : '' ?><?php endif; ?>>
            <span class="checkbox__text">Показывать выполненные</span>
        </label>
    </div>
    <table class="tasks">
        <?php foreach ($tasks_sort as $task): ?>
        <?php if (isset($task['st_check'])) :?>
            <?php if ($task['st_check'] == 1 && $show_complete_tasks == 0) : ?>
            <?php continue; ?>
            <?php else: ?>
                <tr class="tasks__item task <?php echo $task['st_check'] == 1 ? 'task--completed' : ''?>
                <!-- Считаем часы до завершения -->
                <?php if ($task['dt_end'] == 'null' || $task['st_check']) : ?>
                ''
                <?php elseif (date_complit($task['dt_end']) <= 24)  : ?>
                task--important
            <?php endif ?>">
        <?php endif ?>
            <td class="task__select">
                <label class="checkbox task__checkbox">
                    <input class="checkbox__input task__checkbox visually-hidden"
                    <?php if (isset($task['st_check'])) :?>
                        <?php echo $task['st_check'] == 1  ? 'checked': '';?>
                    <?php endif; ?>
                    type="checkbox" value = "<?=$task['id']?>">
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
            <td class="task__date"><?php if (isset($task['st_check'])) :?><?php echo $task['st_check'] != 'null' ? $task['dt_end'] : ''; ?><?php endif; ?></td>
            <td class="task__controls"></td>
        </tr>
        <?php endif; ?>
        <?php endforeach; ?>
        <?php if (empty($tasks_sort)) : ?>
            <tr class="tasks__item task">
            <td class="task__select">
                <span>Ничего не найдено по вашему запросу</span>
            </td>
            </tr>
        <?php endif; ?>
        </table>
    </main>
</div>


