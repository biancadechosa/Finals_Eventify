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
        $this->db->table('bookings')->where('booking_id', $booking_id)->update(['status' => $status]);
    }
    

    public function reject_booking($booking_id)
{
    $this->db->table('bookings')->where('booking_id', $booking_id)->update(['status' => $status]);
}

}
?>
