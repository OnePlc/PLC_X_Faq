<?php
/**
 * BlogController.php - Main Controller
 *
 * Main Controller Blog Module
 *
 * @category Controller
 * @package Blog
 * @author Verein onePlace
 * @copyright (C) 2020  Verein onePlace <admin@1plc.ch>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @version 1.0.0
 * @since 1.0.0
 */

declare(strict_types=1);

namespace OnePlace\Blog\Controller;

use Application\Controller\CoreController;
use Application\Model\CoreEntityModel;
use OnePlace\Blog\Model\Blog;
use OnePlace\Blog\Model\BlogTable;
use Laminas\View\Model\ViewModel;
use Laminas\Db\Adapter\AdapterInterface;

class BlogController extends CoreController {
    /**
     * Blog Table Object
     *
     * @since 1.0.0
     */
    private $oTableGateway;

    /**
     * BlogController constructor.
     *
     * @param AdapterInterface $oDbAdapter
     * @param BlogTable $oTableGateway
     * @since 1.0.0
     */
    public function __construct(AdapterInterface $oDbAdapter,BlogTable $oTableGateway,$oServiceManager) {
        $this->oTableGateway = $oTableGateway;
        $this->sSingleForm = 'blog-single';
        parent::__construct($oDbAdapter,$oTableGateway,$oServiceManager);

        if($oTableGateway) {
            # Attach TableGateway to Entity Models
            if(!isset(CoreEntityModel::$aEntityTables[$this->sSingleForm])) {
                CoreEntityModel::$aEntityTables[$this->sSingleForm] = $oTableGateway;
            }
        }
    }

