$(function () {
    'use strict';

    var Switchery = require('switchery');

    if ($("#js-select-example").length) {
        $("#js-select-example").select2();
    }

    if ($("#switchery-primary").length) {
        var elem = document.querySelector('#switchery-primary');
        var switchery = new Switchery(elem, {
            className: 'switchery switch-primary',
            color: '#f3f5f6'
        });
    }

    if ($("#switchery-success").length) {
        var elem = document.querySelector('#switchery-success');
        var switchery = new Switchery(elem, {
            className: 'switchery switch-success',
            color: '#f3f5f6'
        });
    }

    if ($("#switchery-warning").length) {
        var elem = document.querySelector('#switchery-warning');
        var switchery = new Switchery(elem, {
            className: 'switchery switch-warning',
            color: '#f3f5f6'
        });
    }

    if ($("#switchery-danger").length) {
        var elem = document.querySelector('#switchery-danger');
        var switchery = new Switchery(elem, {
            className: 'switchery switch-danger',
            color: '#f3f5f6'
        });
    }

    if ($("#switchery-info").length) {
        var elem = document.querySelector('#switchery-info');
        var switchery = new Switchery(elem, {
            className: 'switchery switch-info',
            color: '#f3f5f6'
        });
    }

    if ($("#ul-slider-1").length) {
        var startSlider = document.getElementById('ul-slider-1');
        noUiSlider.create(startSlider, {
            start: [72],
            connect: [true, false],
            range: {
                'min': [0],
                'max': [100]
            }
        });
    }

    if ($("#ul-slider-2").length) {
        var startSlider = document.getElementById('ul-slider-2');
        noUiSlider.create(startSlider, {
            start: [92],
            connect: [true, false],
            range: {
                'min': [0],
                'max': [100]
            }
        });
    }

    if ($("#ul-slider-3").length) {
        var startSlider = document.getElementById('ul-slider-3');
        noUiSlider.create(startSlider, {
            start: [43],
            connect: [true, false],
            range: {
                'min': [0],
                'max': [100]
            }
        });
    }

    if ($("#ul-slider-4").length) {
        var startSlider = document.getElementById('ul-slider-4');
        noUiSlider.create(startSlider, {
            start: [20],
            connect: [true, false],
            range: {
                'min': [0],
                'max': [100]
            }
        });
    }

    if ($("#ul-slider-5").length) {
        var startSlider = document.getElementById('ul-slider-5');
        noUiSlider.create(startSlider, {
            start: [75],
            connect: [true, false],
            range: {
                'min': [0],
                'max': [100]
            }
        });
    }

    if ($("#ul-slider-6").length) {
        var startSlider = document.getElementById('ul-slider-6');
        noUiSlider.create(startSlider, {
            start: [72],
            connect: [true, false],
            orientation: "vertical",
            range: {
                'min': [0],
                'max': [100]
            }
        });
    }

    if ($("#ul-slider-7").length) {
        var startSlider = document.getElementById('ul-slider-7');
        noUiSlider.create(startSlider, {
            start: [92],
            connect: [true, false],
            orientation: "vertical",
            range: {
                'min': [0],
                'max': [100]
            }
        });
    }

    if ($("#ul-slider-8").length) {
        var startSlider = document.getElementById('ul-slider-8');
        noUiSlider.create(startSlider, {
            start: [43],
            connect: [true, false],
            orientation: "vertical",
            range: {
                'min': [0],
                'max': [100]
            }
        });
    }

    if ($("#ul-slider-9").length) {
        var startSlider = document.getElementById('ul-slider-9');
        noUiSlider.create(startSlider, {
            start: [20],
            connect: [true, false],
            orientation: "vertical",
            range: {
                'min': [0],
                'max': [100]
            }
        });
    }

    if ($("#ul-slider-10").length) {
        var startSlider = document.getElementById('ul-slider-10');
        noUiSlider.create(startSlider, {
            start: [75],
            connect: [true, false],
            orientation: "vertical",
            range: {
                'min': [0],
                'max': [100]
            }
        });
    }

    if ($("#skipstep-connect").length) {
        $(function () {
            var skipSlider = document.getElementById('skipstep-connect');
            noUiSlider.create(skipSlider, {
                connect: true,
                range: {
                    'min': 0,
                    '10%': 10,
                    '20%': 20,
                    '30%': 30,
                    // Nope, 40 is no fun.
                    '50%': 50,
                    '60%': 60,
                    '70%': 70,
                    // I never liked 80.
                    '90%': 90,
                    'max': 100
                },
                snap: true,
                start: [20, 90]
            });
            var skipValues = [
                document.getElementById('skip-value-lower-3'),
                document.getElementById('skip-value-upper-3')
            ];

            skipSlider.noUiSlider.on('update', function (values, handle) {
                skipValues[handle].innerHTML = values[handle];
            });
        });
    }

    if ($("#datepicker-popup").length) {
        $('#datepicker-popup').datepicker({
            enableOnReadonly: true,
            todayHighlight: true,
            templates: {
                leftArrow: '<i class="mdi mdi-chevron-left"></i>',
                rightArrow: '<i class="mdi mdi-chevron-right"></i>'
            }

        });
    }
});