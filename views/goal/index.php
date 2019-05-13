<?php include ROOT . '/views/layouts/header.php'; ?>

<section>
    <div class="container">
        <div class="row">

            <h3>Создание задания</h3>

            <?php if (isset($errors) && is_array($errors)): ?>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li> - <?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <div class="col-lg-4">
                <div class="login-form">
                    <form action="#" method="post">

                        <p>Задание</p>
                        <textarea name="goal"></textarea>

                        <br/><br/>
                        <?php if ($userId == false): ?>
                            <input type="text" name="name" placeholder="Имя"/>
                            <input type="email" name="email" placeholder="E-mail"/>
                        <?php endif; ?>

                        <input type="submit" name="submit" class="btn btn-default" value="Отправить">

                        <br/><br/>

                    </form>
                </div>
            </div>
            
        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer.php'; ?>