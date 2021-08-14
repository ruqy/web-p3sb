<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
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
        $data['title'] = 'Profil';
        $data['heading'] = 'My Profile';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['role'] = $this->db->get_where('user_role', ['id' => $data['user']['role_id']])->row_array();

        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar');
        $this->load->view('layout/navbar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('layout/footer');
    }

    private function _uploadImage($id, $old_image)
    {
        $config['upload_path'] = './asset/img/profil/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['file_name']    = $id;
        $config['overwrite']     = true;
        $config['max_size']      = 1024;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('image')) {
            $this->session->set_flashdata('success', 'user berhasil diubah');
            return $this->upload->data("file_name");
        } else {
            if ($this->upload->data('file_size') != NULL)
                $this->session->set_flashdata('error', 'foto harus berupa file jpg, png, jpeg, & ukuran maksimal 1Mb ');
        }
        return $old_image;
    }

    public function edit()
    {

        $data['title'] = 'Edit Profile';
        $data['heading'] = 'Edit Profile';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();


        $this->form_validation->set_rules('name', 'Name', 'required', [
            'required' => 'nama tidak boleh kosong',
        ]);

        if ($this->form_validation->run() == true) {
            $db = [
                'name' => $this->input->post('name'),
                'image' => $this->_uploadImage($data['user']['id'], $data['user']['image']),
            ];
            //cek adakah data yang berubah
            if ($db['name'] != $data['user']['name'] || $db['image'] != $data['user']['image']) {
                $this->session->set_flashdata('success', 'user berhasil diubah.');
                $this->db->where('id', $data['user']['id'])->set($db)->update('user');
            }
            redirect('user');
        } else {
            $this->load->view('layout/header', $data);
            $this->load->view('layout/sidebar');
            $this->load->view('layout/navbar', $data);
            $this->load->view('user/edit', $data);
            $this->load->view('layout/footer');
        }
    }
}