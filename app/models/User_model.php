<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class User_model extends Model {

    public function home() {
        return $this->db->table('event')->get_all();
    }

    public function get_event_dates($event_id) {
        return $this->db->table('event')
                        ->select('start_date, end_date')
                        ->where('event_id', $event_id)
                        ->get(); 
    }

    public function create_booking($event_id, $booking_date, $ticket_quantity, $reminder_set, $reminder_date) {
        $user_id = $_SESSION['user_id']; 
        
        $ticket_number = $this->generate_ticket_number($event_id);
            
        $data = array(
            'event_id' => $event_id,
            'booking_date' => $booking_date,
            'ticket_quantity' => $ticket_quantity,
            'reminder_set' => $reminder_set,
            'reminder_date' => $reminder_date,
            'user_id' => $user_id, 
            'ticket_number' => $ticket_number 
        );
        
        $inserted_id = $this->db->table('bookings')->insert($data);
    
        if ($inserted_id) {
            // Retrieve user email directly (you already have this functionality)
            $user_email_data = $this->get_user_email($user_id);
    
            // If email exists, send the confirmation email
            if ($user_email_data && isset($user_email_data['email'])) {
                $user_email = $user_email_data['email'];
                
                $this->send_confirmation_email(
                    $user_email,
                    $ticket_number,
                    $event_id,
                    $booking_date,
                    $ticket_quantity
                );
            }
    
            return array(
                'success' => true,
                'ticket_number' => $ticket_number,
                'message' => 'Booking successful. Your ticket number is ' . $ticket_number . '.'
            );
        }
    
        return array(
            'success' => false,
            'message' => 'Failed to create booking. Please try again.'
        );
    }

    public function generate_ticket_number($booking_id) {
        return 'TICKET-' . strtoupper(uniqid($booking_id . '-'));
    }

    public function get_user_email($user_id) {
        return $this->db->table('users')
                        ->select('email')
                        ->where('id', $user_id)
                        ->get();
    }

    // Add this method to send the confirmation email
    private function send_confirmation_email($to_email, $ticket_number, $event_id, $booking_date, $ticket_quantity) {
        // Retrieve event details
        $event = $this->db->table('event')
                          ->select('title')
                          ->where('event_id', $event_id)
                          ->get();

        $event_name = $event['title'];

        // Email content
        $subject = 'Booking Confirmation - ' . $event_name;
        $message = "Hello,\n\nThank you for booking your event with us. Here are your booking details:\n\n"
                 . "Event Name: $event_name\n"
                 . "Booking Date: $booking_date\n"
                 . "Ticket Quantity: $ticket_quantity\n"
                 . "Ticket Number: $ticket_number\n\n"
                 . "Please save this email for future reference.\n\n"
                 . "Best regards,\nEventify Team";

        // Use the built-in mail function to send the email
        mail($to_email, $subject, $message, "From: no-reply@eventify.com");
    }
}
?>
