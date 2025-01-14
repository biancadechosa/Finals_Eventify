<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class User extends Controller {

    public function __construct() {
        parent::__construct();
        $this->call->model('User_model');

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

    public function home() {
        $events = $this->User_model->home();
        $this->call->view('user/home', ['event' => $events]);
    }

    public function about() {
        $this->call->view('user/about');
    }

    public function contact() {
        $this->call->view('user/contact');
    }

    public function create_booking($event_id) {
        $event = $this->User_model->get_event_dates($event_id);

        $user_id = $_SESSION['user_id']; 
        $user = $this->User_model->get_user_email($user_id); 
        
        if ($this->form_validation->submitted()) {
            $booking_date = $this->io->post('booking_date');
            $ticket_quantity = $this->io->post('ticket_quantity');
            $reminder_set = isset($_POST['reminder_set']) && $_POST['reminder_set'] === 'on' ? 1 : 0;
            
            $reminder_date = $reminder_set ? $this->io->post('reminder_date') : '1970-01-01 00:00:00';
            
            if ($reminder_set && empty($reminder_date)) {
                set_flash_alert('danger', 'Please select a reminder date.');
                redirect('/user/create_booking/' . $event_id);
                return;
            }

            if ($this->form_validation->run()) {
                if ($this->User_model->create_booking($event_id, $booking_date, $ticket_quantity, $reminder_set, $reminder_date)) {
                    $ticket_number = $this->User_model->generate_ticket_number($event_id);
                    set_flash_alert('success', 'Booking created successfully!');
                    $this->call->view('user/bookings', [
                        'event' => $event,
                        'ticket_number' => $ticket_number,
                        'email' => $user['email']
                    ]);
                } else {
                    set_flash_alert('danger', 'Failed to create booking.');
                    redirect('/user/create_booking/' . $event_id);
                }
            } else {
                set_flash_alert('danger', $this->form_validation->errors());
                redirect('/user/create_booking/' . $event_id);
            }
        } else {
            $this->call->view('user/bookings', [
                'event' => $event,
                'user' => $user
            ]);
        }
    }

    public function booking_form($event_id) {
        $event = $this->User_model->get_event_dates($event_id); 
        if (!$event) {
            show_404();
        }
        $this->call->view('user/bookings', ['event' => $event]);
    }

    public function Apply() {
        // Check if the form is submitted via POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Gather all form inputs
            $name = $this->io->post('name');
            $email = $this->io->post('email');
            $phone = $this->io->post('phone');
            $experience = $this->io->post('experience');
            $event_type = $this->io->post('event_type');
            
            // Step 1: Check if the email exists in the users table
            $existing_user = $this->User_model->get_user_by_email($email);
    
            // If the email doesn't exist, prevent the form submission and display the error
            if (!$existing_user['success'] || !isset($existing_user['data']['id'])) {
                set_flash_alert('danger', 'The email address does not exist in our system.');
                redirect('/user/apply_as_organizer');
                return;
            }
    
            // Step 2: Check if the user has already submitted an application in the 'apply' table
            $existing_application = $this->User_model->get_application_by_email($email);  // Changed to check in 'apply' table
            if ($existing_application) {
                set_flash_alert('danger', 'This email has already submitted an application.');
                redirect('/user/apply_as_organizer');
                return;
            }
    
            // Step 3: Handle file upload
            $picture = $this->handleFileUpload();
    
            // Step 4: Get the user_id from the users table based on email
            $user_id = $existing_user['data']['id'];  // Now accessing the 'id' directly from the single user record
    
            // Run form validation
            if ($this->form_validation->run()) {
                // Prepare the data for the apply table, including the user_id
                $application_successful = $this->User_model->apply($user_id, $name, $email, $phone, $experience, $event_type, $picture);
    
                if ($application_successful) {
                    set_flash_alert('success', 'Application submitted successfully!');
                    redirect('/user/apply_as_organizer');
                } else {
                    set_flash_alert('danger', 'Failed to submit application. Please try again.');
                    redirect('/user/apply_as_organizer');
                }
            } else {
                // Form validation failed
                set_flash_alert('danger', $this->form_validation->errors());
                redirect('/user/apply_as_organizer');
            }
        } else {
            // Show the apply form if not submitted
            $this->call->view('user/apply');
        }
    }
    
    
    
    /**
     * Handle file upload for the user picture.
     * @return string|null The file path of the uploaded picture or null if no file was uploaded.
     */
    private function handleFileUpload() {
        $upload_dir = '/public/uploads/';
        $picture = null;
    
        if (!empty($_FILES['picture']['name'])) {
            $file_name = time() . '_' . $_FILES['picture']['name'];
            $file_path = $upload_dir . $file_name;
    
            // Create upload directory if it doesn't exist
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
    
            // Move uploaded file to the designated directory
            if (move_uploaded_file($_FILES['picture']['tmp_name'], $file_path)) {
                $picture = $file_path;
            } else {
                // Error during file upload
                set_flash_alert('danger', 'Failed to upload picture. Please try again.');
                redirect('/user/apply_as_organizer');
            }
        }
    
        return $picture;
    }

    public function myBook() {
        // Assuming the user ID is stored in the session
        $userId = $_SESSION['user_id']; // Adjust this based on how you store user session data
        
        // Query to fetch bookings for the logged-in user
        $query = "
            SELECT 
                b.booking_id,
                e.title AS event_title,
                b.booking_date,
                b.ticket_quantity,
                b.ticket_number,
                b.reminder_set,
                b.reminder_date,
                b.status
            FROM bookings b
            INNER JOIN event e ON b.event_id = e.event_id
            WHERE b.user_id = :user_id";  // Add condition to filter by the logged-in user's ID
    
        // Prepare the query and execute
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);  // Bind the user ID parameter
        $stmt->execute();
    
        // Fetch the results and store in a variable
        $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Return the data to the view
        $this->call->view('user/mybook', ['bookings' => $bookings]);
    }
    
    public function Cancel_booking()
{
    $booking_id = $this->io->post('booking_id');
    $status = 'cancelled'; // Status to set

    $this->User_model->Cancel_book($booking_id, $status);
    redirect('/user/mybook');
}

