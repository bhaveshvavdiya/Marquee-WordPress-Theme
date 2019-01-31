// Header Load from extrenal page
/*$.get('header.html', function (response) {
    $('header').html(response);
});*/
// Footer Load from extrenal page
/*$.get('footer.html', function (response) {
    $('footer').html(response);
});*/ 

// For Stiky Header
$(window).scroll(function () {
    if ($(window).scrollTop() >= 50) {
        $('header').addClass('scrolled');
    } else {
        $('header').removeClass('scrolled');
    }
});

$(document).ready(function () {
    setTimeout(function () {
        var dropdownMenuTop = $('header').outerHeight() + 'px';
        // console.log(dropdownMenuTop);
        $('.mega-dropdown-menu').css('top', dropdownMenuTop);
    },200);

    // For Footer Current Year Get & set
    setTimeout(function () {
        var dteNow = new Date();
        var intYear = dteNow.getFullYear();
        $('#copyYear').text(intYear);
    },400)
});




// for Bootstrap Mega Menu open on hover
// $(".dropdown").hover(
//   function () {
//     $('.dropdown-menu', this).not('.in .dropdown-menu').stop(true, true).slideDown("400");
//     $(this).toggleClass('open');
//   },
//   function () {
//     $('.dropdown-menu', this).not('.in .dropdown-menu').stop(true, true).slideUp("400");
//     $(this).toggleClass('open');
//   }
// );



