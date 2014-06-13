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

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">

    <head>
        <!--Start of Scroll to Top Button-->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="http://yourjavascript.com/1651244511/arrow30.js"></script>
<noscript>Not seeing a <a href="http://www.scrolltotop.com/">Scroll to Top Button</a>? Go to our FAQ page for more info.</noscript>
<!--End of Scroll to Top Button-->

        <!--Start of Zopim Live Chat Script-->
<script type="text/javascript">
window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute('charset','utf-8');
$.src='//v2.zopim.com/?217UmN2pPr4qxIBTGZsNv45tLEyFyJiU';z.t=+new Date;$.
type='text/javascript';e.parentNode.insertBefore($,e)})(document,'script');
</script>
<!--End of Zopim Live Chat Script-->

        <?php osc_current_web_theme_path('common/head.php') ; ?>

    </head>

<body <?php bender_body_class(); ?>>

<div id="header">

    <div class="wrapper">

        <div id="logo">

            <?php echo logo_header(); ?>

        </div>

        <ul class="nav">

            <?php if( osc_is_static_page() || osc_is_contact_page() ){ ?>

                <li class="search"><a class="ico-search icons" data-bclass-toggle="display-search"></a></li>

                <li class="cat"><a class="ico-menu icons" data-bclass-toggle="display-cat"></a></li>

            <?php } ?>

            <?php if( osc_users_enabled() ) { ?>

            <?php if( osc_is_web_user_logged_in() ) { ?>

                <li class="first logged">

                    <span><?php echo sprintf(__('Hi %s', 'bender'), osc_logged_user_name() . '!'); ?>  &middot;</span>

                    <strong><a href="<?php echo osc_user_dashboard_url(); ?>"><?php _e('My account', 'bender'); ?></a></strong> &middot;

                    <a href="<?php echo osc_user_logout_url(); ?>"><?php _e('Logout', 'bender'); ?></a>

                </li>

            <?php } else { ?>

                <li><a id="login_open" href="<?php echo osc_user_login_url(); ?>"><?php _e('Login', 'bender') ; ?></a></li>

                <?php if(osc_user_registration_enabled()) { ?>

                    <li><a href="<?php echo osc_register_account_url() ; ?>"><?php _e('Register for a free account', 'bender'); ?></a></li>

                <?php }; ?>

            <?php } ?>

            <?php } ?>

            <?php if( osc_users_enabled() || ( !osc_users_enabled() && !osc_reg_user_post() )) { ?>

            <li class="publish"><a href="<?php echo osc_item_post_url_in_category() ; ?>"><?php _e("Publish your ad for free", 'bender');?></a></li>

            <?php } ?>

        </ul>

    </div>

    <?php if( osc_is_home_page() || osc_is_static_page() || osc_is_contact_page() ) { ?>

    <form action="<?php echo osc_base_url(true); ?>" method="get" class="search nocsrf">

        <input type="hidden" name="page" value="search"/>

        <div class="main-search">



            <div class="search_pattern">

                <div class="has- input-text">

                        <input type="text" name="sPattern" id="query" class="input-text" value="" placeholder="<?php echo osc_esc_html(__(osc_get_preference('keyword_placeholder', 'bender_theme'), 'bender')); ?>" />

                </div>

            </div>



            <?php  if ( osc_count_categories() ) { ?>

                <div class="cell selector">

                    <?php osc_categories_select('sCategory', null, __('Select a category', 'bender')) ; ?>

                </div>



                <div class="cell selector">

                    <div class="select-box undefined">

                    <select id="sRegion" name="sRegion" style="opacity: 0;">

                        <option value="">Select a state</option>

              <option value="">All</option>

                            <option value="781677">Selangor</option>

                            <option value="781667">Kuala Lumpur</option>

                            <option value="781664">Johor</option>

                            <option value="781665">Kedah</option>

                            <option value="781666">Kelantan</option>

                            <option value="781668">Melaka</option>

                            <option value="781669">Negeri Sembilan</option>

                            <option value="781670">Pahang</option>

                            <option value="781671">Penang</option>

                            <option value="781672">Perak</option>

                            <option value="781673">Perlis</option>

                            <option value="781674">Putrajaya</option>

                            <option value="781675">Sabah</option>

                            <option value="781676">Sarawak</option>

                            <option value="781678">Terengganu</option>

                     </select>

                    </div>



                </div>

                <div class="cell reset-padding">

            <?php  } else { ?>

                <div class="cell">

            <?php  } ?>

                <button class="ui-button ui-button-big js-submit"><?php _e("Search", 'bender');?></button>

            </div>

        </div>

        <div id="message-seach"></div>

    </form>

    <?php } ?>

</div>

<div class="wrapper wrapper-flash">

    <?php

        $breadcrumb = osc_breadcrumb('&raquo;', false, get_breadcrumb_lang());

        if( $breadcrumb !== '') { ?>

        <div class="breadcrumb">

            <?php echo $breadcrumb; ?>

            <div class="clear"></div>

        </div>

    <?php

        }

    ?>

    <?php osc_show_flash_message(); ?>

</div>

<?php osc_run_hook('before-content'); ?>

<div class="wrapper" id="content">

    <?php osc_run_hook('before-main'); ?>
    <?php if (function_exists('carousel')) {carousel();} ?>
    <div id="main">

        <?php osc_run_hook('inside-main'); ?>
