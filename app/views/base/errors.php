
<?php 
$CI =& get_instance();
$CI->load->helper('url');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title><?= $error_code ?> - Fishee system</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="<?= image_url('favicon.ico')?>" type="image/x-ico"/>
	<!-- Fonts and icons -->
	<script src="<?=$BASE_URL?>assets/themes/atlantis/plugins/webfont/webfont.min.js"></script>
	<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['<?=$BASE_URL?>assets/themes/atlantis/css/fonts.min.css']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>
	<!-- CSS Files -->
	<link rel="stylesheet" href="<?=$BASE_URL?>assets/themes/atlantis/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?=$BASE_URL?>assets/themes/atlantis/css/atlantis.css">
</head>
<body class="login">
	<div class="wrapper wrapper-login wrapper-login-full p-0">
        <div class="login-aside w-50 d-flex flex-column align-items-center justify-content-center text-center bg-primary-gradient">
	        <h1 class="title fw-bold text-white mb-3 d-none d-sm-block"><img src="<?= $BASE_URL?>assets/images/404_bg.svg" style="width:90%"></h1>
        </div>
        <div class="login-aside w-50 d-flex align-items-center justify-content-center bg-white">
            <div class="container-scroller">
                <div class="container-fluid page-body-wrapper full-page-wrapper">
                    <div class="content-wrapper d-flex align-items-center text-center error-page ">
                        <div class="row flex-grow">
                            <div class="col-lg-7 mx-auto text-white">
                                <div class="row align-items-center d-flex flex-row">
                                    <div class="col-lg-6 text-lg-right pr-lg-4">
                                        <h1 class="display-1 mb-0 text-primary"><?=$error_code?></h1>
                                    </div>
                                    <div class="col-lg-6 error-page-divider text-lg-left pl-lg-4 text-primary">
                                        <h2><?=$error_title?></h2>
                                        <h3 class="font-weight-light"><?=$error_message?>.</h3>
                                    </div>
                                </div>
                                
                                <div class="row mt-5">
                                    <div class="col-12 text-center mt-xl-2">
                                    <?php if ($CI->session->userdata('com_user')) { ?>
                                        <a class="btn btn-warning btn-sm mb-2" href="<?= $BASE_URL . $CI->session->userdata('com_user')['default_page'] ?>"><i class="fa fa-tv mr-1"></i>Kembali ke Dashboard</a>	
                                        <a class="btn btn-primary btn-sm" onclick="history.back()"><i class="fa fa-home mr-1"></i>Kembali ke Halaman Sebelumnya</a>
                                    <?php } else { ?> 
                                        <a class="btn btn-primary btn-sm" onclick="history.back()"><i class="fa fa-home mr-1"></i>Kembali ke Halaman Sebelumnya</a>
                                    <?php } ?>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-12 mt-xl-2">
                                        <p class="text-primary font-weight-medium text-center">Copyright &copy; <?= date('Y') ?> All rights reserved.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- content-wrapper ends -->
                </div>
                <!-- page-body-wrapper ends -->
            </div>
        </div>
	</div>
</body>
</html>