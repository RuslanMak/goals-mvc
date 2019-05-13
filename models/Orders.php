<?php

/**
 * Класс Orders - модель для работы с orders
 */
class Orders
{

    // Количество отображаемых задач по умолчанию
    const SHOW_BY_DEFAULT = 3;
    const SHOW_BY_LOT = 999;

    /**
     * Возвращает список вопросов-ответов
     * @return array <p>Массив с faq</p>
     */
    public static function getOrdersList($page = 1,  $status='', $name='', $email='')
    {
        $limit = Orders::SHOW_BY_DEFAULT;
        // Смещение (для запроса)
        $offset = ($page - 1) * self::SHOW_BY_DEFAULT;

        // Соединение с БД
        $db = Db::getConnection();

        // Получение и возврат результатов
        $sql = 'SELECT orders.*, user.name, user.email
                FROM orders
                LEFT JOIN user ON id_user = user.id
                WHERE orders.status LIKE concat(\'%\', :status, \'%\')
                AND user.name LIKE concat(\'%\', :name, \'%\')
                AND user.email LIKE concat(\'%\', :email, \'%\')
                ORDER BY orders.id ASC LIMIT :limit OFFSET :offset';

        // Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':status', $status, PDO::PARAM_INT);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':limit', $limit, PDO::PARAM_INT);
        $result->bindParam(':offset', $offset, PDO::PARAM_INT);

        // Выполнение коменды
        $result->execute();

        // Получение и возврат результатов
        $i = 0;
        $orders = array();
        while ($row = $result->fetch()) {
            $orders[$i]['id'] = $row['id'];
            $orders[$i]['description'] = $row['description'];
            $orders[$i]['id_user'] = $row['id_user'];
            $orders[$i]['status'] = $row['status'];
            $orders[$i]['name'] = $row['name'];
            $orders[$i]['email'] = $row['email'];
            $i++;
        }
//        print_r($orders);
//        exit();
        return $orders;
    }

    public static function getTotalOrders($status='', $name='', $email='')
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Текст запроса к БД
        $sql = 'SELECT orders.id
                FROM orders
                INNER JOIN user ON id_user = user.id
                WHERE orders.status LIKE concat(\'%\', :status, \'%\')
                AND user.name LIKE concat(\'%\', :name, \'%\')
                AND user.email LIKE concat(\'%\', :email, \'%\')';

        // Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':status', $status, PDO::PARAM_INT);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);

        // Выполнение коменды
        $result->execute();

        // Возвращаем значение count - количество
        $row = $result->fetchAll();
//        print_r(count($row));
//        exit();
        return count($row);
    }

    /**
     * Добавляет нового задания
     * @param array $options <p>Массив с информацией о goal</p>
     * @return integer <p>id добавленной в таблицу записи</p>
     */
    public static function createGoal($options)
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Текст запроса к БД
        $sql = 'INSERT INTO orders '
            . '(description, id_user, status)'
            . 'VALUES '
            . '(:description, :id_user, :status)';

        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':description', $options['goal'], PDO::PARAM_STR);
        $result->bindParam(':id_user', $options['id_user'], PDO::PARAM_INT);
        $result->bindParam(':status', $options['status'], PDO::PARAM_INT);
        if ($result->execute()) {
            // Если запрос выполенен успешно, возвращаем id добавленной записи
            return $db->lastInsertId();
        }
        // Иначе возвращаем 0
        return 0;
    }

    /**
     * Редактирует orders с заданным id
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function updateById($id, $status, $goal)
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Текст запроса к БД
        $sql = "UPDATE orders
            SET 
                status = :status, 
                description = :description
            WHERE id = :id";

        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':status', $status, PDO::PARAM_INT);
        $result->bindParam(':description', $goal, PDO::PARAM_STR);
        return $result->execute();
    }
}
