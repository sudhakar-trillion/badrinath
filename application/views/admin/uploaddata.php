 <div id="content">
                    <div class="outer">
                        <div class="inner bg-light lter">
								
                                <div class="row" style="margin-top:80px; margin-bottom:320px">
  <div class="col-lg-12">
        <div class="box">
            <header>
                <div class="icons"><i class="fa fa-file-excel-o"></i></div>
                <h5>Upload Sheet</h5>
            </header>
            
             <?PHP echo $FileError;	?>
            
            <form action="" method="post" name="uploadsheet" id="uploadexcelsheet"  enctype="multipart/form-data"> 
            <div id="collapse4" class="body">
                	
                    <div class="col-md-6">
                    	
                        <input type="file" name="UploadExcel" class="form-control" />
                    </div>
                     <div class="col-md-6">
                    	<input type="submit" name="uploadexcelsheet" class="btn btn-primary" value="Upload" />
                        
                    </div>
                    
                    <div class="clearfix"></div>
                    
                    
            </div>
 </form>            
            
        </div>
        
        
    </div>
</div>

                        </div>
                        <!-- /.inner -->
                    </div>
                    <!-- /.outer -->
                </div>
                <!-- /#content -->

