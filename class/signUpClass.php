<?php
include('class/config.php');
class signUp {
    private $userName;
    protected $myUserList;
    private $db;
    private $operation = 'user';

    public function __construct(string $userName)
    {
        $this->userName = $userName;

        $conf = new DbConfig($userName,$this->operation);
        $this->db = $conf->getDbFile();
    }

    public function getUser() : array {
            $this->myUserList = json_decode(file_get_contents($this->db));
            return $this->myUserList;
    }

    // Save file
    public function save(){
        file_put_contents($this->db, json_encode($this->myUserList));
        header('location:/bootcamp/todolist');
    }
}
class Validation
{

    public function readPostData($name)
    {
        return @$_POST[$name];
    }

    public function validate(...$elements)
    {
        foreach ($elements as $elm) {
            if (empty($this->readPostData($elm))) {
                return false;
            }
        }
        return true;
    }
}

class User
{
    private $id;
    private $username;
    private $name;
    private $lastname;

    public function setData($data)
    {
        $this->id = $data['id'];
        $this->username = $data['username'];
        $this->name = $data['name'];
        $this->lastname = $data['lastname'];
    }

    public function __get($name)
    {
        if (isset($this->$name)) {
            return $this->$name;
        } else {
            return null;
        }
    }

    public function __set($name, $value)
    {
        if (isset($this->$name)) {
            $this->$name = $value;
        }
    }
}

class Db extends signUp
{
    private $row;
    private $userList;

    public function __construct()
    {
        $this->row = new User();
    }

    public function fetch($username,$name,$lastname ,$password)
    {
        $this->userList = $this->getUser();
        foreach ($this->userList as $user){
            if ($user['username'] === $username && $user['password'] === $password) {
                return null;
            }else{
                $data = [
                    'username' => $username,
                    'name' => $name,
                    'lastname' => $lastname,
                    'password'=> $password
                ];
                $this->myUserList[] = $data;
                $this->save();
                return $data;
            }
        }

    }
}

class Auth extends signUp
{
    private $validation;
    private $db;

    public function __construct()
    {
        $this->validation = new Validation();
        $this->db = new Db();
    }

    public function signUp()
    {

        $isValid = $this->validation->validate('username', 'name', 'lastname', 'password');
        if ($isValid) {
            $data = $this->db->fetch($_POST['username'], $_POST['name'], $_POST['lastname'], $_POST['password']);

            if ($data !== null) {

                $_SESSION['isLogged'] = true;
                $_SESSION['user'] = $data;
                return ['login' => true, 'data' => $data];
            } else {
                return [
                    'login' => false
                ];
            }
        } else {
            return [
                'login' => false
            ];
        }
    }

}