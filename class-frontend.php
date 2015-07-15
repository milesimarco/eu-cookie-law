<?php    

    $euCookieSet = 0;

function eucookie_scripts() {
    
    global $euCookieSet;
    global $deleteCookieUrlCheck;
    
    if ( isset($_GET['nocookie']) ) {
        unset($_COOKIE['euCookie']);
        setcookie('euCookie', '', time() - 3600, '/'); 
        $euCookieSet = 0;
    } else if (  wp_get_referer() && eucookie_option('navigationconsent') && (!cookie_accepted()) && (eucookie_option('boxlinkid') != get_the_ID()) ) {
        setcookie('euCookie', 'set', time()+get_expire_timer()*60*60*24, '/', eucookie_option('networkshareurl'));
        $euCookieSet = 1;
    }
    
	wp_register_style	('basecss', plugins_url('css/style.css', __FILE__), false);
	wp_enqueue_style	('basecss');
    
    $eclData = array(
        'euCookieSet' => $euCookieSet,
        'expireTimer' => get_expire_timer(),
        'scrollConsent' => eucookie_option('scrollconsent'),
        'networkShareURL' => ecl_get_cookie_domain(),
        'isCookiePage' => eucookie_option('boxlinkid') == get_the_ID(),
        'isRefererWebsite' => eucookie_option('navigationconsent') && wp_get_referer(),
        'deleteCookieUrl' => esc_url( add_query_arg( 'nocookie', '1', get_permalink() ) )
    );
    
    wp_enqueue_script(
        'eucookielaw-scripts',
        plugins_url('js/scripts.js', __FILE__),
        array( 'jquery' ),
        '',
        true
    );
    wp_localize_script('eucookielaw-scripts','eucookielaw_data',$eclData);
    
}
add_action('wp_head', 'eucookie_scripts');

function ecl_get_cookie_domain() {
    
    if ( !eucookie_option('networkshare') ) {
        return false;
    }
    return 'domain='.eucookie_option('networkshareurl').'; ';
}

function cookie_accepted() {
    global $euCookieSet;
    
    if ( ! eucookie_option('enabled') ) { return true; }
    
    if ( isset( $_COOKIE['euCookie'] ) || $euCookieSet ) {
        return true;
    } else {
        return false;
    }
}

function get_expire_timer() {
    
    switch( eucookie_option('length') ){
        case "hours":
            $multi = 1;
            break;
        case "days":
            $multi = 1;
            break;
        case "weeks":
            $multi = 7;
            break;
        case "months":
            $multi = 30;
            break;
    }
    return $multi *  eucookie_option('lengthnum');
}
    
function peadig_eucookie_bar() {
    
	if ( cookie_accepted()  ) {
        return;
    }
            
    if ( eucookie_option('boxlinkid') ) {
        $linkid = apply_filters( 'wpml_object_id', eucookie_option('boxlinkid'), 'page' );
        $link = get_permalink( $linkid );
    } else {
        $link = '#';
    }
?>
        <div
            class="pea_cook_wrapper pea_cook_<?php echo eucookie_option('position'); ?>"
            style="
                color:<?php echo ecl_frontstyle('fontcolor'); ?>;
                background-color: rgba(<?php echo ecl_frontstyle('backgroundcolor'); ?>,0.85);
            ">
            <p><?php echo eucookie_option('barmessage'); ?> <a style="color:<?php echo eucookie_option('fontcolor'); ?>;" href="<?php echo $link; ?>" id="fom"><?php echo eucookie_option('barlink'); ?></a> <button id="pea_cook_btn" class="pea_cook_btn" href="#"><?php echo eucookie_option('barbutton'); ?></button></p>
        </div>
        <div class="pea_cook_more_info_popover">
            <div
                 class="pea_cook_more_info_popover_inner"
                 style="
                    color:<?php echo ecl_frontstyle('fontcolor'); ?>;
                    background-color: rgba(<?php echo ecl_frontstyle('backgroundcolor'); ?>,0.9);
                    ">
             <p><?php echo eucookie_option('boxcontent'); ?></p>
                <p><a style="color:<?php echo eucookie_option('fontcolor'); ?>;" href="#" id="pea_close"><?php echo eucookie_option('closelink'); ?></a></p>
			</div>
        </div>
<?php
}
add_action('wp_footer', 'peadig_eucookie_bar', 1000);

