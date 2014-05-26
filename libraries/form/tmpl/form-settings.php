<?php
if ( ! empty( $_POST[ 'ig_uniform_config' ] ) ) {
	foreach ( $_POST[ 'ig_uniform_config' ] as $key => $value ) {
		if ( get_option( $key ) !== false ) {
			// The option already exists, so we just update it.
			update_option( $key, $value );
		}
		else {
			// The option hasn't been added yet. We'll add it with $autoload set to 'no'.
			$deprecated = null;
			$autoload = 'no';
			add_option( $key, $value, $deprecated, $autoload );
		}
	}
}
$loadBootstrapCss = get_option( 'ig_uniform_load_bootstrap_css', 1 );
$checkLoadCssBootstrap = '';
if ( $loadBootstrapCss != '0' && $loadBootstrapCss != 0 ) {
	$checkLoadCssBootstrap = 'checked="checked" ';
}
$loadBootstrapJs = get_option( 'ig_uniform_load_bootstrap_js', 1 );

$checkLoadJsBootstrap = '';
if ( $loadBootstrapJs != '0' && $loadBootstrapJs != 0 ) {
	$checkLoadJsBootstrap = 'checked="checked" ';
}
$username = '';
$password = '';
$customer_account = get_option( 'ig_customer_account', null );

if ( ! empty( $customer_account ) ) {
	$username = $customer_account[ 'username' ];
	$password = $customer_account[ 'password' ];
}
?>
<div class="wrap">
	<h2><?php echo '' . __( 'IG ContactForm Settings', IG_UNIFORM_TEXTDOMAIN );?></h2>
	<?php if ( ! empty( $_POST ) ) { ?>
	<div class="updated below-h2" id="message"><p>Settings updated.</p></div>
	<?php } ?>
	<form method="POST" id="ig_uniform_settings">
		<table class="form-table">
			<tbody>
			<tr valign="top">
				<th scope="row">
					<label><?php echo '' . __( 'Load Bootstrap Assets', IG_UNIFORM_TEXTDOMAIN );?></label>
				</th>
				<td>
					<label class="auto-get-data">
						<input type="checkbox" <?php echo '' . $checkLoadJsBootstrap;?> value="1" id="ig_uniform_load_bootstrap_js"> <?php echo '' . __( 'JS', IG_UNIFORM_TEXTDOMAIN );?>
						<input type="hidden" value="<?php echo '' . $loadBootstrapJs;?>" name="ig_uniform_config[ig_uniform_load_bootstrap_js]" id="ig_config_uniform_load_bootstrap_js" />
					</label>
					<br>
					<label class="auto-get-data">
						<input type="checkbox" <?php echo '' . $checkLoadCssBootstrap;?> value="1" id="ig_uniform_load_bootstrap_css"> <?php echo '' . __( 'CSS', IG_UNIFORM_TEXTDOMAIN );?>
						<input type="hidden" value="<?php echo '' . $loadBootstrapCss;?>" name="ig_uniform_config[ig_uniform_load_bootstrap_css]" id="ig_config_uniform_load_bootstrap_css" />
					</label>

					<p class="description"><?php echo '' . __( 'You should choose NOT to load Bootstrap JS / CSS if your theme or some other plugin installed on your website already loaded it.', IG_UNIFORM_TEXTDOMAIN );?></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php echo '' . __( 'InnoGears Customer Account', IG_UNIFORM_TEXTDOMAIN );?></th>
				<td>
					<div>
						<label for="username">
							<?php echo '' . __( 'Username:', IG_UNIFORM_TEXTDOMAIN );?>
							<input type="text" autocomplete="off" name="ig_uniform_config[ig_customer_account][username]" id="username" class="input-xlarge" value="<?php echo '' . $username?>">
						</label>
						<label for="password">
							<input type="password" autocomplete="off" name="ig_uniform_config[ig_customer_account][password]" id="password" class="input-xlarge" value="<?php echo '' . $password?>">
						</label>

						<p class="description">
							<?php echo '' . __( 'Insert the customer account you registered on:', IG_UNIFORM_TEXTDOMAIN );?>
							<a target="_blank" href="http://www.innogears.com">www.innogears.com</a>. <?php echo '' . __( 'This account is only required when you want to update commercial plugins purchased from innogears.com.', IG_UNIFORM_TEXTDOMAIN );?>
						</p>
					</div>
				</td>
			</tr>
			<?php do_action( 'ig_uniform_action_config' );?>
			</tbody>
		</table>
		<p class="submit">
			<input type="submit" value="Save Changes" class="button button-primary" id="submit" name="submit"></p>
	</form>
</div>
<?php
$script = '(function ($) {
	$(".jsn-modal-overlay,.jsn-modal-indicator").remove();
    $("body").append($("<div/>", {
        "class":"jsn-modal-overlay",
        "style":"z-index: 1000; display: inline;"
    })).append($("<div/>", {
        "class":"jsn-modal-indicator",
        "style":"display:block"
    })).addClass("jsn-loading-page");
    $("#ig_uniform_settings label.auto-get-data input:checkbox").change(function(){
		if($(this).is(":checked")){
			$(this).parent().find("input:hidden").val(1);
		}else{
			$(this).parent().find("input:hidden").val(0);
		}
    });
     setTimeout(function () {
        $("#wpbody-content").show();
        $(".jsn-modal-overlay,.jsn-modal-indicator").remove();
   }, 500);
  })(jQuery);';
IG_Init_Assets::inline( 'js', $script );
