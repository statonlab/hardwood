$(function() {

    $("#elasticsearch_hits_table tr td:last-of-type").each(function() {
        var text = $(this).html();
        var array = text.split("<br>");

        if(array.length > 2) {
            var div = $("<div />", {});
            div.append(array.shift() + '<br>' + array.shift());
            var hidden = $('<div />', {'class':'hidden-hit'}).css('display', 'none');
            hidden.append(array.join('<br>'));
            div.append(hidden);
            div.append('<br>');
            var btn = $("<button />", {
                'type': 'button',
                'class': 'btn btn-secondary btn-sm'
            }).html('Show More').click(function(e) {
                e.preventDefault();

                var hidden_hit = hidden;
                if(hidden_hit.hasClass('is_open')) {
                    hidden_hit.removeClass('is_open');
                    hidden_hit.slideUp();
                } else {
                    hidden_hit.slideDown();
                    hidden_hit.addClass('is_open');
                }
            });
            div.append(btn);
            $(this).html(div);
        }
    });

});