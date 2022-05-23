<?php
include './core/Database.php';

class AssignmentController{
    protected $asm;

    public function __construct()
    {
        $this->asm = new Database;
    }

    public function all($user_id)
    {
      
        $query = $this->asm->pdo->prepare('
            SELECT p.id, p.title, p.description, p.due, c.name
            FROM professor_assignment p
            INNER JOIN courses c
            ON p.course_id = c.id
            WHERE p.professor_id = :user_id
        ');

        
         $query->bindParam(':user_id', $user_id);
         $query->execute();

        return $query->fetchAll();
    }

    public function get_courses($id){
        $query=$this->asm->pdo->prepare('SELECT * FROM courses where semester=:sem');
        $query->bindParam(':sem', $id);
        $query->execute();
        return $query->fetchAll();
    }

    // request = $_POST[key=>value]
    public function store($request){
        
        $query = $this->asm->pdo->prepare('INSERT INTO professor_assignment (title, description, professor_id, course_id, due) VALUES (:title,:description,:professor_id,:course_id, :due)');
        $query->bindParam(':title', $request['title']);
        $query->bindParam(':description', $request['description']);
        $query->bindParam(':professor_id', $request['user_id']);
        $query->bindParam(':course_id', $request['selectCourse']);
        $query->bindParam(':due', $request['due']);

        $query->execute();
    
    }

    public function edit($id){
        $query = $this->asm->pdo->prepare('SELECT * FROM courses WHERE id = :id');
        $query->execute(['id' => $id]);

        return $query->fetch();
        }


    public function update($course_id, $request)
    {
        $query = $this->asm->pdo->prepare('UPDATE courses SET name = :name, semester =:semester, professor_id =:professor_id  WHERE id = :id');
        $query->bindParam(':name', $request['coursename']);
        $query->bindParam(':semester', $request['selectSemester']);
        $query->bindParam(':professor_id', $request['selectProfessor']);
        $query->bindParam(':id', $course_id);
        $query->execute();

        return header('Location: ./coursepanel.php');
    }


    public function destroy($cid)
    {
        $query = $this->asm->pdo->prepare('DELETE FROM courses WHERE id = :cid');
        $query->execute(['cid' => $cid]);

        
        return header('Location: ./coursepanel.php');
    }

    public function professor($id){
        $query=$this->asm->pdo->prepare('SELECT name FROM users where id=:id');
        $query->bindParam(':id', $id);
        $query->execute();
        return $query->fetchAll();
    }

    public function professors()
    {
        $query = $this->asm->pdo->query('SELECT * FROM users WHERE role_id = 1');

        return $query->fetchAll();
    }

    public function students()
    {
        $query = $this->asm->pdo->query('SELECT * FROM users WHERE role_id = 1');

        return $query->fetchAll();
    }


    public function courses()
    {
        $query = $this->asm->pdo->query('SELECT * FROM courses');

        return $query->fetchAll();
    }



}