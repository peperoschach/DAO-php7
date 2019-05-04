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

            $this->setData($result[0]);

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

            $this->setData($result[0]);

        } else {
            throw new Exception( "Invalid login and/or password");

        }
    }

    public function setData($data)
    {
        $this->setIduser($data['iduser']);
        $this->setDeslogin($data['deslogin']);
        $this->setDespassword($data['despassword']);
        $this->setDtregister(new DateTime($data['dtregister']));
    }

    public function insert()
    {
        $sql = new Sql();

        $result = $sql->select("CALL sp_users_insert(:LOGIN, :PASSWORD)", array(
            ':LOGIN'=>$this->getDeslogin(),
            ':PASSWORD'=>$this->getDespassword()
        ));

        if (isset($result[0])) {
            $this->setData($result[0]);
        }
    }

    public function update($login, $password)
    {
        $this->setDeslogin($login);
        $this->setDespassword($password);

        $sql = new Sql();

        $sql->query("UPDATE tb_users SET deeslogin = :LOGIN, despassword = :PASSWORD WHERE iduser = :ID", array(
            ':LOGIN'=>$this->getDeslogin(),
            ':PASSWORD'=>$this->getDespassword(),
            ':ID'=>$this->getIduser()
        ));
    }

    public function __construct($login =  "", $password = "")
    {
        $this->setDeslogin($login);
        $this->setDespassword($password);
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
