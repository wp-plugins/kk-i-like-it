<?php
	$kkLikeSettings = get_option('kklikesettings');
	$page = $_GET['page'];
?>
<ul class="kkadmin-menu-ul">
	<?php if(empty($kkLikeSettings['plugin_rank']) || current_user_can($kkLikeSettings['plugin_rank'])): ?>
		<li>
			<a class="<?php echo ($page == 'kklike-menu')? 'active':''; ?>" href="<?php echo home_url(); ?>/wp-admin/admin.php?page=kklike-menu">
				<span class="kkadmin-arrow"></span>
				<?php echo __('Stats','lang-kklike'); ?>
			</a>
		</li>
	<?php endif; ?>
	<?php if(empty($kkLikeSettings['settings_rank']) || current_user_can($kkLikeSettings['settings_rank'])): ?>
		<li>
			<a class="<?php echo ($page == 'kklike-settings')? 'active':''; ?>" href="<?php echo home_url(); ?>/wp-admin/admin.php?page=kklike-settings" class="">
				<span class="kkadmin-arrow"></span>
				<?php echo __('Settings','lang-kklike'); ?>
			</a>
		</li>
	<?php endif; ?>
	<li>
		<a class="<?php echo ($page == 'kklike-documentation')? 'active':''; ?>" href="<?php echo home_url(); ?>/wp-admin/admin.php?page=kklike-documentation">
			<span class="kkadmin-arrow"></span> 
			<?php echo __('Documentation','lang-kklike'); ?>
		</a>
	</li>
	<li>
		<a class="<?php echo ($page == 'kklike-changelog')? 'active':''; ?>" href="<?php echo home_url(); ?>/wp-admin/admin.php?page=kklike-changelog">
			<span class="kkadmin-arrow"></span>
			Changelog
		</a>
	</li>
	<?php if(false && current_user_can('administrator')): ?>
	<?php endif; ?>
</ul>