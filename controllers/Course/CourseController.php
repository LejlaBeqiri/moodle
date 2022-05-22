<?php
include './core/Database.php';

class CourseController{
    protected $course;

    public function __construct()
    {
        $this->course = new Database;
    }

    public function all()
    {
        $query = $this->course->pdo->query('SELECT * FROM courses');

        return $query->fetchAll();
    }

    public function get_courses($id){
        $query=$this->course->pdo->prepare('SELECT * FROM courses where semester=:sem');
        $query->bindParam(':sem', $id);
        $query->execute();
        return $query->fetchAll();
    }

    public function store($request){
        
        $query = $this->course->pdo->prepare('INSERT INTO courses (name,semester, professor_id) VALUES (:name,:semester,:professor_id)');
        $query->bindParam(':name', $request['coursename']);
        $query->bindParam(':semester', $request['semester']);
        $query->bindParam(':professor_id', $request['professor_id']);

        $query->execute();
    
    }

    public function edit($id){
        $query = $this->course->pdo->prepare('SELECT * FROM courses WHERE id = :id');
        $query->execute(['id' => $id]);

        return $query->fetch();
        }


    public function update($course_id, $request)
    {
        $query = $this->course->pdo->prepare('UPDATE courses SET title = :cname, category =:cid WHERE course_id = :id');
        $query->execute([
            'cname' => $request['coursename'],
            'cid' => $request['selectCategory'],
            'id'=> $course_id
        ]);

        return header('Location: ./coursespanel.php');
    }


    public function destroy($cid)
    {
        $query = $this->course->pdo->prepare('DELETE FROM courses WHERE course_id = :cid');
        $query->execute(['cid' => $cid]);

        
        return header('Location: ./coursespanel.php');
    }

    public function professor($id){
        $query=$this->course->pdo->prepare('SELECT name FROM users where id=:id');
        $query->bindParam(':id', $id);
        $query->execute();
        return $query->fetchAll();
    }

    public function professors()
    {
        $query = $this->course->pdo->query('SELECT * FROM users WHERE role_id = 1');

        return $query->fetchAll();
    }

    public function students()
    {
        $query = $this->course->pdo->query('SELECT * FROM users WHERE role_id = 1');

        return $query->fetchAll();
    }



}