<?php

/**
 * Ogólne ustawienia:
 */

require_once ('kkDataBase.class.php');
$db = new kkDataBase;

global $kkplugin, $wersja_plugin, $wpdb;

$click = false;
$liked = false;
$range = null;

if (!empty($_GET['range'])) {
	$range = $_GET['range'];
}


if($_GET['charts'] == 'click' || empty($_GET['charts'])){
	$click = true;
}else if ($_GET['charts'] == 'liked') {
	$liked = true;
}

?>

<div class="kkadmin-box">
	<div class="kkadmin-top">
		<?php include 'head.php'; ?>
	</div>
	<div class="kkadmin-content">
		<div class="kkadmin-text">
			<div class="kkadmin-text-wew">
				
				<ul class="kkmenu-bar">
					<li>
						<a class="<?php if($click): ?>active<?php endif; ?>" href="<?php echo home_url(); ?>/wp-admin/admin.php?page=kklike-stats&charts=click">
							<?php echo __('Likes','lang-kklike'); ?>
						</a>
					</li>
					<li>
						<a class="<?php if($liked): ?>active<?php endif; ?>" href="<?php echo home_url(); ?>/wp-admin/admin.php?page=kklike-stats&charts=liked">
							<?php echo __('Most liked','lang-kklike'); ?>
						</a>
					</li>

					<?php if($_GET['charts'] == 'click' || empty($_GET['charts'])){ ?>
					<ul class="submenu">
						<li>
							<a class="<?php if($range == 1): ?>active<?php endif; ?>" href="<?php echo home_url(); ?>/wp-admin/admin.php?page=kklike-stats&charts=click&range=1">
								<?php echo __('Today','lang-kklike'); ?>
							</a>
						</li>
						<li>
							<a class="<?php if($range == 7): ?>active<?php endif; ?>" href="<?php echo home_url(); ?>/wp-admin/admin.php?page=kklike-stats&charts=click&range=7">
								<?php echo __('7 days','lang-kklike'); ?>
							</a>
						</li>
						<li>
							<a class="<?php if($range == 14): ?>active<?php endif; ?>" href="<?php echo home_url(); ?>/wp-admin/admin.php?page=kklike-stats&charts=click&range=14">
								<?php echo __('14 days','lang-kklike'); ?>
							</a>
						</li>
						<li>
							<a class="<?php if($range == 30): ?>active<?php endif; ?>" href="<?php echo home_url(); ?>/wp-admin/admin.php?page=kklike-stats&charts=click&range=30">
								<?php echo __('30 days','lang-kklike'); ?>
							</a>
						</li>
					</ul>

					<?php }else if($_GET['charts'] == 'liked'){ ?>

					<ul class="submenu">
						<li>
							<a class="<?php if($range == 1): ?>active<?php endif; ?>" href="<?php echo home_url(); ?>/wp-admin/admin.php?page=kklike-stats&charts=liked&range=1">
								<?php echo __('Today','lang-kklike'); ?>
							</a>
						</li>
						<li>
							<a class="<?php if($range == 7): ?>active<?php endif; ?>" href="<?php echo home_url(); ?>/wp-admin/admin.php?page=kklike-stats&charts=liked&range=7">
								<?php echo __('7 days','lang-kklike'); ?>
							</a>
						</li>
						<li>
							<a class="<?php if($range == 14): ?>active<?php endif; ?>" href="<?php echo home_url(); ?>/wp-admin/admin.php?page=kklike-stats&charts=liked&range=14">
								<?php echo __('14 days','lang-kklike'); ?>
							</a>
						</li>
						<li>
							<a class="<?php if($range == 30): ?>active<?php endif; ?>" href="<?php echo home_url(); ?>/wp-admin/admin.php?page=kklike-stats&charts=liked&range=30">
								<?php echo __('30 days','lang-kklike'); ?>
							</a>
						</li>
					</ul>	
					<?php } ?>
				</ul>

				<div id="charts-box"></div>

				<div id="table-click-box" class="kktable-gray kkdisplay-none">
					<a href="http://codecanyon.net/item/kk-i-like-it/5053736?ref=KrzysztofF" target="_blank">
						<img src="<?php echo WP_PLUGIN_URL; ?>/kk-i-like-it/images/char1.jpg" alt="Chart1">
					</a>
				</div>

				<div id="table-like-box" class="kktable-gray kkdisplay-none">
					<a href="http://codecanyon.net/item/kk-i-like-it/5053736?ref=KrzysztofF" target="_blank">
						<img src="<?php echo WP_PLUGIN_URL; ?>/kk-i-like-it/images/char2.jpg" alt="Chart2">
					</a>
				</div>
				
			</div>
		</div>
		<div class="kkadmin-sidebar">
			<?php include 'menu.inc.php'; ?>
			<?php include 'sidebar.php'; ?>
		</div>
		<div class="kkclear"></div>
	</div>
	
</div>


<?php if($click): ?>

	<script type="text/javascript">
		jQuery(document).ready(function($) {
			$('#table-click-box').show();
		});
	</script>

<?php elseif($liked): ?>

	<script type="text/javascript">
		jQuery(document).ready(function($) {
			$('#table-like-box').show();
		});
	</script>

	<style type="text/css">
	.jqplot-data-label {
		color: #fff;
	}
	</style>

<?php endif; ?>