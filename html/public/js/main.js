$(document).ready(function() {

	$(".btn__mb").on("click",function(){
		$(this).toggleClass('active');
		$('.menu').toggleClass('active');
	});

	$(".opt__menu nav ul li").on("click",function(){
		$('.btn__mb').removeClass('active');
		$('.menu').removeClass('active');
	});


	$(".delete__acc").on("click",function(){
        $('#delete').fadeIn();
    });
	$(".clos__lb").on("click",function(){
        $(this).closest('.lb__msn').fadeOut();
    });

    $( function() {
        $( ".cont__faqs" ).accordion({
            heightStyle: "content",
            active: true,
            collapsible: true
        });
    });
	
});
