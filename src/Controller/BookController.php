<?php
/**
 * BookController.php - Main Controller
 *
 * Main Controller Book Module
 *
 * @category Controller
 * @package Book
 * @author Verein onePlace
 * @copyright (C) 2020  Verein onePlace <admin@1plc.ch>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @version 1.0.0
 * @since 1.0.0
 */

declare(strict_types=1);

namespace OnePlace\Book\Controller;

use Application\Controller\CoreController;
use Application\Model\CoreEntityModel;
use OnePlace\Book\Model\Book;
use OnePlace\Book\Model\BookTable;
use Laminas\View\Model\ViewModel;
use Laminas\Db\Adapter\AdapterInterface;

class BookController extends CoreController {
    /**
     * Book Table Object
     *
     * @since 1.0.0
     */
    private $oTableGateway;

    /**
     * BookController constructor.
     *
     * @param AdapterInterface $oDbAdapter
     * @param BookTable $oTableGateway
     * @since 1.0.0
     */
    public function __construct(AdapterInterface $oDbAdapter,BookTable $oTableGateway,$oServiceManager) {
        $this->oTableGateway = $oTableGateway;
        $this->sSingleForm = 'book-single';
        parent::__construct($oDbAdapter,$oTableGateway,$oServiceManager);

        if($oTableGateway) {
            # Attach TableGateway to Entity Models
            if(!isset(CoreEntityModel::$aEntityTables[$this->sSingleForm])) {
                CoreEntityModel::$aEntityTables[$this->sSingleForm] = $oTableGateway;
            }
        }
    }

    /**
     * Book Index
     *
     * @since 1.0.0
     * @return ViewModel - View Object with Data from Controller
     */
    public function indexAction() {
        # Set Layout based on users theme
        $this->setThemeBasedLayout('book');

        # Add Buttons for breadcrumb
        $this->setViewButtons('book-index');

        # Set Table Rows for Index
        $this->setIndexColumns('book-index');

        # Get Paginator
        $oPaginator = $this->oTableGateway->fetchAll(true);
        $iPage = (int) $this->params()->fromQuery('page', 1);
        $iPage = ($iPage < 1) ? 1 : $iPage;
        $oPaginator->setCurrentPageNumber($iPage);
        $oPaginator->setItemCountPerPage(3);

        # Log Performance in DB
        $aMeasureEnd = getrusage();
        $this->logPerfomance('book-index',$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"utime"),$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"stime"));

        return new ViewModel([
            'sTableName'=>'book-index',
            'aItems'=>$oPaginator,
        ]);
    }

    /**
     * Book Add Form
     *
     * @since 1.0.0
     * @return ViewModel - View Object with Data from Controller
     */
    public function addAction() {
        # Set Layout based on users theme
        $this->setThemeBasedLayout('book');

        # Get Request to decide wether to save or display form
        $oRequest = $this->getRequest();

        # Display Add Form
        if(!$oRequest->isPost()) {
            # Add Buttons for breadcrumb
            $this->setViewButtons('book-single');

            # Load Tabs for View Form
            $this->setViewTabs($this->sSingleForm);

            # Load Fields for View Form
            $this->setFormFields($this->sSingleForm);

            # Log Performance in DB
            $aMeasureEnd = getrusage();
            $this->logPerfomance('book-add',$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"utime"),$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"stime"));

            return new ViewModel([
                'sFormName' => $this->sSingleForm,
            ]);
        }

        # Get and validate Form Data
        $aFormData = $this->parseFormData($_REQUEST);

        # Save Add Form
        $oBook = new Book($this->oDbAdapter);
        $oBook->exchangeArray($aFormData);
        $iBookID = $this->oTableGateway->saveSingle($oBook);
        $oBook = $this->oTableGateway->getSingle($iBookID);

        # Save Multiselect
        $this->updateMultiSelectFields($_REQUEST,$oBook,'book-single');

        # Log Performance in DB
        $aMeasureEnd = getrusage();
        $this->logPerfomance('book-save',$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"utime"),$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"stime"));

        # Display Success Message and View New Book
        $this->flashMessenger()->addSuccessMessage('Book successfully created');
        return $this->redirect()->toRoute('book',['action'=>'view','id'=>$iBookID]);
    }

    /**
     * Book Edit Form
     *
     * @since 1.0.0
     * @return ViewModel - View Object with Data from Controller
     */
    public function editAction() {
        # Set Layout based on users theme
        $this->setThemeBasedLayout('book');

        # Get Request to decide wether to save or display form
        $oRequest = $this->getRequest();

        # Display Edit Form
        if(!$oRequest->isPost()) {

            # Get Book ID from URL
            $iBookID = $this->params()->fromRoute('id', 0);

            # Try to get Book
            try {
                $oBook = $this->oTableGateway->getSingle($iBookID);
            } catch (\RuntimeException $e) {
                echo 'Book Not found';
                return false;
            }

            # Attach Book Entity to Layout
            $this->setViewEntity($oBook);

            # Add Buttons for breadcrumb
            $this->setViewButtons('book-single');

            # Load Tabs for View Form
            $this->setViewTabs($this->sSingleForm);

            # Load Fields for View Form
            $this->setFormFields($this->sSingleForm);

            # Log Performance in DB
            $aMeasureEnd = getrusage();
            $this->logPerfomance('book-edit',$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"utime"),$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"stime"));

            return new ViewModel([
                'sFormName' => $this->sSingleForm,
                'oBook' => $oBook,
            ]);
        }

        $iBookID = $oRequest->getPost('Item_ID');
        $oBook = $this->oTableGateway->getSingle($iBookID);

        # Update Book with Form Data
        $oBook = $this->attachFormData($_REQUEST,$oBook);

        # Save Book
        $iBookID = $this->oTableGateway->saveSingle($oBook);

        $this->layout('layout/json');

        # Parse Form Data
        $aFormData = $this->parseFormData($_REQUEST);

        # Save Multiselect
        $this->updateMultiSelectFields($aFormData,$oBook,'book-single');

        # Log Performance in DB
        $aMeasureEnd = getrusage();
        $this->logPerfomance('book-save',$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"utime"),$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"stime"));

        # Display Success Message and View New User
        $this->flashMessenger()->addSuccessMessage('Book successfully saved');
        return $this->redirect()->toRoute('book',['action'=>'view','id'=>$iBookID]);
    }

    /**
     * Book View Form
     *
     * @since 1.0.0
     * @return ViewModel - View Object with Data from Controller
     */
    public function viewAction() {
        # Set Layout based on users theme
        $this->setThemeBasedLayout('book');

        # Get Book ID from URL
        $iBookID = $this->params()->fromRoute('id', 0);

        # Try to get Book
        try {
            $oBook = $this->oTableGateway->getSingle($iBookID);
        } catch (\RuntimeException $e) {
            echo 'Book Not found';
            return false;
        }

        # Attach Book Entity to Layout
        $this->setViewEntity($oBook);

        # Add Buttons for breadcrumb
        $this->setViewButtons('book-view');

        # Load Tabs for View Form
        $this->setViewTabs($this->sSingleForm);

        # Load Fields for View Form
        $this->setFormFields($this->sSingleForm);

        # Log Performance in DB
        $aMeasureEnd = getrusage();
        $this->logPerfomance('book-view',$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"utime"),$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"stime"));

        return new ViewModel([
            'sFormName'=>$this->sSingleForm,
            'oBook'=>$oBook,
        ]);
    }
}
