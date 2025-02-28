<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Admin_model extends Model {

    public function get_all_events()
    {
        return $this->db->table('event')->get_all();
    }

    public function approve_event($id)
    {
        return $this->db->table('event')->where('event_id', $id)->update(['status' => 'approved']);
    }

    public function reject_event($id)
    {
        return $this->db->table('event')->where('event_id', $id)->update(['status' => 'rejected']);
    }

    public function delete_event($id)
    {
        return $this->db->table('event')->where('event_id', $id)->delete();
    }

    public function approve_application($user_id, $role)
    {
        // Update the 'role' in the users table using user_id
        $this->db->table('users')
                 ->where('id', $user_id)
                 ->update(['role' => $role]);
    
        // Update the 'status' in the apply table to 'approved'
        $this->db->table('apply')
                 ->where('user_id', $user_id) // Assuming 'user_id' is the foreign key in the apply table
                 ->update(['status' => 'approved']);
    }
    
    public function reject_application($user_id, $role)
    {
        // Update the 'role' in the users table using user_id
        $this->db->table('users')
                 ->where('id', $user_id)
                 ->update(['role' => $role]);
    
        // Update the 'status' in the apply table to 'rejected'
        $this->db->table('apply')
                 ->where('user_id', $user_id) // Assuming 'user_id' is the foreign key in the apply table
                 ->update(['status' => 'rejected']);
    }
    
    

}
?>
