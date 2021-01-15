<?php

require_once 'user.php';

class admin extends user{

    public function deleteUser ($id){
        $query = $this->pdo -> prepare("DELETE from utilisateurs WHERE id=:id");
        $query->execute(["id"=>$id]);
    }

    public function changeStatus ($status, $id){
        if ($status=="Modérateur"){
            $status="mod";
        }
        if ($status=="Administrateur"){
            $status="admin";
        }
        if ($status=="Membre"){
            $status="membre";
        }

        $query = $this->pdo->prepare("UPDATE utilisateurs SET status=:status where id=:id");
        $query -> execute(["status" => $status, "id" => $id]);
    }

}
