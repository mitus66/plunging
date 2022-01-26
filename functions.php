<?php

function displayFlashMassage($name)
{
    if(isset($_SESSION[$name])) {
        echo '<div class="alert alert-' . $name . ' text-dark" role="alert">
                <strong>Уведомление! </strong>' . $_SESSION[$name] .
            '</div>';
        unset($_SESSION[$name]);
    }
}

function getUserByEmail($email)
{
    // Создаем объект-соединение с базой данных
    $dbh = new \PDO(
        'mysql:host=localhost;dbname=test',
        'root',
        ''
    );
    // Готовим запрос
    $sql = 'SELECT * FROM users WHERE email=:email';
    $sth = $dbh->prepare($sql);

    // Выполняем запрос:
    $sth->execute(['email' => $email]);

    // Получаем данные результата запроса:
    $user = $sth->fetch(PDO::FETCH_ASSOC);

    return $user;
}


function addUser($email, $password)
{
    // Создаем объект-соединение с базой данных
    $dbh = new \PDO(
        'mysql:host=localhost;dbname=test',
        'root',
        ''
    );
    // готовим запрос в БД
    $sql = 'INSERT INTO users (email, password) VALUES (:email, :password)';
    $sth = $dbh->prepare($sql);
    // Выполняем запрос:
    $sth->execute(['email' => $email, 'password' => password_hash($password, PASSWORD_DEFAULT)]);
    //    $sth->bindParam(':emaile', $email);
    //    $sth->bindParam(':password', $hashedPassword);
    //    $sth->execute();
    // готовим флеш-сообщение
}

function redirectTo($path)
{
    header('Location: ' . $path);
}

function setFlashMassage($name, $content)
{
    $_SESSION[$name] = $content;
}