<div class="wrap">
	<h2><?php echo __( self::$plugin_name, 'user-age-calculator' ); ?></h2>

	<div id="uac-message"></div>

	<h2 class="nav-tab-wrapper uac-tabs">
		<a class="nav-tab <?php echo ( 1 === $active_tab ) ? 'nav-tab-active' : ''; ?>" href="<?php echo admin_url( 'options-general.php?page=' . self::$plugin_slug ); ?>"><?php echo __( 'Calculate To Current Date', 'user-age-calculator' ); ?></a>
		<a class="nav-tab <?php echo ( 2 === $active_tab ) ? 'nav-tab-active' : ''; ?>" href="<?php echo admin_url( 'options-general.php?page=' . self::$plugin_slug ); ?>"><?php echo __( 'Calculate To Given Date', 'user-age-calculator' ); ?></a>
		<a class="nav-tab <?php echo ( 3 === $active_tab ) ? 'nav-tab-active' : ''; ?>" href="<?php echo admin_url( 'options-general.php?page=' . self::$plugin_slug ); ?>"><?php echo __( 'About', 'user-age-calculator' ); ?></a>
	</h2>

	<input type="hidden" name="uac_current_tab" id="uac_current_tab" value="1">

	<section class="uac-section">
		<p>
			<b><?php echo __( 'Use the following shortcode to display age calculator', 'user-age-calculator' ); ?></b>
		</p>

		<input type="text" class="uac-shortcode-input" value="[user-age-calculator template=1]" id="uac-shortcode1">
		<button class="button" onclick="uac_copy_shortcode( 'uac-shortcode1' )">Copy Shortcode</button>

	</section>

	<section class="uac-section">
		<p>
			<b><?php echo __( 'Use the following shortcode to display age calculator', 'user-age-calculator' ); ?></b>
		</p>

		<input type="text" class="uac-shortcode-input" value="[user-age-calculator template=2]" id="uac-shortcode2">
		<button class="button" onclick="uac_copy_shortcode( 'uac-shortcode2' )">Copy Shortcode</button>

	</section>

	<section class="uac-section">
		<div class="uac-about">

			<p><b><?php echo __( 'User age calculator', 'user-age-calculator' ); ?></b></p>

			<p><?php echo __( 'Version: 1.0.1', 'user-age-calculator' ); ?></p>

			<p><a href="http://caketech.in/" target="_blank"><?php echo __( 'Author\'s Website', 'user-age-calculator' ); ?></a></p>

			<p><?php echo __( 'If you have any feedback please tell us. We love to improve our service.', 'user-age-calculator' ); ?></p>

			<p><a href="http://caketech.in/provide-feedback/" target="_blank"><?php echo __( 'Provide Feedback', 'user-age-calculator' ); ?></a></p>
		</div>

	</section>

	<div id="uac-instructions">
		<h4 class="heading">Instructions</h4>
		<ul>
			<li>In the navigation menu, click "Posts" or "Pages".</li>
			<li>Edit the Post or Page where you want to add the age calculator widget.</li>
			<li>Paste the shortcode at your preferred location inside the text editor.</li>
			<li>Click "Update" to save your changes.</li>
		</ul>
	</div>
</div>



