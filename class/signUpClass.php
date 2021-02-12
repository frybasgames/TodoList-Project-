<?php
include('class/config.php');
class signUp {
    private $userName;
    protected $myUserList;
    private $dbConfig;
    private $operation = 'user';

    public function __construct(string $userName)
    {
        $this->userName = $userName;

        $conf = new DbConfig($userName,$this->operation);
        $this->dbConfig = $conf->getDbFile();
    }

  //   public function getUser() : array {
        // $this->myUserList = json_decode(file_get_contents($this->db));
    //return $this->myUserList;
//}

    // Save file
    public function save($name,$data) {
        echo $name;
       // print_r($data);
       // $this->myUserList=[];
       // $this->myUserList=$data;

      // file_put_contents($name, json_encode($this->myUserList));
        //header('location:/bootcamp/todolist');
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
    private $username;
    private $name;
    private $lastname;
    private $password;

    public function setData($data)
    {
        $this->username = $data['username'];
        $this->name = $data['name'];
        $this->lastname = $data['lastname'];
        $this->password = $data['password'];
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
                $data = [
                    'username' => $username,
                    'name' => $name,
                    'lastname' => $lastname,
                    'password'=> $password
                ];
                return $data;

    }
}

class Auth extends signUp
{
    private $validation;
    private $db;
private $signUp;
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
                //$this->myUserList[] = $this->getUser();
                $this->myUserList[] = $data;
                //$signUp = new signUp(date('Ymd'));
               //$this->save($signUp,$data);

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