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

/////////////////////////////////////////////////////////
// installer will be replaced soon, only quick and dirty 
/////////////////////////////////////////////////////////

function install(){
    // using global variables to share state with the form so it can show errors and refill the already filled up fields in error case
    global $errors;
    global $oldFormValues;
    
    $requiredMissing = false;
    $validationFault = false;
    
    // remove the scriptfile itself and the parent folder from the path to get the needed webroot
    $pathSplits = explode('/',$_SERVER['SCRIPT_FILENAME']);
    if(!is_array($pathSplits)){
        $errors[] = 'Could not determine webroot. Make sure to use apache or nginx.';
    }
    array_pop($pathSplits);
    array_pop($pathSplits);
    $webRoot = implode('/',$pathSplits).'/';
    
    //////////////////////////
    // get post variables
    //////////////////////////
    
    // databasehost
    if(empty($_POST['databasehost'])){
        $errors[] = "Empty field 'database host'";
        $requiredMissing = true;
    }else{
        $dbHost = trim($_POST['databasehost']);
        $oldFormValues['databasehost'] = $dbHost;
    }        
    // databaseuser
    if(empty($_POST['databaseuser'])){
        $errors[] = "Empty field 'database user'";
        $requiredMissing = true;
    }else{
        $dbUser = trim($_POST['databaseuser']);
        $oldFormValues['databaseuser'] = $dbUser;
    }
        
    // databasepassword
    if(empty($_POST['databasepassword'])){
        $errors[] = "Empty field 'database password'";
        $requiredMissing = true;
    }else{
        $dbPassword = trim($_POST['databasepassword']);
        $oldFormValues['databasepassword'] = $dbPassword;
    }
    
    // databasename
    if(empty($_POST['databasename'])){
        $errors[] = "Empty field database name";
        $requiredMissing = true;
    }else{
        $dbName = trim($_POST['databasename']);
        $oldFormValues['databasename'] = $dbName;
    }
    
    // adminpassword
    if(empty($_POST['adminpassword'])){
        $errors[] = "Empty field 'admin password'";
        $requiredMissing = true;
    }else{
        $adminPassword = trim($_POST['adminpassword']);
        if(strlen($adminPassword) < 4){
            $errors[] = 'Admin password lenght should be minimum 4';
            return;
        }
        $oldFormValues['adminpassword'] = $adminPassword;
    }
    
    // securitysalt
    if(empty($_POST['securitysalt'])){
        $errors[] = "Empty field 'security salt'";
        $requiredMissing = true;
    }else{
        $securitySalt = trim($_POST['securitysalt']);
        if(!ctype_alnum($securitySalt)){
            $errors[] = 'Security salt must be alphanumeric';
            $validationFault = true;
            return;
        }
        if(strlen($securitySalt) < 8 || strlen($securitySalt) > 32){
            $errors[] = 'Security salt lenght should be between 8 and 32 (inclusive)';
            $validationFault = true;
        }
        $oldFormValues['securitysalt'] = $securitySalt;
    }
    
    // jwtsigningkey
    if(empty($_POST['jwtsigningkey'])){
        $errors[] = "Empty field 'jwt signing key'";
        $requiredMissing = true;
    }else{
        $jwtSigningKey = trim($_POST['jwtsigningkey']);
        if(!ctype_alnum($jwtSigningKey)){
            $errors[] = 'JWT signing key must be alphanumeric';
            $validationFault = true;
        }
        if(strlen($jwtSigningKey) < 16 || strlen($jwtSigningKey) > 64){
            $errors[] = 'JWT signing key lenght should be between 16 and 64 (inclusive)';
            $validationFault = true;
        }
        $oldFormValues['jwtsigningkey'] = $jwtSigningKey;
    }
    
    // sharedsecret
    if(empty($_POST['sharedsecret'])){
        $errors[] = "Empty field 'Shared Secret'";
        $requiredMissing = true;
    }else{
        $sharedSecret = trim($_POST['sharedsecret']);
        if(!ctype_alnum($sharedSecret)){
            $errors[] = 'Shared Secret must be alphanumeric';
            $validationFault = true;
        }
        if(strlen($sharedSecret) < 16 || strlen($sharedSecret) > 64){
            $errors[] = 'Shared Secret lenght should be between 16 and 64 (inclusive)';
            $validationFault = true;
        }
        $oldFormValues['sharedsecret'] = $sharedSecret;
    }
    
    // optional relayhost
    if(empty($_POST['relayhost'])){
        $relayHost = 'smarthost.domain.tld';
    }else{
        $relayHost = trim($_POST['relayhost']);
        $oldFormValues['relayhost'] = $relayHost;
    }
    
    // optional rootalias
    if(empty($_POST['rootalias'])){
        $rootAlias = 'user@domain.tld';
    }else{
        $rootAlias = trim($_POST['rootalias']);
        $oldFormValues['rootalias'] = $rootAlias; 
    }
    
    if($requiredMissing){
        $errors[] = "All fields are required (except optional).";
        return;
    }
    if($validationFault){
        return;
    }
    
    // create folders
    exec("mkdir -p ".$webRoot."cache 2>&1",$output1,$exitstatus1);
    exec("mkdir -p ".$webRoot."cache/volt 2>&1",$output2,$exitstatus2);
    exec("mkdir -p ".$webRoot."cache/security 2>&1",$output3,$exitstatus3);
    exec("mkdir -p ".$webRoot."logs 2>&1",$output4,$exitstatus4);
    exec("mkdir -p ".$webRoot."app/config/keys 2>&1",$output5,$exitstatus5);
    if($exitstatus1 != 0 || $exitstatus2 != 0 || $exitstatus3 != 0 || $exitstatus4 != 0 || $exitstatus5 != 0) {
        $errors = array_merge($output1,$output2,$output3,$output4,$output5);
        return;
    }
    
    // create public and private key
    $cmd = 'openssl genpkey -algorithm RSA -out '.$webRoot.'app/config/keys/private.key -pkeyopt rsa_keygen_bits:2048 2>&1';
    exec($cmd,$output,$exitstatus);
    if($exitstatus != 0) {
        $errors = $output;
        return;
    }
    $cmd = 'openssl rsa -pubout -in '.$webRoot.'app/config/keys/private.key -out '.$webRoot.'app/config/keys/public.pem 2>&1';
    exec($cmd,$output,$exitstatus);
    if($exitstatus != 0) {
        $errors = $output;
        return;
    }
    
    // create core tables
    unset($output);
    $output = array();
    $cmd = "mysql -u ".$dbUser." -p'".$dbPassword."' -D ".$dbName." < ".$webRoot."vendor/rnt-forest/core/config/install.sql 2>&1";
    exec($cmd,$output,$exitstatus);
    if($exitstatus != 0) {
        $errors = $output;
        return;
    }
    
    // create dns tables
    unset($output);
    $output = array();
    $cmd = "mysql -u ".$dbUser." -p'".$dbPassword."' -D ".$dbName." < ".$webRoot."vendor/rnt-forest/dns/config/install.sql 2>&1";
    exec($cmd,$output,$exitstatus);
    if($exitstatus != 0) {
        $errors = $output;
        return;
    }
    
    // create mysql connection
    $mysqli = new mysqli($dbHost,$dbUser,$dbPassword,$dbName);
    
    // create customer in db
    $sql = "INSERT INTO `customers` (`id`, `lastname`, `firstname`, `company`, `company_add`, `street`, `po_box`, `zip`, `city`, `phone`, `email`, `website`, `comment`, `active`) ".
    " VALUES(1, 'Istrator', 'Admin', 'MyCompany', '', '', '', '', '', '', '', '', 'Just a placeholder', 1)";
    
    if(!$mysqli->query($sql)){
        $errors = "Not able to insert the initial customer: ".$mysqli->error;    
    }

    // create adminuser in db
    $sql = "INSERT INTO `logins` (`id`, `loginname`, `password`, `hashtoken`, `hashtoken_reset`, `hashtoken_expire`, `customers_id`, `admin`, `main`, `groups`, `title`, `lastname`, `firstname`, `phone`, `comment`, `email`, `active`, `locale`, `permissions`, `settings`, `newsletter`) ".
    " VALUES(1, 'admin', '".hash('sha256', $securitySalt.$adminPassword)."', NULL, NULL, NULL, 1, 1, 0, 1, 'Mr', 'Istrator', 'Admin', NULL, NULL, 'admin@mycompany.com', 1, 'en_US.utf8', 'NULL', 'NULL', 0)";
    
    if(!$mysqli->query($sql)){
        $errors = "Not able to insert the initial adminuser: ".$mysqli->error;    
    }
    
    // insert groups
    $sql = file_get_contents("groups.sql");
    if(!$mysqli->query($sql)){
        $errors = "Not able to insert the initial groups: ".$mysqli->error;    
    }
    
    // insert menu
    $sql = file_get_contents("menu.sql");
    if(!$mysqli->query($sql)){
        $errors = "Not able to insert the initial menu: ".$mysqli->error;    
    }
    
    // create config.ini
    $configContent = '[database]
        host     = '.$dbHost.'
        username = '.$dbUser.'
        password = '.$dbPassword.'
        dbname   = '.$dbName.'
        
        [application]
        securitySalt = '.$securitySalt.'
        
        [mail]
        relayhost = '.$relayHost.'
        rootalias = '.$rootAlias.'

        [push]
        jwtsigningkey = '.$jwtSigningKey.'
        sharedsecret = '.$sharedSecret.'
        
        [dns]
        dnsmaster = '.$dnsMaster.'
        primary = '.$primaryDns.'
        mail = '.$soaMail;
    file_put_contents($webRoot."app/config/config.ini",str_replace(' ','',$configContent));
    
    // create cronjob
    $cron = "* * * * * /usr/bin/php -q ".$webRoot."app/cli.php jobsystem push 2>&1\n".
    "";
    file_put_contents($webRoot."install/cron",$cron);
    
    $user = exec('whoami');
    $cmd = 'crontab -u '.$user.' '.$webRoot.'install/cron 2>&1';
    unset($output);
    $output = array();
    exec($cmd,$output,$exitstatus);
    if($exitstatus != 0) {
        $errors = $output;
        return;
    }
    
    unlink($webRoot."install/cron");
    
    // rename .htaccess
    if(file_exists($webRoot.".htaccess.install")) {
        copy($webRoot.".htaccess.install",$webRoot.".htaccess");
    } else {
        $errors[] = '.htaccess.install was not found. Please make sure it exists.';
        return;
    }
}

install();

include("index.php");
?>
