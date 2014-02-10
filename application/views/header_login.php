<head>
	<meta charset="utf-8">
	<title>SMSBro - Login</title>

	<!-- Bootstrap -->
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
	