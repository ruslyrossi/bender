<?php
    /*
     *      Osclass – software for creating and publishing online classified
     *                           advertising platforms
     *
     *                        Copyright (C) 2013 OSCLASS
     *
     *       This program is free software: you can redistribute it and/or
     *     modify it under the terms of the GNU Affero General Public License
     *     as published by the Free Software Foundation, either version 3 of
     *            the License, or (at your option) any later version.
     *
     *     This program is distributed in the hope that it will be useful, but
     *         WITHOUT ANY WARRANTY; without even the implied warranty of
     *        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
     *             GNU Affero General Public License for more details.
     *
     *      You should have received a copy of the GNU Affero General Public
     * License along with this program.  If not, see <http://www.gnu.org/licenses/>.
     */

    // meta tag robots
    osc_add_hook('header','bender_follow_construct');

    osc_enqueue_script('fancybox');
    osc_enqueue_style('fancybox', osc_current_web_theme_url('js/fancybox/jquery.fancybox.css'));
    osc_enqueue_script('jquery-validate');

    bender_add_body_class('item');
    osc_add_hook('after-main','sidebar');
    function sidebar(){
        osc_current_web_theme_path('item-sidebar.php');
    }

    $location = array();
    if( osc_item_city_area() !== '' ) {
        $location[] = osc_item_city_area();
    }
    if( osc_item_city() !== '' ) {
        $location[] = osc_item_city();
    }
    if( osc_item_region() !== '' ) {
        $location[] = osc_item_region();
    }
    if( osc_item_country() !== '' ) {
        $location[] = osc_item_country();
    }

    osc_current_web_theme_path('header.php');
?>

