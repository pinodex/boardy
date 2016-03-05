/*!
 * Boardy Default Theme
 * (c) 2016, Raphael Marco
 */

(function() {
    
})();

$('.dropdown > *:first-child').click(function(e) {
    e.preventDefault();

    var dropdown = $(this).parent();
    var menu = dropdown.find('ul');

    if (!dropdown.hasClass('touched')) {
        var position = dropdown.offset();

        position.position = 'absolute';
        position.top += $(this).height() * 2;

        if (position.left + dropdown.width() >= screen.width) {
            position.left -= dropdown.width() + 140;
        }
        
        menu.css(position);
    }

    dropdown.addClass('touched').toggleClass('active');
    $('.dropdown').not(dropdown).removeClass('active');
});