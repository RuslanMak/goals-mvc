<?php

/**
 * Контроллер CartController
 */
class SiteController extends AdminBase
{
    /**
     * Action для главной страницы
     */
    public function actionIndex($page = 1)
    {
        $isAdmin = self::checkAdmin();


        // Обработка формы
        if (isset($_SESSION["status"])) {
            // Список
            $orders = Orders::getOrdersList($page, $_SESSION["status"], $_SESSION["name"], $_SESSION["email"]);
            // Общее количетсво вопросов-ответов (необходимо для постраничной навигации)
            $total = Orders::getTotalOrders($_SESSION["status"], $_SESSION["name"], $_SESSION["email"]);
        } else {
            $orders = Orders::getOrdersList($page);
            $total = Orders::getTotalOrders();
        }

        // Обработка формы
        if (isset($_POST['submit2'])) {
            $id = $_POST['id'];
            $status = $_POST['status'];
            $goal = $_POST['goal'];

            // Сохраняем изменения
            if (Orders::updateById($id, $status, $goal)) {
                header("Location: /");
            }
        }

        // Создаем объект Pagination - постраничная навигация
        $pagination = new Pagination($total, $page, Orders::SHOW_BY_DEFAULT, 'page-');

        // Подключаем вид
        require_once(ROOT . '/views/site/index.php');
        return true;
    }

    /**
     * Action для страницы "404"
     */
    public function action404()
    {
        echo "<h1>404</h1>";
        exit();
        // Список категорий для левого меню
        $categories = Category::getCategoriesList();
        // Подключаем вид
        require_once(ROOT . '/views/site/404.php');
        return true;
    }

    /**
     * Action для филтра
     */
    public function actionFilter()
    {
        if (isset($_POST['submit2'])) {
            $_SESSION["status"] = $_POST['status'];
            $_SESSION["name"] = $_POST['name'];
            $_SESSION["email"] = $_POST['email'];
        }

        header("Location: /");
    }

    /**
     * Action для очистки филтра
     */
    public function actionClearFilter()
    {
        unset($_SESSION["status"]);
        unset($_SESSION["name"]);
        unset($_SESSION["email"]);

        header("Location: /");
    }

    /**
     * Action для подключения онлайн редактора
     */
    public function actionDayside()
    {
        // Подключаем вид
        require_once(ROOT . '/dayside/index.php');
        return true;
    }
}


