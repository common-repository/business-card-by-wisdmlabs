<?php
/*
Plugin Name: Business Card by WisdmLabs
Description: A simple to use customizable Business Card Plugin for displaying your visiting card on any WordPress page.
Version: 1.0.1
License: GPL
Author: WisdmLabs
Author URI: http://wisdmlabs.com
*/

add_action( 'admin_menu', 'wdm_admin_menu' );
add_action( 'admin_init', 'register_style' );
add_action('init', 'ilc_farbtastic_script');
add_action('admin_print_scripts', 'wp_gear_manager_admin_scripts');
add_action('admin_print_styles', 'wp_gear_manager_admin_styles');

function wp_gear_manager_admin_scripts() {
  wp_enqueue_script('media-upload');
  wp_enqueue_script('thickbox');
  wp_enqueue_script('jquery');
}

function wp_gear_manager_admin_styles() {
  wp_enqueue_style('thickbox');
}

function ilc_farbtastic_script() {
  wp_enqueue_style( 'farbtastic' );
  wp_enqueue_script( 'farbtastic' );
}

function register_style(){
  //wp_register_style('wdm_vcard_css', plugins_url().'/wordpress-business-card/wdm_style.css');
  wp_register_style('wdm_vcard_css', plugins_url('wdm_style.css',__FILE__));
  wp_register_script('wdm_vcard_js', plugins_url('wdm_script.js',__FILE__));
}

function wdm_admin_menu(){
  add_menu_page('Wordpress Business Card', 'Business Card', 'administrator', 'wordpress_business_card_by_wisdmlabs', 'visiting_card',   plugins_url('images/icon.png',__FILE__));
}

add_action('wp_ajax_feedback_function', 'feedback_function_callback');
    
function feedback_function_callback()
    {
      $name=$_POST["name"];
      $email=$_POST["email"];      
      $message=$_POST["message"];      
      $subject="Suggestion/Complaints regarding the visiting card plugin";
      $headers = 'From: '.$name.' <'.$email.'>';
      //$headers = 'From: '.$email;
      $to="sanket@wisdmlabs.com,info@wisdmlabs.com";
      if ( is_email( $email ) ) {
      if(wp_mail( $to, $subject, $message, $headers ))
        echo "true";
      else
        echo "false";
        }
      else echo "The email address you entered is invalid";
      die();  
}

