<?php
/**
* @copyright Copyright (c) ARONET GmbH (https://aronet.swiss)
* @license AGPL-3.0
*
* This code is free software: you can redistribute it and/or modify
* it under the terms of the GNU Affero General Public License, version 3,
* as published by the Free Software Foundation.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU Affero General Public License for more details.
*
* You should have received a copy of the GNU Affero General Public License, version 3,
* along with this program.  If not, see <http://www.gnu.org/licenses/>
*
*/

namespace RNTForest\DNSCP\controllers; 

use RNTForest\core\models\Customers;
use RNTForest\core\libraries\PDF;

class IndexController extends \RNTForest\core\controllers\IndexControllerBase
{
    public function indexAction()
    {
        $this->view->auth = $this->session->get("auth");
        $customersId = $this->session->get("auth")["customers_id"];
        
        // count dns zones by scope
        $scope = $this->permissions->getScope('dns','general');
        if($scope == 'customers'){
            $this->view->count_dns = count('\RNTForest\dns\models\DnsZones'::find('customers_id = '.$customersId));
        }else{
            $this->view->count_dns = count('\RNTForest\dns\models\DnsZones'::findFromScope($scope));
        }
    }
    
    public function PDFSummaryAction($customersId){
        // Sanitize Parameters
        $customersId = $this->filter->sanitize($customersId,"int");

        try{
            // Validate (throws exceptions)
            $customer = Customers::tryFindById($customersId);
            // check permission
            $scope = $this->permissions->getScope('index','pdf_summary');
            
            switch($scope){
                // all allowed
                case '*':
                    break;
                // only own
                case 'customers':
                    if($customer->getId() != \Phalcon\DI::getDefault()->getSession()->get('auth')['customers_id']){
                        $this->flashSession->error(self::translate("pdfsummary_no_permission"));
                        return $this->redirectTo("/index/");
                    }
                    break;
                // own and from customers
                case 'partners':
                    if($customer->getId() != \Phalcon\DI::getDefault()->getSession()->get('auth')['customers_id']) $allowed = false;
                    foreach($customer->partners as $partner){
                        if($partner->id == \Phalcon\DI::getDefault()->getSession()->get('auth')['customers_id']) $allowed = true;
                    }
                    if(!$allowed){
                        $this->flashSession->error(self::translate("pdfsummary_no_permission"));
                        return $this->redirectTo("/index/");
                    }
                    break;
            }
            

            // Create PDF Object
            $this->PDF = new \RNTForest\DNSCP\libraries\PDF();
            $this->PDF->SetAutoPageBreak(false);

            // Author, title, add new page
            $this->PDF->SetAuthor(BASE_PATH.$this->config->pdf['author']);
            $this->PDF->SetTitle($this->translate("pdfsummary_title"));
            $this->PDF->AddPage();
            
            // Print header
            $customerText = $customer->printAddressText('box');
            $customerText .= "\n".self::translate("pdfsummary_customer_id").": ".$customer->getId();
            $this->PDF->printHeader(self::translate("pdfsummary_title"), $customerText);
            
            // Print summary
            $this->PDF->PDFSummaryLogins($customersId);
            $this->PDF->PDFSummaryDNS($customersId);
                    
            // Dispaly PDF
            $this->PDF->Output(self::translate("pdfsummary_title").'.pdf', 'I');
            die();
        }catch(\Exception $e){
            $this->flashSession->error($e->getMessage());
            $this->logger->error($e->getMessage());
            $this->redirectTo("/index/");
            return;
        }
    }
}
