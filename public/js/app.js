window.callbacks = {};

$.fn.submitParentForm = function () {
    var form = $(this).parents('form:first');
    $(form).submit();
};

$.fn.handleForm = function () {
    $(this).submit(function (event) {
        event.stopPropagation();
        event.preventDefault();

        $('.loader').show();
        var form = $(this);
        var existingMessageBoxes = $('.messageBox', form);
        $(existingMessageBoxes).each(function () {
            $(this).remove();
        });

        var data = new FormData($(this)[0]);
        var lastButton = $('button[type=submit]', form).last();
        var oldHtml = $(lastButton).html();
        $(lastButton).html("<img src='/img/spin.svg' style='height: 24px'/>");

        $.ajax({
            'url': $(this).attr('action'),
            'type': 'POST',
            'data': data,
            'cache': false,
            'contentType': false,
            'processData': false,
            'success': function (result) {
                $(lastButton).html(oldHtml);
                $('.loader').hide();
                var messageBox = $('.messageBox', form);
                if (!messageBox.get(0)) {
                    var messageBox = document.createElement('div');
                    messageBox.className = 'messageBox';
                    $(form).prepend(messageBox);
                } else {
                    messageBox.get(0).innerHTML = '';
                }

                result = JSON.parse(result);
                if (result.success !== true) {
                    for (var i = 0; i < result.faults.length; i++) {
                        $(messageBox).displayMessage(result.faults[i] + '<br/>', 'danger');
                    }
                    $('body').scrollTo('.messageBox');
                } else {
                    var timeout = 0;

                    if (result.response.message != undefined) {
                        $(messageBox).displayMessage(result.response.message, 'success');

                        timeout = 1000;
                        $('html, body').animate({
                            scrollTop: 0
                        }, 250);
                    }

                    if (result.response.reload == true) {
                        window.location.reload();
                    }

                    if (result.response.redirect != undefined) {
                        setTimeout(function () {
                            window.location = result.response.redirect
                        }, timeout);
                    }
                }
            }
        });
    });
};

$.fn.displayMessage = function (text, type) {
    var div = document.createElement('div');
    div.innerHTML = text;
    div.className = 'alert alert-' + type;
    $(this).get(0).appendChild(div);
};

$('document').ready(function () {
    $('form').each(function () {
        if ($(this).hasClass('no-handler')) {
            return;
        }
        $(this).handleForm();
    });

    $('.submitForm').click(function () {
        $(this).submitParentForm();
    });

    if ($.isFunction($.fn.summernote)) {
        $('.js-wysiwyg').summernote({
            'height': 300
        });
    }

    $('.customDropzone').each(function () {
        var prefix = $(this).attr('data-prefix');
        var myDropZone = new Dropzone(document.body, {
            'url': $(this).attr('data-url'),
            'clickable': '.customDropzone',
            'autoQueue': true
        });

        myDropZone.on("addedfile", function (file) {
            var body = $('tbody', $('#fileTable'));
            $(body).append("<tr><td><img src='" + prefix + file.name + "' style=\"max-width: 32px\"/></td><td>" + file.name + "</td><td></tr>");
        });
    });

    var listenerSet = false;
    var selected = null;
    $('.js-modal').click(function (event) {
        selected = $(this);
        if (!listenerSet) {
            $(document).keydown(function (event) {
                if (event.which == 39) {
                    var next = $('img', $(selected.parent().parent()).next());
                    var nextButton = $('.js-btn-next');
                    if (nextButton.css('display') == 'none') {
                        return
                    }

                    $(next).attr('lock', 1);
                    $(next).click();
                    $(next).attr('lock', 0);
                } else if (event.which == 37) {
                    var previous = $('img', $(selected.parent().parent()).prev());
                    var previousButton = $('.js-btn-previous');
                    if (previousButton.css('display') == 'none') {
                        return
                    }

                    $(previous).attr('lock', 1);
                    $(previous).click();
                    $(previous).attr('lock', 0);
                }
            });
            listenerSet = true;
        }

        if ($(this).attr('lock') == '1') {
            event.preventDefault();
            event.stopPropagation();
        }

        $('#modalImage').attr('src', $(this).attr('src'));
        var previous = $('img', $(this.parentNode.parentNode).prev());
        var next = $('img', $(this.parentNode.parentNode).next());

        if (previous.length == 0) {
            $('.js-btn-previous').hide();
        } else {
            $('.js-btn-previous').show();
            $('.js-btn-previous').click(function () {
                $(previous).attr('lock', 1);
                $(previous).click();
                $(previous).attr('lock', 0);
            });
        }

        if (next.length == 0) {
            $('.js-btn-next').hide();
        } else {
            $('.js-btn-next').show();
            $('.js-btn-next').click(function () {
                $(next).attr('lock', 1);
                $(next).click();
                $(next).attr('lock', 0);
            });
        }

    });

    $('#menulist .js-remove-menu-item').each(function () {
        $(this).click(function (e) {
            $(this).adminMenuRemove(e);
        });
    });

    $('#menulist .js-add-menu-item').each(function () {
        $(this).click(function (e) {
            $(this).adminMenuAdd(e);
        });
    });

    $('#menulist .js-move-menu-item-up').each(function () {
        $(this).click(function (e) {
            $(this).adminMenuMoveUp(e);
        });
    });

    $('#menulist .js-move-menu-item-down').each(function () {
        $(this).click(function (e) {
            $(this).adminMenuMoveDown(e);
        });
    });
});

