"use strict"

$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    const appId = $('input[name="app_id"]').val();
    const channel = window.Echo.channel(`app-dev-task`);
    channel.subscribed(function (e) {
        console.log('subscribed!!');
    }).listen('.update-item', (data) => {
        loadTotalTask(appId);
    }).listen('.move-item', (data) => {
        loadTotalTask(appId);
    });

    const loadTotalTask = function (app_id) {
        $.ajax({
            url: `/applications/my-app/${app_id}`,
            type: 'GET',
            success: function (data) {
                fill(data);
            }
        });
    }

    const fill = function (totals) {
        $('#total-open').data('kt-countup-value', totals.total_open);
        $('#total-open').text(totals.total_open);
        $('#total-progress').data('kt-countup-value', totals.total_progress);
        $('#total-progress').text(totals.total_progress);
        $('#total-done').data('kt-countup-value', totals.total_done);
        $('#total-done').text(totals.total_done);
    }
});
