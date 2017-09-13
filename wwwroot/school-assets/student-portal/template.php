<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<title>{school_name} {page_title}</title>
	<link rel="stylesheet" href="{base_url}assets/styles/master.css" type="text/css" media="screen" title="KAMAR" charset="utf-8" />
	{theme_css_include}
</head>

<body id="top">

	<div id="wrap">
		
		<div id="header">
			<h1>{school_name}</h1>
			{auth_head}
		</div>
		
		<div id="container">
			
			<ul id="navigation">
				{navigation}
			</ul>
			
			<div id="wrapper">
				{get_message}
				{page_content}
			</div>
			
		</div>
		
				
			<div id="footer">
				{school_name} - {timestamp}
			</div>
				
	</div>
	
</body>
</html>