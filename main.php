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



    bender_add_body_class('home');





    $buttonClass = '';

    $listClass   = '';

    if(bender_show_as() == 'gallery'){

          $listClass = 'listing-grid';

          $buttonClass = 'active';

    }

?>

<?php osc_current_web_theme_path('header.php') ; ?>

<div class="clear"></div>

<div class="latest_ads">

<h1><strong><?php _e('Latest Listings', 'bender') ; ?></strong></h1>

 <?php if( osc_count_latest_items() == 0) { ?>

    <div class="clear"></div>

    <p class="empty"><?php _e("There aren't listings available at this moment", 'bender'); ?></p>

<?php } else { ?>

    <div class="actions">

      <span class="doublebutton <?php echo $buttonClass; ?>">

           <a href="<?php echo osc_base_url(true); ?>?sShowAs=list" class="list-button" data-class-toggle="listing-grid" data-destination="#listing-card-list"><span><?php _e('List', 'bender'); ?></span></a>

           <a href="<?php echo osc_base_url(true); ?>?sShowAs=gallery" class="grid-button" data-class-toggle="listing-grid" data-destination="#listing-card-list"><span><?php _e('Grid', 'bender'); ?></span></a>

      </span>

      <div class="clear"></div>

    </div>

    <?php

    View::newInstance()->_exportVariableToView("listType", 'latestItems');

    View::newInstance()->_exportVariableToView("listClass",$listClass);

    osc_current_web_theme_path('loop.php');

    ?>

    <div class="clear"></div>

    <?php if( osc_count_latest_items() == osc_max_latest_items() ) { ?>

        <p class="see_more_link"><a href="<?php echo osc_search_show_all_url() ; ?>">

            <strong><?php _e('See all listings', 'bender') ; ?> &raquo;</strong></a>

        </p>

    <?php } ?>

<?php } ?>

</div>

</div><!-- main -->

<div id="sidebar">

  <!-- Load Recent Ads -->
  <div class="recent_ads widget-box">

    <h3><strong>What's currently happening at cuba.my ?</strong></h3>

    <div class="recent_ads_block">

    <?php

        $recent_ads_array = osc_list_recent_ads();

        foreach($recent_ads_array as $recent_ads => $key) { ?>

            <div class="recent_ads_post">

                <div class="recent_ads_image left"><img src="<?php echo osc_current_web_theme_url('images/')?>recent_ads.jpg" width="35" /></div>

                <div class="recent_ads_desc">

                <p class="ads_title"><a href="<?php echo osc_item_url_ns($key['pk_i_id']) ?>"><?php echo osc_title_prefix($key['pk_i_id']) . ' ' . $key['s_title'] ?></a></p>

                <p class="ads_location"><?php echo ($key['s_city']? $key['s_city']:'') . ' ' . ($key['s_region']? $key['s_region']:'')?></p>

                <div class="clear"></div>

                </div>

            </div>

         <?php } ?>

    </div>

  </div>

  <script>

  $(document).ready(function(){

    var timer;

    $('.recent_ads_block').scrollTop(1E10);

    function startLoopAds() {

      timer = setInterval(function(){

        /// call your function here

        $('.recent_ads_block').animate({ scrollTop: $(".recent_ads_block").scrollTop() - 55 }, 'slow');

      }, 4000);

    }

    $('.recent_ads_block').hover(function (ev) {

      clearInterval(timer);

    }, function (ev) {

      startLoopAds();

    });

    startLoopAds();

  });

  </script>
  <!-- Load Recent Ads - END -->

  <iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fcuba.my&amp;width=300&amp;height=258&amp;colorscheme=light&amp;show_faces=true&amp;header=false&amp;stream=false&amp;show_border=true&amp;appId=692199897488747" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100%; height:258px;" allowTransparency="true"></iframe>



    <div class="widget-box" style="margin-top:30px;">

        <?php if(osc_count_list_regions() > 0 ) { ?>

        <div class="box location">

            <h3><strong><?php _e("Location", 'bender') ; ?></strong></h3>

            <ul>

            <?php while(osc_has_list_regions() ) { ?>

                <li><a href="<?php echo osc_list_region_url(); ?>"><?php echo osc_list_region_name() ; ?> <em>(<?php echo osc_list_region_items() ; ?>)</em></a></li>

            <?php } ?>

            </ul>

        </div>

        <?php } ?>

    </div>

</div>

<div class="clear"><!-- do not close, use main clossing tag for this case -->

<?php osc_current_web_theme_path('footer.php') ; ?>