<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Organizer extends Controller {

    protected $pdo;
    public function __construct()
    {
        parent::__construct();
        $this->call->model('Organizer_model');

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

    public function dashboard() {
        $data['e'] = $this->Organizer_model->dashboard();
        $this->call->view('organizer/dashboard', $data);
    }

    public function create() {
        if ($this->form_validation->submitted()) {
            $title = $this->io->post('title');
            $description = $this->io->post('description');
            $location = $this->io->post('location');
            $start_date = $this->io->post('start_date');
            $end_date = $this->io->post('end_date');
            $popularity = $this->io->post('popularity');
            $ratings = $this->io->post('ratings');
            $type = $this->io->post('type');
            $ticket_price = $this->io->post('ticket_price');

            $image_path = '/public/images/flowers.png'; 
            if (isset($_FILES['images']) && $_FILES['images']['error'] == 0) {
                $file_name = basename($_FILES['images']['name']);
                $target_file = $_SERVER['DOCUMENT_ROOT'] . '/public/uploads/' . $file_name;

                if (move_uploaded_file($_FILES['images']['tmp_name'], $target_file)) {
                    $image_path = '/public/uploads/' . $file_name;
                }
            }

            $event_created = $this->Organizer_model->create_event(
                $title,
                $description,
                $location,
                $start_date,
                $end_date,
                $popularity,
                $ratings,
                $type,
                $ticket_price,
                $image_path
            );

            if ($event_created) {
                flash_alert('Event created successfully!', 'success');
                redirect('/organizer/dashboard');
            } else {
                flash_alert('Failed to create event, please try again.', 'error');
                redirect('/organizer/create');
            }
        } else {
            $this->call->view('organizer/create_event');
        }
    }

    public function update($id) {
        if ($this->form_validation->submitted()) {
            $title = $this->io->post('title');
            $description = $this->io->post('description');
            $location = $this->io->post('location');
            $start_date = $this->io->post('start_date');
            $end_date = $this->io->post('end_date');
            $popularity = $this->io->post('popularity');
            $ratings = $this->io->post('ratings');
            $type = $this->io->post('type');
            $ticket_price = $this->io->post('ticket_price');
    
            $image_path = null; 
            if (isset($_FILES['images']) && $_FILES['images']['error'] === UPLOAD_ERR_OK) {
                $file_name = basename($_FILES['images']['name']);
                $target_file = '/public/uploads/' . $file_name; 
    
                if (move_uploaded_file($_FILES['images']['tmp_name'],$_SERVER['DOCUMENT_ROOT'] . $target_file)) {
                    $image_path = $target_file; 
                } else {
                    flash_alert('Failed to upload the new image. Please try again.', 'error');
                    redirect('/organizer/update/' . $id);
                }
            }
    
            if ($this->Organizer_model->update_event(
                $title,
                $description,
                $location,
                $start_date,
                $end_date,
                $popularity,
                $ratings,
                $type,
                $ticket_price,
                $image_path, 
                $id
            )) {
                flash_alert('Event updated successfully!', 'success');
                redirect('/organizer/dashboard');
            } else {
                flash_alert('Failed to update event. Please try again.', 'error');
                redirect('/organizer/update/' . $id);
            }
        }
    
        $data['e'] = $this->Organizer_model->get_one($id);
        $this->call->view('organizer/update_event', $data);
    }
    
    public function delete($id) {
        if ($this->Organizer_model->delete_event($id)) {
            flash_alert('Event deleted successfully!', 'success');
            redirect('/organizer/dashboard');
        } else {
            flash_alert('Failed to delete event, please try again.', 'error');
            redirect('/organizer/dashboard');
        }
    }

    public function bookings() {
        $this->call->model('Organizer_model');
        $bookings = $this->Organizer_model->get_all_bookings();
        
        $data['bookings'] = $bookings; // Pass bookings to the view
        $this->call->view('organizer/manage_booking', $data);
    }
    
    // Inside your EventController.php or BookingController.php or OrganizerController.php

    public function manageBooking() {
        // Assuming the user ID is stored in the session
        $user_id = $_SESSION['user_id'];  // Adjust this if you're using a different session variable for user ID
    
        // Query to fetch only bookings for the logged-in user
        $query = "
            SELECT 
                b.booking_id,
                e.title AS event_title,
                u.email AS user_email,
                b.booking_date,
                b.ticket_quantity,
                b.ticket_number,
                b.reminder_set,
                b.reminder_date,
                b.status
            FROM bookings b
            INNER JOIN event e ON b.event_id = e.event_id
            INNER JOIN users u ON b.user_id = u.id
            WHERE b.user_id = :user_id";  // Filter by the logged-in user's ID
        
        // Prepare the query and execute
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);  // Bind the user ID
        $stmt->execute();
        
        // Fetch the results and store in a variable
        $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Return the data to the view
        $this->call->view('organizer/manage_booking', ['bookings' => $bookings]);
    }
    


public function reject_booking()
{
    $booking_id = $this->io->post('booking_id');
    $status = 'rejected'; // Status to set

    if ($this->Organizer_model->update_booking($booking_id, $status)){
         flash_alert('Booking rejected', 'success');
            redirect('/organizer/manage_booking');
        } else {
            flash_alert('Failed to reject booking, please try again.', 'error');
            redirect('/organizer/manage_booking');
        }
    redirect('/organizer/manage_booking');
}


    
}
?>
