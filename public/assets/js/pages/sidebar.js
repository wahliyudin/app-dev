"use strict";

$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "GET",
        url: "/globals/sidebar",
        dataType: "JSON",
        success: function (response) {
            fill(response);
        }
    });

    var fill = (data) => {
        data.forEach(item => {
            $(item.selector).text(item.value);
        });
    }
});
