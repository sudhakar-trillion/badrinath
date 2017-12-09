  </div>
 
 <div id="filter-data-notfound" class="modal fade forgot-modal" role="dialog" style="top: 77px;">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="display:inline-block; right:0px; position:absolute; background:#000; padding:5px; z-index:9999 ">

     <button type="button" class="close" data-dismiss="modal" style="text-shadow:none; color:#fff; opacity:1;">&times;</button> 
	
      </div>
      <div class="modal-body">
        <p class="kind" style="font-size:20px; color:#F00"> <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Data not found under this search</p>
    
      </div>
      
      
    </div>

  </div>
</div>


<div id="data-upload" class="modal fade forgot-modal" role="dialog" style="top: 77px;">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="display:inline-block; right:0px; position:absolute; background:#000; padding:5px; z-index:9999 ">

     <button type="button" class="close" data-dismiss="modal" style="text-shadow:none; color:#fff; opacity:1;">&times;</button> 
	
      </div>
      <div class="modal-body">
        <p class="kind" style="font-size:20px; color:#F00">
        	Uploading
            <img src="resources/assets/img/ajax-loader.gif"/>
        </p>
    
      </div>
      
      
    </div>

  </div>
</div>

<div id="askPwd" class="modal fade forgot-modal" role="dialog" style="top: 77px;">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="display:inline-block; right:0px; position:absolute; background:#000; padding:5px; z-index:9999 ">

     <button type="button" class="close" data-dismiss="modal" style="text-shadow:none; color:#fff; opacity:1;">&times;</button> 
	
      </div>
      <div class="modal-body">
        <p class="kind" style="font-size:20px; color:#F00">

            <input type="text" style="width:60%; float:left" class="form-control upload-pwd" placeholder="Enter Password" />
			<button class="btn btn-primary btn-sm" style="margin-left:5px" id="chkpassword"><i class="fa fa-check" aria-hidden="true" style="color:#fff"></i></button>
        </p>
        <p style="color:#F00" class="invalidpwd">Invalid password</p>
    
      </div>
      
      
    </div>

  </div>
