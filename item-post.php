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
    osc_add_hook('header','bender_nofollow_construct');

    osc_enqueue_script('jquery-validate');
    bender_add_body_class('item item-post');
    $action = 'item_add_post';
    $edit = false;
    if(Params::getParam('action') == 'item_edit'){
        $action = 'item_edit_post';
        $edit = true;
    }
	
	// load custom function
	include('custom.php');

    ?>
<?php osc_current_web_theme_path('header.php') ; ?>
<?php ItemForm::location_javascript_new(); ?>

    <div class="form-container form-horizontal">
        <div class="resp-wrapper">
        	
            <form name="item" action="<?php echo osc_base_url(true);?>" method="post" enctype="multipart/form-data" id="item-post">
             
            <div class="header">
                <h1 class="left"><?php _e('Publish a listing', 'bender'); ?></h1>
                
                <div class="right">
                    <button type="submit" class="ui-button ui-button-middle ui-button-main"><?php if($edit) { _e("Update", 'bender'); } else { _e("Publish", 'bender'); } ?></button>
                </div>
                
                <div class="clear"></div>
                     
            </div>
            
            <?php 
			// Remember Form Data
			$form_array = $_SESSION;
			
			if ($_SERVER['REMOTE_ADDR'] == '203.106.201.195') {
			
				//echo '<pre>', print_r($form_array['form']), '</pre>';
			
			}
			
			//echo '<pre>', print_r($form_array['form_post']['s_youtube']), '</pre>';
			$description = (isset($form_array['form']['description']['en_US'])? $form_array['form']['description']['en_US']:'Package includes:
Warranty:
Dealing method:
Age of item:

---

Item(s) conditions:
Reason for sale:');
			$regionId = (isset($form_array['form']['regionId'])? $form_array['form']['regionId']:'');
			$s_youtube = (isset($form_array['form_post']['s_youtube'])? $form_array['form_post']['s_youtube']:'');
			
			// Unseet session
			unset($_SESSION['form']['description']['en_US']);
			unset($_SESSION['form']['regionId']);
			
			?>
            
            <ul id="error_list"></ul>
            
                    <fieldset>
                    <input type="hidden" name="action" value="<?php echo $action; ?>" />
                        <input type="hidden" name="page" value="item" />
                    <?php if($edit){ ?>
                        <input type="hidden" name="id" value="<?php echo osc_item_id();?>" />
                        <input type="hidden" name="secret" value="<?php echo osc_item_secret();?>" />
                    <?php } ?>
                        <h2><?php _e('General Information', 'bender'); ?></h2>
                        <div class="control-group">
                            <label class="control-label" for="select_1"><?php _e('Category', 'bender'); ?></label>
                            <div class="controls">
                                <?php ItemForm::category_select(null, null, __('Select a category', 'bender'), null, $_GET['curr_cat_id']); ?>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="title[<?php echo osc_locale_code(); ?>]"><?php _e('Title', 'bender'); ?></label>
                            <div class="controls">
                                <?php ItemForm::title_input('title',osc_locale_code(), osc_esc_html( bender_item_title() )); ?>
                            </div>
                        </div>
                        
                        <div class="control-group">
                            <label class="control-label" for="description[<?php echo osc_locale_code(); ?>]"><?php _e('Description', 'bender'); ?></label>
                            <div class="controls">
                                 <?php //ItemForm::description_textarea('description',osc_locale_code(), osc_esc_html( bender_item_description() )); ?>
                                
                                 <?php 
								  if($edit) {
									ItemForm::description_textarea('description',osc_locale_code(), osc_esc_html( bender_item_description() ));
								  } else {
								 	ItemForm::description_textarea('description',osc_locale_code(), $description);
								  }
								  ?>
                                
                            </div>
                        </div>
                        
                        <?php if( osc_price_enabled_at_items() ) { ?>
                        <div class="control-group">
                            <label class="control-label" for="price"><?php _e('Price', 'bender'); ?> (<?php ItemForm::currency_select(); ?>)</label>
                            <div class="controls">
                                <?php ItemForm::price_input_text(); ?>
                            </div>
                        </div>
                        <?php } ?>
                        
                        <div class="control-group">
                        	 <label class="control-label" for="images"><?php _e('Images', 'bender'); ?></label>
                             <div class="controls">
								<?php if( osc_images_enabled_at_items() ) {
                                    ItemForm::ajax_photos();
                                 } ?>
                                <p class="remark">*Photo can drastically increase your chances.</p> 
                            </div>
                        </div>
 
                        <div class="clear"></div>
                        
                        <?php
						  if($edit) {
                            ItemForm::plugin_edit_item();
                        } else {
                            ItemForm::plugin_post_item();
                        }
						?>        
                        
                                      
                        <div class="box location">
                            <h2><?php _e('Listing Location', 'bender'); ?></h2>

                            <div class="control-group">
                                <label class="control-label" for="country"><?php _e('Country', 'bender'); ?></label>
                                <div class="controls">
                                    <?php ItemForm::country_select(osc_get_countries(), osc_user()); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="region"><?php _e('Region', 'bender'); ?></label>
                                <div class="controls">
                                
                                <?php if($edit) { ?>
                                  <div id="region_autocomplete">
                                  <?php ItemForm::region_text(osc_user()); ?> 
                                  </div>
                                <?php } else { ?>   
                              	  <div id="region_autocomplete">
                                  <?php ItemForm::region_text(osc_user()); ?>  
                                  </div>
                                  
                                  <div id="region_select" style="display:none">
                                  <select name="regionId" id="regionId">
									<?php
                                    $region_array = get_region();
                                    foreach ($region_array as $region) { ?>
                                        <option value="<?php echo $region['pk_i_id']; ?>" <?php echo ($regionId == $region['pk_i_id']? 'selected="selected"':'') ?>><?php echo $region['s_name']; ?></option>
                                    <?php    
                                    }
                                    ?>
                                  </select>
                                  </div>
                                  
                                  
                                  
                                <?php } ?>  
                                  
                                  <script>
								  $("#countryId").change(function(){
									  var val = $(this).val();
									  if(val == 'MY') {
										  $("#region_select").show();
										  $("#region_autocomplete").hide();
									  }
									  
									  //default: set after countryId was change
									  var regionIdVal = $("select#regionId option:first-child").val();
									   $("input#regionId").val(regionIdVal);
									  
								   });
								   
								   $("select#regionId").change(function(){
									  var value = $(this).val();
									  console.log(value);
									  $("input#regionId").val(value);
								   });
								   
									<?php if($edit) { ?>
									<?php } else { ?>   
									$('#countryId').val('MY').trigger('change');
									<?php } ?>

								  </script>
                                  
                                </div>
                                    </div>
                                    <div class="control-group">
                                <label class="control-label" for="city"><?php _e('City Area', 'bender'); ?></label>
                                <div class="controls">
                                    <?php ItemForm::city_text(osc_user()); ?>
                                </div>
                            </div>
                            
							<?php /*?> <div class="control-group" style="display:none">
                                <label class="control-label" for="cityArea"><?php _e('City Area', 'bender'); ?></label>
                                <div class="controls">
                                    <?php ItemForm::city_area_text(osc_user()); ?>
                                </div>
                            </div><?php */?>
                            
                            <div class="control-group">
                                <label class="control-label" for="address"><?php _e('Address', 'bender'); ?></label>
                                <div class="controls">
                                  <?php ItemForm::address_text(osc_user()); ?>
                                </div>
                            </div>
   
                            
                        </div>
                        <!-- seller info -->
                        <?php if(!osc_is_web_user_logged_in() ) { ?>
                        <div class="box seller_info">
                            <h2><?php _e("Seller's information", 'bender'); ?></h2>
                            <div class="control-group">
                                <label class="control-label" for="contactName"><?php _e('Name', 'bender'); ?></label>
                                <div class="controls">
                                    <?php ItemForm::contact_name_text(); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="contactEmail"><?php _e('E-mail', 'bender'); ?></label>
                                <div class="controls">
                                    <?php ItemForm::contact_email_text(); ?> <span style="font-size:12px; font-style:italic">(Either E-mail or Phone)</span>
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <label class="control-label" for="contactPhone"><?php _e('or Phone', 'bender'); ?></label>
                                <div class="controls">
                                <?php ItemForm::contact_phone_text(); ?>
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <div class="controls checkbox" style="line-height:16px;">
                                    <?php ItemForm::show_email_checkbox(); ?> <label for="showEmail"><?php _e('Show E-mail on the listing page', 'bender'); ?></label>
                                </div>
                                <div class="controls checkbox" style="line-height:16px;">
                                    <?php ItemForm::show_phone_checkbox(); ?> <label for="showPhone"><?php _e('Show Phone on the listing page', 'bender'); ?></label>
                                </div>
                            </div>          
                        </div>
                        
                        <!-- here -->
                        
                        
                        <?php
                        } else {
                      
                        ?>
                        
                      		<div class="control-group">
                                <label class="control-label" for="contactEmail"><?php _e('E-mail', 'bender'); ?></label>
                                <div class="controls">
                                    <?php ItemForm::contact_email_text(); ?> <span style="font-size:12px; font-style:italic">(Either E-mail or Phone)</span>
                                </div>
                            </div>
                        
                            <div class="control-group">
                                <label class="control-label" for="contactPhone"><?php _e('or Phone', 'bender'); ?></label>
                                <div class="controls">
                                <?php ItemForm::contact_phone_text(); ?>
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <div class="controls checkbox" style="line-height:16px;">
                                    <?php ItemForm::show_email_checkbox(); ?> <label for="showEmail"><?php _e('Show E-mail on the listing page', 'bender'); ?></label>
                                </div>
                                <div class="controls checkbox" style="line-height:16px;">
                                    <?php ItemForm::show_phone_checkbox(); ?> <label for="showPhone"><?php _e('Show Phone on the listing page', 'bender'); ?></label>
                                </div>
                            </div> 
                                                    
                        <?php } ?>
                        <div class="control-group">
                            <?php if( osc_recaptcha_items_enabled() ) { ?>
                                <div class="controls">
                                    <?php osc_show_recaptcha(); ?>
                                </div>
                            <?php }?>
                            <div class="controls">
                                <button type="submit" class="ui-button ui-button-middle ui-button-main"><?php if($edit) { _e("Update", 'bender'); } else { _e("Publish", 'bender'); } ?></button>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
        
						<script>
						//setup before functions
						var typingTimer;                //timer identifier
						var doneTypingInterval = 500;  //time in ms, 5 second for example
						
						/* if user key-in Phone number, auto select 'Show Phone on the listing page' */
						$('#contactEmail').keyup(function(){
							clearTimeout(typingTimer);
							if ($('#contactEmail').val) {
								typingTimer = setTimeout(doneTyping, doneTypingInterval);
							}
						});
						
						// if user paste Phone number
						$("#contactEmail").bind('paste', function(e) {
							doneTyping();
						});
						
						/* if user key-in Phone number, auto select 'Show Phone on the listing page' */
						$('#contactPhone').keyup(function(){
							clearTimeout(typingTimer);
							if ($('#contactPhone').val) {
								typingTimer = setTimeout(doneTyping, doneTypingInterval);
							}
						});
						
						// if user paste
						$("#showEmail").bind('paste', function(e) {
							doneTyping();
						});
						
						$("#showPhone").bind('paste', function(e) {
							doneTyping();
						});
						
						//user is "finished typing," do something
						function doneTyping() {
							
							var email = $('#contactEmail').val();
							var email_length = email.length;
							
							var phone = $('#contactPhone').val();
							var phone_length = phone.length;
							
							// check length
							if(phone_length > 7 && email_length < 1) {
								$('#showPhone').prop('checked', true);
								$('#showPhone').parent().hide();
							} else {
								$('#showPhone').prop('checked', false);
								$('#showPhone').parent().show();
							}
							
							if(email_length > 5) {
								$('#showEmail').prop('checked', true);
							} else {
								$('#showEmail').prop('checked', false);
							}
							
						}

						</script>       
        
        
        <script type="text/javascript">
    <?php if(osc_locale_thousands_sep()!='' || osc_locale_dec_point() != '') { ?>
    $(document).ready(function(){
		
		// hide attribute
		
		//$('.personal_attribute').hide();
		
		var labelDefault = $('#catId :selected').parent().attr('label');
		
		if(labelDefault == 'Jobs' || labelDefault == 'Websites' || labelDefault == 'Business') {
				$('label[for="price"]').hide();
				$('label[for="price"] + div').hide();
			
		} else if(labelDefault == 'Personals') {
			$('.personal_attribute').show();
			$('label[for="price"]').hide();
			$('label[for="price"] + div').hide();
			
		} 
		
		 $("#catId").change(function(){
		 	var label=$('#catId :selected').parent().attr('label');
			
			console.log(label);
			
			if(label == 'Jobs' || label == 'Websites' || label == 'Business') {
				$('label[for="price"]').hide();
				$('label[for="price"] + div').hide();
			
			} else if(label == 'Personals') {
				$('.personal_attribute').show();
				$('label[for="price"]').hide();
				$('label[for="price"] + div').hide();
				
			} else {
				$('label[for="price"]').show();
				$('.personal_attribute').hide();
			}
			
		 });
		
		
        $("#price").blur(function(event) {
            var price = $("#price").prop("value");
            <?php if(osc_locale_thousands_sep()!='') { ?>
            while(price.indexOf('<?php echo osc_esc_js(osc_locale_thousands_sep());  ?>')!=-1) {
                price = price.replace('<?php echo osc_esc_js(osc_locale_thousands_sep());  ?>', '');
            }
            <?php }; ?>
            <?php if(osc_locale_dec_point()!='') { ?>
            var tmp = price.split('<?php echo osc_esc_js(osc_locale_dec_point())?>');
            if(tmp.length>2) {
                price = tmp[0]+'<?php echo osc_esc_js(osc_locale_dec_point())?>'+tmp[1];
            }
            <?php }; ?>
            $("#price").prop("value", price);
        });
    });
    <?php }; ?>
</script>



<?php osc_current_web_theme_path('footer.php'); ?>