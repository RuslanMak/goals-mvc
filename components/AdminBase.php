<?php

/**
 * Абстрактный класс AdminBase содержит общую логику для контроллеров, которые 
 * используются в панели администратора
 */
abstract class AdminBase
{

    /**
     * Метод, который проверяет пользователя на то, является ли он администратором
     * @return boolean
     */
    public static function checkAdmin()
    {
        // Проверяем авторизирован ли пользователь. Если нет, он будет переадресован
//        $userId = User::checkLogged();
        $userId = User::checkLoggedOrFall();

        // Получаем информацию о текущем пользователе
        $user = User::getUserById($userId);

        // Если роль текущего пользователя "admin", пускаем его в админпанель
        if ($user['role'] == 'admin') {
            return true;
        } else {
            return false;
        }

        // Иначе завершаем работу с сообщением об закрытом доступе
//        http_response_code(403);
////        echo '<h1>Access denied</h1>'; /* для вывода своего сообщения */
//        exit();
    }

}
