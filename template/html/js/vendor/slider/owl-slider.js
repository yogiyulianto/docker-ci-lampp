// JavaScript Document
$(document).on('ready', function() {
	
// DENTIST TESTIMONIAL CAROUSEL
	  var owl = $(".owl-demo,.owl-demo1");	 
	  owl.owlCarousel({
		  autoPlay: 4000,
		  items : 1, //1 item above 1000px browser width
		  itemsDesktop : [1920,1], //1 item between 1920px and 901px
		  itemsDesktopSmall : [900,1], // 1 item betweem 900px and 641px
		  itemsTablet: [640,1], //1 item between 640 and 0
		  itemsMobile : [380,1] 
	  });
	 
	  // Custom Navigation Events
	  $(".next").click(function(){
		owl.trigger('owl.next');
	  })
	  $(".prev").click(function(){
		owl.trigger('owl.prev');
	  })
	  $(".play").click(function(){
		owl.trigger('owl.play',1000); //owl.play event accept autoPlay speed as second parameter
	  })
	  $(".stop").click(function(){
		owl.trigger('owl.stop');
	  })
	  
	  // CLININC TESTIMONIAL CAROUSEL
	  var owl = $("#owl-demo2");	 
	  owl.owlCarousel({
		  autoPlay: 4000,
		  items : 2, //2 items above 1000px browser width
		  itemsDesktop : [1920,2], //2 items between 1920px and 901px
		  itemsDesktopSmall : [900,2], // 2 items betweem 900px and 641px
		  itemsTablet: [640,1], //1 item between 640 and 0
		  itemsMobile : [380,1] 
	  });
	 
	  // Custom Navigation Events
	  $(".next").click(function(){
		owl.trigger('owl.next');
	  })
	  $(".prev").click(function(){
		owl.trigger('owl.prev');
	  })
	  $(".play").click(function(){
		owl.trigger('owl.play',1000); //owl.play event accept autoPlay speed as second parameter
	  })
	  $(".stop").click(function(){
		owl.trigger('owl.stop');
	  })
	  
	  // PREGNANCY TESTIMONIAL CAROUSEL
	  var owl = $("#owl-demo3");	 
	  owl.owlCarousel({
		  autoPlay: 4000,
		  items : 2, //2 items above 1000px browser width
		  itemsDesktop : [1920,2], //2 items between 1920px and 901px
		  itemsDesktopSmall : [991,1], // 1 item betweem 991px and 641px
		  itemsTablet: [640,1], //1 item between 640 and 0
		  itemsMobile : [380,1] 
	  });
	  
	  // YOGA HEADER CAROUSEL
	  var owl = $("#owl-demo4");	 
	  owl.owlCarousel({
		  autoPlay: 4000,
		  items : 1, //1 item above 1000px browser width
		  itemsDesktop : [1920,1], //1 item between 1920px and 901px
		  itemsDesktopSmall : [900,1], // 1 item betweem 900px and 641px
		  itemsTablet: [640,1], //1 item between 640 and 0
		  itemsMobile : [380,1] 
	  });	  
	  
	  // YOGA TESTIMONIAL CAROUSEL
	  var owl = $("#owl-demo5");	 
	  owl.owlCarousel({
		  autoPlay: 4000,
		  items : 2, //2 items above 1000px browser width
		  itemsDesktop : [1920,2], //2 items between 1920px and 901px
		  itemsDesktopSmall : [900,2], // 2 items betweem 900px and 641px
		  itemsTablet: [640,1], //1 item between 640 and 0
		  itemsMobile : [380,1] 
	  });
	  
	   // SPA TESTIMONIAL CAROUSEL
	  var owl = $("#owl-demo6");	 
	  owl.owlCarousel({
		  autoPlay: 4000,
		  items : 1, //1 item above 1000px browser width
		  itemsDesktop : [1920,1], //1 item between 1920px and 901px
		  itemsDesktopSmall : [900,1], // 1 item betweem 900px and 641px
		  itemsTablet: [640,1], //1 item between 640 and 0
		  itemsMobile : [380,1] 
	  });
});