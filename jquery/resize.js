$(document).ready(function() {
	var header_width = $(".header").width();
	var section = $("section").width();
	var window_width = $(window).width(); 
	//var section = section-17;
	var header = window_width-20;

	var usersForm = 218;
	var usersForm_input = 188;
	var register_b = $(".regist_form div").width();
	var label = $(".label").width();
	var input_label = $(".input_label").width();
	var ccc = $(".f_block").width();
	
	if((window_width>1100))
	{
		var section = 1100;
		var header = 1100;	
		var footer = 1100;
		var wish_descr=480;
		var friendwish_descr=340;
		var error_list = 736;
	}

	if(window_width<1100)
	{
		var header = header;
		var metasearch = header-2;
		var bt = 35;
		var inserttext = metasearch-bt;
		var section = window_width-22;
		var footer = window_width-20;
		$('.inserttext input').css("width", inserttext+ "px");
		var wish_descr = header-145;
		var friendwish_descr = header-122;
		var error_list = section-42;
	 }
	
	$('.header').css("width", header + "px");
	$('section').css("width", section+ "px");
	$('.error_list').css("width", error_list+ "px");
	$('footer').css("width", footer+ "px");
	$('.wish_descr').css("width", wish_descr+ "px");	
	$('.friendwish_descr').css("width", friendwish_descr+ "px");	
});



$(document).ready(function() { 
	$(window).resize(function(){
	var header_width = $(".header").width();
	var window_width = $(window).width(); 
	var header = window_width-20;

	var usersForm = 218;
	var usersForm_input = 188;
	var register_b = $(".regist_form div").width();
	var label = $(".label").width();
	var input_label = $(".input_label").width();
	var ccc = $(".f_block").width();
	
	if((window_width>1100))
	{
		var window_width = 1100;
		var header = 1100;	
		var section = 1100;
		var footer = 1100;
		var metasearch = 400;
		var bt = 41;
		var inserttext = metasearch-bt;
		$('.inserttext input').css("width", inserttext+ "px");
		var wish_descr = 480;
		var friendwish_descr = 340;
		var error_list = 736;
	}

	if(window_width<1100)
	{
		var header = header;
		var metasearch = header-2;
		var bt = 35;
		var inserttext = metasearch-bt;
		var section = window_width-22;
		var footer = window_width-20;
		$('.inserttext input').css("width", inserttext+ "px");
		var wish_descr = header-145;
		var friendwish_descr = header-122;		
		var error_list = section-42;
	}
	$('.header').css("width", header + "px");
	$('section').css("width", section+ "px");
	$('.error_list').css("width", error_list+ "px");
	$('footer').css("width", footer+ "px");
	$('.wish_descr').css("width", wish_descr+ "px");	
	$('.friendwish_descr').css("width", friendwish_descr+ "px");	
	
	});
});
