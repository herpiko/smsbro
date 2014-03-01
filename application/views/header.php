<head>
	<meta charset="utf-8">
	<title>SMSBroadcast - <?php echo $title; ?></title>

	<!-- Bootstrap-->
	<link href="<?php echo $base_url;?>application/views/css/bootstrap.css" rel="stylesheet">
	<link href="<?php echo $base_url;?>application/views/css/bootstrap-responsive.css" rel="stylesheet">
	<link href="<?php echo $base_url;?>application/views/css/style.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>application/views/css/jquery.asmselect.css" />

	<script type="text/javascript" src="<?php echo $base_url;?>application/views/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo $base_url;?>application/views/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo $base_url;?>application/views/js/scripts.js"></script>


 
	<!-- BSM Select -->
		<script type="text/javascript" src="<?php echo $base_url;?>application/views/js/jquery.js"></script>
	<script type="text/javascript" src="<?php echo $base_url;?>application/views/js/jquery.ui.js"></script>
	<script type="text/javascript" src="<?php echo $base_url;?>application/views/js/jquery.asmselect.js"></script>

	<script type="text/javascript">

		$(document).ready(function() {
			$("select[multiple]").asmSelect({
				addItemTarget: 'bottom',
				animate: true,
				highlight: false,
				sortable: true
			});
			
		}); 
      
      function countChar1(val) {
        var len = val.value.length;
        var partby1 = " karakter. ( 1 SMS )";
        var partby2 = " karakter. ( 2 SMS )";
        var partby3 = " karakter. ( 3 SMS )";
        var partby4 = " karakter. ( 4 SMS )";
        var partby5 = " karakter. ( 5 SMS )";
        var partby6 = " karakter. Buset. Kebanyakan, woi!";
        
        if (len <= 160) {
          $('#charNum1').text(len);
          $('#charNumPart1').text(partby1);

        } else {
        	if (len <= 306) {
        		$('#charNum1').text(len);
          		$('#charNumPart1').text(partby2);
        	} else {
        		if (len <= 459) {
        		$('#charNum1').text(len);
          		$('#charNumPart1').text(partby3);
        	} else {
        		if (len <= 612) {
        		$('#charNum1').text(len);
          		$('#charNumPart1').text(partby4);
        	} else {
        		if (len <= 765) {
        		$('#charNum1').text(len);
          		$('#charNumPart1').text(partby5);
        	} else {
        		if (len >= 765) {
        		$('#charNum1').text(len);
          		$('#charNumPart1').text(partby6);
        	}
        	}
        	}
        	}
        	}
        }
      };

      function countChar2(val) {
        var len = val.value.length;
        var partby1 = " karakter. ( 1 SMS )";
        var partby2 = " karakter. ( 2 SMS )";
        var partby3 = " karakter. ( 3 SMS )";
        var partby4 = " karakter. ( 4 SMS )";
        var partby5 = " karakter. ( 5 SMS )";
        var partby6 = " karakter. Buset. Kebanyakan, woi!";
        
        if (len <= 160) {
          $('#charNum2').text(len);
          $('#charNumPart2').text(partby1);

        } else {
        	if (len <= 306) {
        		$('#charNum2').text(len);
          		$('#charNumPart2').text(partby2);
        	} else {
        		if (len <= 459) {
        		$('#charNum2').text(len);
          		$('#charNumPart2').text(partby3);
        	} else {
        		if (len <= 612) {
        		$('#charNum2').text(len);
          		$('#charNumPart2').text(partby4);
        	} else {
        		if (len <= 765) {
        		$('#charNum2').text(len);
          		$('#charNumPart2').text(partby5);
        	} else {
        		if (len >= 765) {
        		$('#charNum2').text(len);
          		$('#charNumPart2').text(partby6);
        	}
        	}
        	}
        	}
        	}
        }
      };
	function countChar3(val) {
        var len = val.value.length;
        var partby1 = " karakter. ( 1 SMS )";
        var partby2 = " karakter. ( 2 SMS )";
        var partby3 = " karakter. ( 3 SMS )";
        var partby4 = " karakter. ( 4 SMS )";
        var partby5 = " karakter. ( 5 SMS )";
        var partby6 = " karakter. Buset. Kebanyakan, woi!";
        
        if (len <= 160) {
          $('#charNum3').text(len);
          $('#charNumPart3').text(partby1);

        } else {
        	if (len <= 306) {
        		$('#charNum3').text(len);
          		$('#charNumPart3').text(partby2);
        	} else {
        		if (len <= 459) {
        		$('#charNum3').text(len);
          		$('#charNumPart3').text(partby3);
        	} else {
        		if (len <= 612) {
        		$('#charNum3').text(len);
          		$('#charNumPart3').text(partby4);
        	} else {
        		if (len <= 765) {
        		$('#charNum3').text(len);
          		$('#charNumPart3').text(partby5);
        	} else {
        		if (len >= 765) {
        		$('#charNum3').text(len);
          		$('#charNumPart3').text(partby6);
        	}
        	}
        	}
        	}
        	}
        }
      };

      function countChar4(val) {
        var len = val.value.length;
        var partby1 = " karakter. ( 1 SMS )";
        var partby2 = " karakter. ( 2 SMS )";
        var partby3 = " karakter. ( 3 SMS )";
        var partby4 = " karakter. ( 4 SMS )";
        var partby5 = " karakter. ( 5 SMS )";
        var partby6 = " karakter. Buset. Kebanyakan, woi!";
        
        if (len <= 160) {
          $('#charNum4').text(len);
          $('#charNumPart4').text(partby1);

        } else {
          if (len <= 406) {
            $('#charNum4').text(len);
              $('#charNumPart4').text(partby2);
          } else {
            if (len <= 459) {
            $('#charNum4').text(len);
              $('#charNumPart4').text(partby3);
          } else {
            if (len <= 612) {
            $('#charNum4').text(len);
              $('#charNumPart4').text(partby4);
          } else {
            if (len <= 765) {
            $('#charNum4').text(len);
              $('#charNumPart4').text(partby5);
          } else {
            if (len >= 765) {
            $('#charNum4').text(len);
              $('#charNumPart4').text(partby6);
          }
          }
          }
          }
          }
        }
      };


