jQuery(function ($) {
    $(document).ready(function() {
        $(".wdm_feedback_mail").removeClass("wdm_highlight");
        $("#color1").change(function(){ 
        $(".wdm_card_container").css("background-color","green");
    });
        setInterval(function() {
            $(".wdm_card_container").css("background-color",$("#color1").val());
            
            $(".wdm_card_container").css("color",$("#color3").val());
            
            $(".wdm_name").css("color",$("#color2").val());
            
            $(".wdm_name").html($(".wdm_vcard_name").val());
            $(".wdm_email").html($(".wdm_vcard_email").val());
            $(".wdm_contact").html($(".wdm_vcard_contact").val());
            $(".wdm_org").html($(".wdm_vcard_org").val());
            $(".wdm_addr1").html($(".wdm_vcard_addr1").val());
            $(".wdm_addr2").html($(".wdm_vcard_addr2").val());
            $(".wdm_logo_img").attr("src",$("#upload_image").val());
            
            }, 100);
        
        var f = $.farbtastic('#picker');
        var p = $('#picker').css('opacity', 0.25);
        var selected;
        $('.colorwell')
        .each(function () { f.linkTo(this); $(this).css('opacity', 0.75); })
        .focus(function() {
        if (selected) {
          $(selected).css('opacity', 0.75).removeClass('colorwell-selected');
        }
        f.linkTo(this);
        p.css('opacity', 1);
        $(selected = this).css('opacity', 1).addClass('colorwell-selected');
        });
        });   
});

jQuery(document).ready(function() {
    jQuery('#upload_image_button').click(function() {
    formfield = jQuery('#upload_image').attr('name');
    tb_show('', 'media-upload.php?type=image&TB_iframe=true');
    return false;
    });
    
    window.send_to_editor = function(html) {
    imgurl = jQuery('img',html).attr('src');
    jQuery('#upload_image').val(imgurl);
    tb_remove();
    }
});