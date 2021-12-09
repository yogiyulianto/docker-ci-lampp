<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_email extends CI_Model {

    public $email_settings;
    public $mail_to = '';
    public $mail_cc = array();
    public $mail_bcc = array();
    public $mail_subject = '';
    public $mail_message = array();
    public $mail_attachments = array();

    // constructor
    public function __construct() {
        // load parent constructor
        parent::__construct();
        // load library
        $this->load->library('email');
        // get email settings
        $this->email_settings = $this->get_email_preferences();
    }

    /*
     * EMAIL UTILITY
     */

    // get email preferences
    public function get_email_preferences() {
        $sql = "SELECT * FROM com_email";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            $data = array();
            foreach ($result as $rec) {
                $data[$rec['email_id']] = $rec;
            }
            return $data;
        } else {
            return array();
        }
    }

    // send mail
    public function send_mail($email_id = '01') {
        // check email
        if (!isset($this->email_settings[$email_id])) {
            return FALSE;
        }
        // clear email
        $this->email->clear(TRUE);
        // config
        $config = [
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'protocol'  => 'smtp',
            'smtp_host' => 'smtp.gmail.com',
            'smtp_user' => $this->email_settings[$email_id]['smtp_username'],
            'smtp_pass'   => $this->email_settings[$email_id]['smtp_password'],
            'smtp_crypto' => 'ssl',
            'smtp_port'   => $this->email_settings[$email_id]['smtp_port'],
            'crlf'    => "\r\n",
            'newline' => "\r\n"
        ];
        // $config['smtp_crypto'] = 'ssl';
        $this->email->initialize($config);
        $this->email->from($this->email_settings[$email_id]['email_address'], $this->email_settings[$email_id]['email_name']);
        $this->email->to($this->mail_to);
        $this->email->cc($this->mail_cc);
        $this->email->subject($this->mail_subject);
        $this->email->message($this->mail_message);
        if (!empty($this->mail_attachments)) {
            foreach ($this->mail_attachments as $attachment) {
                $this->email->attach($attachment);
            }
        }
        if ($this->email->send()) {
            $return = TRUE;
        } else {
            $return = FALSE;
            echo $this->email->print_debugger();
        }
        return $return;
    }

    // html
    public function set_mail($email) {
        // get parameters
        $this->mail_to = !empty($email['to']) ? $email['to'] : '';
        $this->mail_cc = !empty($email['cc']) ? $email['cc'] : array();
        $this->mail_subject = !empty($email['subject']) ? $email['subject'] : '';
        $this->mail_attachments = !empty($email['attachments']) ? $email['attachments'] : array();
        // set message
        $data['title'] = !empty($email['message']['title']) ? $email['message']['title'] : 'Nothing on title';
        $data['greetings'] = !empty($email['message']['greetings']) ? $email['message']['greetings'] : 'Email not completed!';
        $data['intro'] = !empty($email['message']['intro']) ? $email['message']['intro'] : '';
        $data['details'] = !empty($email['message']['details']) ? $email['message']['details'] : '';
        $data['actions']['title'] = !empty($email['message']['actions']['title']) ? $email['message']['actions']['title'] : '';
        $data['actions']['link'] = !empty($email['message']['actions']['link']) ? $email['message']['actions']['link'] : '';
        $data['footer'] = !empty($email['message']['footer']) ? $email['message']['footer'] : 'Best Regards, <br /> Fishee';
        $data['disclaimer'] = !empty($email['message']['disclaimer']) ? $email['message']['disclaimer'] : 'You got this email because you are using the Integrated Fishee App  [ No Reply ]';
        $data['copyright'] = !empty($email['message']['copyright']) ? $email['message']['copyright'] : '© ' . date('Y') . ' IT Team. Fishee.';
        // parse message
        $this->mail_message = $this->slice->view('base.email.default', $data, true);
    }

}
