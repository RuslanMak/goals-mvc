<?php include ROOT . '/views/layouts/header.php';?>


    <section>
        <div class="container">
            <div class="row">

                <div class="col-sm-3">
                    <div class="left-sidebar">
                        <h2>Фильтр</h2>
                        <div class="panel-group category-faqs">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="color: grey">
                                    <form action="filter/filtered" method="post">

                                        <p>Статус</p>
                                        <select name="status">
                                            <option value="" selected="selected">Все</option>
                                            <option value="1" <?php if (isset($_SESSION['status']) &&  $_SESSION['status'] == 1) echo ' selected="selected"'; ?>>Выполнено</option>
                                            <option value="0" <?php if (isset($_SESSION['status']) &&  $_SESSION['status'] == 0) echo ' selected="selected"'; ?>>Невыполнено</option>
                                        </select><br/><br/>

                                        <input type="text" name="name" placeholder="Имя" value="<?php if (isset($_SESSION['name'])) {echo $_SESSION["name"];} ?>"/>
                                        <br/><br/>
                                        <input type="text" name="email" placeholder="E-mail" value="<?php if (isset($_SESSION['email'])) {echo $_SESSION["email"];} ?>"/>

                                        <br/><br/>
                                        <input type="submit" name="submit2" class="btn btn-default" value="Фильтр">
                                        <a href="filter/clear" class="btn btn-default">Отмена</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-9 padding-right">
                    <div class="features_items">
                        <h2 class="title text-center">список задач</h2>
                        <?php foreach ($orders as $order): ?>
                            <div class="col-sm-12">
                                <div class="faq-image-wrapper">
                                    <div class="single-faqs">
                                        <div class="faqinfo text-center">
                                            <p style="color: #d58512; font-size: 1.75em;">
                                                <?php echo $order['description']; ?>
                                            </p>

                                            <p>
                                                <?php echo $order['name']; ?>
                                            </p>
                                            <p>
                                                <?php echo $order['email']; ?>
                                            </p>


                                            <?php if ($isAdmin): ?>
                                                <form action="#" method="post">
                                                    <select name="status">
                                                        <option value="1" <?php if ($order['status'] == 1) echo ' selected="selected"'; ?>>Выполнено</option>
                                                        <option value="0" <?php if ($order['status'] == 0) echo ' selected="selected"'; ?>>Невыполнено</option>
                                                    </select><br/><br/>

                                                    <textarea name="goal"><?php echo $order['description']; ?></textarea>
                                                    <input type="hidden" name="id" placeholder="" value="<?php echo $order['id']; ?>">

                                                    <br/><br/>
                                                    <input type="submit" name="submit2" class="btn btn-default" value="Изменить">
                                                    <br/><br/>
                                                </form>
                                            <?php endif ?>


                                        </div>
                                        <?php if ($order['status']): ?>
                                            <img src="/template/images/home/new.png" class="new" alt="" />
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>

                    </div>
                    <!-- Постраничная навигация -->
                    <?php echo $pagination->get(); ?>

                </div>
            </div>
        </div>
    </section>

<?php include ROOT . '/views/layouts/footer.php'; ?>