/**
 * Make elastic search tables display two rows of the last column
 * and allow for a show more button.
 */
$(function () {
    $("#elasticsearch_hits_table tr td:last-of-type").each(function () {
        var text = $(this).html();
        var array = text.split("<br>");

        if (array.length > 2) {
            var div = $("<div />", {});
            div.append(array.shift() + '<br>' + array.shift());
            var hidden = $('<div />', {'class': 'hidden-hit'}).css('display', 'none');
            hidden.append(array.join('<br>'));
            div.append(hidden);
            div.append('<br>');
            var btn = $("<button />", {
                'type': 'button',
                'class': 'btn btn-secondary btn-sm'
            }).html('Show More')
                .click(function (e) {
                    e.preventDefault();

                    var hidden_hit = hidden;
                    if (hidden_hit.hasClass('is_open')) {
                        hidden_hit.removeClass('is_open');
                        hidden_hit.slideUp();
                        btn.html("Show More")
                    } else {
                        hidden_hit.slideDown();
                        hidden_hit.addClass('is_open');
                        btn.html("Show Less");
                    }
                });
            div.append(btn);
            $(this).html(div);
        }
    });
});

/**
 * Allow dropdown menus to open by hover on bigger devices.
 */
$(function () {
    if ($(window).width() > 1200) {
        $('.navbar .dropdown > .nav-link').click(function (e) {
            var href = $(this).attr('href');
            if (href != '#') {
                return window.location.href = href;
            }
        });

        $('.navbar .dropdown').hover(function () {
            if ($(window).width() > 1200) {
                $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(100);
            }
        }, function () {
            if ($(window).width() > 1200) {
                $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(100);
            }
        });
    }
});