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
}
?>
