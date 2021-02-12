<?php
class TodoList {

    private $todolistName;
    private $myTodoList;
    private $db;
    private $operation = 'todo';

    // init
    public function __construct(string $todoListName)
    {
        $this->todolistName = $todoListName;

        $conf = new DbConfig($todoListName,$this->operation);
        $this->db = $conf->getDbFile();
    }

    public function getTodos() : array {
        $this->myTodoList = json_decode(file_get_contents($this->db));
        return $this->myTodoList;
    }

    // create todolist
    private function create(){

    }

    // Add task
    public function add(){
        $task = @$_POST['mytodo'];
        if (!empty($task)){
            array_unshift($this->myTodoList,$task);
            $this->save();
        }
    }

    // Up task
    public function up(int $id){
        $id--;
        if($id>0 && $id<count($this->myTodoList)){
            $temp=$this->myTodoList[$id-1];
            $this->myTodoList[$id-1]=$this->myTodoList[$id];
            $this->myTodoList[$id]=$temp;
            $this->save();
        }
        else{
            return null;
        }
        
    }

    // Down task
    public function down(int $id){
        $id--;
        if($id<count($this->myTodoList)-1 && $id>=0){
            $temp=$this->myTodoList[$id+1];
            $this->myTodoList[$id+1]=$this->myTodoList[$id];
            $this->myTodoList[$id]=$temp;
            $this->save();
        }
        else{
            return null;
        }
    }

    // Delete task
    public function delete(int $id){
        $id--;
        unset($this->myTodoList[$id]);
        $this->myTodoList = array_values( $this->myTodoList );
        $this->save();
    }
    // Update task
    public function update(int $id,string $data){
        $id--;
        $task = $data;
        if (!empty($task)){
            $this->myTodoList[$id] = $task;
            $this->save();
        }
    }
    // StatusChange task
    public function statusChange(int $id){
        $id--;
        if(!empty($this->myTodoList[$id])){
            $task = '<s>'.$this->myTodoList[$id].'</s>';
            $this->myTodoList[$id] = $task;
            unset($this->myTodoList[$id]);
            $this->myTodoList = array_values( $this->myTodoList );
            $this->myTodoList[]=$task;
            $this->save();
        }
    }

    // Save file
    public function save(){
        file_put_contents($this->db, json_encode($this->myTodoList));
        header('location:/bootcamp/todolist');
    }

}
?>