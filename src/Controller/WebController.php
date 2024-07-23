<?php
/**
 * FaqController.php - Main Controller
 *
 * Main Controller Faq Module
 *
 * @category Controller
 * @package Faq
 * @author Verein onePlace
 * @copyright (C) 2020  Verein onePlace <admin@1plc.ch>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @version 1.0.0
 * @since 1.0.0
 */

declare(strict_types=1);

namespace OnePlace\Faq\Controller;

use Application\Controller\CoreController;
use Application\Model\CoreEntityModel;
use OnePlace\Faq\Model\FaqTable;
use Laminas\View\Model\ViewModel;
use Laminas\Db\Adapter\AdapterInterface;

class WebController extends CoreController {
    /**
     * Faq Table Object
     *
     * @since 1.0.0
     */
    private $oTableGateway;

    /**
     * FaqController constructor.
     *
     * @param AdapterInterface $oDbAdapter
     * @param FaqTable $oTableGateway
     * @since 1.0.0
     */
    public function __construct(AdapterInterface $oDbAdapter,FaqTable $oTableGateway,$oServiceManager) {
        $this->oTableGateway = $oTableGateway;
        $this->sSingleForm = 'faq-single';
        parent::__construct($oDbAdapter,$oTableGateway,$oServiceManager);

        if($oTableGateway) {
            # Attach TableGateway to Entity Models
            if(!isset(CoreEntityModel::$aEntityTables[$this->sSingleForm])) {
                CoreEntityModel::$aEntityTables[$this->sSingleForm] = $oTableGateway;
            }
        }
    }

    /**
     * Faq Index
     *
     * @since 1.0.0
     * @return ViewModel - View Object with Data from Controller
     */
    public function indexAction() {
        ini_set('display_errors', '1');
        error_reporting(E_ALL);
        $this->layout('layout/web');

        # Get Paginator
        $oPaginator = $this->oTableGateway->fetchAll(true);
        $iPage = (int) $this->params()->fromQuery('page', 1);
        $iPage = ($iPage < 1) ? 1 : $iPage;
        $oPaginator->setCurrentPageNumber($iPage);
        $oPaginator->setItemCountPerPage(3);

        return new ViewModel([
            'aItems'=>$oPaginator,
        ]);
    }

    public function showAction()
    {
        $this->layout('layout/web');
        $url = $this->params()->fromRoute('name', '');

        $faq = $this->oTableGateway->getSingleByUrl($url);

        return new ViewModel([
            'faq'=>$faq,
        ]);
    }
}
