<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
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


    public function index()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email', [
            'required' => 'email harus diisi',
            'valid_email' => 'format email tidak sesuai',
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|trim', [
            'required' => 'password harus diisi',
        ]);

        if ($this->form_validation->run() == false) {
            $data['title'] = "Login";
            $this->load->view('layout/header', $data);
            $this->load->view('auth/login');
        } else {
            $this->_login();
        }
    }

    public function register()
    {
        $this->form_validation->set_rules('name', 'Name', 'required|trim', [
            'required' => 'nama harus diisi'
        ]);
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'required' => 'email harus diisi',
            'valid_email' => 'format email tidak sesuai',
            'is_unique' => 'email sudah digunakan',
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[4]|matches[password2]', [
            'required' => 'password harus diisi',
            'matches' => 'password tidak sama',
            'min_length' => 'password terlalu pendek'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password]');
        if ($this->form_validation->run() == false) {
            $data['title'] = "Daftar";
            $this->load->view('layout/header', $data);
            $this->load->view('auth/register');
        } else {
            $data = [
                'name' => htmlspecialchars($this->input->post('name', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'gender' => $this->input->post('gender'),
                'image' => 'default.jpg',
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'role_id' => 2,
                'is_active' => 1,
                'created_at' => time()
            ];
            $this->db->insert('user', $data);
            $this->session->set_flashdata('message', ' <div class="alert alert-success">user berhasil ditambahkan</div>');
            redirect('auth');
        }
    }

    private function _login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $user = $this->db->get_where('user', ['email' => $email])->row_array();
        if ($user) {
            if ($user['is_active'] == 1) {
                if (password_verify($password, $user['password'])) {
                    $data = [
                        'email' => $user['email'],
                        'role_id' => $user['role_id'],
                    ];
                    $this->session->set_userdata($data);
                    if ($user['role_id'] == 1) {
                        redirect('admin');
                    } elseif ($user['role_id'] == 2) {
                        redirect('user');
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger">Password salah</div>');
                    redirect('auth');
                }
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Email belum terdaftar</div>');
            redirect('auth');
        }
    }

    public function forgot_password()
    {
        $data['title'] = "Lupa Password";
        $this->load->view('layout/header', $data);
        $this->load->view('auth/forgot-password');
    }

    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');
        $this->session->set_flashdata('message', ' <div class="alert alert-success">kamu berhasil logout</div>');
        redirect('auth');
    }

    public function blocked()
    {
        $this->load->view('auth/blocked');
    }
}