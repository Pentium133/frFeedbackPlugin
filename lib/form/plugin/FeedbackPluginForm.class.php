<?php
/**
 * Feedback form.
 *
 * @package    frFeedbackPlugin
 * @subpackage feedback
 * @author     Serg Puhoff
 * @version    SVN: $Id: FeedbackForm.class.php 12534 2008-11-01 13:38:27Z Kris.Wallsmith $
 */
class FeedbackPluginForm extends sfForm
{
  public function configure()
  {
    parent::configure();

    $this->setWidgets(array(
      'yourname' => new sfWidgetFormInput(),
      'youremail'    => new sfWidgetFormInput(),
      'yourcomment'  => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'yourname'  => new sfValidatorAnd(array(
        new sfValidatorString(array('min_length' => 3, 'max_length' => 50))
      )),
      'youremail'     => new sfValidatorAnd(array(
        new sfValidatorString(array('max_length' => 100)),
        new sfValidatorEmail()
      )),
      'yourcomment'   => new sfValidatorString(array('max_length' => 512)),
      ));

    $this->widgetSchema->setNameFormat('feedback[%s]');
    $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('feedback');

    if (sfConfig::get('app_fr_feedback_plugin_use_authorization_info') && $this->options['user']) {
      $user = $this->options['user'];
      if ($user->isAuthenticated())
      {
        $username = call_user_func( array( $user->getGuarduser(), sfConfig::get('app_fr_feedback_plugin_username_method')));
        $email = call_user_func( array( $user->getGuarduser(), sfConfig::get('app_fr_feedback_plugin_email_method')));

        $this->setDefault('yourname', $username);
        $this->setDefault('youremail', $email);
      }
    }
  }
}