'use strict';


// THEME COLORS
var style = getComputedStyle(document.body);
var chartColors = ["#4d8af0", "#2d92fe", "#05478f", "#00cccc", "#6CA5E0", "#1A76CA"];
var primaryColor = style.getPropertyValue('--primary');
var secondaryColor = style.getPropertyValue('--secondary');
var successColor = style.getPropertyValue('--success');
var warningColor = style.getPropertyValue('--warning');
var dangerColor = style.getPropertyValue('--danger');
var infoColor = style.getPropertyValue('--info');
var darkColor = style.getPropertyValue('--dark');


// BODY ELEMENTS
var Body = $("body");
var TemplateSidebar = $('.sidebar');
var TemplateHeader = $('.t-header');
var PageContentWrapper = $(".page-content-wrapper");
var DesktopToggler = $(".t-header-desk-toggler");
var MobileToggler = $(".t-header-mobile-toggler");


// CHART JS DEFAULTS
var Chart = Chart;
if ($(Chart).length) {
  Chart.defaults.global.tooltips.enabled = false;
  Chart.defaults.global.tooltips.caretSize = 4;
  Chart.defaults.global.tooltips.intersect = false;
  Chart.defaults.global.tooltips.custom = function (tooltipModel) {
    // Tooltip Element
    var tooltipEl = document.getElementById('chartjs-tooltip');

    // Create element on first render
    if (!tooltipEl) {
      tooltipEl = document.createElement('div');
      tooltipEl.id = 'chartjs-tooltip';
      tooltipEl.innerHTML = "<table></table>";
      document.body.appendChild(tooltipEl);
    }

    // Hide if no tooltip
    if (tooltipModel.opacity === 0) {
      tooltipEl.style.opacity = 0;
      return;
    }

    // Set caret Position
    tooltipEl.classList.remove('above', 'below', 'no-transform');
    if (tooltipModel.yAlign) {
      tooltipEl.classList.add(tooltipModel.yAlign);
    } else {
      tooltipEl.classList.add('no-transform');
    }

    function getBody(bodyItem) {
      return bodyItem.lines;
    }

    // Set Text
    if (tooltipModel.body) {
      var titleLines = tooltipModel.title || [];
      var bodyLines = tooltipModel.body.map(getBody);

      var innerHtml = '<thead>';

      titleLines.forEach(function (title) {
        innerHtml += '<tr><th>' + title + '</th></tr>';
      });
      innerHtml += '</thead><tbody>';

      bodyLines.forEach(function (body, i) {
        var colors = tooltipModel.labelColors[i];
        var style = 'background:' + colors.backgroundColor;
        style += '; border-color:' + colors.borderColor;
        style += '; border-width: 2px';
        var span = '<span style="' + style + '"></span>';
        innerHtml += '<tr><td>' + span + body + '</td></tr>';
      });
      innerHtml += '</tbody>';

      var tableRoot = tooltipEl.querySelector('table');
      tableRoot.innerHTML = innerHtml;
    }

    // `this` will be the overall tooltip
    var position = this._chart.canvas.getBoundingClientRect();

    // Display, position, and set styles for font
    tooltipEl.style.opacity = 1;
    tooltipEl.style.position = 'absolute';
    tooltipEl.style.left = position.left + window.pageXOffset + tooltipModel.caretX + 'px';
    tooltipEl.style.top = position.top + window.pageYOffset + tooltipModel.caretY + 'px';
    tooltipEl.style.fontFamily = tooltipModel._bodyFontFamily;
    tooltipEl.style.fontSize = tooltipModel.bodyFontSize + 'px';
    tooltipEl.style.fontStyle = tooltipModel._bodyFontStyle;
    tooltipEl.style.padding = tooltipModel.yPadding + 'px ' + tooltipModel.xPadding + 'px';
    tooltipEl.style.pointerEvents = 'none';
  }
}