<div id="item-content">

        <h1>
    <?php if(price_status(osc_category_id()) == true) { ?>
          <span class="price"><?php echo osc_item_formated_price(); ?></span>
    <?php } ?>

        <strong><?php echo osc_title_prefix(osc_item_id()); ?> <?php echo osc_item_title(); ?></strong></h1>
        <div class="item-header">
            <div>
                <?php if ( osc_item_pub_date() !== '' ) { printf( __('<strong class="publish">Published date</strong>: %1$s', 'bender'), osc_format_date( osc_item_pub_date() ) ); } ?>
            </div>
            <div>
                <?php if ( osc_item_mod_date() !== '' ) { printf( __('<strong class="update">Modified date:</strong> %1$s', 'bender'), osc_format_date( osc_item_mod_date() ) ); } ?>
            </div>
            <ul id="item_location">
                <li><strong><?php _e("Location", 'bender'); ?></strong>: <?php echo implode(', ', $location); ?></li>
            </ul>
        </div>
        <?php if(osc_is_web_user_logged_in() && osc_logged_user_id()==osc_item_user_id()) { ?>
            <p id="edit_item_view">
                <strong>
                    <a href="<?php echo osc_item_edit_url(); ?>" rel="nofollow"><?php _e('Edit item', 'bender'); ?></a>
                </strong>
            </p>
        <?php } ?>


    <?php if( osc_images_enabled_at_items() ) { ?>
        <?php
        if( osc_count_item_resources() > 0 ) {
            $i = 0;
        ?>
        <div class="item-photos">
            <a href="<?php echo osc_resource_url(); ?>" class="main-photo" title="<?php _e('Image', 'bender'); ?> <?php echo $i+1;?> / <?php echo osc_count_item_resources();?>">
                <img src="<?php echo osc_resource_url(); ?>" alt="<?php echo osc_item_title(); ?>" title="<?php echo osc_item_title(); ?>" />
            </a>
            <div class="thumbs">
                <?php for ( $i = 0; osc_has_item_resources(); $i++ ) { ?>
                <a href="<?php echo osc_resource_url(); ?>" rel="image_group" title="<?php _e('Image', 'bender'); ?> <?php echo $i+1;?> / <?php echo osc_count_item_resources();?>">
                    <img src="<?php echo osc_resource_thumbnail_url(); ?>" width="84" alt="<?php echo osc_item_title(); ?>" title="<?php echo osc_item_title(); ?>" />
                </a>
                <?php } ?>
            </div>
        </div>
        <?php } ?>
    <?php } ?>
    <div id="description">
        <p><?php echo osc_item_description(); ?></p>
        <div id="custom_fields">
            <?php if( osc_count_item_meta() >= 1 ) { ?>
                <br />
                <div class="meta_list">

                <table class="table_info">
                  <tbody>
            <?php while ( osc_has_item_meta() ) { ?>
                            <?php if(osc_item_meta_value()!='') { ?>
                            <tr>
                            <td width="150"><?php echo osc_item_meta_name(); ?></td>
                            <td><?php echo osc_item_meta_value(); ?></td>
                            </tr>
                            <?php } ?>
                        <?php } ?>
                     </tbody>
                </table>

                </div>
            <?php } ?>
        </div>
        <?php osc_run_hook('item_detail', osc_item() ); ?>
        <p class="contact_button">
            <?php if( !osc_item_is_expired () ) { ?>
            <?php if( !( ( osc_logged_user_id() == osc_item_user_id() ) && osc_logged_user_id() != 0 ) ) { ?>
                <?php     if(osc_reg_user_can_contact() && osc_is_web_user_logged_in() || !osc_reg_user_can_contact() ) { ?>
<div align="center">
<!-- SHARE BUTTONS -->
<!-- Email -->
<a href="<?php echo osc_item_send_friend_url(); ?>" target="_blank" rel="nofollow" id="share-btn"><img src="http://i62.photobucket.com/albums/h101/CubaDotMy/Share%20Button%20Icons/email_zps040a6f7a.png"></a>
<!-- Facebook -->
<a href="http://www.facebook.com/sharer.php?u=<?php echo osc_item_url() ; ?>" target="_blank" id="share-btn"><img src="http://i62.photobucket.com/albums/h101/CubaDotMy/Share%20Button%20Icons/facebook_zps7ef40d6e.png"></a>
<!-- Twitter -->
<a href="http://twitter.com/share?url=<?php echo osc_item_url() ; ?> <?php echo osc_item_title(); ?>" target="_blank" id="share-btn"><img src="http://i62.photobucket.com/albums/h101/CubaDotMy/Share%20Button%20Icons/twitter_zpsbd840c6e.png"></a>
<!-- Google+ -->
<a href="https://plus.google.com/share?url=<?php echo osc_item_url() ; ?>" target="_blank" id="share-btn"><img src="http://i62.photobucket.com/albums/h101/CubaDotMy/Share%20Button%20Icons/google_zps4e2dbed7.png"></a>
<!-- SHARE BUTTONS -->
</div>
                <?php     } ?>
            <?php     } ?>
            <?php } ?>
        </p>
        <?php osc_run_hook('location'); ?>
    </div>
    <!-- plugins -->
    <div id="useful_info" class="bordered-box">
        <h2><?php _e('Useful information', 'bender'); ?></h2>
        <ul>
            <li><?php _e('Avoid scams by acting locally or paying with PayPal', 'bender'); ?></li>
            <li><?php _e('Never pay with Western Union, Moneygram or other anonymous payment services', 'bender'); ?></li>
            <li><?php _e('Don\'t buy or sell outside of your country. Don\'t accept cashier cheques from outside your country', 'bender'); ?></li>
            <li><?php _e('This site is never involved in any transaction, and does not handle payments, shipping, guarantee transactions, provide escrow services, or offer "buyer protection" or "seller certification"', 'bender'); ?></li>
        </ul>
    </div>

        <?php related_listings(); ?>
        <?php if( osc_count_items() > 0 ) { ?>
        <div class="similar_ads">
            <h2><?php _e('Related listings', 'bender'); ?></h2>
            <?php
            View::newInstance()->_exportVariableToView("listType", 'items');
            osc_current_web_theme_path('loop.php');
            ?>
            <div class="clear"></div>
        </div>
    <?php } ?>
    <?php if( osc_comments_enabled() ) { ?>
        <?php if( osc_reg_user_post_comments () && osc_is_web_user_logged_in() || !osc_reg_user_post_comments() ) { ?>
        <div id="comments">
            <h2><?php _e('Comments', 'bender'); ?></h2>
            <ul id="comment_error_list"></ul>
            <?php CommentForm::js_validation(); ?>
            <?php if( osc_count_item_comments() >= 1 ) { ?>
                <div class="comments_list">
                    <?php while ( osc_has_item_comments() ) { ?>
                        <div class="comment">
                            <h3><strong><?php echo osc_comment_title(); ?></strong> <em><?php _e("by", 'bender'); ?> <?php echo osc_comment_author_name(); ?>:</em></h3>
                            <p><?php echo nl2br( osc_comment_body() ); ?> </p>
                            <?php if ( osc_comment_user_id() && (osc_comment_user_id() == osc_logged_user_id()) ) { ?>
                            <p>
                                <a rel="nofollow" href="<?php echo osc_delete_comment_url(); ?>" title="<?php _e('Delete your comment', 'bender'); ?>"><?php _e('Delete', 'bender'); ?></a>
                            </p>
                            <?php } ?>
                        </div>
                    <?php } ?>
                    <div class="paginate" style="text-align: right;">
                        <?php echo osc_comments_pagination(); ?>
                    </div>
                </div>
            <?php } ?>
            <div class="form-container form-horizontal">
                <div class="header">
                    <h3><?php _e('Leave your comment (spam and offensive messages will be removed)', 'bender'); ?></h3>
                </div>
                <div class="resp-wrapper">
                    <form action="<?php echo osc_base_url(true); ?>" method="post" name="comment_form" id="comment_form">
                        <fieldset>

                            <input type="hidden" name="action" value="add_comment" />
                            <input type="hidden" name="page" value="item" />
                            <input type="hidden" name="id" value="<?php echo osc_item_id(); ?>" />
                            <?php if(osc_is_web_user_logged_in()) { ?>
                                <input type="hidden" name="authorName" value="<?php echo osc_esc_html( osc_logged_user_name() ); ?>" />
                                <input type="hidden" name="authorEmail" value="<?php echo osc_logged_user_email();?>" />
                            <?php } else { ?>
                                <div class="control-group">
                                    <label class="control-label" for="authorName"><?php _e('Your name', 'bender'); ?></label>
                                    <div class="controls">
                                        <?php CommentForm::author_input_text(); ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="authorEmail"><?php _e('Your e-mail', 'bender'); ?></label>
                                    <div class="controls">
                                        <?php CommentForm::email_input_text(); ?>
                                    </div>
                                </div>
                            <?php }; ?>
                            <div class="control-group">
                                <label class="control-label" for="title"><?php _e('Title', 'bender'); ?></label>
                                <div class="controls">
                                    <?php CommentForm::title_input_text(); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="body"><?php _e('Comment', 'bender'); ?></label>
                                <div class="controls textarea">
                                    <?php CommentForm::body_input_textarea(); ?>
                                </div>
                            </div>
                            <div class="actions">
                                <button type="submit"><?php _e('Send', 'bender'); ?></button>
                            </div>

                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
        <?php } ?>
    <?php } ?>
</div>
<?php osc_current_web_theme_path('footer.php') ; ?>