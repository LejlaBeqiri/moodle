<?php
include './core/Database.php';

class Homework{
    protected $asm;

    public function __construct()
    {
        $this->asm = new Database;
    }

    public function myHomework($user_id)
    {
        $query = $this->asm->pdo->prepare('
            SELECT sa.id, sa.student_id, sa.title, sa.description, sa.score, sa.semester, sa.file, sa.evaluated, professor_assignment.course_id
            FROM (student_assignment sa
                INNER JOIN professor_assignment ON sa.professor_assignment_id = professor_assignment.id)
                WHERE sa.student_id = :user_id

        ');

         $query->bindParam(':user_id', $user_id);
         $query->execute();

        return $query->fetchAll();
    }

    public function allAssignments()
    {
      
        $query = $this->asm->pdo->prepare('
            SELECT p.id, p.title, p.description, p.due, c.name
            FROM professor_assignment p
            INNER JOIN courses c
            ON p.course_id = c.id
        ');

         $query->execute();

        return $query->fetchAll();
    }


    public function get_course($id){
        $query=$this->asm->pdo->prepare('SELECT name FROM courses where id =:id');
        $query->bindParam('id', $id);
        $query->execute();
        return $query->fetchColumn();
    }

    public function update($assignment_id, $request)
    {
      
        $query = $this->asm->pdo->prepare('UPDATE student_assignment SET score = :score, evaluated = 1 WHERE id = :id');
        $query->bindParam(':id', $assignment_id);
        $query->bindParam(':score', $request['score']);
        
        $query->execute();
    }


    public function destroy($cid)
    {
        $query = $this->asm->pdo->prepare('DELETE FROM student_assignment WHERE id = :cid');
        $query->execute(['cid' => $cid]);

        
        return header('Location: ./coursepanel.php');
    }

    public function user($id){
        $query=$this->asm->pdo->prepare('SELECT name FROM users where id=:id');
        $query->bindParam(':id', $id);
        $query->execute();
        return $query->fetchAll();
    }




    public function courses($id)
    {
        $query=$this->asm->pdo->prepare('SELECT * FROM courses where professor_id=:id');
        $query->bindParam(':id', $id);
        $query->execute();
        return $query->fetchAll();
    }
    
    public function search($request){

        $query = $this->asm->pdo->prepare('
            SELECT sa.id, sa.title, sa.description, sa.score, sa.semester, sa.file, sa.evaluated, professor_assignment.course_id
            FROM (student_assignment sa
                INNER JOIN professor_assignment ON sa.professor_assignment_id = professor_assignment.id)
                WHERE semester = :semester

        ');

        $query->bindParam(':semester', $request);
        $query->execute();

        return $query->fetchAll();
    
   

    }


    public function get_all_courses(){
        $query=$this->asm->pdo->prepare('SELECT * FROM courses');
        $query->execute();
        return $query->fetchAll();
    }


}