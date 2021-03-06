
<div class="content">

    <section class="content__side">
        <p class="content__side-info">Если у вас уже есть аккаунт, авторизуйтесь на сайте</p>
        <a class="button button--transparent content__side-button" href="auth.php">Войти</a>
    </section>
    <main class="content__main">
        <h2 class="content__main-heading">Вход на сайт</h2>
        <form class="form" action="" method="post" autocomplete="off">
            <div class="form__row">
            <label class="form__label" for="email">E-mail <sup>*</sup></label>

            <input class="form__input <?php echo isset($errors['email']) ? 'form__input--error' : '' ?>" type="text" name="email" id="email" value="<?= isset($_POST['email'])? $_POST['email'] : '' ?>" placeholder="Введите e-mail">
            <?php if (isset($errors['email'])): ?>
                <?php if ($errors['email']=='Проверьте написание Email'): ?>
                    <p class="form__message">E-mail введён некорректно</p>
                <?php elseif ($errors['email']=='Email не существует'): ?>
                    <p class="form__message">'Email не существует'</p>
                <?php endif; ?>
            <?php endif; ?>
            </div>

            <div class="form__row">
            <label class="form__label" for="password">Пароль <sup>*</sup></label>

            <input class="form__input <?php echo isset($errors['password']) ? 'form__input--error' : '' ?>" type="password" name="password" id="password" value="" placeholder="Введите пароль">
            <?php if (isset($errors['password'])): ?>
                <p class="form__message">Это поле надо заполнить</p>
            <?php endif; ?>
            </div>
            <?php if (isset($errors['email'])) : ?>
                <?php if ($errors['email']==true): ?>
                    <p class="error-message">Пожалуйста, исправьте ошибки в форме</p>
                <?php endif ?>
            <?php endif ?>
            <div class="form__row form__row--controls">
            <input class="button" type="submit" name="" value="Войти">
            </div>
        </form>

      </main>

    </div>
