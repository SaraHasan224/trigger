$(function () {
    'use strict';
    if ($("#sample-data-table").length) {
        $("#sample-data-table").DataTable({});
    }

    if ($("#json-sample-data-table").length) {
        $("#json-sample-data-table").DataTable({
            "ajax": "../../../assets/js/TABLE_DATA.json",
            "columns": [{
                    "data": "name"
                },
                {
                    "data": "position"
                },
                {
                    "data": "office"
                },
                {
                    "data": "extn"
                },
                {
                    "data": "start_date"
                },
                {
                    "data": "salary"
                }
            ]
        });
    }

    if ($("#complex-header-table").length) {
        $("#complex-header-table").DataTable({
            stateSave: true
        });
    }

    if ($("#horizontal-scroll-table").length) {
        $("#horizontal-scroll-table").DataTable({
            stateSave: true,
            "scrollY": "50vh",
            "scrollX": true,
            "scrollCollapse": true,
        });
    }
});