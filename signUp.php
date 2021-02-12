<?php
include 'class/signUpClass.php';
include 'header.php';

$signUp = new signUp(date('Ymd'));

//$userList = $signUp->getUser();

$auth = new Auth();

$sign = $auth->signUp();

$user = new User();


if (@$sign['login'] === true) {
    $user->setData($sign['data']);
   // header('location:/bootcamp/todolist');
}


?>
<div class="container">
    <form action="/bootcamp/todolist/" method="post">
        <div class="row">
            <div class="col-sm">
                <input type="text" name="username" value="" placeholder="Kullanıcı Adı Girin" class="form-control" /><br />
            </div>
            <div class="col-sm">
                <input type="text" name="name" value="" placeholder="Adınızı Girin" class="form-control" /><br />
            </div>
            <div class="col-sm">
                <input type="text" name="lastname" value="" placeholder="Soyadınızı Giriniz" class="form-control" /><br />
            </div>
            <div class="col-sm">
                <input type="password" name="password" value="" placeholder="Şifrenizi Girin" class="form-control" /><br />
            </div>
            <div class="col-sm">
                <input type="submit" value="Login" class="btn btn-primary" />
            </div>
        </div>
    </form>
</div>
