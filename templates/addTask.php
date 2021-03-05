<?php
  require_once('add.php');
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

      <main class="content__main">
        <h2 class="content__main-heading">Добавление задачи</h2>
        <form class="form" action="" method="post" enctype="multipart/form-data" autocomplete="off">
          <div class="form__row">
            <?php $classname =  isset($errors['name']) ? "form__input--error" : ""; ?>
            <?= !empty($errors['name']) ? '<p class="form__message">' : '' ?>
            <label class="form__label" for="name">Название <sup>*</sup></label>
            <input class="form__input <?= empty($classname)?>" type="text" name="name" id="name" value="<?= isset($_POST['name'])? $_POST['name'] : ''?>" placeholder="Введите название">
            <?= empty($errors['name']) ? '</p>' : '' ?>
        </div>

          <div class="form__row">
            <label class="form__label" for="project">Проект <sup>*</sup></label>
            <select class="form__input form__input--select" name="project" id="project">
            <?php foreach ($projects as $project): ?>
              <option value="<?= $project['title_project'] ?>"><?= $project['title_project'] ?></option>
            <?php endforeach?>
            </select>

          </div>

          <div class="form__row">
            <?php $classname =  isset($errors['date']) ? "form__input--error" : ""; ?>
            <?= !empty($errors['date']) ? '<p class="form__message">' : '' ?>
            <label class="form__label" for="date">Дата выполнения *</label>
            <input class="form__input form__input--date <?= empty($classname)?>" type="text" name="date" id="date" value="<?= isset($_POST['date'])? $_POST['date'] : ''?>" placeholder="Введите дату в формате ГГГГ-ММ-ДД">
          </div>

          <div class="form__row">
            <label class="form__label" for="file">Файл</label>

            <div class="form__input-file">
              <input class="visually-hidden" type="file" name="file" id="file" value="">

              <label class="button button--transparent" for="file">
                <span>Выберите файл</span>
              </label>
            </div>
          </div>

          <div class="form__row form__row--controls">
            <input class="button" type="submit" name="" value="Добавить">
          </div>

        </form>

    </div>
  </div>
</div>
