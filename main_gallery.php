<!DOCTYPE html>
	<head>
		<meta charset="utf-8">
		<title>Test page for auto-generated image gallery in PHP</title>

		<!-- This is the stylesheet for the pop up box. This is required in the HTML header -->
		<link rel="stylesheet" href="colorbox.css" />
		<!-- This is the jquery script and the colorbox script. These are required in the HTML header -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script src="jquery.colorbox.js"></script>

		<!-- This CSS defines the look of the box around the thumbnail. This can be copied into your CSS for the page -->
		<style type="text/css">
			.clear { clear:both; }
			.photo-link		{ padding:5px; margin:5px; border:1px solid #ccc; display:block;  float:left; }
			.photo-link:hover	{ background: #777; border-color:#999; }
		</style>

		<!-- This script controls how the colorbox pop up behaves and needs to be in the header -->
		<!-- The options for colorbox can be found at http://www.jacklmoore.com/colorbox/ -->
		<script>
		$(document).ready(function(){
			$(".photo-link").colorbox({rel:'photo-link', title:false});
		});
		</script>
	</head>
	<body>
		<!-- This is the php script that will include the main code to generate the gallery. It should be placed in the location you want the gallery -->
		<?php require("gallery.php"); ?>
	</body>
</html>


			
