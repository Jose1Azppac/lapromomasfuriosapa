$(document).ready(function() {

	var prod__ini = $('.prod__foo .key__prod .paque img')
        flames = $('.prod__foo .flames img')

    tlsPaque = new TimelineLite();
    tlsPaque

    .staggerFromTo(prod__ini,1,{scale:0, y: '40%'},{scale:1, y: '0%', ease: Elastic.easeOut.config(1, 0.7)},0.15, '-=.7')
    .fromTo(flames, 1, {scale: 0,}, {scale: 1, ease: Elastic.easeOut.config(1, 0.7)}, '-=.7')

    var ourScene = new ScrollMagic.Scene({ triggerElement: ".footer .prod__foo", triggerHook: .6}) 
    .setTween(tlsPaque)
    .addTo(controller);

    var l__foo = $('.links li')

    tlsTxt = new TimelineLite();
    tlsTxt

    .staggerFromTo(l__foo, .5, {autoAlpha: 0, y: 50}, {autoAlpha:1, y:0, ease: Elastic.easeOut.config(1, 0.7), delay: 1},0.10)

    var ourScene = new ScrollMagic.Scene({ triggerElement: ".links", triggerHook: .9}) 
    .setTween(tlsTxt)
    .addTo(controller);

});