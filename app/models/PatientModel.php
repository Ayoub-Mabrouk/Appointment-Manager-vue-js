<?php
class PatientModel
{
    private $con;
    public function __construct()
    {
        $this->con = new Database();
    }
    public function register($firstname, $lastname, $reference, $email, $password)
    {
        $this->con->query("SELECT * FROM patient WHERE email= :email OR p_reference= :reference");
        $this->con->bind(':reference', $reference);
        $this->con->bind(':email', $email);
        $this->con->getSingleResult();
        if ($this->con->getRowCount() > 0) {
            return false;
        } else {

            $this->con->query("INSERT INTO patient (`f_name`,`l_name`,`email`,`p_reference`,`password`) VALUES (:firstname,:lastname,:email,:reference,:password)");
            $this->con->bind(':firstname', $firstname);
            $this->con->bind(':lastname', $lastname);
            $this->con->bind(':email', $email);
            $this->con->bind(':reference', $reference);
            $this->con->bind(':password', PASSWORD_HASH($password, PASSWORD_DEFAULT));
            if ($this->con->execute()) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function login($email, $password)
    {

        $this->con->query("SELECT * FROM patient WHERE email= :email ");
        $this->con->bind(':email', $email);
        $row = $this->con->getSingleResult();
        if ($row) {
            if (password_verify($password, $row->password)) {
                unset($row->password);
                $array['status'] = true;
                $array['data'] = $row;
                return  $array;
            } else {
                $array['status'] = false;
                return $array;
            }
        } else {
            $array['status'] = false;
            return $array;
        }
    }
    public function loginByReference($p_reference)
    {
        $this->con->query("SELECT * FROM patient WHERE p_reference= :p_reference ");
        $this->con->bind(':p_reference', $p_reference);
        $row = $this->con->getSingleResult();
        if ($row) {
            unset($row->password);
            $array['status'] = true;
            $array['data'] = $row;
            return  $array;
        } else {
            $array['status'] = false;
            return $array;
        }
    }
}
