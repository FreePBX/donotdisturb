<div class="message alert" style="display:none;"></div>
<form role="form">
	<div class="form-group">
		<label for="dndenable-h" class="help"><?php echo _('Enable')?> <i class="fa fa-question-circle"></i></label>
		<div class="onoffswitch">
			<input type="checkbox" name="dndenable" class="onoffswitch-checkbox" id="dndenable" <?php echo ($enabled) ? 'checked' : ''?>>
			<label class="onoffswitch-label" for="dndenable">
				<div class="onoffswitch-inner"></div>
				<div class="onoffswitch-switch"></div>
			</label>
		</div>
		<span class="help-block help-hidden" data-for="dndenable-h"><?php echo _('Used to indicate that somebody does not wish to be disturbed.')?></span>
	</div>
</form>
