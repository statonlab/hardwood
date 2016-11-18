$(function() {

    $("#elasticsearch_hits_table tr td:last-of-type").each(function() {
        var text = $(this).html();
        console.log(text.split("<br>"));
    });

});