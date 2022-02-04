<?php
session_start();
require 'functions.php';

// если нет авторизации или пользователь не админ, вернуться на страницу логинизации
isUserNotAdmin();

// если нет данных из формы вернуться в форму
if(empty($_POST)) {
    redirectTo('create_user.php');
    exit();
}

// проверить не занят ли емейл
$email = $_POST['email'];

if (!empty(getUserByEmail($email))) {
    setFlashMassage('danger', 'Этот эл. адрес уже занят другим пользователем.');
    redirectTo('page_register.php');
    exit();
}

// обработать загрузку аватара
$avatar = $_FILES['avatar'];

// занести в базу
if(empty($_POST['email'] && $_POST['password'])) {
    setFlashMassage('danger', 'Не заполнены поля Email и/или Password');
    redirectTo('create_users.php');
} else {
    addUserInfo($_POST['name'], $_POST['position'], $_POST['phone'], $_POST['address']);
    addUserSecurity($_POST['email'], $_POST['password']);
    addUserAvatar($avatar);
    addUserStatus($_POST['status']);
    addUserMedia($_POST['vkontakte'], $_POST['telegram'], $_POST['instagram']);
    // подготовить сообщение
    setFlashMassage('success', 'Профиль успешно обновлен');
    // перенаправить
    redirectTo('users.php');
}

