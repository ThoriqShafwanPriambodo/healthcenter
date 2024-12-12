<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('m_home'));
    }

    public function index()
	{
        $data['js'] = 'home';

        $this->load->view('header', $data);
		$this->load->view('home/v_home.php', $data);
        $this->load->view('footer', $data);
	}

    public function load_patient() 
    {
        $data['patient'] = $this->m_home->get_patient_data();
        echo json_encode($data);
    }

    public function load_poli() 
    {
        $data['poli'] = $this->m_home->get_poli_data();
        echo json_encode($data);
    }

    public function load_queues() 
    {
        $data['queues'] = $this->m_home->get_queues_data();
        echo json_encode($data);
    }

    public function load_umumqueue() 
    {
        $data['umum'] = $this->m_home->get_umumqueue_data();
        echo json_encode($data);
    }

    public function load_gigiqueue() 
    {
        $data['gigi'] = $this->m_home->get_gigiqueue_data();
        echo json_encode($data);
    }

    public function load_giziqueue() 
    {
        $data['gizi'] = $this->m_home->get_giziqueue_data();
        echo json_encode($data);
    }
}