$.fn.adminMenuMoveUp = function (event) {
    event.stopPropagation();
    event.preventDefault();
    var parent = $(this).closest('.menulist__entry');
    var previous = $(parent).prev();

    if (previous.length <= 0) {
        return;
    }

    $(previous).before(parent);
    var curVal = $(parent).find('.js-position').val();
    $(parent).find('.js-position').val($(previous).find('.js-position').val());
    $(previous).find('.js-position').val(curVal);
};

$.fn.adminMenuMoveDown = function (event) {
    event.stopPropagation();
    event.preventDefault();
    var parent = $(this).closest('.menulist__entry');
    var next = $(parent).next();

    if (next.length <= 0) {
        return;
    }

    $(next).after(parent);
    var curVal = $(parent).find('.js-position').val();
    $(parent).find('.js-position').val($(next).find('.js-position').val());
    $(next).find('.js-position').val(curVal);
};

$.fn.adminMenuRemove = function (event) {
    event.stopPropagation();
    event.preventDefault();
    $(this).closest('.menulist__entry').remove();
};

$.fn.adminMenuAdd = function(event) {
    event.stopPropagation();
    event.preventDefault();
    var entry =  $(this).closest('.menulist__entry');
    var subEntries =  $(entry).children('.menulist__entry-subItems').first();
    var container = $('#menuTemplate');
    var containerClone = $(container).clone(true, true).find('.menulist__entry');

    $(subEntries).first().append(containerClone);

    var position = entry.length;
    var parentId = $(entry).attr('data-id');
    var uniqueId = Math.floor(Math.random() * 26) + Date.now();
    $(containerClone).find('.js-position').val(position);
    console.log(parentId);
    $(containerClone).find('.js-parent-id').val(parentId);
    $(containerClone).find('.js-id').val(uniqueId);
    $(containerClone).attr('data-id', uniqueId);

    $(containerClone).find('.js-add-menu-item').each(function () {
        $(this).click(function (e) {
            $(this).adminMenuAdd(e);
        });
    });

    $(containerClone).find('.js-remove-menu-item').each(function () {
        $(this).click(function (e) {
            $(this).adminMenuRemove(e);
        });
    });


    $(containerClone).find('.js-move-menu-item-up').each(function () {
        $(this).click(function (e) {
            $(this).adminMenuMoveUp(e);
        });
    });

    $(containerClone).find('.js-move-menu-item-down').each(function () {
        $(this).click(function (e) {
            $(this).adminMenuMoveDown(e);
        });
    });
};