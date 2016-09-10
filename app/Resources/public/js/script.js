$(function() {
    $('div.tags-container').each(function(i, container) {
        var $container = $(container);

        $container.data('index', $container.find('div.tag-row').length)
    });

    $('a.action-add-tag').click(function(e) {
        e.preventDefault();

        var $this = $(this),
            max = $this.data('max'),
            $tags = $($this.data('target'));

        if (max !== undefined) {
            if ($tags.find('div.tag-row').length >= max) {
                return;
            }
        }

        var prototype = $tags.data('prototype'),
            index = $tags.data('index'),
            tagForm = prototype.replace(/__name__/g, index);

        $tags.data('index', index + 1).append(tagForm);
    });

    $(document).on('click', 'a.action-remove-tag', function(e) {
        e.preventDefault();

        $(this).closest('div.tag-row').remove();
    });
});
