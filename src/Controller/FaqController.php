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
use OnePlace\Faq\Model\Faq;
use OnePlace\Faq\Model\FaqTable;
use Laminas\View\Model\ViewModel;
use Laminas\Db\Adapter\AdapterInterface;

class FaqController extends CoreController {
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
        # Set Layout based on users theme
        $this->setThemeBasedLayout('faq');

        # Add Buttons for breadcrumb
        $this->setViewButtons('faq-index');

        # Set Table Rows for Index
        $this->setIndexColumns('faq-index');

        # Get Paginator
        $oPaginator = $this->oTableGateway->fetchAll(true);
        $iPage = (int) $this->params()->fromQuery('page', 1);
        $iPage = ($iPage < 1) ? 1 : $iPage;
        $oPaginator->setCurrentPageNumber($iPage);
        $oPaginator->setItemCountPerPage(3);

        # Log Performance in DB
        $aMeasureEnd = getrusage();
        $this->logPerfomance('faq-index',$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"utime"),$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"stime"));

        return new ViewModel([
            'sTableName'=>'faq-index',
            'aItems'=>$oPaginator,
            'sRoute' => 'faq-admin',
        ]);
    }

    /**
     * Faq Add Form
     *
     * @since 1.0.0
     * @return ViewModel - View Object with Data from Controller
     */
    public function addAction() {
        # Set Layout based on users theme
        $this->setThemeBasedLayout('faq');

        # Get Request to decide wether to save or display form
        $oRequest = $this->getRequest();

        # Display Add Form
        if(!$oRequest->isPost()) {
            # Add Buttons for breadcrumb
            $this->setViewButtons('faq-single');

            # Load Tabs for View Form
            $this->setViewTabs($this->sSingleForm);

            # Load Fields for View Form
            $this->setFormFields($this->sSingleForm);

            # Log Performance in DB
            $aMeasureEnd = getrusage();
            $this->logPerfomance('faq-add',$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"utime"),$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"stime"));

            return new ViewModel([
                'sFormName' => $this->sSingleForm,
            ]);
        }

        # Get and validate Form Data
        $aFormData = $this->parseFormData($_REQUEST);

        # Save Add Form
        $oFaq = new Faq($this->oDbAdapter);
        $pretty = str_replace([' ', 'ä', 'ö', 'ü', 'Ä', 'Ö', 'Ü','+',' & ','&','/','.','?'],['-', 'ae', 'oe', 'ue', 'ae', 'oe', 'ue','','_','_','-','-',''], strtolower($aFormData['label']));
        $aFormData['url'] = $pretty;
        $oFaq->exchangeArray($aFormData);
        $iFaqID = $this->oTableGateway->saveSingle($oFaq);
        $oFaq = $this->oTableGateway->getSingle($iFaqID);

        # Save Multiselect
        $this->updateMultiSelectFields($_REQUEST,$oFaq,'faq-single');

        # Log Performance in DB
        $aMeasureEnd = getrusage();
        $this->logPerfomance('faq-save',$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"utime"),$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"stime"));

        # Display Success Message and View New Faq
        $this->flashMessenger()->addSuccessMessage('Faq successfully created');
        return $this->redirect()->toRoute('faq-admin',['action'=>'view','id'=>$iFaqID]);
    }

    /**
     * Faq Edit Form
     *
     * @since 1.0.0
     * @return ViewModel - View Object with Data from Controller
     */
    public function editAction() {
        # Set Layout based on users theme
        $this->setThemeBasedLayout('faq');

        # Get Request to decide wether to save or display form
        $oRequest = $this->getRequest();

        # Display Edit Form
        if(!$oRequest->isPost()) {

            # Get Faq ID from URL
            $iFaqID = $this->params()->fromRoute('id', 0);

            # Try to get Faq
            try {
                $oFaq = $this->oTableGateway->getSingle($iFaqID);
            } catch (\RuntimeException $e) {
                echo 'Faq Not found';
                return false;
            }

            # Attach Faq Entity to Layout
            $this->setViewEntity($oFaq);

            # Add Buttons for breadcrumb
            $this->setViewButtons('faq-single');

            # Load Tabs for View Form
            $this->setViewTabs($this->sSingleForm);

            # Load Fields for View Form
            $this->setFormFields($this->sSingleForm);

            # Log Performance in DB
            $aMeasureEnd = getrusage();
            $this->logPerfomance('faq-edit',$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"utime"),$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"stime"));

            return new ViewModel([
                'sFormName' => $this->sSingleForm,
                'oFaq' => $oFaq,
            ]);
        }

        $iFaqID = $oRequest->getPost('Item_ID');
        $oFaq = $this->oTableGateway->getSingle($iFaqID);

        # Update Faq with Form Data
        $oFaq = $this->attachFormData($_REQUEST,$oFaq);

        # Save Faq
        $iFaqID = $this->oTableGateway->saveSingle($oFaq);

        $this->layout('layout/json');

        # Parse Form Data
        $aFormData = $this->parseFormData($_REQUEST);

        # Save Multiselect
        $this->updateMultiSelectFields($aFormData,$oFaq,'faq-single');

        # Log Performance in DB
        $aMeasureEnd = getrusage();
        $this->logPerfomance('faq-save',$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"utime"),$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"stime"));

        # Display Success Message and View New User
        $this->flashMessenger()->addSuccessMessage('Faq successfully saved');
        return $this->redirect()->toRoute('faq-admin',['action'=>'view','id'=>$iFaqID]);
    }

    /**
     * Faq View Form
     *
     * @since 1.0.0
     * @return ViewModel - View Object with Data from Controller
     */
    public function viewAction() {
        # Set Layout based on users theme
        $this->setThemeBasedLayout('faq');

        # Get Faq ID from URL
        $iFaqID = $this->params()->fromRoute('id', 0);

        # Try to get Faq
        try {
            $oFaq = $this->oTableGateway->getSingle($iFaqID);
        } catch (\RuntimeException $e) {
            echo 'Faq Not found';
            return false;
        }

        # Attach Faq Entity to Layout
        $this->setViewEntity($oFaq);

        # Add Buttons for breadcrumb
        $this->setViewButtons('faq-view');

        # Load Tabs for View Form
        $this->setViewTabs($this->sSingleForm);

        # Load Fields for View Form
        $this->setFormFields($this->sSingleForm);

        # Log Performance in DB
        $aMeasureEnd = getrusage();
        $this->logPerfomance('faq-view',$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"utime"),$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"stime"));

        return new ViewModel([
            'sFormName'=>$this->sSingleForm,
            'oFaq'=>$oFaq,
        ]);
    }
}
