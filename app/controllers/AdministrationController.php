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

use \RNTForest\core\models\Customers;
use \RNTForest\core\models\CustomersPartners;
use \RNTForest\core\models\Logins;
use \RNTForest\core\models\Groups;
use \RNTForest\core\libraries\Helpers;

class AdministrationController extends \RNTForest\core\controllers\AdministrationControllerBase
{
    /**
    * helper method only for IDE auto completion purpose
    * 
    * @return \RNTForest\core\services\Push
    */
    protected function getPushService(){
        return $this->di['push'];
    }
    
    public function fakerAction(){
        $faker = \Faker\Factory::create("de_CH");
        $count = 10;

        if(!Customers::findFirstByid(2)){
            // customer
            $customer = new Customers();
            $customer->setId(2);
            $customer->setLastname("Forest");
            $customer->setFirstname("RNT");
            $customer->setCompany("RNT-Forest");
            $customer->setStreet("Foreststreet");
            $customer->setZip(1234);
            $customer->setCity("Forestcity");
            $customer->setPhone("+41 61 984 56 78");
            $customer->setEmail("rnt@forest.ch");
            $customer->setWebsite("www.rnt-forest.ch");
            $customer->setActive(1);
            if (!$customer->save()) {
                foreach ($customer->getMessages() as $message) {
                    $this->flashSession->error("Customers: ".$message);
                }
                return $this->redirectTo("administration/index");
            }

            // login
            $login = new Logins();
            $login->setLoginname("rntforest");
            $login->setPassword(hash('sha256', $this->config->application['securitySalt']."1234.abcd"));
            $login->setCustomersId(2);
            $login->setAdmin(0);
            $login->setMain(1);
            $login->setTitle("Mr");
            $login->setFirstname("Rnt");
            $login->setLastname("Forest");
            $login->setEmail("rnt@forest.ch");
            $login->setGroups(1);
            $login->setLocale("en_US.utf8");
            $login->setActive(1);
            $login->setNewsletter(0);
            if (!$login->save()) {
                foreach ($login->getMessages() as $message) {
                    $this->flashSession->error("Logins: ".$message);
                }
                return $this->redirectTo("administration/index");
            }

            $this->flashSession->success("Successfully created fake entries for RNT-Forest");
        } else {
            $this->flashSession->warning("Customer with ID=2 already exists.");
        }
        return $this->redirectTo("administration/index");
    }
        

    /* random entries */
    // random customers
    public function fakeCustomersAction(){
        $faker = \Faker\Factory::create("de_CH");
        
        for($i=1;$i<=10;$i++){
            $customer = new Customers;
            $customer->setLastname($faker->lastName);
            $customer->setFirstname($faker->firstName);
            $customer->setCompany($faker->company);
            $customer->setCompanyAdd($faker->companySuffix);
            $customer->setStreet($faker->streetName);
            $customer->setZip($faker->postcode);
            $customer->setCity($faker->city);
            $customer->setPhone($faker->phoneNumber);
            $customer->setEmail($faker->email);
            $customer->setWebsite("www.".$faker->domainName);
            $customer->setActive(1);
            if (!$customer->save()) {
                foreach ($customer->getMessages() as $message) {
                    $this->flashSession->error("Customers: ".$message);
                }
                return $this->redirectTo("administration/index");;
            }
        }
        $this->flashSession->success("Customers created successfully");
        return $this->redirectTo("administration/index");
    }
    
    public function fakePartnersAction(){
        $faker = \Faker\Factory::create("de_CH");
        
        // random partners
        for($i=1;$i<=10;$i++){
            $customerPartners = new CustomersPartners();
            
            // random customer
            $customer = $this->getRandomEntry('\RNTForest\core\models\Customers',3);
            $customerPartners->setCustomersId($customer->getId());
            
            // random partner
            $partner = $this->getRandomEntry('\RNTForest\core\models\Customers',3,$customer->getId());
            $customerPartners->setPartnersId($partner->getId());
            
            if (!$customerPartners->save()) {
                foreach ($customerPartners->getMessages() as $message) {
                    $this->flashSession->error("Partners: ".$message);
                }
                return $this->redirectTo("administration/index");
            }
        }
        $this->flashSession->success("Partners created successfully");
        return $this->redirectTo("administration/index");
    }
        
    public function fakeLoginsAction(){
        $faker = \Faker\Factory::create("de_CH");
        
        // random logins
        for($i=1;$i<=10;$i++){
            $login = new Logins();
            $login->setLoginname($faker->username(10));
            $login->setPassword(hash('sha256', $this->config->application['securitySalt']."1234.abcd"));

            $customer = $this->getRandomEntry('\RNTForest\core\models\Customers',3);
            $login->setCustomersId($customer->getId());

            $login->setAdmin(0);
            $login->setMain(1);
            $login->setTitle($faker->title);
            $login->setFirstname($faker->firstName);
            $login->setLastname($faker->lastName);
            $login->setEmail($faker->email);

            $group = $this->getRandomEntry('\RNTForest\core\models\Groups',1);
            $login->setGroups($group->getId());

            $login->setLocale("en_US.utf8");
            $login->setActive(1);
            $login->setNewsletter(rand(0,1));
            if (!$login->save()) {
                foreach ($login->getMessages() as $message) {
                    $this->flashSession->error("Logins: ".$message);
                }
                return $this->redirectTo("administration/index");
            }
        }
        $this->flashSession->success("Logins created successfully");
        return $this->redirectTo("administration/index");
    }
    
    /**
    * returns an random entry of any model
    * 
    * @param mixed $model
    * @param mixed $min
    * @param mixed $exceptId
    */
    private function getRandomEntry($model,$min=1,$exceptId=0){
        $rand = rand($min,$model::count()-1);
        
        $entry = $model::findFirst(
            array(
                'offset'=>$rand,
                "conditions" => "id != ".$exceptId,
            )
        );
        if(!$entry){
            return $this->getRandomEntry($model,$min,$exceptId);
        }
            
        return $entry;
    }
}
