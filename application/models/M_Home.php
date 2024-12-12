<?php
class M_home extends CI_Model
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
        $sql = "SELECT COUNT(*) AS jumlah FROM patient WHERE patientDelete = 0";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function get_poli_data()
    {
        $sql = "SELECT COUNT(*) AS jumlah FROM polyclinic";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function get_queues_data()
    {
        $sql = "SELECT * FROM queues
        JOIN patient ON patientId = queuesPatientId
        JOIN polyclinic ON polyclinicId = queuesPolyclinicId
        ORDER BY queuesId DESC";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function get_umumqueue_data()
    {
        $sql = "SELECT COUNT(*) AS jumlah FROM queues WHERE queuesPolyclinicId = 1 AND queuesStatus = 0";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function get_gigiqueue_data()
    {
        $sql = "SELECT COUNT(*) AS jumlah FROM queues WHERE queuesPolyclinicId = 3 AND queuesStatus = 0";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function get_giziqueue_data()
    {
        $sql = "SELECT COUNT(*) AS jumlah FROM queues WHERE queuesPolyclinicId = 2 AND queuesStatus = 0";
        $query = $this->db->query($sql);
        return $query->result();
    }
}
