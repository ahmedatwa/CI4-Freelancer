
function getURLVar(key) {
    var value = [];

    var query = String(document.location).split('?');

    if (query[1]) {
        var part = query[1].split('&');

        for (i = 0; i < part.length; i++) {
            var data = part[i].split('=');

            if (data[0] && data[1]) {
                value[data[0]] = data[1];
            }
        }

        if (value[key]) {
            return value[key];
        } else {
            return '';
        }
    }
}

$(document).ready(function() {
    'use strict';

    //Form Submit for IE Browser
    $('button[type=\'submit\']').on('click', function() {
        $("form[id*='form-']").submit();
    });

    // Highlight any found errors
    $('.text-danger').each(function() {
        var element = $(this).prev();

        if (element.hasClass('form-control')) {
            element.addClass('is-invalid');
        }
    });

      // Menu Button x|s viewport 
    $('#button-menu').on('click', function(e) {
        e.preventDefault();
        $('#sidebar').toggleClass('active');
    });

    // Disable delete Button 
    $( "input[name^=\'selected\']" ).click(function() {
        if ($(this).is(":checked" )) {
            $('#button-delete').prop('disabled', false);
        } else {
            $('#button-delete').prop('disabled', true); 
        }
    });


    // ============================================================== 
    // Sidebar  
    // ============================================================== 
    // Set last page opened on the menu
    $('#menu a[href]').on('click', function() {
        sessionStorage.setItem('menu', $(this).attr('href'));
    });

    if (!sessionStorage.getItem('menu')) {
        $('#menu .menu-dashboard').addClass('active');
    } else {
        // Sets active and open to selected page in the left column menu.
        $('#menu a[href=\'' + sessionStorage.getItem('menu') + '\']').parent().addClass('active');
    }
    
    $('#menu a[href=\'' + sessionStorage.getItem('menu') + '\']').parents('li > a').removeClass('collapsed');
    
    $('#menu a[href=\'' + sessionStorage.getItem('menu') + '\']').parents('ul').addClass('show');
    
    $('#menu a[href=\'' + sessionStorage.getItem('menu') + '\']').parents('li').addClass('active');
    

    // ============================================================== 
    // tooltip
    // ============================================================== 
    // tooltips on hover
    $('[data-toggle=\'tooltip\']').tooltip();
    // // Makes tooltips work on ajax generated content
    $(document).ajaxStop(function() {
        $('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
    });
    // tooltip remove
    $('[data-toggle=\'tooltip\']').on('remove', function() {
        $(this).tooltip('dispose');
    });
    // Tooltip remove fixed
    $(document).on('click', '[data-toggle=\'tooltip\']', function(e) {
        $('body > .tooltip').remove();
    });
  
     // ============================================================== 
    // Image Manager
    // ============================================================== 
    $(document).on('click', 'a[data-toggle=\'image\']', function(e) {
        var $element = $(this);
        var $popover = $element.data('bs.popover'); // element has bs popover?

        e.preventDefault();

        // destroy all image popovers
        $('a[data-toggle="image"]').popover('dispose');

        // remove flickering (do not re-add popover when clicking for removal)
        if ($popover) {
            return;
        }

        $element.popover({
            html: true,
            placement: 'right',
            trigger: 'manual',
            content: function() {
                return '<a role="button" id="button-image" class="btn btn-primary"><i class="fas fa-file-import"></i></a> <a role="button" id="button-clear" class="btn btn-danger"><i class="fas fa-minus-circle"></i></a>';
            }
        });

        $element.popover('show');

        $('#button-image').on('click', function() {
            var $button = $(this);
            var $icon   = $button.find('> i');

            $('#modal-image').remove();

            $.ajax({
                url: 'index.php/common/filemanager?user_token=' + getURLVar('user_token') + '&target=' + $element.parent().find('input').attr('id') + '&thumb=' + $element.attr('id'),
                dataType: 'html',
                beforeSend: function() {
                    $button.prop('disabled', true);
                    if ($icon.length) {
                        $icon.attr('class', 'fa fa-circle-o-notch fa-spin');
                    }
                },
                complete: function() {
                    $button.prop('disabled', false);

                    if ($icon.length) {
                        $icon.attr('class', 'fa fa-pencil');
                    }
                },
                success: function(html) {
                    $('body').append('<div id="modal-image" class="modal">' + html + '</div>');

                    $('#modal-image').modal('show');
                }
            });

            $element.popover('dispose');
        });

        $('#button-clear').on('click', function() {
            $element.find('img').attr('src', $element.find('img').attr('data-placeholder'));

            $element.parent().find('input').val('');

            $element.popover('dispose');
        });
    });





});

