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

    public function apply($user_id, $name, $email, $phone, $experience, $event_type, $picture) {
        $data = array(
            'user_id' => $user_id,  // Add the user_id to the data array
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'experience' => $experience,
            'event_type' => $event_type,
            'picture' => $picture
        );
    
        // Insert the data into the 'apply' table
        return $this->db->table('apply')->insert($data);
    }
    
    public function get_user_by_email($email) {
        // Perform the query to get the user by email
        $result = $this->db->table('users')
                           ->where('email', $email)
                           ->get();
    
        // Check if result is an array and not empty
        if (is_array($result) && count($result) > 0) {
            return array(
                'success' => true,
                'data' => $result  // Return the entire result as an associative array
            );
        }
    
        // If no user is found, return false
        return array(
            'success' => false,
            'data' => null  // No user found
        );
    }

    public function get_application_by_email($email) {
        // Query the 'apply' table to check if the email already exists
        $result = $this->db->table('apply')
                           ->where('email', $email)
                           ->get();
    
        // Check if result is an array and not empty
        if (is_array($result) && count($result) > 0) {
            return true;  // Email found in the 'apply' table, meaning the user already submitted an application
        }
    
        return false;  // No application found for this email
    }
    
    public function Cancel_book($booking_id, $status)
    {
        $this->db->table('bookings')->where('booking_id', $booking_id)->update(['status' => $status]);
    }
    
}


?>
