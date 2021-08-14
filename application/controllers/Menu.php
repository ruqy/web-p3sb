<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
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
        $data['heading'] = 'Menu Management';
        $data['menu'] = $this->db->get('user_menu')->result_array();
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('menu', 'Menu', 'required', [
            'required' => 'Menu harus diisi',
        ]);

        if ($this->form_validation->run() == false) {
            $this->load->view('layout/header', $data);
            $this->load->view('layout/sidebar');
            $this->load->view('layout/navbar', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('layout/footer');
        } else {
            $db['menu'] = $this->input->post('menu');
            $this->db->insert('user_menu', $db);
            $this->session->set_flashdata('success', 'menu berhasil ditambah');
            redirect('menu');
        }
    }

    public function edit($id)
    {
        $data['menu'] = $this->input->post('menu');
        $this->db->where('id', $id)->update('user_menu', $data);
        $this->session->set_flashdata('success', 'menu berhasil diubah');
        redirect('menu');
    }

    public function delete($id)
    {
        if ($this->input->post('_method') == 'DELETE') {
            $this->db->where('id', $id)->delete('user_menu');
            $this->session->set_flashdata('success', 'menu berhasil dihapus');
        }
        redirect('menu');
    }

    public function submenu()
    {
        $data['heading'] = 'Submenu Management';
        $data['menu'] = $this->db->get('user_menu')->result_array();
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['subMenu'] = $this->menuModel->get_menu_name();

        $this->form_validation->set_rules('submenu', 'Submenu', 'required', [
            'required' => 'Submenu harus diisi',
        ]);

        $this->form_validation->set_rules('menu_id', 'Menu', 'required', [
            'required' => 'Menu harus dipilih',
        ]);
        $this->form_validation->set_rules('url', 'Url', 'required', [
            'required' => 'Url harus diisi',
        ]);
        $this->form_validation->set_rules('icon', 'Icon', 'required', [
            'required' => 'Icon harus diisi',
        ]);

        if ($this->form_validation->run() == false) {
            $this->load->view('layout/header', $data);
            $this->load->view('layout/sidebar');
            $this->load->view('layout/navbar', $data);
            $this->load->view('menu/submenu', $data);
            $this->load->view('layout/footer');
        } else {
            $db = [
                'submenu' => $this->input->post('submenu'),
                'menu_id' => $this->input->post('menu_id'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'is_active' => $this->input->post('is_active'),
            ];
            $this->db->insert('user_sub_menu', $db);
            $this->session->set_flashdata('success', 'submenu berhasil ditambah');
            redirect('menu/submenu');
        }
    }

    public function submenu_edit($id)
    {
        $db = [
            'submenu' => $this->input->post('submenu'),
            'menu_id' => $this->input->post('menu_id'),
            'url' => $this->input->post('url'),
            'icon' => $this->input->post('icon'),
            'is_active' => $this->input->post('is_active'),
        ];
        $this->db->where('id', $id)->update('user_sub_menu', $db);
        $this->session->set_flashdata('success', 'submenu berhasil diubah');
        redirect('menu/submenu');
    }

    public function submenu_delete($id)
    {
        if ($this->input->post('_method') == 'DELETE') {
            $this->db->where('id', $id)->delete('user_sub_menu');
            $this->session->set_flashdata('success', 'submenu berhasil dihapus');
        }
        redirect('menu/submenu');
    }

    public function role()
    {
        $data['heading'] = "Role Management";
        $data['role'] = $this->db->get('user_role')->result_array();
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('role', 'Role', 'required', [
            'required' => 'Role harus diisi',
        ]);

        if ($this->form_validation->run() == false) {
            $this->load->view('layout/header', $data);
            $this->load->view('layout/sidebar');
            $this->load->view('layout/navbar', $data);
            $this->load->view('menu/role', $data);
            $this->load->view('layout/footer');
        } else {
            $db['role'] = $this->input->post('role');
            $this->db->insert('user_role', $db);
            $this->session->set_flashdata('success', 'role berhasil ditambah');
            redirect('menu/role');
        }
    }

    public function role_edit($id)
    {
        $db = [
            'role' => $this->input->post('role'),
        ];
        $this->db->where('id', $id)->update('user_role', $db);
        $this->session->set_flashdata('success', 'role berhasil diubah');
        redirect('menu/role');
    }

    public function role_delete($id)
    {
        if ($this->input->post('_method') == 'DELETE') {
            $this->db->where('id', $id)->delete('user_role');
            $this->session->set_flashdata('success', 'role berhasil dihapus');
        }
        redirect('menu/role');
    }
}