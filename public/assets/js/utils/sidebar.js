"use strict"

export const loadSidebar = () => {
    $.ajax({
        type: "GET",
        url: "/globals/sidebar",
        dataType: "JSON",
        success: function (response) {
            fill(response);
        }
    });
}

const fill = (data) => {
    data.forEach(item => {
        $(item.selector).text(item.value);
    });
}
