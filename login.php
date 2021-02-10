<?php
include 'class/loginClass.php';
$auth = new Auth();
$login = $auth->login();
$user = new User();

if (@$login['login'] === true) {
    $user->setData($login['data']);
    header('location:/bootcamp/todolist');
}

?>
<div class="container">
    <form action="/bootcamp/todolist/" method="post">
        <div class="row">
            <div class="col-sm">
                <input type="text" name="username" value="" placeholder="Kullanıcı Adı Girin" class="form-control" /><br />
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