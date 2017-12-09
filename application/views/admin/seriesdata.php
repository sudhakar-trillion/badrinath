 <div id="content">
                    <div class="outer">
                        <div class="inner bg-light lter">
								
                                <div class="row">
  <div class="col-lg-12">
        <div class="box">
            <header>
                <div class="icons"><i class="fa fa-table"></i></div>
                <h5>Dynamic Table</h5>

            </header>
            <?PHP
				$NUM='';
				$XVAL='';
				
				if( trim($this->session->userdata('Num'))!='' )
				{
					$NUM  = trim($this->session->userdata('Num'));
					$XVAL = trim($this->session->userdata('XVAL'));
				}
				elseif( $this->input->post('filterseriesdata') )
				{
					$XVAL = $this->input->post('Xval');
					$this->session->set_userdata('XVAL',$XVAL);
					
					$NUM = $this->input->post('Num');
					$this->session->set_userdata('Num',$NUM);	
				}
	
			?>
            
             <form class="form-horizontal filter-form" method="post" action="<?PHP echo base_url('series-data')?>">
            <div class="" style="margin-top:10px; margin-left:2px">
            	
               
                
                <div class="col-md-1">
            		<input type="text" class="form-control" name="Xval" placeholder="X" value="<?PHP echo $XVAL; ?>" maxlength="1" />
                    <span class="display-err" ><?PHP echo form_error('Xval'); ?></span>
                </div>
                
                <div class="col-md-1">
            		<input type="text" class="form-control" name="Num" placeholder="N" value="<?PHP echo $NUM; ?>" maxlength="1" />
                    <span class="display-err" ><?PHP echo form_error('Num'); ?></span>
                </div>
                
                
                <div class="col-md-4">
                		
                        <input class="btn btn-primary" type="submit" name="filterseriesdata" value="Filter data" />
                        <input class="btn btn-danger" type="button" name="export" value="Download" />
                </form>
                <form class="form-horizontal" method="post" action="<?PHP echo base_url('series-data')?>" style="display:inline-block">
                      
                      <!--  <input class="btn btn-warning" type="submit" name="resetfilterdata" value="Reset Filter" /> -->
                     <input class="btn btn-warning selecteddata" type="button" name="selectedseriesdata" value="Download Selected" /> 
                </form>
                </div>
                
                <div class="clearfix"></div>
                
                
                
           </div>
            
            <div id="collapse4" class="body">
            
            <?PHP
				echo @$this->session->flashdata('Imported');
			?>
                <table id="dataTable" class="table table-bordered table-condensed table-hover ">
                    <thead>
                    <tr>
                        <th>SLNO</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Close</th>
                        <th >Next Close</th>
                        <th>Flow</th>
                        
                        <th>Avg Flow</th>
                        <th class="avg4">Avg4 Comb</th>
                        <th class="avg3">Avg3 Comb</th>
                        <th>D1</th>
                        <th>D2</th>
                        <th>D3</th>

                        <th>S1</th>
                        <th>S2</th>
                        <th>S3</th>
                        <th>S4</th>
                        <th>S5</th>
                        
                        
                        
                    </tr>
                    </thead>
                    <tbody>
                            <?PHP
								$today = strtotime('now');
								$date_format = 'd-M-Y';
								 
								$UpDown = array('Uparrow'=>'<i class="fa fa-arrow-up fa-0.2x" aria-hidden="true"></i>', 'Downarrow'=>'<i class="fa fa-arrow-down fa-0.2x" aria-hidden="true"></i>');
								
							$showAvg4='';
							$showAvg3='';
									
							if($seriesstockdata!='0')
							{
								if( @$combo4!='' && $this->session->userdata('D1') !='' )
									 $showAvg3='none';
								
								if( @$combo3!='' && $this->session->userdata('D1') !='' )
									 $showAvg4='none';

								$slno=0;
								if($this->uri->segment(2)) { $slno = ($this->uri->segment(2)-1)*$perpage;	}	
								
								foreach( $seriesstockdata->result() as $data )
								{
									$slno++;
									?>
                                    <tr class="chkdata" three="<?PHP echo $showAvg3; ?>" four="<?PHP echo $showAvg4; ?>" >
                                    	<td><?PHP echo $slno; ?></td>
                                        <td><?PHP echo $data->Name ?></td>
                                        <td>
											<?PHP 
										 			$dated = date_create($data->Date);
													echo $dated = date_format($dated,"d/m/Y");
											?>
                                            </td>
                                         <td><?PHP echo $data->Close;?></td>
                                         <td>
                                         <?PHP
                                         		$clse = $this->db->query("SELECT Close, DATE from stockdata where Date>'".$data->Date."' and Name='".$data->Name."' order by Date ASC LIMIT 0,1");
												if($clse->num_rows()>0)
												{
													foreach( $clse->result() as $closest)
													{
														echo $closest->Close;	
													}
													
												}
												else
													echo "---";
												
										?>
                                         </td>
                                         
                                         <td>
										 		<?PHP 
														echo $data->Flow; 
														
														if( trim($data->Flow)=='A')
															echo $UpDown['Uparrow'];
														else	
															echo $UpDown['Downarrow'];
															
														
												?>
                                          </td>
                                          
                                          <td>
                                          	<?PHP echo $data->Avg_Flow; ?>
                                          </td>
                                          
                                          <td  style="display:<?PHP echo $showAvg4;?>">
                                          	<?PHP echo $data->Avg4_Combo; ?>
                                          </td>
                                          
                                          <td style="display:<?PHP echo $showAvg3;?>">
                                          	<?PHP echo $data->Avg3_Combo; ?>
                                          </td>
                                          
										   <td> <?PHP echo $data->D1; ?> </td>
                                           <td> <?PHP echo $data->D2; ?> </td>
                                           <td> <?PHP echo $data->D3; ?> </td>
                                           
                                           <td> <?PHP echo $data->S1; ?> </td>
                                           <td> <?PHP echo $data->S2; ?> </td>
                                           
                                           <td> <?PHP echo $data->S3; ?> </td>
                                           <td> <?PHP echo $data->S4; ?> </td>
                                           <td> <?PHP echo $data->S5; ?> </td>

                                    </tr>
                                    <?PHP	
								}
								
							}
							else
								echo "<tr><td colspan='17' align='center'><h1>No data found </h1></td></tr>";	
							
							?>
                         
                    </tbody> 
                 </table>
            </div>
            
            <div class="row">
        		<div class="col-sm-7">
                	<div class="dataTables_paginate paging_simple_numbers" id="dataTable_paginate">
				
                            <?PHP echo $pagination_string; ?>
            
            		</div>
                 </div>
              </div>
            
        </div>
        
        
    </div>
</div>

                        </div>
                        <!-- /.inner -->
                    </div>
                    <!-- /.outer -->
                </div>
                <!-- /#content -->