function visiting_card(){
    if($_REQUEST["page"]==wordpress_business_card_by_wisdmlabs){
      wp_enqueue_style('wdm_vcard_css');
      wp_enqueue_script('wdm_vcard_js');
    }
    
    if(get_option("wdm_color1")==false)
      update_option("wdm_color1","#ffffff");
    else{
      if(isset($_POST["color1"]))
        update_option("wdm_color1",$_POST["color1"]);
    }
    
    if(get_option("wdm_color2")==false)
      update_option("wdm_color2","#b22a12");
    else{
      if(isset($_POST["color2"]))
          update_option("wdm_color2",$_POST["color2"]);
    }
    
    if(get_option("wdm_color3")==false)
      update_option("wdm_color3","#4b4646");
    else{
      if(isset($_POST["color3"]))
        update_option("wdm_color3",$_POST["color3"]);
    }    
    
    if(isset($_POST["wdm_name"]))
    update_option("wdm_name",$_POST["wdm_name"]);
    
    if(isset($_POST["wdm_vcard_contact"]))
    update_option("wdm_vcard_contact",$_POST["wdm_vcard_contact"]);
    
    if(isset($_POST["wdm_vcard_email"]))
    update_option("wdm_vcard_email",$_POST["wdm_vcard_email"]);
    
    if(isset($_POST["wdm_vcard_org"]))
    update_option("wdm_vcard_org",$_POST["wdm_vcard_org"]);
    
    if(isset($_POST["wdm_vcard_addr1"]))
    update_option("wdm_vcard_addr1",$_POST["wdm_vcard_addr1"]);
    
    if(isset($_POST["wdm_vcard_addr2"]))
    update_option("wdm_vcard_addr2",$_POST["wdm_vcard_addr2"]);
    
    if(isset($_POST["upload_image"]))
    update_option("wdm_vcard_logo",$_POST["upload_image"]);
    
    ?>
    
    <script type="text/javascript" >
      jQuery(document).ready(function($) {
        jQuery(".submit_suggestion").click(function(){
              var wdm=1;
              document.getElementById('submit_suggestion').disabled = true;
              $(".wdm_contact_form").css("opacity","0.2");
              $(".wdm_loading").show();
              $(".wdm_loading").css("opacity","1");
              if(jQuery(".wdm_feedback_mail").val()==""){
                //code to highlight the missing field
                $(".wdm_feedback_mail").addClass("wdm_highlight");
                wdm=0;
              }
              if(jQuery(".wdm_feedback_name").val()==""){
                //code to highlight the missing field
                $(".wdm_feedback_name").addClass("wdm_highlight");
                wdm=0;
              }
              if(jQuery(".wdm_feedback_text").val()==""){
                //code to highlight the missing field
                $(".wdm_feedback_text").addClass("wdm_highlight");
                wdm=0;
              }
              if(wdm==1){
              $(".wdm_contact_form").css("opacity","0.5");
              $(".wdm_feedback_mail").removeClass("wdm_highlight");
              $(".wdm_feedback_text").removeClass("wdm_highlight");
              var data = {
                      action: 'feedback_function',
                      name: jQuery(".wdm_feedback_name").val(),
                      email: jQuery(".wdm_feedback_mail").val(),
                      message: jQuery(".wdm_feedback_text").val(),
              };
              jQuery.post(ajaxurl, data, function(response) {
                      //alert('Got this from the server: ' + response);
                      if(response=="The email address you entered is invalid"){
                        alert(response);
                      }
                      else{
                      if(response=="true")
                      alert("Thanks for contacting us. We will get back to you soon.");
                      else
                      alert("unexpected error occured, please try again later");
                      
                      }
                      $(".wdm_contact_form").css("opacity","1");
                      document.getElementById('submit_suggestion').disabled = false;
                      $(".wdm_loading").css("opacity","0");
                      $(".wdm_loading").hide();
              });
              }
              return false;
        });
      });
</script>
    <div class="wdm_box">
      <h2>&nbsp;&nbsp;&nbsp;&nbsp;Settings for Business Card</h2>
      <div class="wdm_container">
        <form method="POST" action="">
          
          <div class="wdm_p_info_box">
            
          
          <div style="margin-left:23px;font-weight:bold;font-size:14px;">
            Personal information
          </div>
          
          
          <fieldset>
            <div class="wdm_form_col">
              Field 1 (e.g. Name)<br/>
              <input type="text" class="wdm_vcard_name" name="wdm_name" maxlength="20" value= "<?php echo get_option("wdm_name"); ?>"/>
            </div>
            <div class="wdm_form_col">
              Field 2 (e.g. Contact)<br/>
              <input type="text" class="wdm_vcard_contact" maxlength="15" name="wdm_vcard_contact" value= "<?php echo get_option("wdm_vcard_contact"); ?>"/>
            </div>
          </fieldset>
          
          <fieldset>
            <div class="wdm_form_col">
              Field 3 (e.g. Email)<br/>
              <input type="text" class="wdm_vcard_email" maxlength="23" name="wdm_vcard_email" value= "<?php echo get_option("wdm_vcard_email"); ?>"/>
            </div>
            <div class="wdm_form_col">
              Field 4 (e.g. Organisation)<br/>
              <input type="text" class="wdm_vcard_org" maxlength="15" name="wdm_vcard_org" value= "<?php echo get_option("wdm_vcard_org"); ?>"/>
            </div>
          </fieldset>
          
          <fieldset>
            <div class="wdm_form_col">
              Field 5 (e.g. Address line 1)<br/>
              <input type="text" class="wdm_vcard_addr1" maxlength="25" name="wdm_vcard_addr1" value= "<?php echo get_option("wdm_vcard_addr1"); ?>"/>
            </div>
            <div class="wdm_form_col">
              Field 6 (e.g. Address line 2)<br/>
              <input type="text" class="wdm_vcard_addr2" maxlength="25" name="wdm_vcard_addr2" value= "<?php echo get_option("wdm_vcard_addr2"); ?>"/>
            </div>
          </fieldset>
          
          <fieldset>
            <div class="wdm_form_col">
              <input id="upload_image" type="text" size="30" name="upload_image" value="<?php /*echo $gearimage;*/echo get_option("wdm_vcard_logo") ?>" />
              <input id="upload_image_button" type="button" value="Upload Image" class="wdm_button" />
            </div>
          </fieldset>
          
          </div><!--#wdm_p_info_box-->
          
        <div class="preview_window">        
        <div class="wdm_card_container">
          <div class="wdm_user_info">
              <div class="wdm_name"></div>
              <div class="wdm_email"></div>
          </div>
          <div class="wdm_logo">
              <img class="wdm_logo_img" src="" width="70px" />
          </div>
          <div class="wdm_contact_org">
              <div class="wdm_contact"></div>
              <div class="wdm_org"></div>
          </div>          
          <div class="wdm_addr">    
              <div class="wdm_addr1"></div>
              <div class="wdm_addr2"></div>
          </div>
        </div>
        <h2 style="text-align:center;">LIVE Preview</h2>
        
      </div><!--#preview_window-->
      
          <div style="clear : both;"></div>
          
          <fieldset>
            
            <fieldset>
              <div style="margin-left:-2px;font-weight:bold;font-size:14px;">
              Settings for colors
              </div>
            </fieldset>
      
            <div class="wdm_form_col">
              <table>
                <tr>
                  <td>
                    <label for="color1">Select a color for Background:</label>
                  </td>
                  <td>
                    <input type="text" id="color1" name="color1" class="colorwell" value="<?php echo get_option("wdm_color1"); ?>" /><!--</div>-->
                  </td>
                </tr>
                <tr>
                  <td>
                    <label for="color2">Select a color for the 'Name' field:</label>
                  </td>
                  <td>
                    <input type="text" id="color2" name="color2" class="colorwell" value="<?php echo get_option("wdm_color2"); ?>" /><!--</div>-->
                  </td>
                </tr>
                <tr>
                  <td>
                    <label for="color3">Select a color for other fields</label>
                  </td>
                  <td>
                    <input type="text" id="color3" name="color3" class="colorwell" value="<?php echo get_option("wdm_color3"); ?>" /><!--</div>-->
                  </td>
                </tr>
              </table>
            </div>
      
            <div class="wdm_form_col wdm_col_pic">
              <div id="picker" ></div>
            </div>
            
          </fieldset>
          
          <div style="font-weight:bold;font-size: 14px;margin-left: 22px;">
        To display your visiting card on a wordpress page just put the shortcode [visiting_card]
        </div>
          
          <fieldset>
              <div class="wdm_form_col">
              <input type="submit" class="wdm_button wdm_save_button" value="Save settings"/>
              </div>
          </fieldset>
          
        </form>
                
        
        
        <hr/>
      
        <div class="wdm_feedback wdm_form_col">
          
          <table><tr><td>
          
          <div class="wdm_contact_form" style="float: left;">
            <form action="" method="POST">  
              <fieldset>
                <div class="wdm_form_col">
                  If you have any suggestions or complaints , please feel free to contact us.
                </div>
              </fieldset>
              
              <fieldset>
                <div class="wdm_form_col">
                  Name<br/>
                  <input type="text" class="wdm_feedback_name" name="name"/>
                </div>
              </fieldset>
      
              <fieldset>
                <div class="wdm_form_col">
                  Email<br/>
                  <input type="text" class="wdm_feedback_mail" name="email"/>
                </div>
              </fieldset>
              
              <fieldset>
                <div class="wdm_form_col">
                  Suggestion
                  <br/>
                  <textarea class="wdm_feedback_text" name="message"></textarea>
                </div>
              </fieldset>
      
              <fieldset>
                <button class="submit_suggestion wdm_button" id="submit_suggestion">Submit</button>
              </fieldset>
            </form>
      
          </div><!--#wdm_contact_form-->
          
          </td><td>
          
          <div class="wdm_loading" style="position: absolute;top: 131px;left: 305px;">
            <img src="<?php echo plugins_url('images/loading.gif',__FILE__); ?>"/>
          </div>
          
          </td></tr></table>
          
        </div><!--#wdm_feedback-->
        
          
      
      </div><!--#wdm_container-->
      
      
    </div>
        
      <?php
      }
function display_visiting_card(){
  wp_enqueue_style('wdm_vcard_css', plugins_url('wdm_style.css',__FILE__));
  $visiting_card="";
  $visiting_card .= '<div class="wdm_card_container" style="color:'.get_option("wdm_color3").' ;background-color:'. get_option("wdm_color1").'">
        <div class="wdm_user_info">
            <div class="wdm_name" style="color:'. get_option("wdm_color2").'">'.get_option("wdm_name").'</div>
            <div class="wdm_email">'.get_option("wdm_vcard_email").'</div>
        </div>
        <div class="wdm_logo">
            <img class="wdm_logo_img" src="'.get_option("wdm_vcard_logo").'" width="70px" />
        </div>
        <div class="wdm_contact_org">
            <div class="wdm_contact">'.get_option("wdm_vcard_contact").'</div>
            <div class="wdm_org">'.get_option("wdm_vcard_org").'</div>
        </div>
        
        <div class="wdm_addr">    
            <div class="wdm_addr1">'.get_option("wdm_vcard_addr1").'</div>
            <div class="wdm_addr2">'.get_option("wdm_vcard_addr2").'</div>
        </div>
        </div>';
    return $visiting_card;

}
add_shortcode('visiting_card','display_visiting_card');
?>
