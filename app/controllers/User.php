<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class User extends Controller {

    public function __construct() {
        parent::__construct();
        $this->call->model('User_model');
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

    // New function to handle organizer applications
    public function Apply() {
        // Check if the form is submitted
        if ($this->form_validation->submitted()) {
            // Gather all form inputs
            $name = $this->io->post('name');
            $email = $this->io->post('email');
            $phone = $this->io->post('phone');
            $experience = $this->io->post('experience');
            $event_type = $this->io->post('event_type');
    
            // Handle file upload
            $picture = $this->handleFileUpload();
    
            // Run form validation
            if ($this->form_validation->run()) {
                // Apply the user data to the model
                $application_successful = $this->User_model->apply($name, $email, $phone, $experience, $event_type, $picture);
    
                // Check if the application was successful
                if ($application_successful) {
                    flash_alert('Application submitted successfully!', 'success');
                    redirect('/user/home');
                } else {
                    flash_alert('Failed to submit application.', 'error');
                    redirect('/user/apply_as_organizer');
                }
            } else {
                // Form validation failed
                flash_alert($this->form_validation->errors(), 'error');
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
                flash_alert('Failed to upload picture.', 'error');
                redirect('/user/apply_as_organizer');
            }
        }
    
        return $picture;
    }
    
}
?>
