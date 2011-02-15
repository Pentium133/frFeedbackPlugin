<?php

/**
 * Base actions for the frFeedbackPlugin feedback module.
 *
 * @package     frFeedbackPlugin
 * @subpackage  feedback
 * @author      Serg Puhoff
 * @version     SVN: $Id: BaseActions.class.php 12534 2008-11-01 13:38:27Z Kris.Wallsmith $
 */
abstract class BasefrFeedbackActions extends sfActions
{
  public function executeFeedback(sfWebRequest $request)
  {
    $this->form = new FeedbackForm(array(), array('user'=>$this->getUser()));

    if ($request->isMethod(sfRequest::POST))
    {
      $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));
      if ($this->form->isValid())
      {
        sfContext::getInstance()->getConfiguration()->loadHelpers(array('I18N'));
        $mailBody = $this->getPartial('frFeedback/feedbackMail', array('values' => $this->form->getValues()));
        $mailFrom = array($this->form->getValue('youremail') => $this->form->getValue('yourname'));

        $message = Swift_Message::newInstance()
          ->setFrom($mailFrom)
          ->setTo(sfConfig::get('app_fr_feedback_plugin_email_to'))
          ->setReplyTo($mailFrom)
          ->setSubject(sfConfig::get('app_email_prefix').__('Feedback form', null, 'feedback'))
          ->setBody($mailBody);

        $sendResult = $this->getMailer()->send($message);

        if ($sendResult)
          $this->getUser()->setFlash('notice', __('Your message has been successfully sent.', null, 'feedback'));
        else
          $this->getUser()->setFlash('notice', __('An error occurred while sending a message. Error code = %1%', array('%1%'=>$sendResult), 'feedback'));

        $this->redirect('feedback');
      }
    }
  }
}
