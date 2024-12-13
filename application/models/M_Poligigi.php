<?php
class M_poligigi extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function insert_queues($data)
    {
        return $this->db->insert('queues', $data);
    }

    public function get_queues_data()
    {
        $sql = "SELECT * FROM queues
        JOIN patient ON patientId = queuesPatientId
        JOIN polyclinic ON polyclinicId = queuesPolyclinicId
        WHERE polyclinicId = 3 ORDER BY queuesId DESC";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function get_patient_data()
    {
        $sql = "SELECT * FROM patient ORDER BY patientId DESC";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function get_poli_data()
    {
        $sql = "SELECT * FROM polyclinic WHERE polyclinicId = 3";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function status_data($id)
    {
        // Update query dengan kondisi untuk tiga status (0, 1, 2)
        $sql = "UPDATE queues 
            SET queuesStatus = CASE 
                WHEN queuesStatus = 0 THEN 1   -- Jika 0, set jadi 1
                WHEN queuesStatus = 1 THEN 2   -- Jika 1, set jadi 2
                ELSE queuesStatus              -- Jika tidak ada, biarkan tetap
            END 
            WHERE queuesId = '$id'";

        return $this->db->query($sql);
    }
}
