<?php
class M_patient extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function insert_patient($data)
    {
        return $this->db->insert('patient', $data);
    }
    public function get_patient_data()
    {
        $sql = "SELECT * FROM patient WHERE patientDelete = 0 ORDER BY patientId DESC";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function delete_data($id)
    {
        $sql = "UPDATE patient SET patientDelete = 1 WHERE patientId = '$id'";
        return $this->db->query($sql, array($id));
    }
}