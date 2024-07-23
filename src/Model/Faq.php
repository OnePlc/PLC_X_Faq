<?php
/**
 * Faq.php - Faq Entity
 *
 * Entity Model for Faq
 *
 * @category Model
 * @package Faq
 * @author Verein onePlace
 * @copyright (C) 2020 Verein onePlace <admin@1plc.ch>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @version 1.0.0
 * @since 1.0.0
 */

namespace OnePlace\Faq\Model;

use Application\Model\CoreEntityModel;

class Faq extends CoreEntityModel {
    public $label;
    public $url;

    /**
     * Faq constructor.
     *
     * @param AdapterInterface $oDbAdapter
     * @since 1.0.0
     */
    public function __construct($oDbAdapter) {
        parent::__construct($oDbAdapter);

        # Set Single Form Name
        $this->sSingleForm = 'faq-single';

        # Attach Dynamic Fields to Entity Model
        $this->attachDynamicFields();
    }

    /**
     * Set Entity Data based on Data given
     *
     * @param array $aData
     * @since 1.0.0
     */
    public function exchangeArray(array $aData) {
        $this->id = !empty($aData['Faq_ID']) ? $aData['Faq_ID'] : 0;
        $this->label = !empty($aData['label']) ? $aData['label'] : '';
        $this->url = !empty($aData['url']) ? $aData['url'] : '';

        $this->updateDynamicFields($aData);
    }
}