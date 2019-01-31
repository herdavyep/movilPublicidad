jQuery('#database-reset').click(function () {
    var ele = jQuery(this);
    if (ele.is(':checked')) {
        jQuery('.import-btn').attr('data-reset', 'true');
    } else {
        jQuery('.import-btn').attr('data-reset', 'false');
    }
});
jQuery('[data-wpop-importer]').each(function() {
    var $this = jQuery(this),
        item = $this,
        tag = $this.find('.wpop-tag'),
        content = $this.find('.wpop-importer-response');

    $this.find('[data-import]').click(function(e) {
        e.preventDefault();
        var confrm = confirm('Please make sure you take backup of everything. Your default contents may be overwritten/lost. So it is strongly suggested to run importer on fresh installation of WordPress and make sure that all the plugins are installed and active before proceeding further.');
        if (confrm == true) {
            var $this = jQuery(this),
                demo = $this.data('import'),
                nonce = $this.data('nonce'),
                dataReset = $this.data('reset');

            jQuery.ajax({
                url: ajaxurl,
                type: 'post',
                data: {
                    action: 'wpop_demo_importer',
                    nonce: nonce,
                    id: demo,
                    reset: dataReset,
                },
                beforeSend: function() {
                    $this.html('<span class="spinner">Please Wait...</span>');
                },
                complete: function() {
                    content.addClass('active');
                    item.addClass('imported');
                    tag.html("Imported");
                    $this.html('Re-Import');
                },
                success: function(data) {
                    content.append(data)
                }
            });
        }

    });

    jQuery('.dismiss').click(function() {
        content.removeClass('active');
    });

});