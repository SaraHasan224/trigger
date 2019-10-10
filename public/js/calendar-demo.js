(function ($) {
    'use strict';
    if ($('#calendar').length) {
        $('#calendar').fullCalendar({
            header: {
                left: 'title',
                center: '',
                right: 'today'
            },
            defaultDate: '2019-03-12',
            defaultView: 'listWeek',
            navLinks: true, // can click day/week names to navigate views
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            events: [{
                    title: "CEO's Birthday",
                    start: '2019-03-12T09:15',
                    color: dangerColor
                }, {
                    title: 'UI/UX Workshop',
                    start: '2018-03-05',
                    color: primaryColor
                },
                {
                    title: 'Meeting With Client',
                    start: '2019-03-13T10:25',
                    color: dangerColor
                },
                {
                    title: 'Meeting With Alisa',
                    start: '2019-03-12T12:32',
                    color: infoColor
                },
                {
                    title: 'Team Meetup',
                    start: '2019-03-11T02:32',
                    color: successColor
                },
                {
                    title: 'UI/UX Workshop',
                    start: '2018-03-05',
                    color: infoColor
                }, {
                    title: 'Annual Team Meetup',
                    start: '2018-03-27T12:30',
                    color: primaryColor
                },
                {
                    title: 'Check Reports',
                    start: '2019-03-12T10:45',
                    color: infoColor
                }, {
                    title: 'Annual Team Meetup',
                    start: '2018-03-27T09:15',
                    color: dangerColor
                }, {
                    title: 'Check Reports',
                    start: '2019-03-15T03:10',
                    color: dangerColor
                },
            ]
        });
    }
})(jQuery);