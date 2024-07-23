<?php
/**
 * FaqTable.php - Faq Table
 *
 * Table Model for Faq
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

use Application\Controller\CoreController;
use Application\Model\CoreEntityTable;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\Sql\Select;
use Laminas\Db\Sql\Where;
use Laminas\Paginator\Paginator;
use Laminas\Paginator\Adapter\DbSelect;

class FaqTable extends CoreEntityTable {

    /**
     * FaqTable constructor.
     *
     * @param TableGateway $tableGateway
     * @since 1.0.0
     */
    public function __construct(TableGateway $tableGateway) {
        parent::__construct($tableGateway);

        # Set Single Form Name
        $this->sSingleForm = 'faq-single';
    }

    /**
     * Get Faq Entity
     *
     * @param int $id
     * @return mixed
     * @since 1.0.0
     */
    public function getSingle($id) {
        $id = (int) $id;
        $rowset = $this->oTableGateway->select(['Faq_ID' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new \RuntimeException(sprintf(
                'Could not find faq with identifier %d',
                $id
            ));
        }

        return $row;
    }

    /**
     * Save Faq Entity
     *
     * @param Faq $oFaq
     * @return int Faq ID
     * @since 1.0.0
     */
    public function saveSingle(Faq $oFaq) {
        $aData = [
            'label' => $oFaq->label,
        ];

        $aData = $this->attachDynamicFields($aData,$oFaq);

        $id = (int) $oFaq->id;

        if ($id === 0) {
            # Add Metadata
            $aData['created_by'] = CoreController::$oSession->oUser->getID();
            $aData['created_date'] = date('Y-m-d H:i:s',time());
            $aData['modified_by'] = CoreController::$oSession->oUser->getID();
            $aData['modified_date'] = date('Y-m-d H:i:s',time());

            # Insert Faq
            $this->oTableGateway->insert($aData);

            # Return ID
            return $this->oTableGateway->lastInsertValue;
        }

        # Check if Faq Entity already exists
        try {
            $this->getSingle($id);
        } catch (\RuntimeException $e) {
            throw new \RuntimeException(sprintf(
                'Cannot update faq with identifier %d; does not exist',
                $id
            ));
        }

        # Update Metadata
        $aData['modified_by'] = CoreController::$oSession->oUser->getID();
        $aData['modified_date'] = date('Y-m-d H:i:s',time());

        # Update Faq
        $this->oTableGateway->update($aData, ['Faq_ID' => $id]);

        return $id;
    }

    /**
     * Generate daily stats for faq
     *
     * @since 1.0.5
     */
    public function generateDailyStats() {
        # get all faqs
        $iTotal = count($this->fetchAll(false));
        # get newly created faqs
        $iNew = count($this->fetchAll(false,['created_date-like'=>date('Y-m-d',time())]));

        # add statistics
        CoreController::$aCoreTables['core-statistic']->insert([
            'stats_key'=>'faq-daily',
            'data'=>json_encode(['new'=>$iNew,'total'=>$iTotal]),
            'date'=>date('Y-m-d H:i:s',time()),
        ]);
    }
}