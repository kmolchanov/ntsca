(function ($) {
    function buildImage(target) {
        return $('<img>')
            .attr('src', target.attr('rel'))
            .attr('alt', target.attr('title') || '')
            .attr('data-id', target.data('id') || '');
    }

    $.Redactor.prototype.clips = function () {
        return {
            init: function () {
                var items = this.opts.clips || [];

                this.clips.template = $('<ul id="redactor-modal-list">');

                for (var i = 0; i < items.length; i++) {
                    var li = $('<li>');
                    var link = $('<a href="#" class="redactor-clip-link">').text(items[i][0]);
                    var block = $('<div class="redactor-clip">').hide().html(items[i][1]);

                    li.append(link);
                    li.append(block);
                    this.clips.template.append(li);
                }

                this.modal.addTemplate('clips', '<section>' + this.utils.getOuterHtml(this.clips.template) + '</section>');

                var button = this.button.add('clips', 'Блоки');
                this.button.addCallback(button, this.clips.show);
            },
            show: function () {
                this.modal.load('clips', 'Вставить блок', 420);
                this.modal.createCancelButton();

                $('#redactor-modal-list').find('.redactor-clip-link').each($.proxy(this.clips.load, this));

                this.selection.save();
                this.modal.show();
            },
            load: function (i, link) {
                $(link).on('click', $.proxy(function (event) {
                    event.preventDefault();
                    this.clips.insert($(link).next().html());
                }, this));
            },
            insert: function (html) {
                var spacer = '<p><br></p>';

                this.selection.restore();
                this.insert.htmlWithoutClean(spacer + html + spacer);
                this.modal.close();
                this.observe.load();
                this.code.sync();
            }
        };
    };

    $.Redactor.prototype.imagemanager = function () {
        return {
            init: function () {
                if (!this.opts.imageManagerJson) return;

                this.imagemanager.targetSlot = false;
                this.modal.addCallback('image', this.imagemanager.load);

                this.$editor.on('mousedown.redactor-image-slot click.redactor-image-slot', '.content-image-slot', $.proxy(function (event) {
                    this.imagemanager.targetSlot = $(event.currentTarget);
                }, this));
            },
            load: function () {
                var $modal = this.modal.getModal();

                this.imagemanager.targetSlot = this.imagemanager.getCurrentSlot();

                this.modal.createTabber($modal);
                this.modal.addTab(1, this.lang.get('upload'), 'active');
                this.modal.addTab(2, this.lang.get('choose'));

                $('#redactor-modal-image-droparea').addClass('redactor-tab redactor-tab1');

                var $box = $('<div id="redactor-image-manager-box" style="overflow: auto; height: 300px;" class="redactor-tab redactor-tab2">').hide();
                $modal.append($box);

                $.ajax({
                    dataType: 'json',
                    cache: false,
                    url: this.opts.imageManagerJson,
                    success: $.proxy(function (data) {
                        $.each(data, $.proxy(function (key, val) {
                            var thumbtitle = '';
                            if (typeof val.title !== 'undefined') thumbtitle = val.title;

                            var id = '';
                            if (typeof val.id !== 'undefined') id = val.id;

                            var img = $('<img src="' + val.thumb + '" rel="' + val.image + '" title="' + thumbtitle + '" data-id="' + id + '" style="width: 100px; height: 75px; cursor: pointer;" />');
                            $('#redactor-image-manager-box').append(img);
                            $(img).click($.proxy(this.imagemanager.insert, this));
                        }, this));
                    }, this)
                });
            },
            getCurrentSlot: function () {
                var current = this.selection.getCurrent();
                var $slot = $(current).closest('.content-image-slot', this.$editor[0]);

                if ($slot.length) {
                    return $slot;
                }

                if (this.imagemanager.targetSlot && $.contains(this.$editor[0], this.imagemanager.targetSlot[0])) {
                    return this.imagemanager.targetSlot;
                }

                return false;
            },
            insert: function (event) {
                var $target = $(event.target);
                var $slot = this.imagemanager.getCurrentSlot();
                var $image = buildImage($target);

                if ($slot && $slot.length && $.contains(this.$editor[0], $slot[0])) {
                    $slot.empty().append($image);
                    this.modal.close();
                    this.observe.load();
                    this.code.sync();
                    this.imagemanager.targetSlot = false;
                    return;
                }

                this.image.insert(this.utils.getOuterHtml($image));
                this.observe.load();
                this.code.sync();
            }
        };
    };
})(jQuery);
