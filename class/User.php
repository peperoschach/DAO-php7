<?php

class User {

    private $iduser;
    private $deslogin;
    private $despassword;
    private $dtregister;


    public function getIduser()
    {
        return $this->iduser;
    }

    public function setIduser($iduser)
    {
        $this->iduser = $iduser;

        return $this;
    }

    public function getDeslogin()
    {
        return $this->deslogin;
    }

    public function setDeslogin($deslogin)
    {
        $this->deslogin = $deslogin;

        return $this;
    }

    public function getDespassword()
    {
        return $this->despassword;
    }

    public function setDespassword($despassword)
    {
        $this->despassword = $despassword;

        return $this;
    }

    public function getDtregister()
    {
        return $this->dtregister;
    }

    public function setDtregister($dtregister)
    {
        $this->dtregister = $dtregister;

        return $this;
    }

    public function loadById($id)
    {
        $sql = new Sql();

        $result = $sql->select("SELECT * FROM tb_users WHERE iduser = :ID", array(
            ":ID"=>$id
        ));

        if (isset($result[0])) {

            $row = $result[0];

            $this->setIduser($row['iduser']);
            $this->setDeslogin($row['deslogin']);
            $this->setDespassword($row['despassword']);
            $this->setDtregister(new DateTime($row['dtregister']));

        }
    }

    public static function getList()
    {
        $sql = new Sql();

        return $sql->select("SELECT * FROM tb_users ORDER BY deslogin");
    }

    public static function search($login)
    {
        $sql = new Sql();

        return $sql->select("SELECT * FROM tb_users WHERE deslogin LIKE :SEARCH ORDER BY deslogin", array(
            ':SEARCH'=>"%" . $login . "%"
        ));
    }

    public function login($login, $password)
    {
        $sql = new Sql();

        $result = $sql->select("SELECT * FROM tb_users WHERE deslogin = :LOGIN AND despassword= :PASSWORD ", array(
            ":LOGIN" => $login,
            ":PASSWORD"=>$password
        ));

        if (isset($result[0])) {

            $row = $result[0];

            $this->setIduser($row['iduser']);
            $this->setDeslogin($row['deslogin']);
            $this->setDespassword($row['despassword']);
            $this->setDtregister(new DateTime($row['dtregister']));
        } else {
            throw new Exception( "Invalid login and/or password");

        }
    }

    public function __toString()
    {
        return json_encode(array(
            "iduser"=>$this->getIduser(),
            "deslogin"=>$this->getDeslogin(),
            "despassword"=>$this->getDespassword(),
            "dtregister"=>$this->getDtregister()->format("d/m/Y H:i:s")
        ));
    }
}