function generate_cookie_notice_text($height, $width, $text) {
    return '<div class="eucookie" style="color:'.ecl_frontstyle('fontcolor').'; background: rgba('.ecl_frontstyle('backgroundcolor').',0.85) url(\''.plugins_url('img/block.png', __FILE__).'\') no-repeat; background-position: -30px -20px; width:'.$width.';height:'.$height.';"><span>'.$text.'</span></div><div class="clear"></div>';    
}

function generate_cookie_notice($height, $width) {
    return generate_cookie_notice_text($height, $width, eucookie_option('bhtmlcontent') );
}
function eu_cookie_shortcode( $atts, $content = null ) {
    extract(shortcode_atts(
        array(
            'height' => '',
            'width' => '',
            'text' => eucookie_option('bhtmlcontent')
        ),
        $atts)
    );
    if ( cookie_accepted() ) {
        return do_shortcode( $content );
    } else {
        if (!$width) { $width = pulisci($content,'width='); }
        if (!$height) { $height = pulisci($content,'height='); }
        return generate_cookie_notice($height, $width);
    }
}
add_shortcode( 'cookie', 'eu_cookie_shortcode' );

function ecl_callback($buffer) { return ecl_erase($buffer); }

add_filter( 'the_content', 'ecl_erase', 11); 
add_filter( 'widget_display_callback','ecl_erase', 11, 3 ); 

function ecl_buffer_start() { ob_start("ecl_callback"); } 
function ecl_buffer_end() { ob_end_flush();	}

add_action('wp_head', 'ecl_buffer_start'); 
add_action('wp_footer', 'ecl_buffer_end'); 

function ecl_erase($content) {
    if ( !cookie_accepted() && eucookie_option('autoblock') && !get_post_field( 'eucookielaw_exclude', get_the_id() ) ) {
        $content = preg_replace('#<iframe.*?\/iframe>|<object.+?</object>|<embed.*?>#is', generate_cookie_notice('auto', '100%'), $content);
        $content = preg_replace('#<script.*?\/script>#is', '', $content);
        $content = preg_replace('#<!cookie_start.*?\!cookie_end>#is', generate_cookie_notice('auto', '100%'), $content);
        $content = preg_replace('#<div id=\"disqus_thread\".*?\/div>#is', generate_cookie_notice('auto', '100%'), $content);
    }
    return $content;
}

add_filter( 'widget_text', 'do_shortcode');

function pulisci($content,$ricerca){
	$caratteri = strlen($ricerca)+6;
	$stringa = substr($content, strpos($content, $ricerca), $caratteri);
	$stringa = str_replace($ricerca, '', $stringa);
	$stringa = trim(str_replace('"', '', $stringa));
	return $stringa;
}

function ecl_hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   return array($r, $g, $b);
}

function ecl_frontstyle($name) {
    switch ($name) {
    case 'fontcolor':
        return  eucookie_option('fontcolor');
        break;
    case 'backgroundcolor':
        $backgroundcolors = ecl_hex2rgb( eucookie_option('backgroundcolor') );
        return $backgroundcolors[0].','.$backgroundcolors[1].','.$backgroundcolors[2];
        break;
    }
}

function eu_cookie_control_shortcode( $atts ) {
    if ( !eucookie_option('enabled') ) { return; }
    if ( cookie_accepted() ) {
        return '
            <div class="pea_cook_control" style="color:'.ecl_frontstyle('fontcolor').'; background-color: rgba('.ecl_frontstyle('backgroundcolor').',0.9);">
                '.__('Cookies are enabled', 'eu-cookie-law').'
                <button id="eu_revoke_cookies" class="eu_control_btn">'.__('Revoke cookie consent', 'eu-cookie-law').'</button>
            </div>';
    } else {
        return '
            <div class="pea_cook_control" style="color:'.ecl_frontstyle('fontcolor').'; background-color: rgba('.ecl_frontstyle('backgroundcolor').',0.9);">
                '.__('Cookies are disabled', 'eu-cookie-law').'<br>'.sprintf( __( 'Accept Cookies by clicking "%s" in the banner.', 'eu-cookie-law' ), '<b>'.eucookie_option('barbutton').'</b>' ).'
            </div>';            
    }
}
add_shortcode( 'cookie-control', 'eu_cookie_control_shortcode' );