public function Get_email_notifications($booking_id) {
    // Prepare the SQL query
    $query = "
        SELECT 
            id, 
            recipient_email, 
            subject, 
            message, 
            sent_at, 
            ticket_number, 
            ticket_quantity, 
            event_id, 
            event_title, 
            event_location, 
            start_date, 
            end_date, 
            ticket_price
        FROM email_notifications
        WHERE booking_id = :booking_id";  // Add condition to filter by the booking_id
    
    // Prepare the query and execute
    $stmt = $this->pdo->prepare($query);
    $stmt->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);  // Bind the booking ID parameter
    $stmt->execute();
    
    // Fetch the results and store in a variable
    $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Pass the fetched data to the view
    $this->call->view('user/view_email', ['notifications' => $notifications]);
}

public function Access_organizer_panel() {
    // Check if the user is logged in
    if (!isset($_SESSION['id'])) {
        set_flash_alert('danger', 'You must log in to access this section.');
        redirect('/user/login');
        return;
    }

    // Get the logged-in user ID
    $user_id = $_SESSION['id'];

    // Get the user details, including role
    $users = $this->User_model->Get_user_by_id($user_id);

    // Debugging: Check if the $users variable is populated
    var_dump($users);  // This will print the $users array or object to check its contents

    // If users data is returned (not null)
    if ($users) {
        // Check if the user is an organizer
        if ($this->User_model->Check_user_role($user_id)) {
            // Pass the user data to the header view
            $this->call->view('user/header', ['users' => $users]);  // Make sure this is the correct path
        } else {
            set_flash_alert('danger', 'You do not have permission to access this panel.');
            redirect('/user/home');
        }
    } else {
        // Handle case where user data is not found (just in case)
        set_flash_alert('danger', 'User not found.');
        redirect('/user/login');
    }
}

}
?>
