<?php

/**
 * Контроллер GoalController
 */
class GoalController
{
    public function actionIndex()
    {
        // Получаем идентификатор пользователя из сессии
        $userId = isset($_SESSION['user']) ? $_SESSION['user'] : false;

        // Обработка формы
        if (isset($_POST['submit'])) {
            // Флаг ошибок в форме
            $errors = false;
            $id_user = false;

            // Если форма отправлена
            // Получаем данные из формы

            if (isset($_POST['name']) && isset($_POST['email'])) {
                // При необходимости можно валидировать значения нужным образом
                if (empty($_POST['name']) || empty($_POST['email'])) {
                    $errors[] = 'Заполните поля контактных данных';
                }
                // Получаем данные из формы
                $name = $_POST['name'];
                $email = $_POST['email'];
                $password = 123;

                // Флаг ошибок
                $errors = false;

                // Валидация полей
                if (!User::checkName($name)) {
                    $errors[] = 'Имя не должно быть короче 2-х символов';
                }
                if (!User::checkEmail($email)) {
                    $errors[] = 'Неправильный email';
                }
                if (User::checkEmailExists($email)) {
                    $userId = User::checkEmailAndNameExists($email, $name);
                    if ($userId) {
                        $errors[] = 'Такой email уже используется';
                    }
                }

                if ($errors == false || $userId == false) {
                    // Регистрируем пользователя
                    $userId = User::register($name, $email, $password);
                }
            }

            $options['goal'] = $_POST['goal'];
            $options['id_user'] = $userId;
            $options['status'] = 0;

            // При необходимости можно валидировать значения нужным образом
            if (!isset($options['goal']) || empty($options['goal'])) {
                $errors[] = 'Заполните поле задания';
            }

            if ($errors == false) {
                // Если ошибок нет
                // Добавляем новый goal
                Orders::createGoal($options);

                header("Location: /");
            }
        }


        // Подключаем вид
        require_once(ROOT . '/views/goal/index.php');
        return true;
    }

}
