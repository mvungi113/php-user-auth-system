<?php
require __DIR__ . '/../src/bootstrap.php';
require __DIR__ . '/../src/login.php';
?>

<?php view('header', ['title' => 'Login']) ?>

<form action="login.php" method="post">
    <h1>Login</h1>

    <?php if (isset($errors['login'])) : ?>
        <div class="alert alert-error">
            <?= $errors['login'] ?>
        </div>
    <?php endif ?>

    <div>
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" value="<?= $inputs['username'] ?? '' ?>"
               class="<?= error_class($errors, 'username') ?>">
        <small><?= $errors['username'] ?? '' ?></small>
    </div>

    <div>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password"
               class="<?= error_class($errors, 'password') ?>">
        <small><?= $errors['password'] ?? '' ?></small>
    </div>

    <button type="submit">Login</button>

    <footer>Don't have an account? <a href="register.php">Register here</a></footer>

</form>

<?php view('footer') ?>
