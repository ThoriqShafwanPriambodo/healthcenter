<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Poligigi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('m_poligigi'));
    }
    public function index()
    {
        $data['poligigi'] = $this->m_poligigi->get_queues_data();
        $data['js'] = 'poligigi';


        $this->load->view('header', $data);
        $this->load->view('poligigi/v_poligigi.php', $data);
        $this->load->view('footer', $data);
    }
    public function load_poligigi()
    {
        $data['poligigi'] = $this->m_poligigi->get_queues_data();
        echo json_encode($data);
    }

    public function load_patient()
    {
        $data['patient'] = $this->m_poligigi->get_patient_data();
        echo json_encode($data);
    }

    public function load_poli()
    {
        $data['poli'] = $this->m_poligigi->get_poli_data();
        echo json_encode($data);
    }

    public function create()
    {
        $queuesPolyclinicId = $this->input->post('poli');
        $queuesPatientId = $this->input->post('nama');

        $sql = "SELECT IFNULL(
            (
                SELECT CONCAT(
                    'GI/', 
                    DATE_FORMAT(CURRENT_DATE(), '%m%d'), '/', 
                    LPAD(RIGHT(MAX(queuesNo), 3) + 1, 3, '0')
                ) AS no_trans
                FROM queues
                WHERE queuesNo LIKE CONCAT(
                    'GI/', DATE_FORMAT(CURRENT_DATE(), '%m%d'), '/%')
                AND DATE_FORMAT(CURRENT_DATE(), '%d%m')
                ORDER BY queuesNo DESC
                LIMIT 1
            ), 
            CONCAT('GI/', DATE_FORMAT(CURRENT_DATE(), '%m%d'), '/001')
        ) AS no_trans;";

        $no_trans = $this->db->query($sql)->row()->no_trans;
        $sql2 = "INSERT INTO queues (queuesPolyclinicId, queuesPatientId, queuesNo, queuesRegTime) VALUES ('{$queuesPolyclinicId}','{$queuesPatientId}','{$no_trans}', NOW())";
        $exc = $this->db->query($sql2);

        if ($exc) {
            $patientNameQuery = "SELECT patientName FROM patient WHERE patientId = '{$queuesPatientId}'";
            $patientName = $this->db->query($patientNameQuery)->row()->patientName;
                
            $res['status'] = 'success';
            $res['msg'] = "{$patientName} berhasil ditambahkan ke antrian";
        } else {
            $res['status'] = 'error';
            $res['msg'] = "Pasien gagal ditambahkan ke antrian";
        }

        echo json_encode($res);
    }

    public function status_data()
    {
        $id = $this->input->post("id");
        $status = $this->input->post("status");

        // Menentukan deskripsi berdasarkan status
        if ($status == 1) {
            $action = "telah dilayani"; // Selesai
        } elseif ($status == 0) {
            $action = "sedang dilayani"; // Menunggu
        } elseif ($status == 2) {
            $action = "harus menunggu kembali"; // Dilayani
        } else {
            $action = "unknown";
        }

        $isSuccess = $this->m_poligigi->status_data($id, $status); // Update status data

        if ($isSuccess) {
            $res["status"] = "success";
            $res["msg"] = "Pasien " . $action;
        } else {
            $res["status"] = "error";
            $res["msg"] = "Pasien " . $action;
        }

        echo json_encode($res);
    }
}
