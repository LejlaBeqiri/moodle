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

    public function get_assignments_from_course($id){
        $query=$this->asm->pdo->prepare('SELECT * FROM professor_assignment where course_id=:id');
        $query->bindParam(':id', $id);
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
        $query = $this->asm->pdo->prepare('SELECT * FROM professor_assignment WHERE id = :id');
        $query->execute(['id' => $id]);

        return $query->fetch();
     }

     public function show($id){
        $query = $this->asm->pdo->prepare('
        SELECT p.id, p.title, p.description, p.due, c.name
        FROM professor_assignment p
        INNER JOIN courses c
        ON p.course_id = c.id
        WHERE p.id = :id');
        $query->execute(['id' => $id]);

        return $query->fetch();
     }


    public function update($assignment_id, $request)
    {
      
        $query = $this->asm->pdo->prepare('UPDATE professor_assignment SET title = :title, description =:description, professor_id =:professor_id, course_id=:course_id, due=:due  WHERE id = :id');
        $query->bindParam(':title', $request['title']);
        $query->bindParam(':description', $request['description']);
        $query->bindParam(':professor_id', $request['user_id']);
        $query->bindParam(':course_id', $request['selectCourse']);
        $query->bindParam(':due', $request['due']);
        $query->bindParam(':id', $assignment_id);

       
        $query->execute();

        return header('Location: ./assignments.php');
    }


    public function destroy($cid)
    {
        $query = $this->asm->pdo->prepare('DELETE FROM professor_assignment WHERE id = :cid');
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


    public function courses($id)
    {
        $query=$this->asm->pdo->prepare('SELECT * FROM courses where professor_id=:id');
        $query->bindParam(':id', $id);
        $query->execute();
        return $query->fetchAll();
    }



}