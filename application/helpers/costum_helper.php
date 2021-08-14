<?php
function check_access($role_id, $menu_id)
{
    $ci = get_instance();
    $access = $ci->db->where(['role_id' => $role_id, 'menu_id' => $menu_id])->count_all_results('user_access_menu');

    if ($access < 1) {
        return false;
    } else {
        return true;
    }
}

function is_logged_in()
{
    $ci = get_instance();
    if (!$ci->session->userdata('email')) {
        redirect('auth');
    } else {
        $role_id = $ci->session->userdata('role_id');
        $menu = $ci->uri->segment(1);
        $qryMenu = $ci->db->get_where('user_menu', ['menu' => $menu])->row_array();
        $menu_id = $qryMenu['id'];
        $access = $ci->db->where(['role_id' => $role_id, 'menu_id' => $menu_id])->count_all_results('user_access_menu');
        if ($access < 1) {
            redirect('auth/blocked');
        }
    }
}

function csrf_field()
{
    $ci = get_instance();
    $csrf_name = $ci->security->get_csrf_token_name();
    $csrf_hash = $ci->security->get_csrf_hash();
    $input     = '<input type="hidden" name="' . $csrf_name . '" value="' . $csrf_hash . '">';
    return $input;
}