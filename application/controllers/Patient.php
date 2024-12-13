<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Patient extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('m_patient'));
    }
    public function index()
    {
        $data['patient'] = $this->m_patient->get_patient_data();
        $data['js'] = 'patient';


        $this->load->view('header', $data);
        $this->load->view('patient/v_patient.php', $data);
        $this->load->view('footer', $data);
    }
    public function load_patient()
    {
        $data['patient'] = $this->m_patient->get_patient_data();
        echo json_encode($data);
    }

    public function create()
    {
        $patientName = $this->input->post('nama');
        $patientGender = $this->input->post('gender');
        $patientBloodType = $this->input->post('goldarah');
        $patientNik = $this->input->post('nik');
        $patientPhoneNumber = $this->input->post('telepon');
        $patientPlaceOfBirth = $this->input->post('tempat');
        $patientDateOfBirth = $this->input->post('tanggal');
        $patientAddress = $this->input->post('alamat');


        $query = $this->db->query("SELECT COUNT(*) as count FROM patient WHERE patientNik = '{$patientNik}'");
        $result = $query->row();

        if ($result->count > 0) {
            $res['status'] = 'error';
            $res['msg'] = "Code {$patientNik} sudah terdaftar";
        } else {
            $sql = "INSERT INTO patient (patientName, patientGender, patientBloodType, patientNik, patientPhoneNumber, patientPlaceOfBirth, patientDateOfBirth, patientAddress) VALUES ('{$patientName}','{$patientGender}', '{$patientBloodType}' ,'{$patientNik}','{$patientPhoneNumber}','{$patientPlaceOfBirth}','{$patientDateOfBirth}','{$patientAddress}')";
            $exc = $this->db->query($sql);

            if ($exc) {
                $res['status'] = 'success';
                $res['msg'] = "Simpan data {$patientName} berhasil";
            } else {
                $res['status'] = 'error';
                $res['msg'] = "Simpan data {$patientName} gagal";
            }
        }
        echo json_encode($res);
    }

    public function detail()
    {
        $id = $this->input->post('id');
        $sql = $this->db->query("SELECT * FROM patient WHERE patientId = ?", array($id));
        $result = $sql->row_array();
        if ($result > 0) {
            $res['status'] = 'ok';
            $res['data'] = $result;
            $res['msg'] = "Data {$id} sudah ada";
        } else {
            $res['status'] = 'error';
            $res['msg'] = "Pasien tidak ditemukan";
        }
        echo json_encode($res);
    }

    public function delete_table()
    {
        if ($this->m_patient->delete_data($this->input->post('id'))) {
            $res['status'] = 'success';

            $res['msg'] = "Data berhasil dihapus";
        } else {
            $res['status'] = 'error';
            $res['msg'] = "Gagal menghapus data";
        }
        echo json_encode($res);
    }
}
