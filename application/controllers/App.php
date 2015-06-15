<?php

require(APPPATH . '/libraries/REST_Controller.php');

class Rest_app extends REST_Controller {

    function index() {
        $this->response(array('name' => 'magi'));
    }

    function user_get() {
        if (!$this->get('id')) {
            $this->response(NULL, 400);
        }

        $this->db->where('employee_id', $this->get('id'));
        $q = $this->db->get('employees');
        $data = array();
        if ($q->num_rows()) {
            $data['status'] = 'success';
            $data['data'] = $q->result();
        } else {
            $data['status'] = 'failed';
        }
        $this->response($data);
    }

   function user_post()
    {
        if (!$this->get('id')) {
            $this->response(NULL, 400);
        }
        
       $id=$this->get('id');
          $f_name=urldecode($this->get('firstname'));
          $l_name=urldecode($this->get('lastname'));
          $title= urldecode($this->get('title'));
          $em_data=array(
              'first_name'=>$f_name,
              'last_name'=>$l_name,
              'title'=>$title
          );

        $this->db->where('employee_id', $this->get('id'));
        $q = $this->db->update('employees',$em_data);
        $data = array();
        if ($q) {
            $data['status'] = 'success';
        } else {
            $data['status'] = 'failed';
        }
        $this->response($data);

    }

    function user_put()
    {
       $id=$this->get('id');
          $f_name=urldecode($this->get('firstname'));
          $l_name=urldecode($this->get('lastname'));
          $title= urldecode($this->get('title'));

          $em_data=array(
              'employee_id'=>$id,
              'first_name'=>$f_name,
              'last_name'=>$l_name,
              'title'=>$title
          );
        $q = $this->db->insert('employees',$em_data);
        $data = array();
        if ($q) {
            $data['status'] = 'success';
        } else {
            $data['status'] = 'failed';
        }
        $this->response($data);
    }

    function user_delete() {
        if (!$this->get('id')) {
            $this->response(NULL, 400);
        }

        $this->db->where('employee_id', $this->get('id'));
        $q = $this->db->delete('employees');
        if ($q) {
            $data['status'] = 'success';
        } else {
            $data['status'] = 'failed';
        }
        $this->response($data);
    }


    function users_get() {

        $q = $this->db->get('employees');
        $data = array();
        if ($q->num_rows()) {
            $data['status'] = 'success';
            $data['data'] = $q->result();
        } else {
            $data['status'] = 'failed';
        }
        $this->response($data);
    }

}

