<div class="message alert" style="display:none;"></div>
<form role="form">
	<label>
		<?php echo _('Enable')?>
		<div class="onoffswitch">
			<input type="checkbox" name="dndenable" class="onoffswitch-checkbox" id="dndenable" <?php echo ($enabled) ? 'checked' : ''?>>
			<label class="onoffswitch-label" for="dndenable">
				<div class="onoffswitch-inner"></div>
				<div class="onoffswitch-switch"></div>
			</label>
		</div>
	</label>
</form>
