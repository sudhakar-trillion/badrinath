<!doctype html>
<html>

<head>
<base href="<?PHP echo base_url(); ?>">
    <meta charset="UTF-8">
    <!--IE Compatibility modes-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--Mobile first-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Metis</title>
    
    <meta name="description" content="Free Admin Template Based On Twitter Bootstrap 3.x">
    <meta name="author" content="">
    
    <meta name="msapplication-TileColor" content="#5bc0de" />
    <meta name="msapplication-TileImage" content="resources/assets/img/metis-tile.png" />
    
    <!-- Bootstrap -->
    <link rel="stylesheet" href="resources/assets/lib/bootstrap/css/bootstrap.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="resources/assets/lib/font-awesome/css/font-awesome.css">
    
    <!-- Metis core stylesheet -->
    <link rel="stylesheet" href="resources/assets/css/main.css">
    
    <!-- metisMenu stylesheet -->
    <link rel="stylesheet" href="resources/assets/lib/metismenu/metisMenu.css">
    
    <!-- onoffcanvas stylesheet -->
    <link rel="stylesheet" href="resources/assets/lib/onoffcanvas/onoffcanvas.css">
    
    <!-- animate.css stylesheet -->
    <link rel="stylesheet" href="resources/assets/lib/animate.css/animate.css">



<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

    <!--For Development Only. Not required -->
    <script>
        less = {
            env: "development",
            relativeUrls: false,
            rootpath: "/resources/assets/"
        };
    </script>
    <link rel="stylesheet" href="resources/assets/css/style-switcher.css">
    <link rel="stylesheet/less" type="text/css" href="resources/assets/less/theme.less">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/less.js/2.7.1/less.js"></script>
<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>


<style>
	#dataTable i{
			font-size:12px;
			font-weight:normal;

	}
	
	.navbar-nav {
    	margin: 0;
    display: inline-block !important;
	float:none !important;
	}
	
	.display-err
	{
		color:#F00;
	}

#dataTable tr td, tr th{
	text-align:center;
	text-transform:uppercase;
}

#dataTable tr td
{
	font-size:15px;
}
#dataTable tr td
{
	font-size:15px;
}

.filter-form input::placeholder{
	font-size:16px;
}

.filter-form input[type='text']{
	font-size:20px;
	text-transform:uppercase;

}

.navbar-inverse .navbar-nav > li > a {
    color: #fff;
}
.nav > li {
    position: relative;
    display: block;
    margin-right: 8px;
    background: #f00;
}
.btn-metis-1 {
    color: #fff;
    background-color: #f00;
    border-color: #f00;
    height: 54px;
	line-height:34px;
	border-radius:0px;
}
#top .topnav{
	margin:0px;
}
#top > .navbar {
    border-top: 0px solid #428bca;
}
.navbar-nav > li > a {
    padding-top: 17px;
    padding-bottom: 17px;
}
.nav > li {
    position: relative;
    display: inline-block;
  
    background: #f00;
}
.navbar-inverse .navbar-nav > li > a{

}
.navbar-nav > li {
   float: none; 
   	margin-right:10px;
}

.chkdata.highlight
{
	background:#F00 !important;
	color:#fff;
}
</style>

  </head>

        <body class="  ">
            <div class="bg-dark dk" id="wrap">
                <div id="top">
                    <!-- .navbar -->
                    <nav class="navbar navbar-inverse navbar-static-top">
                        <div class="container-fluid">
                    
                    
                            <!-- Brand and toggle get grouped for better mobile display -->
                            <header class="navbar-header">
                    
                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                               
                    
                            </header>
                    
                    
                    
                            <div class="topnav">
                                
                                <div class="btn-group">
                                    <a href="<?PHP echo base_url('logout'); ?>" data-toggle="tooltip" data-original-title="Logout" data-placement="bottom"
                                       class="btn btn-metis-1 btn-sm">
                                        <i class="fa fa-power-off"></i>
                                    </a>
                                </div>
                                
                    
                            </div>
                    
                    
                    
                    
                            <div class="collapse navbar-collapse navbar-ex1-collapse text-right">
                    
                                <!-- .nav -->
                                <ul class="nav navbar-nav">
                                    <li><a href="<?PHP echo base_url('upload-data'); ?>" >Upload Data</a></li>
                                    <li><a href="<?PHP echo base_url('view-data'); ?>">View Data</a></li>
                                     <li><a href="<?PHP echo base_url('series-data'); ?>">Series Data</a></li>
                                </ul>
                                <!-- /.nav -->
                            </div>
                        </div>
                        <!-- /.container-fluid -->
                    </nav>
                    <!-- /.navbar -->
                      
                </div>
                <!-- /#top -->
                    
                    <!-- /#left -->