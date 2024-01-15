<?php

namespace Models;

class RoomRepository extends Model{

    public function exist($name): bool
    {
        $sql = "SELECT * FROM ecran_rooms WHERE name LIKE '%" . $name . "%'";
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute([$name]);
        if($stmt->fetch()){
            return true;
        }
        return false;
    }

    public function add($name) : void {
        $sql = "INSERT INTO ecran_rooms(name) VALUES (?)";
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute([$name]);
    }

    /**
     * @return Room[]
     */
    public function getAllComputerRooms(){
        $sql = "SELECT * FROM ecran_rooms WHERE isComputerRoom=TRUE";
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute();
        $roomList = [];

        while($row = $stmt->fetch()){
            $roomList[] = new Room($row['name']);
        }
        return $roomList;
    }

    public function getAllRoom(){
        $sql = "SELECT * FROM ecran_rooms";
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute();
        $roomList = [];

        while($row = $stmt->fetch()){
            $roomList[] = new Room($row['name']);
        }
        return $roomList;
    }


}
