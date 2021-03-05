<?php
    require_once('project.php')
?>
<div class="content">
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
        <a class="button button--transparent button--plus content__side-button" href="project.php">Добавить проект</a>
      </section>
<div class="container">
      <main class="content__main">
        <h2 class="content__main-heading">Добавление проекта</h2>
        <form class="form"  action="" method="post" autocomplete="off">
          <div class="form__row">
            <?= !empty($errors['name']) ? '<p class="form__message">' : '' ?>
            <label class="form__label" for="project_name">Название <sup>*</sup></label>
            <?php $classname =  isset($errors['name']) ? "form__input--error" : ""; ?>
            <input class="form__input <?= $classname?>" type="text" name="name" id="project_name" value="" placeholder="Введите название проекта">
            <?= !empty($errors['name']) ? '</p>' : '' ?>
            <?php if (isset($errors['name'])) : ?>
                <?php if ($errors['name']== 'Проект существует'): ?>
                    <p class="form__message">Проект существует</p>
                <?php endif; ?>
            <?php endif; ?>
        </div>

          <div class="form__row form__row--controls">
            <input class="button" type="submit" name="" value="Добавить">
          </div>
        </form>
      </main>
</div>
</div>
