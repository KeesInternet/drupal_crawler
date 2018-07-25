<?php
namespace Drupal\kees_crawler\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class KeesCrawlerSettingsForm extends ConfigFormBase
{

    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'kees_crawler_form';
    }
    /**
     * This method will create the settings form
     *
     * @param array $form
     * @param FormStateInterface $form_state
     * @return array
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        // Form constructor.
        $form = parent::buildForm($form, $form_state);
        // Default settings.
        $config = $this->config('kees_crawler.settings');
        // Page title field.
        $form['crawl_div_id'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('Div ID the spider will crawl through'),
            '#default_value' => $config->get('kees_crawler.crawl_div_id'),
            '#description' => $this->t('The spider will only crawl through all <b>< a></b> inside this div.<small><b>Main navigation recommended</b></small>'),
        );
        // Text field.
        $form['max_crawlable_pages'] = array(
            '#type' => 'number',
            '#title' => $this->t('Maximum crawlable pages'),
            '#default_value' => $config->get('kees_crawler.max_crawlable_pages'),
            '#min' => 1,
            '#max' => 200,
            '#description' => $this->t('Maximum number of pages to crawl, the more pages to crawl the longer cache clear will take.'),
        );
        // Accept button text field
        $form['max_depth'] = array(
            '#type' => 'number',
            '#title' => $this->t('Maximum crawlable depth'),
            '#default_value' => $config->get('kees_crawler.max_depth'),
            '#min' => 1,
            '#max' => 10,
            '#description' => $this->t('Maximum depth the spider will crawl through'),
        );

        return $form;
    }

    /**
     * Form validation for settings form
     *
     * @param array $form
     * @param FormStateInterface $form_state
     * @return void
     */
    public function validateForm(array &$form, FormStateInterface $form_state)
    {
        // Not (yet) implemented
    }

    /**
     * Save to form by submitting it.
     *
     * @param array $form
     * @param FormStateInterface $form_state
     * @return parent::submitForm
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $config = $this->config('kees_crawler.settings');
        $config->set('kees_crawler.crawl_div_id', $form_state->getValue('crawl_div_id'));
        $config->set('kees_crawler.max_crawlable_pages', $form_state->getValue('max_crawlable_pages'));
        $config->set('kees_crawler.max_depth', $form_state->getValue('max_depth'));
        $config->save();
        return parent::submitForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    protected function getEditableConfigNames()
    {
        return [
            'kees_crawler.settings',
        ];
    }
}