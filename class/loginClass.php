<?php
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

class Db
{
    private $row;

    public function __construct()
    {
        $this->row = new User();
    }

    public function fetch($username, $password)
    {
        if ($username === 'volkan' && $password === 'demo') {
            $data = [
                'id' => 4,
                'username' => 'volkansengul',
                'name' => 'volkan',
                'lastname' => 'sengul'
            ];
            return $data;
        } else {
            return null;
        }
    }
}

class Auth
{

    private $validation;
    private $db;

    public function __construct()
    {
        $this->validation = new Validation();
        $this->db = new Db();
    }

    private function getFormData()
    {
    }

    public function login()
    {
        $isValid = $this->validation->validate('username', 'password');
        if ($isValid) {
            $data = $this->db->fetch($_POST['username'], $_POST['password']);

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
