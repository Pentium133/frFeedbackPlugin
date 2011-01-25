<?php use_helper('I18N')?>
<h3><?php echo __('Feedback form', null, 'feedback')?></h3>
<?php echo $form->renderFormTag(url_for('feedback'))."\n" ?>
<fieldset>
  <?php echo $form ?><br/>
  <input type="submit" value="<?php echo __('Send', null, 'feedback')?>" />
</fieldset>
</form>
