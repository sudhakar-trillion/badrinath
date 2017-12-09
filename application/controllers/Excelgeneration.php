<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Excelgeneration extends CI_Controller 
{

	 public function __construct()
		{
			parent::__construct();
			date_default_timezone_set("Asia/Kolkata");
			$this->load->library('excel');
			$this->load->model('Commonmodel');
			
		}//constructor stARTS HERE
		
	
	public function stockdata()
	{
		
		extract($_POST);
		
		$table = 'stockdata';
				
		
		if( trim($avg4combo)!='' )
			$combo4 = trim($avg4combo);
		else
			$combo4 = '';
				
		if( trim($avg3combo)!='')
			$combo3 = trim($avg3combo);
		else
			$combo3 = '';
			
		
		if( $combo4 !='' )
		{
			$this->db->where("Avg4_Combo",$combo4);	
			$append="Avg4combo";
		}
		else if( $combo3 !='' )
		{
			$this->db->where("Avg3_Combo",$combo3);	
			$append="Avg3combo";
		}
				
			
			$this->db->like('D1', trim($D1),'after');
			$this->db->like('D2', trim($D2),'after');
			$this->db->like('D3', trim($D3),'after');
			$this->db->order_by('Date','DESC');
			$this->db->order_by('Name','ASC');
			
			$qry = $this->db->get('stockdata');
			
			
			if( $qry->num_rows()>0) 
			{
				
					$this->excel->setActiveSheetIndex(0);
					if($combo3!='')
						$select_cols = array('Slno','Name','Date','Close','Next Close','Flow','	Avg Flow','Avg3 Comb','D1','D2','D3','S1','S2','S3','S4','S5');
					else if ($combo4!='')
						$select_cols = array('Slno','Name','Date','Close','Next Close','Flow','	Avg Flow','Avg4 Comb', 'D1','D2','D3','S1','S2','S3','S4','S5');
					
					$excel_sheet_name = $append."_".time();
			
					$cnt=1;
					
					$Excelcolmns = range('A','Z');
					
					$needed_columns = array_slice( $Excelcolmns,0,sizeof($select_cols) );
					foreach( $needed_columns as $key=>$val )
					{
						$col = $select_cols[$key];
						$this->excel->getActiveSheet()->setCellValue($needed_columns[$key].'1', $col);
						$this->excel->getActiveSheet()->getStyle($needed_columns[$key].'1')->getFont()->setSize(13);
						$this->excel->getActiveSheet()->getStyle($needed_columns[$key].'1')->getFont()->setBold(true);
						$this->excel->getActiveSheet()->getStyle($needed_columns[$key].'1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
					}
					
					$out_resp = array();
					$slcnt=0;
					foreach( $qry->result() as $data)
					{
						$slcnt++;
						
							$date = date_create($data->Date);
							$date = date_format($date,"d-m-Y");
							
							$clse = $this->db->query("SELECT Close, DATE from stockdata where Date>'".$data->Date."' and Name='".$data->Name."' order by Date ASC LIMIT 0,1");
												if($clse->num_rows()>0)
												{
													foreach( $clse->result() as $closest)
													{
														$NextClose = $closest->Close;	
													}
													
												}
												else
													$NextClose = "---";
						
						$out_resp[] = array(
												'Slno'=>$slcnt,
												"Name"=>(trim($data->Name)!='' ? trim($data->Name) : ''),
												"Date"=>$date,
												"Close"=>$data->Close,
												"Next Close"=>$NextClose,
												"Flow"=>$data->Flow,
												"Avg Flow"=>$data->Avg_Flow,
												"Avg4 Combo"=>$data->Avg4_Combo,
												"Avg3 Combo"=>$data->Avg3_Combo,
												"D1"=>$data->D1,
												"D2"=>$data->D2,
												"D3"=>$data->D3,
												"S1"=>$data->S1,
												"S2"=>$data->S2,
												"S3"=>$data->S3,
												"S4"=>$data->S4,
												"S5"=>$data->S5
											);
					}
					
					
					//prepare the excel sheet
					foreach($out_resp as $key=>$va)
					{
						
						
				
			//prepare the excel sheet name
			
				if($cnt==1)
				{ 
					$this->excel->getActiveSheet()->setTitle("View-student-attendance-report"); 
					//$excel_sheet_name = time().str_replace(" ","-",$postdata['filter']['Owner_Name']); 							
				}	
				
				foreach($va as $k=>$value)
				{
				
					if($k=="Slno")
					{
					//	echo "$k:".$value;	
							$this->excel->getActiveSheet()->setCellValue('A'.($cnt+1), $value);
							//change the font size
							$this->excel->getActiveSheet()->getStyle('A'.($cnt+1))->getFont()->setSize(12);
							$this->excel->getActiveSheet()->getStyle('A'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
					}
					if($k=="Name")
					{
					//	echo "$k:".$value;	
							$this->excel->getActiveSheet()->setCellValue('B'.($cnt+1), $value);
							//change the font size
							$this->excel->getActiveSheet()->getStyle('B'.($cnt+1))->getFont()->setSize(12);
							$this->excel->getActiveSheet()->getStyle('B'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
					}
					if($k=="Date")
					{
					//	echo "$k:".$value;	
							$this->excel->getActiveSheet()->setCellValue('C'.($cnt+1), $value);
							//change the font size
							$this->excel->getActiveSheet()->getStyle('C'.($cnt+1))->getFont()->setSize(12);
							$this->excel->getActiveSheet()->getStyle('C'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
					}
					if($k=="Close")
					{
					//	echo "$k:".$value;	
							$this->excel->getActiveSheet()->setCellValue('D'.($cnt+1), $value);
							//change the font size
							$this->excel->getActiveSheet()->getStyle('D'.($cnt+1))->getFont()->setSize(12);
							$this->excel->getActiveSheet()->getStyle('D'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
					}
					
					if($k=="Next Close")
					{
					//	echo "$k:".$value;	
							$this->excel->getActiveSheet()->setCellValue('E'.($cnt+1), $value);
							//change the font size
							$this->excel->getActiveSheet()->getStyle('E'.($cnt+1))->getFont()->setSize(12);
							$this->excel->getActiveSheet()->getStyle('E'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
					}
					if($k=="Flow")
					{
					//	echo "$k:".$value;	
					if( $value=="A")
						$this->excel->getActiveSheet()->setCellValue('F'.($cnt+1), $value.'↑');
					else if( $value=="B")
						$this->excel->getActiveSheet()->setCellValue('F'.($cnt+1), $value.'↓');
							//change the font size
							$this->excel->getActiveSheet()->getStyle('F'.($cnt+1))->getFont()->setSize(12);
							$this->excel->getActiveSheet()->getStyle('F'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
					}
				
					if($k=="Avg Flow")
					{
					//	echo "$k:".$value;	
							$this->excel->getActiveSheet()->setCellValue('G'.($cnt+1), $value);
							//change the font size
							$this->excel->getActiveSheet()->getStyle('G'.($cnt+1))->getFont()->setSize(12);
							$this->excel->getActiveSheet()->getStyle('G'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
					}
					
					if($k=="Avg4 Combo" && $combo4!='')
					{
					//	echo "$k:".$value;	
							$this->excel->getActiveSheet()->setCellValue('H'.($cnt+1), $value);
							//change the font size
							$this->excel->getActiveSheet()->getStyle('H'.($cnt+1))->getFont()->setSize(12);
							$this->excel->getActiveSheet()->getStyle('H'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
					}
					
					if($k=="Avg3 Combo" && $combo3!='')
					{
					//	echo "$k:".$value;	
							$this->excel->getActiveSheet()->setCellValue('H'.($cnt+1), $value);
							//change the font size
							$this->excel->getActiveSheet()->getStyle('H'.($cnt+1))->getFont()->setSize(12);
							$this->excel->getActiveSheet()->getStyle('H'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
					}
					
					if($k=="D1")
					{
					//	echo "$k:".$value;	
							$this->excel->getActiveSheet()->setCellValue('I'.($cnt+1), $value);
							//change the font size
							$this->excel->getActiveSheet()->getStyle('I'.($cnt+1))->getFont()->setSize(12);
							$this->excel->getActiveSheet()->getStyle('I'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
					}
					
					if($k=="D2")
					{
					//	echo "$k:".$value;	
							$this->excel->getActiveSheet()->setCellValue('J'.($cnt+1), $value);
							//change the font size
							$this->excel->getActiveSheet()->getStyle('J'.($cnt+1))->getFont()->setSize(12);
							$this->excel->getActiveSheet()->getStyle('J'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
					}
					
					if($k=="D3")
					{
					//	echo "$k:".$value;	
							$this->excel->getActiveSheet()->setCellValue('K'.($cnt+1), $value);
							//change the font size
							$this->excel->getActiveSheet()->getStyle('K'.($cnt+1))->getFont()->setSize(12);
							$this->excel->getActiveSheet()->getStyle('K'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
					}
						
						
					if($k=="S1")
					{
					//	echo "$k:".$value;	
							$this->excel->getActiveSheet()->setCellValue('L'.($cnt+1), $value);
							//change the font size
							$this->excel->getActiveSheet()->getStyle('L'.($cnt+1))->getFont()->setSize(12);
							$this->excel->getActiveSheet()->getStyle('L'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
					}
					
					if($k=="S2")
					{
					//	echo "$k:".$value;	
							$this->excel->getActiveSheet()->setCellValue('M'.($cnt+1), $value);
							//change the font size
							$this->excel->getActiveSheet()->getStyle('M'.($cnt+1))->getFont()->setSize(12);
							$this->excel->getActiveSheet()->getStyle('M'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
					}
					
					if($k=="S3")
					{
					//	echo "$k:".$value;	
							$this->excel->getActiveSheet()->setCellValue('N'.($cnt+1), $value);
							//change the font size
							$this->excel->getActiveSheet()->getStyle('N'.($cnt+1))->getFont()->setSize(12);
							$this->excel->getActiveSheet()->getStyle('N'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
					}
					
					if($k=="S4")
					{
					//	echo "$k:".$value;	
							$this->excel->getActiveSheet()->setCellValue('O'.($cnt+1), $value);
							//change the font size
							$this->excel->getActiveSheet()->getStyle('O'.($cnt+1))->getFont()->setSize(12);
							$this->excel->getActiveSheet()->getStyle('O'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
					}
					
					if($k=="S5")
					{
					//	echo "$k:".$value;	
							$this->excel->getActiveSheet()->setCellValue('P'.($cnt+1), $value);
							//change the font size
							$this->excel->getActiveSheet()->getStyle('P'.($cnt+1))->getFont()->setSize(12);
							$this->excel->getActiveSheet()->getStyle('P'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
					}
					
				
				
				//'Slno','Paid For','Paid Amount','Paid To','Paid On','Contact Person','Email','Phone'
				}
				$cnt++;
			
			
					
					}
					
				$filename="$excel_sheet_name.xls"; //save our workbook as this file name
				
				
				header("Pragma: public");
				header("Expires: 0");
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				header("Content-Type: application/force-download");
				header("Content-Type: application/octet-stream");
				header("Content-Type: application/download");
				
				header('Content-Type: application/vnd.ms-excel'); //mime type
				header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
				header('Cache-Control: max-age=0'); //no cache
				
				//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
				//if you want to save it as .XLSX Excel 2007 format
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
				//force user to download the Excel file without writing it to server's HD
				
				$requested_from =  $_SERVER['HTTP_REFERER'];
				
				if( strpos($requested_from, 'localhost') !== false)
				$filename = $filename;
				
				//$objWriter->save('php://output');
				$objWriter->save($filename);
				echo $filename;
				
			}
			else
				echo "0";
		
		
		
	}

public function deleteexcelsheet()
	{
		
		
		$requested_from =  $_SERVER['HTTP_REFERER'];
			
		if( strpos($requested_from, 'localhost') !== false)
			$path = $_SERVER['DOCUMENT_ROOT']."/badrinath/".$_POST['excelname'];
		elseif(strpos($requested_from, 'trillionit.in') !== false)
			$path = $_SERVER['DOCUMENT_ROOT']."/badrinath/".$_POST['excelname'];
		

		$this->load->helper('file');
		unlink($path);
			
	}
	
		
}//class ends here		