</div>

            <!-- /#wrap -->
            <footer class="Footer bg-dark dker">
                <p>2017 &copy; Developed by <a href="http://www.trillionit.com" target="_blank" >TrillionIt Services PVT LTD</a></p>
            </footer>
            
            <!--jQuery -->
            <script src="resources/assets/lib/jquery/jquery.js"></script>


            <!--Bootstrap -->
            <script src="resources/assets/lib/bootstrap/js/bootstrap.js"></script>
            <!-- MetisMenu -->
            <script src="resources/assets/lib/metismenu/metisMenu.js"></script>
            <!-- onoffcanvas -->
            <script src="resources/assets/lib/onoffcanvas/onoffcanvas.js"></script>
			
            <script>
				var base_url = "<?PHP echo base_url(); ?>";
				$(document).ready(function()
				{

					
					$("input[name='export']").on('click',function()
					{
						
						var Onclick = $(this);
						
						var avg4combo = $("input[name='avg4combo']").val();
							avg4combo = $.trim(avg4combo);
							
						var avg3combo	= $("input[name='avg3combo']").val();
							avg3combo = $.trim(avg3combo);
						
						var D1 = $("input[name='D1']").val();
							D1 = $.trim(D1);
						
						var D2 = $("input[name='D2']").val();
							D2 = $.trim(D2);
							
						var D3 = $("input[name='D3']").val();
							D3 = $.trim(D3);
						
						var Err_cnt='0';
						
						
						if( D1=='')
						{
							Err_cnt='1';
							$("input[name='D1']").next().html('Enter D1');
						}
						else
							$("input[name='D1']").next().html('');
						
						
						if( D2=='')
						{
							Err_cnt='1';
							$("input[name='D2']").next().html('Enter D2');
						}
						else
							$("input[name='D2']").next().html('');
							
						if( D3=='')
						{
							Err_cnt='1';
							$("input[name='D3']").next().html('Enter D3');
						}
						else
							$("input[name='D3']").next().html('');		
						
						
						if( avg4combo!='' ||  avg3combo!='' )
						{
							$("input[name='avg3combo']").next().html('');
							$("input[name='avg4combo']").next().html('');
						}
						else
						{
							Err_cnt='1';
							$("input[name='avg4combo']").next().html('Enter Avg4Combo');
							$("input[name='avg3combo']").next().html('Enter Avg3Combo');
						}
						
						if(Err_cnt=='0')
						{
							if( avg4combo!='' &&  avg3combo!='' )	
							{
								$("input[name='avg3combo']").next().html('Enter Only One Combo');
								$("input[name='avg4combo']").next().html('Enter Only One Combo');
								Err_cnt='1';
							}
							else
							{
								$("input[name='avg3combo']").next().html('');
								$("input[name='avg4combo']").next().html('');	
							}
							
							
							if( Err_cnt=='0')
							{
								
								$.ajax({ 
											url:base_url+'Excelgeneration/stockdata',
											type:"POST",
											data:{"avg4combo":avg4combo,"avg3combo":avg3combo,"D1":D1,"D2":D2,"D3":D3},
											beforeSend:function(){ Onclick.val('Importing....'); Onclick.attr('disabled',true);  },
											success:function(response)
											{
												response = $.trim(response);
												Onclick.attr('disabled',false);
												Onclick.val('Download');
					
												if( response =="0" ) 
												{
													$("#filter-data-notfound").modal('show');	
												}
												else
												{
													location.href=base_url+response;
													setTimeout( function()
													{ 
														
														$.ajax({
														url:base_url+"Excelgeneration/deleteexcelsheet",
														type:'POST',
														data:{"excelname":response},
														async:false,
														success:function()
														{
															Onclick.val('Download');
														}	
														})
													
													},2000 );
												
												
												}//else ends here
											}
											
										
										});
									
							}
							
						}
						
						
					})
				
				var showAvg4= $(".chkdata").attr('four');
				var showAvg3= $(".chkdata").attr('three');
				
				if( showAvg4=="none")
					$(".avg4").hide();
				
				if( showAvg3=="none")
					$(".avg3").hide();
				
				/*
				$("input[name='uploadexcelsheet']").on('click',function()
				{
					
					$("#data-upload").modal('show');	
					
				});
				*/
				
				$('.chkdata').on('click', function()
				{
					
					if( $(this).hasClass('highlight'))
						$(this).removeClass('highlight');
					else
						$(this).addClass('highlight');
					
					//$('.chkdata').removeClass('highlight');
					//$(this).addClass('highlight');
					
				});
				
				
				});
				
				
			$(document).on('click','.selecteddata',function()
			{
				var chklen = $(".highlight").length	
					chklen = parseInt(chklen);
					
					if(chklen>0)
					{
				
						var table='<table><tr><th>SLNO</th><th>NAME</th><th>DATE</th> ';	
							table=table+'<th>CLOSE</th><th>NEXT CLOSE</th><th>FLOW</th> ';	
							table=table+'<th>AVG FLOW</th><th>AVG4 COMB</th><th>AVG3 COMB</th> ';	
							table=table+'<th>D1</th><th>D2</th><th>D3</th> ';	
							table=table+'<th>S1</th><th>S2</th><th>S3</th><th>S4</th><th>S5</th></tr> ';	
						
						$(".highlight").each(function()
						{
							table = table+'<tr>'+$(this).html()+'</tr>';
						});
						table = table+"</table>";	
		
						window.open('data:application/vnd.ms-excel,' + encodeURIComponent($.trim(table)) );
						event.preventDefault();
					}
					else
					alert("Please Select atleast one row");
					
				
			});
			
			

			
			</script>
            
            
        </body>

</html>