// SIDEBAR TOGGLE FUNCTION FOR LARGE SCREENS (SCREEN "LG" AND UP)
DesktopToggler.on("click", function () {
  $(Body).toggleClass("sidebar-minimized");
});

// SIDEBAR TOGGLE FUNCTION FOR MOBILE (SCREEN "MD" AND DOWN)
MobileToggler.on("click", function () {
  $(".page-body").toggleClass("sidebar-collpased");
});


// CHECK FOR CURRENT PAGE AND ADDS AN ACTIVE CLASS FOR TO THE ACTIVE LINK
var current = location.pathname.split("/").slice(-1)[0].replace(/^\/|\/$/g, '');
$('.navigation-menu li a', TemplateSidebar).each(function () {
  var $this = $(this);
  if (current === "") {
    //FOR ROOT URL
    if ($this.attr('href').indexOf("index.html") !== -1) {
      $(this).parents('li').last().addClass('active');
      if ($(this).parents('.navigation-submenu').length) {
        $(this).addClass('active');
      }
    }
  } else {
    //FOR OTHER URL
    if ($this.attr('href').indexOf(current) !== -1) {
      $(this).parents('li').last().addClass('active');
      if ($(this).parents('.navigation-submenu').length) {
        $(this).addClass('active');
      }
      if (current !== "index.html") {
        $(this).parents('li').last().find("a").attr("aria-expanded", "true");
        if ($(this).parents('.navigation-submenu').length) {
          $(this).closest('.collapse').addClass('show');
        }
      }
    }
  }
});


$(".t-header-toggler").click(function () {
  $(".t-header-toggler").toggleClass("arrow");
});


// SIDEBAR COLLAPSE FUNCTION
$(".sidebar .navigation-menu > li > a[data-toggle='collapse']").on("click", function () {
  $(".sidebar .navigation-menu > li").find('.collapse.show').collapse('hide');
  $(".sidebar .sidebar_footer").removeClass("opened");
});


$(".email-header .email-aside-list-toggler").on("click", function () {
  $(".email-wrapper .email-aside-list").toggleClass("open");
});


$(".btn.btn-refresh").on("click", function () {
  $(this).addClass("clicked");
  setTimeout(function () {
    $(".btn.btn-refresh").removeClass("clicked");
  }, 3000);
});


$(".btn.btn-like").on("click", function () {
  $(this).toggleClass("clicked");
  $(this).find("i").toggleClass("mdi-heart-outline clicked").toggleClass("mdi-heart");
});

$(".right-sidebar-toggler").on("click", function () {
  $(".right-sidebar").toggleClass("right-sidebar-opened");
});


$(".sidebar .sidebar_footer").on("click", function () {
  if ($(".sidebar .sidebar_footer").hasClass("opened")) {
    $(".sidebar .sidebar_footer").removeClass("opened");
  } else {
    $(".sidebar .sidebar_footer").addClass("opened");
  }
});


$(".email-compose-toolbar .toolbar-menu .delete-draft").on("click", function () {
  $(".email-compose-wrapper").removeClass("open");
  $("#email-compose")[0].reset()
});


$(".email-composer").on("click", function () {
  $(".email-compose-wrapper").addClass("open");
});


$(".email-compose-wrapper .email-compose-header .header-controls .compose-minimize").on("click", function () {
  $(this).addClass("minimized");
  $(".email-compose-wrapper").addClass("compose-minimized");
  $(this).parentsUntil(".email-compose-header").append('<div class="header-ovelay"></div>');
  $(".email-compose-wrapper .header-ovelay").on("click", function () {
    $(".email-compose-wrapper").removeClass("compose-minimized");
    this.remove(".header-ovelay");
    $(".email-compose-wrapper .email-compose-header .header-controls .compose-minimize").removeClass("minimized");
  });
});


if ($('.animated-count').length) {
  $('.animated-count').counterUp({
    delay: 50,
    time: 800
  });
}