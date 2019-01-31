jQuery(document).ready(function($) {	

    $(".custom").spectrum({
        showAlpha: true,
        showInput: true,
        allowEmpty: true,
        preferredFormat: "rgb",
    });


    $('.wpparallax-repeater-field-control .un-bottom-block-pages #dropdown-pages option:selected').each(function(){
        var page_title = $(this).text();
        $(this).closest('.wpparallax-repeater-fields').siblings('.wpparallax-repeater-field-title').append('<span class="prepended">'+page_title+'</span>');
    });


    $(".customize-control-repeater").on('change','#dropdown-pages',function(){
        var page = $(this).find("option:selected").text();
        $(this).closest('.wpparallax-repeater-fields').siblings('.wpparallax-repeater-field-title').find('span').text(page);
    });

    $('.wpparallax-repeater-field-control .un-bottom-block-layout #dropdown-layouts option:selected').each(function(){
        var layout1 = $(this).val();
        $(this).closest(".un-bottom-block-layout").siblings(".wpop-layout").hide();
        if(layout1=='service' || layout1=='portfolio' || layout1=='testimonial' ||  layout1=='blog' ||  layout1=='team'){
          $(this).closest(".un-bottom-block-layout").siblings(".block-cat").show();
        }else if(layout1=='callto'){
          $(this).closest(".un-bottom-block-layout").siblings(".call-to").show();  
        }
    });

    $('.wpparallax-repeater-field-control .un-bottom-block-layout #dropdown-layouts').each(function(){
    $( ".customize-control-repeater" ).on('change','#dropdown-layouts',function() {
        var layout = $(this).val();
        $(this).closest(".un-bottom-block-layout").siblings(".wpop-layout").hide();
        if(layout=='service' || layout=='portfolio' ||  layout=='testimonial' ||  layout=='blog' ||  layout=='team'){
          $(this).closest(".un-bottom-block-layout").siblings(".block-cat").show();
        }else if(layout=='callto'){
          $(this).closest(".un-bottom-block-layout").siblings(".call-to").show();  
        }
    });
    });

    $(".customize-control-repeater").on('change','.select-bg',function() {
        var page = $(this).val();
        $(this).closest('.un-bottom-block-bg-type').siblings('.bg-type').hide();
        $(this).closest('.un-bottom-block-bg-type').siblings('.'+page).show();
    });    

    $('.wpparallax-repeater-field-control .un-bottom-block-bg-type .select-bg option:selected').each(function(){
        var bg_type = $(this).val();
        $(this).closest('.un-bottom-block-bg-type').siblings('.bg-type').hide();
        $(this).closest('.un-bottom-block-bg-type').siblings('.'+bg_type).show();
    });         


    function wp_parallax_refresh_repeater_values(){


        $(".wpparallax-repeater-field-control-wrap").each(function(){
            
            var values = []; 
            var $this = $(this);
            
            $this.find(".wpparallax-repeater-field-control").each(function(){
            var valueToPush = {};   

            $(this).find('[data-name]').each(function(){
                var dataName = $(this).attr('data-name');
                var dataValue = $(this).val();
                valueToPush[dataName] = dataValue;
            });

            values.push(valueToPush);
            });

            $this.next('.wpparallax-repeater-collector').val(JSON.stringify(values)).trigger('change');
        });
    }
     /**
     * Script for Customizer icons
    */ 
    $(document).on('click', '.ap-customize-icons li', function() {
        $(this).parents('.ap-customize-icons').find('li').removeClass();
        $(this).addClass('selected');
        var iconVal = $(this).parents('.icons-list-wrapper').find('li.selected').children('i').attr('class');
        var inpiconVal = iconVal.split(' ');
        $(this).parents( '.ap-customize-icons' ).find('.ap-icon-value').val(inpiconVal[1]);
        $(this).parents( '.ap-customize-icons' ).find('.selected-icon-preview').html('<i class="' + iconVal + '"></i>');
        $('.ap-icon-value').trigger('change');
    });
    $(document).on('click','.removeimage',function() {
        $(this).parent().html("");
        $("#wpparallax_bread_bg_image").val('');
    });
    $("body").on("click",'.wpparallax-add-control-field', function(){
        var $this = $(this).parent();
        if(typeof $this != 'undefined') {

            var field = $this.find(".wpparallax-repeater-field-control:first").clone();
            if(typeof field != 'undefined'){

                field.find('.wpparallax-repeater-field-title span').text("");

                field.find(".block-cat").hide();
                field.find(".video").hide();
                field.find(".image").hide();
                field.find(".color").show();
                 
                field.find("input[type='text'][data-name]").each(function(){

                    var defaultValue = $(this).attr('data-default');
                    $(this).val(defaultValue);

                });


                field.find("select[data-name]").each(function(){
                    var defaultValue = $(this).attr('data-default');
                    $(this).val(defaultValue);
                });


                field.find('.onoffswitch').each(function(){
                    var defaultValue = $(this).next('input[data-name]').attr('data-default');
                    $(this).next('input[data-name]').val(defaultValue);
                    if(defaultValue == 'on'){
                        $(this).addClass('switch-on');
                    }else{
                        $(this).removeClass('switch-on');
                    }
                });

                field.find('.custom').each(function(){
                    $(this).spectrum({
                        showAlpha: true,
                        allowEmpty: true,
                        showInput: true,
                        preferredFormat: "rgb",
                    }).parents('.wpparallax-type-colorpicker').find('.sp-replacer').slice(1, 2).remove();

                });

                field.find(".attachment-media-view").each(function(){
                    var defaultValue = $(this).find('input[data-name]').attr('data-default');
                    $(this).find('input[data-name]').val(defaultValue);
                    if(defaultValue){
                        $(this).find(".thumbnail-image").html('<img src="'+defaultValue+'"/>').prev('.placeholder').addClass('hidden');
                    }else{
                        $(this).find(".thumbnail-image").html('').prev('.placeholder').removeClass('hidden');   
                    }
                });
                
                
                //field.find('.wpparallax-fields').show();

                $this.find('.wpparallax-repeater-field-control-wrap').append(field);

                field.addClass('expanded');//.find('.wpparallax-repeater-fields').show(); 
                $('.accordion-section-content').animate({ scrollTop: $this.height() }, 1000);
                wp_parallax_refresh_repeater_values();
            }

        }
        return false;
    });


    $("#customize-theme-controls").on("click", ".wpparallax-repeater-field-remove",function(){
        if( typeof  $(this).parent() != 'undefined'){
            $(this).closest('.wpparallax-repeater-field-control').slideUp('normal', function(){
                $(this).remove();
                wp_parallax_refresh_repeater_values();
            });
            
        }
        return false;
    });
    $('#customize-theme-controls').on('click', '.wpparallax-repeater-field-close', function(){
        $(this).closest('.wpparallax-repeater-fields').slideUp();;
        $(this).closest('.wpparallax-repeater-field-control').toggleClass('expanded');
    });
    $('#customize-theme-controls').on('click','.wpparallax-repeater-field-title',function(){
        $(this).next().slideToggle();
        $(this).closest('.wpparallax-repeater-field-control').toggleClass('expanded');
    });

    $('body').on('click','.selector-labels label', function(){
        var $this = $(this);
        var value = $this.attr('data-val');
        $this.siblings().removeClass('selector-selected');
        $this.addClass('selector-selected');
        $this.closest('.selector-labels').next('input').val(value).trigger('change');
    });


    $('body').on('click', '.onoffswitch', function(){
        var $this = $(this);
        if($this.hasClass('switch-on')){
            $(this).removeClass('switch-on');
            $this.next('input').val('off').trigger('change')
        }else{
            $(this).addClass('switch-on');
            $this.next('input').val('on').trigger('change')
        }
    });


    /*Drag and drop to change order*/
    
    $(".wpparallax-repeater-field-control-wrap").sortable({
        orientation: "vertical",
        update: function( event, ui ) {
            wp_parallax_refresh_repeater_values();
        }
    });
    
    $("#customize-theme-controls").on('keyup change', '[data-name]',function(){
         wp_parallax_refresh_repeater_values();
         return false;
    });

    $("#customize-theme-controls").on('change', 'input[type="checkbox"][data-name]',function(){
        if($(this).is(":checked")){
            $(this).val('yes');
        }else{
            $(this).val('no');
        }
        wp_parallax_refresh_repeater_values();
        return false;
    });
    // ADD IMAGE LINK
    $('.customize-control-repeater').on( 'click', '.wpparallax-upload-button', function( event ){
    event.preventDefault();
    var imgContainer = $(this).closest('.wpparallax-fields-wrap').find( '.thumbnail-image'),
    placeholder = $(this).closest('.wpparallax-fields-wrap').find( '.placeholder'),
    imgIdInput = $(this).siblings('.upload-id');

    // Create a new media frame
    frame = wp.media({
        title: 'Select or Upload Image',
        button: {
        text: 'Use Image'
        },
        multiple: false  // Set to true to allow multiple files to be selected
    });

    // When an image is selected in the media frame...
    frame.on( 'select', function() {

    // Get media attachment details from the frame state
    var attachment = frame.state().get('selection').first().toJSON();

    // Send the attachment URL to our custom image input field.
    imgContainer.html( '<img src="'+attachment.url+'" style="max-width:100%;"/>' );
    placeholder.addClass('hidden');

    // Send the attachment id to our hidden input
    imgIdInput.val( attachment.url ).trigger('change');

    });

    // Finally, open the modal on click
    frame.open();
    });
    // DELETE IMAGE LINK
    $('.customize-control-repeater').on( 'click', '.wpparallax-delete-button', function( event ){

    event.preventDefault();
    var imgContainer = $(this).closest('.wpparallax-fields-wrap').find( '.thumbnail-image'),
    placeholder = $(this).closest('.wpparallax-fields-wrap').find( '.placeholder'),
    imgIdInput = $(this).siblings('.upload-id');

    // Clear out the preview image
    imgContainer.find('img').remove();
    placeholder.removeClass('hidden');

    // Delete the image id from the hidden input
    imgIdInput.val( '' ).trigger('change');

    });



});