$(function(){
  var
    $win = $(window),
    $filter = $('.navbar'),
    $filterSpacer = $('<div />', {
      "class": "filter-drop-spacer",
      "height": $filter.outerHeight()
    });
  $win.scroll(function(){     
    if(!$filter.hasClass('navbar-fixed-top')){
        if($win.scrollTop() > $filter.offset().top){
        $filter.before($filterSpacer);
        $filter.addClass("navbar-fixed-top");
      }
    }else if ($filter.hasClass('navbar-fixed-top')){
      if($win.scrollTop() < $filterSpacer.offset().top){
      $filter.removeClass("navbar-fixed-top");
      $filterSpacer.remove();
    }
    } 
  });
});
	</script>
	

	</head>
	<body>   
	<div class="container">
	<div class="row">
	<div class="column">
		<div class="span12">
	<div class="navbar navbar-fixed-top">
				<div class="navbar-inner">
					<div class="container-fluid">
						 <a data-target=".navbar-responsive-collapse" data-toggle="collapse" class="btn btn-navbar"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></a> <a href="#" class="brand"><img src="<?php echo $base_url; ?>/application/views/img/smsbro.png" width="20px" style="margin-top:-7px;"> SMS<strong>Broadcast</strong></a>
						<div class="nav-collapse collapse navbar-responsive-collapse">
							<ul class="nav">
                </li>
                <li <?php if ($active=='c_send') { echo 'class=active'; } ?>>
                  <a href="<?php echo $base_url."c_send"; ?>">Kirim</a>
                </li>
                <li <?php if ($active=='c_inbox') { echo 'class=active'; } ?>>
                  <a href="<?php echo $base_url."c_inbox"; ?>">Inbox</a>
                </li>
                <li class="dropdown">
                   <a data-toggle="dropdown" class="dropdown-toggle" href="#">Outbox <strong class="caret"></strong></a>
                  <ul class="dropdown-menu">
                    <li <?php if ($active=='c_outbox') { echo 'class=active'; } ?>>
                      <a href="<?php echo $base_url."c_outbox"; ?>">Dikirim</a>
                    </li>
                    <li <?php if ($active=='c_sentitems') { echo 'class=active'; } ?>>
                      <a href="<?php echo $base_url."c_sentitems"; ?>">Terkirim</a>
                    </li>
                    <li <?php if ($active=='c_sentitems/failed') { echo 'class=active'; } ?>>
                      <a href="<?php echo $base_url."c_sentitems/failed"; ?>">Gagal Terkirim</a>
                    </li>
                </ul>
              </il>
                <li class="dropdown">
                   <a data-toggle="dropdown" class="dropdown-toggle" href="#">Kontak <strong class="caret"></strong></a>
                  <ul class="dropdown-menu">
                   <li <?php if ($active=='c_pegawai') { echo 'class=active'; } ?>>
                        <a href="<?php echo $base_url."c_people"; ?>">Daftar kontak</a>
                    </li>
                    <li>
                      <a href="<?php echo $base_url."c_grup_sms"; ?>">Kelompok kontak</a>
                    </li>
                </ul>
              </il>
              <li>
                      <a href="<?php echo $base_url."c_smsd_statistik"; ?>">Statistik</a>
               </li>
                
								<li class="dropdown">
									 <a data-toggle="dropdown" class="dropdown-toggle" href="#">Lainnya <strong class="caret"></strong></a>
									<ul class="dropdown-menu">
                    <li>
                      <a href="<?php echo $base_url."c_log_gammu"; ?>">Log & Debugging</a>
                    </li>
                         <li class="divider"></li>
                    <li>
                      <a href="<?php echo $base_url."c_pengaturan"; ?>">Pengaturan</a>
                    </li>

									</ul>
								</li>
							</ul>
							<ul class="nav pull-right">
																
								<li class="divider-vertical">
								</li>
								<?php if ($is_logged_in==FALSE) {
									echo "<li><a href=\"".$base_url."auth/login\">Login</a></li>";
								} ?>
								<?php if ($is_logged_in==TRUE) {
								echo "
								<li class=\"dropdown\">
									 <a data-toggle=\"dropdown\" class=\"dropdown-toggle\" href=\"#\">";
									 echo "<i class=\"icon-user\"></i> Hi, ".$username." "; 
								echo "<strong class=\"caret\"></strong></a>
									<ul class=\"dropdown-menu\">
										<li>
											<a href=\"".$base_url."auth/change_password\">Ganti kata kunci</a>
										</li>
										<li>
											<a href=\"".$base_url."c_log\">Log aktifitas</a>
										</li>
										<li>
											<a href=\"".$base_url."c_help\">Bantuan</a>
										</li>
										<li class=\"divider\">
										</li>
										<li>
											<a href=\"".$base_url."auth/logout\">Keluar</a>
										</li>
									</ul>
								</li>";
								} ?>
								
							</ul>
						</div>
						
					</div>
				</div>
				
			</div>