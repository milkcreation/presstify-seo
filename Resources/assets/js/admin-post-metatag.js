jQuery(document).ready(function ($) {
    $('[data-target]').keyup(function () {
        let $target = $('[data-aim="' + $(this).data('target') + '"]');

        if ($(this).val()) {
            $target.html($(this).val().toString());
        } else {
            $target.html($(this).data('orig'));
        }
    });
});