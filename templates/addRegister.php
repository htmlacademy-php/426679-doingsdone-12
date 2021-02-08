<?php
    require_once('register.php');
?>
      <div class="content">
        <section class="content__side">
          <p class="content__side-info">Если у вас уже есть аккаунт, авторизуйтесь на сайте</p>

          <a class="button button--transparent content__side-button" href="form-authorization.html">Войти</a>
        </section>

        <main class="content__main">
          <h2 class="content__main-heading">Регистрация аккаунта</h2>

          <form class="form" action="" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="form__row">
              <label class="form__label" for="email">E-mail <sup>*</sup></label>

              <input class="form__input <?php echo $errors['email'] ? 'form__input--error' : '' ?>" type="text" name="email" id="email" value="<?= $_POST['email'] ?>" placeholder="Введите e-mail">
                <?php if($errors['email']=='Проверьте написание Email'): ?>
                    <p class="form__message">Проверьте написание Email</p>
                <?php elseif($errors['email']=='Email существует'): ?>
                    <p class="form__message">Пользователь с этим email уже зарегистрирован</p>
                <?php elseif($errors['email']=='Это поле надо заполнить'): ?>
                    <p class="form__message">Это поле надо заполнить</p>
                <?php endif ?>
            </div>

            <div class="form__row">
              <label class="form__label" for="password">Пароль <sup>*</sup></label>

              <input class="form__input <?php echo $errors['password'] ? 'form__input--error' : '' ?>" type="password" name="password" id="password" value="" placeholder="Введите пароль">
              <?php if($errors['password']=='Это поле надо заполнить'): ?>
                    <p class="form__message">Это поле надо заполнить</p>
                <?php endif ?>
            </div>

            <div class="form__row">
              <label class="form__label" for="name">Имя <sup>*</sup></label>

              <input class="form__input <?php echo $errors['name'] ? 'form__input--error' : '' ?>" type="text" name="name" id="name" value="<?= $_POST['name'] ?>" placeholder="Введите имя">
              <?php if($errors['name']=='Это поле надо заполнить'): ?>
                    <p class="form__message">Это поле надо заполнить</p>
                <?php endif ?>
            </div>

            <div class="form__row form__row--controls">
            <?php if($errors['email']==true): ?>
              <p class="error-message">Пожалуйста, исправьте ошибки в форме</p>
            <?php endif ?>
              <input class="button" type="submit" name="" value="Зарегистрироваться">
            </div>
          </form>
        </main>
      </div>
    </div>
  </div>


