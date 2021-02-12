<?php
    session_start();
    ob_start();
include 'header.php';
    //error_reporting(E_ERROR | E_WARNING | E_PARSE);

    //error_reporting(E_ALL);
    //ini_set('display_errors', '1');


    if (!isset($_SESSION['isLogged']) && !(@$_SESSION['isLogged'])) {
    //    include 'chooseAuth.php';
  //      if(@$_POST['Auth']==='signUp'){
//
           include 'signUp.php';
       // }
        //if(@$_POST['Auth']==='login'){
           //include 'login.php';
        //}
    } else {
        include('class/config.php');
        include('class/todolist.php');

        $app = new TodoList(date('Ymd'));

        $todolist = $app->getTodos();


        $reqMethod = $_SERVER['REQUEST_METHOD'];

        switch ($reqMethod) {
            case 'POST':
                // Add Task
                $app->add();
                break;
            case 'GET':
                // Delete Task
                if (@$_GET['action'] === 'delete' && !empty($_GET['id'])) {
                    $app->delete($_GET['id']);
                }
                // StatusChange Task
                if (@$_GET['status'] === 'statusChange' && !empty($_GET['id'])) {
                    $app->statusChange($_GET['id']);
                }
                // Up Task
                if (@$_GET['upTask'] === 'up' && !empty($_GET['id'])) {
                    $app->up($_GET['id']);
                }
                // Down Task
                if (@$_GET['downTask'] === 'down' && !empty($_GET['id'])) {
                    $app->down($_GET['id']);
                }
                // Update Task
                 if (@$_GET['updateTask'] === 'update' && !empty($_GET['id']) && !empty($_GET['updateText'])) {
                    $app->update($_GET['id'],$_GET['updateText']);
                 }
                break;
        }

        $todolist = $app->getTodos();
    ?>
    <p></p>
        <div class="container">
            <form action="/bootcamp/todolist/index.php" method="post">
                <div class="row">
                    <div class="col-sm">
                    </div>
                    <div class="col-sm">
                        <input type="text" name="mytodo" class="form-control" />
                    </div>
                    <div class="col-sm">
                        <input type="submit" value="Ekle" class="btn btn-primary">
                    </div>
                </div>
            </form>
            <form action="/bootcamp/todolist/logout.php">
            <input type="submit" style="float:right" value="Logout" name="logout" class="btn btn-primary"></input>
            </form>
            
        </div>
        <div class="container">
            <ul>
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">TASK</th>
                        </tr>
                    </thead>
                    <?php
                    foreach ($todolist as $k => $v) {
                    ?>
                        <div style="display:inline-block"></div>
                        <tbody>
                            <tr>
                                <th scope="row"><?= $k + 1 ?></th>
                                <td><?= $v ?></td>
                                <form action="/bootcamp/todolist/index.php" style="display:inline-block">
                                    <input type="hidden" id="id" value="<?= $k + 1 ?>" name="id" class="form-control" />
                                    <input type="hidden" value="delete" name="action" />
                                    <td><button class="btn btn-primary" type="submit"> <i class="fa fa-trash" aria-hidden="true"></i><a></td>
                                </form>
                                <form action="/bootcamp/todolist/index.php" style="display:inline-block">
                                    <input type="hidden" id="id" value="<?= $k + 1 ?>" name="id" class="form-control" />
                                    <input type="hidden" value="statusChange" name="status" />
                                    <td><button class="btn btn-primary" type="submit"><i class="fa fa-check" aria-hidden="true"></i></td>
                                </form>
                                <form action="/bootcamp/todolist/index.php" style="display:inline-block">
                                    <input type="hidden" id="id" value="<?= $k + 1 ?>" name="id" class="form-control" />
                                    <input type="hidden" value="up" name="upTask" />
                                    <td><button class="btn btn-primary" id="up" type="submit"><i class="fa fa-angle-double-up" aria-hidden="true"></i></td>
                                </form>
                                <form action="/bootcamp/todolist/index.php" style="display:inline-block">
                                    <input type="hidden" id="id" value="<?= $k + 1 ?>" name="id" class="form-control" />
                                    <input type="hidden" value="down" name="downTask" />
                                    <td><button class="btn btn-primary"id="down" type="submit"><i class="fa fa-angle-double-down" aria-hidden="true"></i></td>
                                </form>
                                <form action="/bootcamp/todolist/index.php" style="display:inline-block">
                                    <input type="hidden" id="id" value="<?= $k + 1 ?>" name="id" class="form-control" />
                                    <input type="hidden" value="update" name="updateTask" />
                                    <td><input type="text" name="updateText" class="form-control" placeholder="Editing Task..."/></td>
                                    <td><input type="submit" value="Edit" class="btn btn-primary"></td>
                                </form>
                            <tr>
                        </tbody>

                    <?php
                    }
                    ?>
                </table>
            </ul>
        </div>
    <?php
    }
    ?>