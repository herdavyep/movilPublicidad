jQuery(document).ready(function($) {    

    /**
     * Script for switch option
    */
    $('.switch_options').each(function() {
        //This object
        var obj = $(this);

        var switchPart = obj.children('.switch_part').attr('data-switch');
        var input = obj.children('input'); //cache the element where we must set the value
        var input_val = obj.children('input').val(); //cache the element where we must set the value

        obj.children('.switch_part.'+input_val).addClass('selected');
        obj.children('.switch_part').on('click', function(){
            var switchVal = $(this).attr('data-switch');
            obj.children('.switch_part').removeClass('selected');
            $(this).addClass('selected');
            $(input).val(switchVal).change(); //Finally change the value to 1
        });

    });
    /**
     * Script for widget switch option
     */
    $('body').on('click', '.widget_switch_part', function () {
        $(this).trigger('change');
        $(this).parent().find('.widget_switch_part').removeClass('selected');
        $(this).addClass('selected');
        var switch_val = $(this).data('switch');
        $(this).parent().find('input[type="hidden"]').val(switch_val);
    });

    $(document).on('click', '.wp-picker-container button', function(){
     $(this).$('.button[name="savewidget"]').prop('disabled', false);
    });

    /*===========================================================================================*/
    /* wpparallax section widget */

    $( "body" ).on('change','.dropdown-layout .selectopt',function() {
        var layout = $(this).val();
        $(this).closest(".dropdown-layout").siblings(".dropdown-cat").hide();
        if(layout=='service' || layout=='portfolio' ||  layout=='testimonial' ||  layout=='blog' ||  layout=='team' ){
          $(this).closest(".dropdown-layout").siblings(".dropdown-cat").show();
        }else if(layout=='callto'){
          $(this).closest(".dropdown-layout").siblings(".call-to").show();  
        }
    });

    $("body").on('change','.dropdown-bg .selectopt',function() {
        var page = $(this).val();
        $(this).closest('.dropdown-bg').siblings('.bg-type').hide();
        $(this).closest('.dropdown-bg').siblings('.'+page).show();
    });
       
});
   