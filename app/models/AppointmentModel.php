<?php
class AppointmentModel
{
    private $con;
    public function __construct()
    {
        $this->con = new Database();
    }
    public function myAppointments($p_id)
    {
        $this->con->query("SELECT * FROM appointment WHERE p_id = :p_id");
        $this->con->bind(':p_id', $p_id);
        return $this->con->getAll();
    }
    public function searchByDay($date)
    {
        $this->con->query("SELECT a_date FROM appointment WHERE a_date LIKE CONCAT(:a_date,'%')");
        $this->con->bind(':a_date', $date);
        return $this->con->getAll();
    }
    public function reserve($p_id, $date)
    {
        $this->con->query("SELECT * FROM appointment WHERE a_date LIKE CONCAT(:a_date,'%')");
        $this->con->bind(':a_date', date('Y-m-d h', strtotime($date)));
        $this->con->getSingleResult();
        if ($this->con->getRowCount() > 0) {
            return false;
        } else {
            $this->con->query("INSERT INTO appointment (p_id,a_date) values (:p_id,:a_date)");
            $this->con->bind(':p_id', $p_id);
            $this->con->bind(':a_date', $date);
            if ($this->con->execute()) {
                return true;
            } else {
                return false;
            }
        }
    }
    public function cancel_appointment($p_id, $a_id)
    {
        $this->con->query("DELETE FROM appointment WHERE a_id = :a_id AND p_id = :p_id");
        $this->con->bind(':a_id', $a_id);
        $this->con->bind(':p_id', $p_id);
        if ($this->con->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function edit_appointment($p_id, $a_id, $date)
    {
        $this->con->query("SELECT * FROM appointment WHERE a_date LIKE CONCAT(:a_date,'%')");
        $this->con->bind(':a_date', date('Y-m-d h', strtotime($date)));
        $this->con->getSingleResult();
        
        if ($this->con->getRowCount() > 0) {
            return false;
        } else {
            $this->con->query("UPDATE appointment SET `a_date`=:a_date  WHERE p_id = :p_id AND a_id = :a_id");
            $this->con->bind(':p_id', $p_id);
            $this->con->bind(':a_id', $a_id);
            $this->con->bind(':a_date', $date);
            if ($this->con->execute()) {
                return true;
            } else {
                return false;
            }
        }
    }
}
