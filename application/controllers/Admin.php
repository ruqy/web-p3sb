<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['heading'] = 'Dashboard';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['role'] = $this->db->get('user_role')->result_array();
        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar');
        $this->load->view('layout/navbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('layout/footer');
    }

    public function role_access($id)
    {
        $data['heading'] = 'Role Access';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['role'] = $this->db->get_where('user_role', ['id' => $id])->row_array();
        $data['menu'] = $this->db->get_where('user_menu', ['id !=' => 1])->result_array();

        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar');
        $this->load->view('layout/navbar', $data);
        $this->load->view('admin/role_access', $data);
        $this->load->view('layout/footer');
    }

    public function changeAccess()
    {
        $menuId = $this->input->post('menuId');
        $roleId = $this->input->post('roleId');
        $db = [
            'role_id' => $roleId,
            'menu_id' => $menuId,
        ];

        $result = $this->db->get_where('user_access_menu', $db);

        if ($result->num_rows() < 1) {
            $this->db->insert('user_access_menu', $db);
            $this->session->set_flashdata('success', 'akses ditambah');
        } else {
            $this->db->delete('user_access_menu', $db);
            $this->session->set_flashdata('success', 'akses dihapus');
        }
    }
}