    /**
     * Blog Index
     *
     * @since 1.0.0
     * @return ViewModel - View Object with Data from Controller
     */
    public function indexAction() {
        # Set Layout based on users theme
        $this->setThemeBasedLayout('blog');

        # Add Buttons for breadcrumb
        $this->setViewButtons('blog-index');

        # Set Table Rows for Index
        $this->setIndexColumns('blog-index');

        # Get Paginator
        $oPaginator = $this->oTableGateway->fetchAll(true);
        $iPage = (int) $this->params()->fromQuery('page', 1);
        $iPage = ($iPage < 1) ? 1 : $iPage;
        $oPaginator->setCurrentPageNumber($iPage);
        $oPaginator->setItemCountPerPage(3);

        # Log Performance in DB
        $aMeasureEnd = getrusage();
        $this->logPerfomance('blog-index',$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"utime"),$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"stime"));

        return new ViewModel([
            'sTableName'=>'blog-index',
            'aItems'=>$oPaginator,
            'sRoute' => 'blog-admin',
        ]);
    }

    /**
     * Blog Add Form
     *
     * @since 1.0.0
     * @return ViewModel - View Object with Data from Controller
     */
    public function addAction() {
        # Set Layout based on users theme
        $this->setThemeBasedLayout('blog');

        # Get Request to decide wether to save or display form
        $oRequest = $this->getRequest();

        # Display Add Form
        if(!$oRequest->isPost()) {
            # Add Buttons for breadcrumb
            $this->setViewButtons('blog-single');

            # Load Tabs for View Form
            $this->setViewTabs($this->sSingleForm);

            # Load Fields for View Form
            $this->setFormFields($this->sSingleForm);

            # Log Performance in DB
            $aMeasureEnd = getrusage();
            $this->logPerfomance('blog-add',$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"utime"),$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"stime"));

            return new ViewModel([
                'sFormName' => $this->sSingleForm,
            ]);
        }

        # Get and validate Form Data
        $aFormData = $this->parseFormData($_REQUEST);

        # Save Add Form
        $oBlog = new Blog($this->oDbAdapter);
        $oBlog->exchangeArray($aFormData);
        $iBlogID = $this->oTableGateway->saveSingle($oBlog);
        $oBlog = $this->oTableGateway->getSingle($iBlogID);

        # Save Multiselect
        $this->updateMultiSelectFields($_REQUEST,$oBlog,'blog-single');

        # Log Performance in DB
        $aMeasureEnd = getrusage();
        $this->logPerfomance('blog-save',$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"utime"),$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"stime"));

        # Display Success Message and View New Blog
        $this->flashMessenger()->addSuccessMessage('Blog successfully created');
        return $this->redirect()->toRoute('blog',['action'=>'view','id'=>$iBlogID]);
    }

    /**
     * Blog Edit Form
     *
     * @since 1.0.0
     * @return ViewModel - View Object with Data from Controller
     */
    public function editAction() {
        # Set Layout based on users theme
        $this->setThemeBasedLayout('blog');

        # Get Request to decide wether to save or display form
        $oRequest = $this->getRequest();

        # Display Edit Form
        if(!$oRequest->isPost()) {

            # Get Blog ID from URL
            $iBlogID = $this->params()->fromRoute('id', 0);

            # Try to get Blog
            try {
                $oBlog = $this->oTableGateway->getSingle($iBlogID);
            } catch (\RuntimeException $e) {
                echo 'Blog Not found';
                return false;
            }

            # Attach Blog Entity to Layout
            $this->setViewEntity($oBlog);

            # Add Buttons for breadcrumb
            $this->setViewButtons('blog-single');

            # Load Tabs for View Form
            $this->setViewTabs($this->sSingleForm);

            # Load Fields for View Form
            $this->setFormFields($this->sSingleForm);

            # Log Performance in DB
            $aMeasureEnd = getrusage();
            $this->logPerfomance('blog-edit',$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"utime"),$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"stime"));

            return new ViewModel([
                'sFormName' => $this->sSingleForm,
                'oBlog' => $oBlog,
            ]);
        }

        $iBlogID = $oRequest->getPost('Item_ID');
        $oBlog = $this->oTableGateway->getSingle($iBlogID);

        # Update Blog with Form Data
        $oBlog = $this->attachFormData($_REQUEST,$oBlog);

        # Save Blog
        $iBlogID = $this->oTableGateway->saveSingle($oBlog);

        $this->layout('layout/json');

        # Parse Form Data
        $aFormData = $this->parseFormData($_REQUEST);

        # Save Multiselect
        $this->updateMultiSelectFields($aFormData,$oBlog,'blog-single');

        # Log Performance in DB
        $aMeasureEnd = getrusage();
        $this->logPerfomance('blog-save',$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"utime"),$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"stime"));

        # Display Success Message and View New User
        $this->flashMessenger()->addSuccessMessage('Blog successfully saved');
        return $this->redirect()->toRoute('blog',['action'=>'view','id'=>$iBlogID]);
    }

    /**
     * Blog View Form
     *
     * @since 1.0.0
     * @return ViewModel - View Object with Data from Controller
     */
    public function viewAction() {
        # Set Layout based on users theme
        $this->setThemeBasedLayout('blog');

        # Get Blog ID from URL
        $iBlogID = $this->params()->fromRoute('id', 0);

        # Try to get Blog
        try {
            $oBlog = $this->oTableGateway->getSingle($iBlogID);
        } catch (\RuntimeException $e) {
            echo 'Blog Not found';
            return false;
        }

        # Attach Blog Entity to Layout
        $this->setViewEntity($oBlog);

        # Add Buttons for breadcrumb
        $this->setViewButtons('blog-view');

        # Load Tabs for View Form
        $this->setViewTabs($this->sSingleForm);

        # Load Fields for View Form
        $this->setFormFields($this->sSingleForm);

        # Log Performance in DB
        $aMeasureEnd = getrusage();
        $this->logPerfomance('blog-view',$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"utime"),$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"stime"));

        return new ViewModel([
            'sFormName'=>$this->sSingleForm,
            'oBlog'=>$oBlog,
        ]);
    }
}
