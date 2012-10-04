<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Session extends CI_Session
{
 public function __construct() {
  parent::__construct();

                //flash seems to use this user agent, so we can identify if the request is coming from uploadify
  if ($this->userdata('user_agent') == "Shockwave Flash") {

                        //a custom session variable, if your already "logged in" on your flash session, than just make sure the session is still valid.
   if ($this->userdata('logged_in')) {

    //make sure parent is still active
    if(!$this->userdata('parent_session'))
    {
     $this->sess_destroy();
     return;
    }

    $this->CI->db->where('session_id', $this->userdata('parent_session'));
    $this->CI->db->where('ip_address', $this->userdata('ip_address'));
    $this->CI->db->select("last_activity");

    $query = $this->CI->db->get($this->sess_table_name);

    // couldnt find session
    if ($query->num_rows() == 0)
    {
     $this->sess_destroy();
     return;
    }

    $row = $query->row();
    $last_activity = $row->last_activity;
    //check that the session hasnt expired
    if (($last_activity + $this->sess_expiration) < $this->now)
    {
     $this->sess_destroy();
     return;
    }

   //not yet logged in
   } else {

    $sessdata = $this->CI->input->post('sessdata');
    if ($sessdata) {
     //decode the sess data
     $sessdata = $this->CI->encrypt->decode($sessdata);
     $sessdata = unserialize($sessdata);

     if (empty($sessdata['session_id']) || empty($sessdata['timestamp'])) {
      $this->sess_destroy();
      return;
     }

     //attempt to clone the session...
     $parent_session['session_id'] = $sessdata['session_id'];
     $parent_session['ip_address'] = $this->userdata('ip_address');

     $this->CI->db->where('session_id', $parent_session['session_id']);
     $this->CI->db->where('ip_address', $parent_session['ip_address']);

     $query = $this->CI->db->get($this->sess_table_name);

     // couldnt find session
     if ($query->num_rows() == 0)
     {
      $this->sess_destroy();
      return;
     }

     //retreive data
     $row = $query->row();
     $parent_session['last_activity'] = $row->last_activity;
     if (isset($row->user_data) AND $row->user_data != '')
     {
      $custom_data = $this->_unserialize($row->user_data);

      if (is_array($custom_data))
      {
       foreach ($custom_data as $key => $val)
       {
        $parent_session[$key] = $val;
       }
      }
     }

     //check that the session hasnt expired
     if (($parent_session['last_activity'] + $this->sess_expiration) < $this->now)
     {
      $this->sess_destroy();
      return;
     }

     if ($parent_session['logged_in']) {

                                        //DO STUFF HERE
                                        //You want to mimic the values of the parent session. But for better security flash will still maintain its own session id. if you use a logged_in flag and user_id in your session vars to check if a user is signed on and identify them, you'll want to set that up here.

      $this->set_userdata('parent_session', $parent_session['session_id']);
      $this->set_userdata('logged_in', $parent_session['logged_in']);
      $this->set_userdata('user_id', $parent_session['user_id']);

     }

    } else {
     $this->sess_destroy();
     return;
    }
   }


  }
 }

        //this method will help get an encrypted session id to send through uploadify
 public function get_encrypted_sessdata() {
  $data['session_id'] = $this->userdata('session_id');
  $data['timestamp'] = time();

  $data = serialize($data);
  $data = $this->CI->encrypt->encode($data);
  return $data;
 }
}
