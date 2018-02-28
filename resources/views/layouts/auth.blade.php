<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <title>@yield('title')</title>
	    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">		
		@yield('StyleSheets')	    
	</head>
	<body>
		<div id="wrapper">        
	        <div id="page-wrapper">
	            <div class="container-fluid main-content">                
	                    @yield('content')
	            </div>            
	        </div>        
	    </div>
	    <footer class="text-center">
	    	© <?php echo date("Y");?>. Всі права захищено.
	    </footer>
	</body>
		<script type="text/javascript" src="{{ Url::asset('assets/libs/jQuery/jquery-3.2.0.min.js') }}"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	    @yield('Scripts')    
</html>