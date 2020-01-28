<?php
/**
 * Book.php - Book Entity
 *
 * Entity Model for Book
 *
 * @category Model
 * @package Book
 * @author Verein onePlace
 * @copyright (C) 2020 Verein onePlace <admin@1plc.ch>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @version 1.0.0
 * @since 1.0.0
 */

namespace OnePlace\Book\Model;

use Application\Model\CoreEntityModel;

class Book extends CoreEntityModel {
    public $label;

    /**
     * Book constructor.
     *
     * @param AdapterInterface $oDbAdapter
     * @since 1.0.0
     */
    public function __construct($oDbAdapter) {
        parent::__construct($oDbAdapter);

        # Set Single Form Name
        $this->sSingleForm = 'book-single';

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
        $this->id = !empty($aData['Book_ID']) ? $aData['Book_ID'] : 0;
        $this->label = !empty($aData['label']) ? $aData['label'] : '';

        $this->updateDynamicFields($aData);
    }
}