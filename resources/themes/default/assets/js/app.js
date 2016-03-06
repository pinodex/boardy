/*!
 * Boardy Default Theme
 * (c) 2016, Raphael Marco
 */

(function() {
    var _window = $(window);
    var topBarNav = $('.top-bar nav');

    $('.top-bar .toggle').click(function() {
        $(this).parent().find('nav').toggleClass('active');
    });

    $('.dropdown > *:first-child').click(function(e) {
        e.preventDefault();

        var dropdown = $(this).parent();
        var menu = dropdown.find('ul');

        if (!dropdown.hasClass('touched')) {
            var position = dropdown.offset();

            position.position = 'absolute';
            position.top += dropdown.height();

            //console.log(position.left, dropdown.width());

            if (position.left + 150 >= _window.width()) {
                position.left -= _window.width() - position.left - dropdown.width();

                menu.addClass('arrow-right');
            } else {
                menu.addClass('arrow-left');
            }
            
            menu.css(position);
        }

        dropdown.addClass('touched').toggleClass('active');
        $('.dropdown').not(dropdown).removeClass('active');
    });

    _window.resize(function() {
        $.each($('.dropdown'), function() {
            var dropdown = $(this);
            var menu = dropdown.find('ul');
            var position = dropdown.offset();

            position.top += dropdown.height();

            if (position.left + 150 >= _window.width()) {
                position.left -= _window.width() - position.left - dropdown.width();
            }
            
            menu.css(position);
        });
    });
})();
