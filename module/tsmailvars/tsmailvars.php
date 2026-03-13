<?php
/**
 * Module: tsmailvars
 * Description: Injects product reference into stock alert emails
 * Author: Studio 109
 * Website: https://www.studio109prod.com
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class TsMailVars extends Module
{
    public function __construct()
    {
        $this->name = 'tsmailvars';
        $this->tab = 'emailing';
        $this->version = '1.0.1';
        $this->author = 'Studio 109';
        $this->need_instance = 0;
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Variables Email Custom (Stock Alert)');
        $this->description = $this->l('Injects product reference {product_reference} into stock alert emails.');

        $this->ps_versions_compliancy = [
            'min' => '1.7.0.0',
            'max' => _PS_VERSION_
        ];
    }

    public function install()
    {
        if (!parent::install()
            || !$this->registerHook('actionUpdateQuantity')
            || !$this->registerHook('sendMailAlterTemplateVars')
        ) {
            return false;
        }

        $id_hook = (int) Hook::getIdByName('actionUpdateQuantity');
        if ($id_hook) {
            $this->updatePosition($id_hook, 0, 1);
        }

        return true;
    }

    public function hookActionUpdateQuantity($params)
    {
        if (!isset($params['id_product'])) {
            return;
        }

        $this->context->ts_last_oos_product = [
            'id_product' => (int) $params['id_product'],
            'id_product_attribute' => isset($params['id_product_attribute']) ? (int) $params['id_product_attribute'] : 0
        ];
    }

    public function hookSendMailAlterTemplateVars(&$params)
    {
        if (isset($params['template']) && $params['template'] === 'productoutofstock') {

            $reference = '';

            if (isset($this->context->ts_last_oos_product)) {

                $id_product = (int) $this->context->ts_last_oos_product['id_product'];
                $id_product_attribute = (int) $this->context->ts_last_oos_product['id_product_attribute'];

                if ($id_product_attribute > 0) {
                    $combination = new Combination($id_product_attribute);
                    if (Validate::isLoadedObject($combination) && !empty($combination->reference)) {
                        $reference = $combination->reference;
                    }
                }

                if (empty($reference) && $id_product > 0) {
                    $product = new Product($id_product);
                    if (Validate::isLoadedObject($product) && !empty($product->reference)) {
                        $reference = $product->reference;
                    }
                }

                unset($this->context->ts_last_oos_product);
            }

            if (!isset($params['template_vars']) || !is_array($params['template_vars'])) {
                $params['template_vars'] = [];
            }

            $params['template_vars']['{product_reference}'] = $reference;
        }
    }
}
