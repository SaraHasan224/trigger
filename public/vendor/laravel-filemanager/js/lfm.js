(function ($) {

    $.fn.filemanager = function (type, options) {
        type = type || 'file';

        this.on('click', function (e) {
            var route_prefix = (options && options.prefix) ? options.prefix : '/laravel-filemanager';
            localStorage.setItem('target_input', $(this).data('input'));
            localStorage.setItem('target_preview', $(this).data('preview'));

            width = (screen.width-150);
            height = (screen.height-250);

            wLeft = (screen.width / 2) - (width / 2);
            wTop = 80;//(screen.height / 2) - (height);

            // alert("Left: "+wLeft+", Top: "+wTop+"\n"+"Width: "+width+", Height: "+height+"\n"+"Screen Width: "+screen.width+", Screen Height: "+screen.height);
            window.open(route_prefix + '?type=' + type, 'FileManager', 'width='+width+',height='+height+', top='+wTop+', left='+wLeft);
            window.SetUrl = function (url, file_path) {
                //set the value of the desired input to image url
                var target_input = $('#' + localStorage.getItem('target_input'));
                target_input.val(file_path).trigger('change');
                var target_preview = $('#' + localStorage.getItem('target_preview'));

                if(type == "images") {
                    target_preview.attr('src', url).trigger('change');
                } else {
                    f = url.split("/");
                    fname = f.slice(-1).pop();
                    target_preview.html('<a href="'+url+'" target="_blank">'+fname+'</a>');
                }
            };
            return false;
        });
    }

})(jQuery);
