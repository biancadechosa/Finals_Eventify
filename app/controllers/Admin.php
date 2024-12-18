<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Admin extends Controller {

    public function __construct()
    {
        parent::__construct();
        $this->call->model('Admin_model');
    }

    public function dashboard()
    {
        $data['events'] = $this->Admin_model->get_all_events();
        $this->call->view('admin/dashboard', $data);
    }

    public function approve($id)
    {
        if ($this->Admin_model->approve_event($id)) {
            redirect('/admin/dashboard');
        } else {
        
        }
    }

   
    public function reject($id)
    {
        if ($this->Admin_model->reject_event($id)) {
            redirect('/admin/dashboard');
        } else {
            
        }
    }

    
    public function delete($id)
    {
        if ($this->Admin_model->delete_event($id)) {
            redirect('/admin/dashboard');
        } else {
           
        }
    }
}
?>
