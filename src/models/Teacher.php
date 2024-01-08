<?php

namespace Models;

class Teacher extends Model
{

    public function exist($name) : bool {
        $sql = "SELECT * FROM teacher WHERE name LIKE '%" . $name . "%'";
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute([$name]);
        if($stmt->fetch()){
            return true;
        }
        return false;
    }

    public function add($name) : void {
        $sql = "INSERT INTO teacher(name) VALUES (?)";
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute([$name]);
    }

    public function getTeacherList(){
        $teacherList = [];
        $sql = "SELECT * FROM teacher";
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute();
        while($row = $stmt->fetch()){
            $teacherList[] = $row['name'];
        }

        return $teacherList;

    }
}