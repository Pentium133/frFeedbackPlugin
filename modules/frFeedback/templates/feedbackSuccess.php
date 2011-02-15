<?php use_helper('I18N')?>
<h3><?php echo __('Feedback form', null, 'feedback')?></h3>
<?php echo $form->renderFormTag(url_for('feedback'), array('class'=>'uniForm'))."\n" ?>
<fieldset>
  <?php echo $form ?>
    <div class="buttonHolder">
      <input class="primaryAction" type="submit" value="<?php echo __('Send', null, 'feedback')?>" />
    </div>


</fieldset>
</form>
