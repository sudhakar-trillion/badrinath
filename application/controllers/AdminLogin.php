<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminLogin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Kolkata");
		$this->load->model('Commonmodel');
		
		if( $this->session->userdata('Userid')!='')
			redirect( base_url('view-data') );	
		
			
	}
	
	
	public function index()
	{
		$data['invalidcredentials'] = '';
		if( $this->input->post('login') )
		{
			$this->form_validation->set_rules( $this->config->item('login') );
			
			if( $this->form_validation->run() === false) 
			{
				$this->load->view('admin/login',$data); 	
			}
			else
			{
				$cond = array();
				$table='admin';
				
				$cond['UserId'] = $this->input->post('userid');
				$cond['Password'] = md5( $this->input->post('password') );
				
				if( $this->Commonmodel->checkexists($table,$cond) )
				{
					$this->session->set_userdata('Userid',$this->input->post('userid'));
					redirect( base_url('view-data') );
				}
				else
				{
					$msg = "<div class='alert alert-danger'>Check your credentials <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a></div>";		
					$data['invalidcredentials'] = $msg;
					$this->load->view('admin/login',$data);
					
				}
				
			}
		}
		else
			$this->load->view('admin/login',$data);
	}
	
	
	
	}
