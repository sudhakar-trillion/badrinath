<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Kolkata");
		$this->load->model('Commonmodel');
		
		if( $this->session->userdata('Userid')=='')
			redirect( base_url('login') );	
	}
	
	
	public function index()
	{
		
		$this->load->view('admin/header');
		
		$table='stockdata';
		$cond= array();
		
		if( $this->input->post('resetfilterdata'))
		{
			$this->session->set_userdata('D1','');	
			$this->session->set_userdata('D2','');	
			$this->session->set_userdata('D3','');
		 
		
		if( $this->session->userdata('Avg4_Combo') !='' )
			 $this->session->set_userdata('Avg4_Combo','') ;

		if($this->session->userdata('Avg3_Combo')!='')
		 $this->session->set_userdata('Avg3_Combo','') ;
		}
		
		else if( $this->input->post('filterdata'))
		{
			$this->form_validation->set_rules( $this->config->item('stockdatafilter') );
			
			if( $this->form_validation->run() !== false) 
			{ 	
				
				if( trim($this->input->post('avg4combo'))!=''  )
					$combo4 = trim($this->input->post('avg4combo'));
				else
					$combo3 = trim($this->input->post('avg3combo'));
				
				if( isset($combo4)) 
				{
					$cond['Avg4_Combo'] = $combo4;
					$this->session->set_userdata('Avg4_Combo',$combo4);
				}
				else if( isset($combo3))
				{
					$cond['Avg3_Combo'] = $combo3;
					$this->session->set_userdata('Avg3_Combo',$combo3);					
				}
					
				$cond['D1'] = trim($this->input->post('D1'));
				$cond['D2'] = trim($this->input->post('D2'));
				$cond['D3'] = trim($this->input->post('D3'));
				
				$D1 = trim($this->input->post('D1'));
				$D2 = trim($this->input->post('D2'));
				$D3 = trim($this->input->post('D3'));
					
				$this->session->set_userdata('D1',$D1);	
				$this->session->set_userdata('D2',$D2);
				$this->session->set_userdata('D3',$D3);									
			}
		}
		else
		{
			
			if(  $this->session->userdata('D1') !='' )	
			{
				if( $this->session->userdata('Avg4_Combo') !='' )
				{
					$combo4 = $this->session->userdata('Avg4_Combo') ;
					$cond['Avg4_Combo'] = $combo4;
					$this->session->set_userdata('Avg4_Combo',$combo4);
				}
				else if( $this->session->userdata('Avg3_Combo') !='' )
				{
					$combo3 = $this->session->userdata('Avg3_Combo') ;
					$cond['Avg3_Combo'] = $combo3;
					$this->session->set_userdata('Avg3_Combo',$combo3);
				}
				
				$D1 = trim( $this->session->userdata('D1') );
				$D2 = trim( $this->session->userdata('D2') );
				$D3 = trim( $this->session->userdata('D3') );
				
				$cond['D1'] = $D1;
				$cond['D2'] = $D2;
				$cond['D3'] = $D3;
					
				$this->session->set_userdata('D1',$D1);	
				$this->session->set_userdata('D2',$D2);
				$this->session->set_userdata('D3',$D3);		
				
				
			}
			
		
		}
			
		$total_rows = $this->Commonmodel->getnumRows($table,$cond);
		
		//echo $this->db->last_query()."<br>".$total_rows; exit; 
		
		$config['base_url'] = base_url('view-data/');
		$config['total_rows'] = $total_rows;
		$config['per_page'] = 50;
		$config['uri_segment'] = 2;
		$config['use_page_numbers'] = TRUE;
		
	/* Pagination configuration style starts here */
	
		$config['full_tag_open'] = '<div><ul class="pagination">';
		$config['full_tag_close'] = '</ul></div><!--pagination-->';
		$config['first_link'] = '&laquo; First';
		$config['first_tag_open'] = '<li class="prev page">';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = 'Last &raquo;';
		$config['last_tag_open'] = '<li class="next page">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = 'Next &rarr;';
		$config['next_tag_open'] = '<li class="next page">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&larr; Previous';
		$config['prev_tag_open'] = '<li class="prev page">';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li class="page">';
		$config['num_tag_close'] = '</li>';
		// $config['display_pages'] = FALSE;
		// 
		$config['anchor_class'] = 'follow_link';
		
		$config['num_links'] = 4;
		
	/* Pagination configuration style ends here */		
		
		$this->pagination->initialize($config);
		
		$data['page'] = ($this->uri->segment(2)) ? (($this->uri->segment(2))) : 0;
		
		$limit = $config["per_page"];

		if($data['page']==0)
		$start = 0;
		else
		$start = ($data['page']-1)*$config["per_page"];
		
		$data['stockdata'] = $this->Commonmodel->paginate($table,$cond,$order_by='DESC',$order_by_field='SLNO',$limit,$start );
		$data['pagination_string'] = $this->pagination->create_links();	
		$data['perpage'] =  $limit ;
		#echo $this->db->last_query(); exit; 
		
		
		if( $this->input->post('filterdata'))
		{
			//locad the config item
			$this->form_validation->set_rules( $this->config->item('stockdatafilter') );
			if( $this->form_validation->run() === false) { 	$this->load->view('admin/viewdata',$data);}
			else
				$this->load->view('admin/viewdata',$data);
			
		}
		else
			$this->load->view('admin/viewdata',$data);
			
		$this->load->view('admin/footer');
		
	}
	
	public function seriesdata()
	{
		$this->load->view('admin/header');
		
		if( $this->input->post('filterseriesdata'))
		{
			$this->session->set_userdata('XVAL','');
			$this->session->set_userdata('Num','');
			
			$this->form_validation->set_rules( $this->config->item('seriesdatafilter') );
			
			if( $this->form_validation->run() === false) 
			{ 	
				$NUM='';
				$XVAL='';
			}
			else
			{
			
				$XVAL = $this->input->post('Xval');
				$this->session->set_userdata('XVAL',$XVAL);
				
				$NUM = $this->input->post('Num');
				$this->session->set_userdata('Num',$NUM);
				
			}
		}
		else
		{
			
			
			if( trim($this->session->userdata('Num'))!='' )
			{
				$NUM = $this->session->userdata('Num');
				$XVAL = $this->session->userdata('XVAL');
				
				$this->session->set_userdata('XVAL',$XVAL);
				$this->session->set_userdata('Num',$NUM);
			}
			else
			{
				$NUM='';
				$XVAL='';
			}
				
		}
		
		
		$total_rows = $this->Commonmodel->checkseriesrows($XVAL,$NUM);
		
		$config['base_url'] = base_url('series-data/');
		$config['total_rows'] = $total_rows;
		$config['per_page'] = 50;
		$config['uri_segment'] = 2;
		$config['use_page_numbers'] = TRUE;
		
	/* Pagination configuration style starts here */
	
		$config['full_tag_open'] = '<div><ul class="pagination">';
		$config['full_tag_close'] = '</ul></div><!--pagination-->';
		$config['first_link'] = '&laquo; First';
		$config['first_tag_open'] = '<li class="prev page">';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = 'Last &raquo;';
		$config['last_tag_open'] = '<li class="next page">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = 'Next &rarr;';
		$config['next_tag_open'] = '<li class="next page">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&larr; Previous';
		$config['prev_tag_open'] = '<li class="prev page">';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li class="page">';
		$config['num_tag_close'] = '</li>';
		// $config['display_pages'] = FALSE;
		// 
		$config['anchor_class'] = 'follow_link';
		
		$config['num_links'] = 4;
		
	/* Pagination configuration style ends here */		
		
		$this->pagination->initialize($config);
		
		$data['page'] = ($this->uri->segment(2)) ? (($this->uri->segment(2))) : 0;
		
		$limit = $config["per_page"];

		if($data['page']==0)
		$start = 0;
		else
		$start = ($data['page']-1)*$config["per_page"];
		
		$data['seriesstockdata'] = $this->Commonmodel->seriesdatapaginate($XVAL,$NUM,$order_by='DESC',$order_by_field='SLNO',$limit,$start );
		$data['pagination_string'] = $this->pagination->create_links();	
		$data['perpage'] =  $limit ;

	#	echo $this->db->last_query(); exit; 
		
		
		
		if( $this->input->post('filterseriesdata'))
		{
			//locad the config item
			$this->form_validation->set_rules( $this->config->item('seriesdatafilter') );
			if( $this->form_validation->run() === false) { 	$this->load->view('admin/seriesdata',$data);}
			else
				$this->load->view('admin/seriesdata',$data);
			
		}
		else
			$this->load->view('admin/seriesdata',$data);
			
		$this->load->view('admin/footer');
		
	
	}
	
	public function uploaddata()
	{
		
		$this->session->set_userdata('D1','');	
		$this->session->set_userdata('D2','');	
		$this->session->set_userdata('D3','');
		 
		
		if( $this->session->userdata('Avg4_Combo') !='' )
			 $this->session->set_userdata('Avg4_Combo','') ;

		if($this->session->userdata('Avg3_Combo')!='')
		 $this->session->set_userdata('Avg3_Combo','') ;
				
		$data['FileError']  = '';
		
		$this->load->view('admin/header');		
		$err='';
		
		if( $this->input->post('uploadexcelsheet')   )
		{
			if( is_uploaded_file($_FILES["UploadExcel"]["tmp_name"]) )
			{
				$type = array("csv","xls","xlsx");
				
				$ext = explode(".",$_FILES["UploadExcel"]["name"]);
				if( in_array(end($ext),$type))
				{
					
				}
				else
					$err="Please Select Excel file to upload";
			}
			else
				$err="Please Select File to upload";
				
				
			if($err=='')
			{
					require_once APPPATH.'third_party/PHPExcel.php';
					$this->excel = new PHPExcel(); 
				
					$file_info = pathinfo($_FILES["UploadExcel"]["name"]);
					$file_directory = "uploads/";
					$new_file_name = date("d-m-Y ")."-".rand(000000, 999999) .".".$file_info["extension"];
				
					if(move_uploaded_file($_FILES["UploadExcel"]["tmp_name"], $file_directory . $new_file_name))
					{
						   
					$file_type	= PHPExcel_IOFactory::identify($file_directory . $new_file_name);
					$objReader	= PHPExcel_IOFactory::createReader($file_type);
					$objPHPExcel = $objReader->load($file_directory . $new_file_name);
					$sheet_data	= $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
					foreach($sheet_data as $data)
					{
						
						$date = (trim($data['E'])!='' ? trim($data['E']) : '');
						if( $date!='')
						{
							$date = date_create($date);
							$date = date_format($date,"Y-m-d")	;
						}
						
						$exceldata = array(
											"Name"=>(trim($data['A'])!='' ? trim($data['A']) : ''),
											"High"=>(trim($data['B'])!='' ? trim($data['B']) : ''),
											"Low"=>(trim($data['C'])!='' ? trim($data['C']) : ''),
											"Close"=>(trim($data['D'])!='' ? trim($data['D']) : ''),
											"Date"=>$date,
											"Flow"=>(trim($data['F'])!='' ? trim($data['F']) : ''),
											"Avg_Flow"=>(trim($data['W'])!='' ? trim($data['W']) : ''),
											"Avg4_Combo"=>(trim($data['X'])!='' ? trim($data['X']) : ''),
											"AX"=>(trim($data['Y'])!='' ? trim($data['Y']) : ( trim($data['Y'])=='=0'?'0':trim($data['Y']) ) ),
											"Avg3_Combo"=> (trim($data['AA'])!='' ? trim($data['AA']) : '' ),
											
											"D1"=>(trim($data['AC'])!='' ? ( trim($data['AC'])=='= 0'?'0':trim($data['AC']) ) : ''),
											"D2"=>(trim($data['AD'])!='' ? ( trim($data['AD'])=='= 0'?'0':trim($data['AD']) ) : ''),
											"D3"=>(trim($data['AE'])!='' ? ( trim($data['AE'])=='= 0'?'0':trim($data['AE']) ) : ''),
											
											"S1"=>(trim($data['AH'])!='' ? trim($data['AH']) : ''),
											"S2"=>(trim($data['AI'])!='' ? trim($data['AI']) : ''),
											"S3"=>(trim($data['AJ'])!='' ? trim($data['AJ']) : ''),
											"S4"=>(trim($data['AL'])!='' ? trim($data['AK']) : ''),
											"S5"=>(trim($data['AL'])!='' ? trim($data['AL']) : ''),
											"LastUpdate"=>time(),
						
											);
						
						$cond = array();
						
						$cond['Name']= trim($data['A']);
						$cond['Date']= $date;
						$table ='stockdata';
						$field = 'SLNO';
						
						if( $this->Commonmodel->checkexists($table,$cond))
						{
							$stockid = $this->Commonmodel->getAfield($table,$cond,$field,$order_by='',$order_by_field='',$limit='');
							
							$cond = array();
							$cond['SLNO'] = $stockid;
							
							$this->Commonmodel->updatedata($table,$exceldata,$cond);
						}
						else
							$this->Commonmodel->insertdata('stockdata',$exceldata);
						
					}
					
					if( unlink( $_SERVER['DOCUMENT_ROOT']."/".$this->config->item('PublicFolder')."/uploads/".$new_file_name ))
					{
						$msg = "<div class='alert alert-success'>Data imported success fully <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a></div>";
						$this->session->set_flashdata('Imported',$msg);
						redirect( base_url('view-data'));
					}
				
					}
			}
			else
			{
				$data['FileError'] = "<div class='alert alert-danger'>".$err." <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> </div>";

				$this->load->view('admin/uploaddata',$data);
			}
			
			
			
			
		}
		else
			$this->load->view('admin/uploaddata',$data);
			
		$this->load->view('admin/footer');
	
	}
	

	
	///call back funcitons 
	
	public function checkavg4combo()
	{
		$checkavg3combo = $this->input->post('avg3combo');
		
		if( trim($checkavg3combo)=='')
			{
				if( trim($this->input->post('avg4combo'))=='')		
				{
					$this->form_validation->set_message('checkavg4combo','Enter Avg4 Combo');
					return false;
				}
				else
					return true;
			}
		else
		{
			if( trim($this->input->post('avg4combo'))!='')		
				{
					$this->form_validation->set_message('checkavg4combo','Only one Combo');
					return false;	
				}
				else
					return true;
		}
	}
	
	public function checkavg3combo()
	{
		$checkavg4combo = $this->input->post('avg4combo');
		
		if( trim($checkavg4combo)!='' && ( trim($this->input->post('avg3combo'))!=''))
		{
			$this->form_validation->set_message('checkavg3combo','Only one Combo');
			return false;		
		}
		else
			return true;
		
	}
	
	
	//call back funciton ends here
	
	public function logout()
	{
		$this->session->unset_userdata('Userid');	
		redirect( base_url('login') );
		
	}
}
