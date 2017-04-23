$(function() {
    var $btn = $('a.action-add-tag'),
        max = $btn.data('max'),
        $tags = $($btn.data('target'));

    function maxIsReached() {
        return (max !== undefined) && ($tags.find('div.tag-row').length >= max);
    }

    function toggleButton() {
        $btn.toggleClass('disabled', maxIsReached());
    }

    $('div.tags-container').each(function(i, container) {
        var $container = $(container);

        $container.data('index', $container.find('div.tag-row').length);
        toggleButton();
    });

    $btn.click(function(e) {
        e.preventDefault();

        if (maxIsReached()) {
            return;
        }

        var prototype = $tags.data('prototype'),
            index = $tags.data('index'),
            tagForm = prototype.replace(/__name__/g, index);

        $tags.data('index', index + 1).append(tagForm);
        toggleButton();
    });

    $(document).on('click', 'button.action-remove-tag', function(e) {
        e.preventDefault();

        $(this).closest('div.tag-row').remove();
        toggleButton();
    });
});
