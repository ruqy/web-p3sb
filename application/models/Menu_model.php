<?php
class Menu_model extends CI_Model
{

    public $title;
    public $content;
    public $date;

    public function get_menu()
    {
        $role_id = $this->session->userdata('role_id');
        $qry = "SELECT user_menu.id, menu FROM user_menu JOIN user_access_menu ON user_menu.id=user_access_menu.menu_id WHERE user_access_menu.role_id = $role_id ORDER BY user_access_menu.menu_id ASC ";
        return $this->db->query($qry)->result_array();
    }

    public function get_sub_menu($menu_id)
    {
        $qry = "SELECT * FROM user_sub_menu WHERE menu_id = $menu_id AND is_active = 1";
        return $this->db->query($qry)->result_array();
    }

    public function get_menu_name()
    {
        $qry = "SELECT user_sub_menu.*, user_menu.menu FROM user_sub_menu JOIN user_menu ON user_sub_menu.menu_id = user_menu.id";
        return $this->db->query($qry)->result_array();
    }

    public function insert_entry()
    {
        $this->title = $_POST['title']; // please read the below note
        $this->content = $_POST['content'];
        $this->date = time();

        $this->db->insert('entries', $this);
    }

    public function update_entry()
    {
        $this->title = $_POST['title'];
        $this->content = $_POST['content'];
        $this->date = time();

        $this->db->update('entries', $this, array('id' => $_POST['id']));
    }
}