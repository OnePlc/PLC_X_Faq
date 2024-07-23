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

class WebController extends CoreController {
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
}
