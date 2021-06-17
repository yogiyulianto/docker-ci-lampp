<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Notification
{
    protected $ci;

    public function __construct()
    {
        $this->ci =& get_instance();
    }

    public function send($content, $type, $message)
    {
        $form_error = array();
        // $content = $content;
        if (!empty($type) && !empty($message)) {
            if ($type == 'success') {
                // set flash data
                $this->ci->session->set_flashdata('success', $message);
                // redirect to content
                redirect($content);
            } else {
                // get error flash data
                $this->_get_error_form();
                
                $this->ci->session->set_flashdata('error', $message);
                $this->ci->session->set_flashdata('old_input', $this->ci->input->post());
                // redirect to content
                redirect($content);
            }
        }
    }

    public function _get_error_form()
    {
        $form_error = array();
        if (!empty($this->ci->input->post())) {
            foreach ($this->ci->input->post() as $key => $value) {
                if (!empty(form_error($key))) {
                    $form_error[$key] = form_error($key);
                }
            }
            $this->ci->session->set_flashdata('form_error', $form_error );
        }else {
            $this->ci->session->set_flashdata('form_error', '');
        }
    }
    

}

/* End of file Notification.php */
