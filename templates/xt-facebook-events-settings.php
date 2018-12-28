<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) exit;
global $xtfe_events;
$xtfe_options = get_option( XTFE_OPTIONS, array() );
$facebook_app_id = isset($xtfe_options['facebook_app_id']) ? $xtfe_options['facebook_app_id'] : '';
$facebook_app_secret = isset($xtfe_options['facebook_app_secret']) ? $xtfe_options['facebook_app_secret'] : '';
$xtfe_user_token_options = get_option( 'xtfe_user_token_options', array() );
$xtfe_fb_authorize_user = get_option( 'xtfe_fb_authorize_user', array() );
?>
<div class="xtfe_container">
    <div class="xtfe_row">
        <h3 class="setting_bar"><?php esc_attr_e( 'Facebook Settings', 'xt-facebook-events' ); ?></h3>
        <?php
        $site_url = get_home_url();
        if( !isset( $_SERVER['HTTPS'] ) && false === stripos( $site_url, 'https' ) ) {
            ?>
            <div class="widefat xtfe_settings_error">
                <?php printf( '%1$s <b><a href="https://developers.facebook.com/blog/post/2018/06/08/enforce-https-facebook-login/" target="_blank">%2$s</a></b> %3$s', __( "It looks like you don't have HTTPS enabled on your website. Please enable it. HTTPS is required for authorize your facebook account.","import-facebook-events" ), __( 'Click here','import-facebook-events' ), __( 'for more information.','import-facebook-events' ) ); ?>
            </div>
        <?php
        } ?>
        <div class="widefat xtfe_settings_notice">
            <?php printf( '<b>%1$s</b> %2$s <b><a href="https://developers.facebook.com/apps" target="_blank">%3$s</a></b> %4$s',  __( 'Note : ','import-facebook-events' ), __( 'You have to create a Facebook application before filling the following details.','import-facebook-events' ), __( 'Click here','import-facebook-events' ),  __( 'to create new Facebook application.','import-facebook-events' ) ); ?>
            <br/>
            <?php _e( 'For detailed step by step instructions ', 'import-facebook-events' ); ?>
            <strong><a href="http://docs.xylusthemes.com/docs/import-facebook-events/creating-facebook-application/" target="_blank"><?php _e( 'Click here', 'import-facebook-events' ); ?></a></strong>.
            <br/>
            <?php _e( '<strong>Set the site url as : </strong>', 'import-facebook-events' ); ?>
            <span style="color: green;"><?php echo get_site_url(); ?></span>
            <br/>
            <?php _e( '<strong>Set Valid OAuth redirect URI : </strong>', 'import-facebook-events' ); ?>
            <span style="color: green;"><?php echo admin_url( 'admin-post.php?action=xtfe_facebook_authorize_callback' ); ?></span>
        </div>

        <?php
        if( $facebook_app_id != '' && $facebook_app_secret != '' ){
            ?>
            <h3 class="setting_bar"><?php esc_attr_e( 'Authorize your Facebook Account', 'import-facebook-events' ); ?></h3>
            <div class="fb_authorize">
                <table class="form-table">
                    <tbody>
                        <tr>
                            <th scope="row">
                                <?php _e( 'Facebook Authorization','import-facebook-events' ); ?> :
                            </th>
                            <td>
                                <form method="post" action="<?php echo admin_url('admin-post.php'); ?>">
                                    <input type="hidden" name="action" value="xtfe_facebook_authorize_action"/>
                                    <?php wp_nonce_field('xtfe_facebook_authorize_action', 'xtfe_facebook_authorize_nonce'); ?>
                                    <?php
                                    $button_value = __('Authorize', 'import-facebook-events');
                                    if( isset( $xtfe_user_token_options['authorize_status'] ) && $xtfe_user_token_options['authorize_status'] == 1 && isset(  $xtfe_user_token_options['access_token'] ) &&  $xtfe_user_token_options['access_token'] != '' ){
                                        $button_value = __('Reauthorize', 'import-facebook-events');
                                    }
                                    ?>
                                    <input type="submit" class="button" name="xtfe_facebook_authorize" value="<?php echo $button_value; ?>" />
                                    <?php
                                    if( !empty( $xtfe_fb_authorize_user ) && isset( $xtfe_fb_authorize_user['name'] ) && $xtfe_events->common->has_authorized_user_token() ){
                                        $fbauthname = sanitize_text_field( $xtfe_fb_authorize_user['name'] );
                                        if( $fbauthname != '' ){
                                           printf( __(' ( Authorized as: %s )', 'import-facebook-events'), '<b>'.$fbauthname.'</b>' );
                                        }
                                    }
                                    ?>
                                </form>

                                <span class="xtfe_small">
                                    <?php _e( 'Please authorize your facebook account for import facebook events. Please authorize with account which you have used for create an facebook app.','import-facebook-events' ); ?>
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php
        }
        ?>

    	<form method="post" id="xtfe_setting_form">
            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row">
                            <?php _e( 'Facebook App ID','xt-facebook-events' ); ?> : 
                        </th>
                        <td>
                            <input class="facebook_app_id" name="xtfe[facebook_app_id]" type="text" value="<?php echo $facebook_app_id; ?>" />
                            <span class="xtei_small">
                                <?php
                                printf( '%s <a href="https://developers.facebook.com/apps" target="_blank">%s</a>', 
                                    __('You can veiw or create your Facebook Apps', 'xt-facebook-events'),
                                    __('from here', 'xt-facebook-events')
                                 );
                                ?>
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <?php _e( 'Facebook App secret','xt-facebook-events' ); ?> : 
                        </th>
                        <td>
                            <input class="facebook_app_secret" name="xtfe[facebook_app_secret]" type="text" value="<?php echo $facebook_app_secret; ?>" />
                            <span class="xtei_small">
                                <?php
                                printf( '%s <a href="https://developers.facebook.com/apps" target="_blank">%s</a>', 
                                    __('You can veiw or create your Facebook Apps', 'xt-facebook-events'),
                                    __('from here', 'xt-facebook-events')
                                 );
                                ?>
                            </span>
                        </td>
                    </tr>       
                </tbody>
            </table>
            <br/>
            <div class="xtfe_element">
                <input type="hidden" name="xtfe_action" value="xtfe_save_settings" />
                <?php wp_nonce_field( 'xtfe_setting_form_nonce_action', 'xtfe_setting_form_nonce' ); ?>
                <input type="submit" class="button-primary xtei_submit_button" style=""  value="<?php esc_attr_e( 'Save Settings', 'xt-facebook-events' ); ?>" />
            </div>
            </form>
    </div>
</div>
