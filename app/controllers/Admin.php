<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Admin extends Controller {

    public function __construct()
    {
        parent::__construct();
        $this->call->model('Admin_model');

        $host = 'localhost';
        $db = 'eventify';
        $user = 'root';
        $pass = '';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
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

    public function manageApplications() {
        // Query to fetch all organizer applications with user information
        $query = "
            SELECT 
                a.apply_id,
                a.name,
                a.email,
                a.phone,
                a.experience,
                a.event_type,
                a.picture,
                a.status,
                u.role AS user_role,
                a.created_at,
                a.user_id
            FROM apply a
            LEFT JOIN users u ON a.user_id = u.id";
    
        // Prepare the query and execute
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
    
        // Fetch the results
        $apply = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Pass data to the view
        $this->call->view('admin/manage_application', ['apply' => $apply]);
    }
    

    public function Approve_application()
    {
        $user_id = $this->io->post('user_id'); // Get user_id from POST data
        $role = 'organizer'; // New role to set
    
        if (!$user_id) {
            // Handle missing user_id error
            redirect('/admin/manage_application');
        }
    
        // Update the role in the users table
        $this->Admin_model->approve_application($user_id, $role);
    
        // Set a success message for approval
        $this->session->set_flashdata('message', 'Application approved successfully.');
    
        // Redirect back to the applications page
        redirect('/admin/manage_application');
    }
    
    public function Reject_application()
    {
        $user_id = $this->io->post('user_id'); // Get user_id from POST data
        $role = 'user'; // New role to set
    
        if (!$user_id) {
            // Handle missing user_id error
            redirect('/admin/manage_application');
        }
    
        // Update the role in the users table
        $this->Admin_model->reject_application($user_id, $role);
    
        // Set a success message for rejection
        $this->session->set_flashdata('message', 'Application rejected successfully.');
    
        // Redirect back to the applications page
        redirect('/admin/manage_application');
    }
    
    
}
?>
