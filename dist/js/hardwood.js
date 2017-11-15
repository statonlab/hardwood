/**
 * Make elastic search tables display two rows of the last column
 * and allow for a show more button.
 */
(function ($) {
    $(function () {
        var window_height = $(window).height() || 0,
            header_height = $('#navigation').outerHeight() || 0,
            footer_height = ($('#footer').outerHeight() || 0) + ($('.main-footer').outerHeight() || 0);
        $('#main').css('min-height', window_height - (header_height + footer_height) - 30);

        $('.tripal_pane-toc-list-item-link').each(function () {
            var id = '.tripal_pane-fieldset-' + $(this).attr('id');
            if ($(id).length === 0) {
                console.log($(this));
                $(this).parents('.views-row').first().remove();
            }
        });

        $('#elasticsearch_hits_table tr td:nth-of-type(2)').each(function () {
            var text = $(this).html();
            var array = text.split('<br>');

            if (array.length > 2) {
                var div = $('<div />', {});
                div.append(array.shift() + '<br>' + array.shift());
                var hidden = $('<div />', {'class': 'hidden-hit'}).css('display', 'none');
                hidden.append(array.join('<br>'));
                div.append(hidden);
                div.append('<br>');
                var btn = $('<button />', {
                    'type': 'button',
                    'class': 'btn btn-secondary btn-sm'
                }).html('Show More')
                    .click(function (e) {
                        e.preventDefault();

                        var hidden_hit = hidden;
                        if (hidden_hit.hasClass('is_open')) {
                            hidden_hit.removeClass('is_open');
                            hidden_hit.slideUp();
                            btn.html('Show More');
                        }
                        else {
                            hidden_hit.slideDown();
                            hidden_hit.addClass('is_open');
                            btn.html('Show Less');
                        }
                    });
                div.append(btn);
                $(this).html(div);
            }
        });

        // Add table responsive to divs that contain tables as a direct child
        $('div').has('table').last().addClass('table-responsive');

        $('#block-tripal-elasticsearch-website-search-category .es-category-item').each(function () {
            $(this).css('position', 'relative');
            var text = $(this).text().split(' ');
            var num = text.pop();
            text = text.join(' ').split('_').join(' ');
            var span = $('<span />', {'class': 'float-right'}).text(num.replace('(', '').replace(')', ''));
            span.css({
                position: 'absolute',
                right: 0,
                top: 0,
                backgroundColor: '#fff'
            });

            if ($(this).hasClass('active')) {
                $(this).css('color', '#000');
                span.html('<i class="fa fa-check"></i>');
            }
            else {
                span.css({
                    backgroundColor: '#e6e6e6',
                    borderRadius: 10,
                    paddingTop: 2,
                    paddingBottom: 2,
                    paddingLeft: 7,
                    paddingRight: 7,
                    fontSize: 12,
                    color: '#999'
                });
            }

            $(this).html(text);
            $(this).append(span);
        });

        $('.es-search-form-in-title .btn, .es-search-form-in-home .btn, .elasticsearch-search-input .btn').each(function () {
            var attributes = {};
            for (var i = 0; i < this.attributes.length; i++) {
                attributes[this.attributes[i].nodeName] = this.attributes[i].nodeValue;
            }

            var searchButton = $('<button />', attributes).html('<i class="fa fa-search"></i>');
            $(this).replaceWith(searchButton);
        });

        $('.elasticsearch-search-input .form-control').attr('style', '');

        $(document).on('elasticsearch.completed', function (event) {
            $('.elastic-result-block-footer a').attr('class', 'btn btn-primary');
        });

        $('.tripal_pane-toc-list-item-link').on('click', function (event) {
            $(this).parents('.ds-left').find('.tripal_pane-toc-list-item-link.active').removeClass('active');
            $(this).addClass('active');
        });

        $('.tripal-pane-button .fa').on('click', function (event) {
            $('.ds-left').find('.tripal_pane-toc-list-item-link.active').removeClass('active');
        });

        $('.tripal_pane').not('.hideTripalPane').each(function () {
            var c = $(this).attr('class');
            var field = c.match(/^tripal_pane-fieldset-(.*$)/) || [];
            if (field.length === 2) {
                $('#' + field[1].split(' ')[0]).addClass('active');
            }
        });

        $(document).on('tripal_ds_pane_expanded', function () {
            if (typeof Event !== 'undefined') {
                window.dispatchEvent(new Event('resize'));
            } else {
                // Support IE
                var event = window.document.createEvent('UIEvents');
                event.initUIEvent('resize', true, false, window, 0);
                window.dispatchEvent(event);
            }
        });
    });
})(jQuery);

/**
 * Allow dropdown menus to open by hover on bigger devices.
 */
(function ($) {
    $(function () {
        $('.navbar .dropdown > .nav-link').click(function (e) {
            if ($(window).width() > 992) {
                var href = $(this).attr('href');
                if (href !== '#') {
                    return window.location.href = href;
                }
            }
        });

        $('.navbar .dropdown').hover(function () {
            if ($(window).width() > 992) {
                $(this).find('.dropdown-menu').fadeIn(100);
            }
        }, function () {
            if ($(window).width() > 992) {
                $(this).find('.dropdown-menu').fadeOut(100);
            }
        });
    });
})(jQuery);