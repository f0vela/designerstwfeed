	<?php 
		if($_POST['twitfeed_hidden'] == 'Y') {
			
			$twitterusername = $_POST['twitterusername'];
			update_option('twitterusername',$twitterusername);
			$numberoftweets = $_POST['numberoftweets'];
			update_option('numberoftweets',$numberoftweets);
			
			$consumerkey = $_POST['consumerkey'];
			update_option('consumerkey',$consumerkey);
			$consumersecret = $_POST['consumersecret'];
			update_option('consumersecret',$consumersecret);
			$accesstoken = $_POST['accesstoken'];
			update_option('accesstoken',$accesstoken);
			$accesstokensecret = $_POST['accesstokensecret'];
			update_option('accesstokensecret',$accesstokensecret);			
									
			?>
			<div class="updated"><p><strong><?php _e('Datos Actualizados.' ); ?></strong></p></div>
			<?php
		} else {
		
			$twitterusername	= get_option('twitterusername');
			$numberoftweets		= get_option('numberoftweets');
			
			$consumerkey		= get_option('consumerkey');
			$consumersecret		= get_option('consumersecret');
			$accesstoken		= get_option('accesstoken');
			$accesstokensecret	= get_option('accesstokensecret');
			
			
		}
		
	function twitfeed_admin_scripts() {
		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
		wp_register_script('my-upload', WP_PLUGIN_URL.'/my-script.js', array('jquery','media-upload','thickbox'));
		wp_enqueue_script('my-upload');
	}

	function twitfeed_admin_styles() {
		wp_enqueue_style('thickbox');
	}

	if (isset($_GET['page']) && $_GET['page'] == 'my_plugin_page') {
		add_action('admin_print_scripts', 'twitfeed_admin_scripts');
		add_action('admin_print_styles', 'twitfeed_admin_styles');
	}

	?>
	<style>
		#twitfeed_anuncios, #twitfeed_eventos, #twitfeed_transmision, #twitfeed_actualizaciones{
			width:90%;
			padding: 10px 20px;
			background-color: #f8f8f8;
			border-radius: 3px;
			-moz-border-radius: 3px;
			-webkit-border-radius: 3px;
			margin-bottom: 10px;
		}
	</style>
	<div class="wrap">
	<div id="icon-options-general" class="icon32"><br></div>
	<h2>Designers Twitter Feed - Administraci&oacute;n</h2>
		<div class="twitfeed_wrap">
			
			<form name="twitfeed_form" method="post" id="twitfeed_form" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">

				<br /><br />
				<!-- CONTROLES DE YOUTUBE VIDEOS -->
				<h3><?php _e("Twitter Info:" ); ?></h3>
				<div id="twitfeed_transmision">
				<p><?php _e("Twitter Username:" ); ?><br>
					<input type="text" name="twitterusername" value="<?php echo $twitterusername; ?>" size="50"></p>
				<p><?php _e("Numero de Tweets:" ); ?><br>
					<input type="text" name="numberoftweets" value="<?php echo $numberoftweets; ?>" size="50"></p>
					<input type="hidden" name="twitfeed_hidden" value="Y"/>	
				
				<hr>
				
				<p><?php _e("Consumer Key:" ); ?><br>
					<input type="text" name="consumerkey" value="<?php echo $consumerkey; ?>" size="50"></p>
				<p><?php _e("Consumer Secret:" ); ?><br>
					<input type="text" name="consumersecret" value="<?php echo $consumersecret; ?>" size="50"></p>
				<p><?php _e("Access Token:" ); ?><br>
					<input type="text" name="accesstoken" value="<?php echo $accesstoken; ?>" size="50"></p>
				<p><?php _e("Access Token Secret:" ); ?><br>
					<input type="text" name="accesstokensecret" value="<?php echo $accesstokensecret; ?>" size="50"></p>
				
				<p class="submit">
				<input type="submit" name="Submit" value="<?php _e('Actualizar Configuraciones', 'oscimp_trdom' ) ?>" />
				</p>
					
				</div>
			</form>
		</div>
	</div>