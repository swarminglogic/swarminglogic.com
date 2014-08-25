<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Errors extends CI_Controller {
	function error_404()
	{
    $data['title'] = 'Error 404';
    $data['navId'] = 'error';

    $this->load->model('navbar_model');
    $data['navbar'] = $this->navbar_model->get_navbar();

    $this->load->view('header', $data);
    $this->load->view('errors/404', $data);
    $this->load->view('footer', $data);
	}
}
