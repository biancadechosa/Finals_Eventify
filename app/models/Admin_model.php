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

    public function approve_application($id, $role)
    {
        $this->db->table('users')->where('id', $id)->update(['role' => $role]);
    }
    
    public function reject_application($id)
{
    $this->db->table('users')->where('id', $id)->update(['role' => $role]);
}
}
?>
