<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Organizer_model extends Model {

    public function dashboard() {
        return $this->db->table('event')->get_all();
    }

    public function create_event($title, $description, $location, $start_date, $end_date, $popularity, $ratings, $type, $ticket_price, $available_tickets, $image_path) {
        $data = array(
            'title' => $title,
            'description' => $description,
            'location' => $location,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'popularity' => $popularity,
            'ratings' => $ratings,
            'type' => $type,
            'ticket_price' => $ticket_price,
            'available_tickets' => $available_tickets,
            'images' => $image_path // Store the image path
        );

        return $this->db->table('event')->insert($data);
    }

    public function get_one($id) {
        return $this->db->table('event')->where('event_id', $id)->get();
    }

    public function update_event($title, $description, $location, $start_date, $end_date, $popularity, $ratings, $type, $ticket_price, $available_tickets, $image_path, $id) {
        // Prepare the data array
        $data = array(
            'title' => $title,
            'description' => $description,
            'location' => $location,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'popularity' => $popularity,
            'ratings' => $ratings,
            'type' => $type,
            'ticket_price' => $ticket_price,
            'available_tickets' => $available_tickets,
        );
    
        // Add the image path only if a new image was uploaded
        if ($image_path) {
            $data['images'] = $image_path;
        }
    
        // Perform the update query
        return $this->db->table('event')->where('event_id', $id)->update($data);
    }
    
    public function delete_event($id) {
        return $this->db->table('event')->where('event_id', $id)->delete();
    }
    
    public function update_booking($booking_id, $status)
    {
        // Update the booking status in the database
        $this->db->table('bookings')->where('booking_id', $booking_id)->update(['status' => $status]);
    
        // Retrieve booking details
        $booking = $this->db->table('bookings')->where('booking_id', $booking_id)->get();
        $user_id = $booking['user_id'];
        $ticket_number = $booking['ticket_number'];
        $ticket_quantity = $booking['ticket_quantity'];
        $event_id = $booking['event_id'];
    
        // Retrieve the user's email from the users table
        $user = $this->db->table('users')->where('id', $user_id)->get();
        $user_email = $user['email'];
    
        // Retrieve event details
        $event = $this->db->table('event')->where('event_id', $event_id)->get();
        $event_title = $event['title'];
        $event_location = $event['location'];
        $start_date = $event['start_date'];
        $end_date = $event['end_date'];
        $ticket_price = $event['ticket_price'];
    
        // Compose the email content
        $email_content = $this->compose_booking_status_email(
            $ticket_number,
            $event_title,
            $status,
            $status == 'rejected' ? 'Your booking was rejected. Please contact support for assistance.' : null
        );
    
        // Save the email content into the database with additional fields
        $this->save_email_to_database(
            $user_email,
            $email_content,
            $booking_id,
            $ticket_number,
            $ticket_quantity,
            $event_id,
            $event_title,
            $event_location,
            $start_date,
            $end_date,
            $ticket_price
        );
    }
    
    public function reject_booking($booking_id)
    {
        $status = 'rejected'; // Set the status to rejected
    
        // Update the booking status in the database
        $this->db->table('bookings')->where('booking_id', $booking_id)->update(['status' => $status]);
    
        // Retrieve booking details
        $booking = $this->db->table('bookings')->where('booking_id', $booking_id)->get();
        $user_id = $booking['user_id'];
        $ticket_number = $booking['ticket_number'];
        $ticket_quantity = $booking['ticket_quantity'];
        $event_id = $booking['event_id'];
    
        // Retrieve the user's email from the users table
        $user = $this->db->table('users')->where('id', $user_id)->get();
        $user_email = $user['email'];
    
        // Retrieve event details
        $event = $this->db->table('event')->where('event_id', $event_id)->get();
        $event_title = $event['title'];
        $event_location = $event['location'];
        $start_date = $event['start_date'];
        $end_date = $event['end_date'];
        $ticket_price = $event['ticket_price'];
    
        // Compose the email content
        $email_content = $this->compose_booking_status_email(
            $ticket_number,
            $event_title,
            $status,
            'Your booking was rejected. Please contact support for assistance.'
        );
    
        // Save the email content into the database with additional fields
        $this->save_email_to_database(
            $user_email,
            $email_content,
            $booking_id,
            $ticket_number,
            $ticket_quantity,
            $event_id,
            $event_title,
            $event_location,
            $start_date,
            $end_date,
            $ticket_price
        );
    }
    
    // Compose email content
    private function compose_booking_status_email($ticket_number, $event_title, $status, $remarks = null)
    {
        // Email content
        $subject = "Booking Status Update - $event_title";
        $message = "Hello,\n\nWe have an update regarding your booking. Please find the details below:\n\n"
                 . "Event Name: $event_title\n"
                 . "Ticket Number: $ticket_number\n"
                 . "Booking Status: " . ($status == 'approved' ? 'Approved' : 'Rejected') . "\n";
    
        // Add remarks if provided
        if ($remarks) {
            $message .= "Remarks: $remarks\n\n";
        }
    
        $message .= "Thank you for using our services.\n\n"
                 . "Best regards,\nEventify Team";
    
        return [
            'subject' => $subject,
            'message' => $message
        ];
    }
    
    // Save email content into the database
    private function save_email_to_database(
        $to_email,
        $email_content,
        $booking_id,
        $ticket_number,
        $ticket_quantity,
        $event_id,
        $event_title,
        $event_location,
        $start_date,
        $end_date,
        $ticket_price
    ) {
        $data = [
            'recipient_email' => $to_email,
            'subject' => $email_content['subject'],
            'message' => $email_content['message'],
            'sent_at' => date('Y-m-d H:i:s'),
            'booking_id' => $booking_id,
            'ticket_number' => $ticket_number,
            'ticket_quantity' => $ticket_quantity,
            'event_id' => $event_id,
            'event_title' => $event_title,
            'event_location' => $event_location,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'ticket_price' => $ticket_price
        ];
    
        $this->db->table('email_notifications')->insert($data);
    }
    
}
?>
