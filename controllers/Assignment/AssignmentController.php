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
            SELECT p.title, p.description, p.due, c.name
            FROM professor_assignment p
            INNER JOIN courses c
            ON p.course_id = c.id
            WHERE p.id = :user_id
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

    public function store($request){
        
        $query = $this->asm->pdo->prepare('INSERT INTO courses (name,semester, professor_id) VALUES (:name,:semester,:professor_id)');
        $query->bindParam(':name', $request['coursename']);
        $query->bindParam(':semester', $request['selectSemester']);
        $query->bindParam(':professor_id', $request['selectProfessor']);

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



}