<?php

class Users extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();       
        $this->load->model('user');
    }

    //------- loading login page------
    public function index()
    {
        
        if (!$this->session->userdata('user_id')) {
            $this->login();
        }
    }

    /**
     * @author Sreemol S
     * Function for luser login-----
     *
     */
    public function login()
    {
        $data = array();
        if ($this->input->post()) {
            $email = $this->input->post('email');
            $password = md5($this->input->post('password'));

            $validUser = $this->user->authenticate($email, $password);

            if ($validUser !== false) {
                    $this->session->set_userdata('user_info', $validUser);
                    
                    redirect('schedules');

            } else {
                $data['registered'] = "Incorrect Email or Password";
            }
        }

        
        $data['content'] = $this->load->view('users/login', $data, true);
        $this->load->view('layouts/main', $data);
    }

    public function logout()
    {
        $this->session->unset_userdata('user_info');
        
        header('location:' . '.');
    }
    
}

?>
