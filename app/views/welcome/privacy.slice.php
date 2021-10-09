<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>SIPPMASBOI</title>
		<!-- FAVICON LINK -->
		<link rel="shortcut icon" href="<?php echo base_url(); ?>template/html/images/logo.png" type="image/x-icon">
		<!-- STYLESHEETS -->
		<!-- BOOTSTRAP CSS -->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>template/html/css/vendor/bootstrap.css">
		<!-- FONT AWESOME -->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>template/html/css/vendor/font-awesome/css/font-awesome.min.css" />
		<!-- MAGNIFIC LIGHT BOX -->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>template/html/css/vendor/magnific/magnific-popup.css">
		<!-- CAROUSEL STYLE LINK -->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>template/html/css/vendor/owl-carousel/owl.carousel.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>template/html/css/vendor/owl-carousel/owl.theme.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>template/html/css/vendor/owl-carousel/carousel.css">
		<link rel="stylesheet" href="{{asset('themes/atlantis/plugins/select2/select2.full.css')}}">
		<link rel="stylesheet" href="{{asset('themes/atlantis/plugins/sweetalert/sweetalert2.min.css')}}">
		<!-- CUSTOM CSS -->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>template/html/css/custom/style.css">
		<style>

.dropdown-menu a {
  color: #33a9ee;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
font-weight : 600;
}

.dropdown-menu a:hover {background-color: #ddd;}

</style>
	</head>
	<body data-spy="scroll" data-target="#navbarSupportedContent" data-offset="132" >
<script>
// When the user scrolls down 50px from the top of the document, resize the header's font size
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
    document.getElementById("header").style.background = "black";
  } else {
    document.getElementById("header").style.background = @if ($this->uri->segment(1) != 'berita') "transparent" @endif;
  }
}
</script>
<!--================================= NAVIGATION END ==========================================-->	

<!--=================================  HEADER START ==========================================-->
<div class='container'>
    <section class="section-padding section-1-bg" id="gallery">
		<div class="container heading-ff-4" style="margin-top:5%;">
			<div class="row rowsafari">
				<div class="col-sm-12 col-md-12 col-lg-8">
					<div class="two-left-col m-2">
						<h3>Privacy Policy</h3>
						<br />
						POST BY : Administrator
						<br />
						<i class="fa fa-calendar" aria-hidden="true"></i>2021-09-24
						<br />
							<img src="{{base_url()}}/assets/images/forgot_password_bg.svg" alt="image" class="img-fluid" style="margin-top:36px;" width="100%" width="100%"/>
						
						<p class="content-top-space mt-2 text-justify">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
						<p class="content-top-space mt-2 text-justify">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
						<p class="content-top-space mt-2 text-justify">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
					</div>
				</div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>template/html/js/vendor/jquery.min.js"></script>	
<!-- BOOTSTRAP -->
<script type="text/javascript" src="<?php echo base_url(); ?>template/html/js/vendor/bootstrap.min.js"></script>	
<!-- SLIDER JS FILES -->
<script type="text/javascript" src="<?php echo base_url(); ?>template/html/js/vendor/slider/owl.carousel.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>template/html/js/vendor/slider/owl-slider.js"></script>			
<!-- MAGNIFIC LIGHT BOX -->
<script type="text/javascript" src="<?php echo base_url(); ?>template/html/js/vendor/magnific/jquery.magnific-popup.js"></script>	
<!-- THEME JS -->
<script type="text/javascript" src="<?php echo base_url(); ?>template/html/js/custom/custom.js"></script>	
<!-- RETINA JS FILES -->		
<script type="text/javascript" src="<?php echo base_url(); ?>template/html/js/vendor/retina.js"></script>
<script src="{{asset('themes/atlantis/plugins/select2/select2.full.min.js')}}"></script>
<script src="{{asset('themes/atlantis/plugins/sweetalert/sweetalert2.all.min.js')}}"></script>
<!--Floating WhatsApp css-->
<link rel="stylesheet" href="https://rawcdn.githack.com/rafaelbotazini/floating-whatsapp/3d18b26d5c7d430a1ab0b664f8ca6b69014aed68/floating-wpp.min.css">
<!--Floating WhatsApp javascript-->
<script type="text/javascript" src="https://rawcdn.githack.com/rafaelbotazini/floating-whatsapp/3d18b26d5c7d430a1ab0b664f8ca6b69014aed68/floating-wpp.min.js"></script>

</body>
</html>


