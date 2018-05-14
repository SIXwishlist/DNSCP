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

// only render form if config does not exist
if(!file_exists("../app/config/config.ini")){
    renderForm();
} else {
    renderInstalled();
}

/**
 * Generate a random string, using a cryptographically secure. 
 * pseudorandom number generator (random_int)
 * 
 * @param int $length
 * @return string
 */
function randomStr($length){
    $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $str = '';
    $max = strlen($keyspace) - 1;
    for ($i = 0; $i < $length; ++$i) {
        $str .= $keyspace[random_int(0, $max)];
    }
    return $str;
}

function renderHTML($content){
    echo '<html>
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
            <title>Install - DNSCP</title>
            <meta name="description" content="">
            <meta name="author" content="">
            
            <!-- Bootstrap -->
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
            
            <style>
                #content {
                    margin-top: 20px;
                }
                
                #install-form {
                    margin-bottom: 30px;
                }

                #install-form .form-group .form-control {
                    max-width: 50%;
                }

                #install-form h4 {
                    margin-bottom: 20px;
                }
            </style>
        </head>
        <body>
            <div id="content" class="container">
                <h1 class="page-header">Install DNSCP</h1>
                '.$content.'
            </div>
        </body>
    </html>';
}

function renderForm() {
    global $errors;
    global $oldFormValues;
    
    $errorsPrint = '';
    if(!empty($errors)){
        foreach($errors as $error){
            $errorsPrint .= $error.'<br />';
        }
        $errorsPrint = '<div class="alert alert-danger">'.$errorsPrint.'</div>';
    } else {
        $errorsPrint = '';
    }
    
    
    if(is_array($oldFormValues)){
        if(key_exists('databasehost',$oldFormValues)){
            $databasehost = $oldFormValues['databasehost'];
        }
        if(key_exists('databasename',$oldFormValues)){
            $databasename = $oldFormValues['databasename'];
        }
        if(key_exists('databaseuser',$oldFormValues)){
            $databaseuser = $oldFormValues['databaseuser'];
        }
        if(key_exists('databasepassword',$oldFormValues)){
            $databasepassword = $oldFormValues['databasepassword'];
        }
        if(key_exists('adminpassword',$oldFormValues)){
            $adminpassword = $oldFormValues['adminpassword'];
        }
        if(key_exists('securitysalt',$oldFormValues)){
            $securitysalt = $oldFormValues['securitysalt'];
        }
        if(key_exists('jwtsigningkey',$oldFormValues)){
            $jwtsigningkey = $oldFormValues['jwtsigningkey'];
        }
        if(key_exists('sharedsecret',$oldFormValues)){
            $sharedsecret = $oldFormValues['sharedsecret'];
        }
        if(key_exists('relayhost',$oldFormValues)){
            $relayhost = $oldFormValues['relayhost'];
        }
        if(key_exists('rootalias',$oldFormValues)){
            $rootalias = $oldFormValues['rootalias'];
        }
        if(key_exists('dnsMaster',$oldFormValues)){
            $dnsmaster = $oldFormValues['dnsMaster'];
        }
        if(key_exists('soaPrimary',$oldFormValues)){
            $soaPrimary = $oldFormValues['soaPrimary'];
        }
        if(key_exists('soaEmail',$oldFormValues)){
            $soaEmail = $oldFormValues['soaEmail'];
        }    
    }
    
    
    $content = '
    '.$errorsPrint.'
    <form method="post" action="install.php" id="install-form">
        <div class="well clearfix">
            <h4>Specify your database connection infos</h4>
            <p>The database and the user must already exist<p>
            <div class="form-group col-xs-12 row">
                <label for="databasehost" class="col-lg-2 row">Database host</label>
                <input class="form-control col-lg-5" type="text" name="databasehost" value="'.(!empty($databasehost)?$databasehost:'localhost').'">
            </div>
            
            <div class="form-group col-xs-12 row">
                <label for="databasename" class="col-lg-2 row">Database name</label>
                <input class="form-control col-lg-5" type="text" name="databasename" value="'.(!empty($databasename)?$databasename:'').'">
            </div>
        
            <div class="form-group col-xs-12 row">
                <label for="mysqluser" class="col-lg-2 row">Database User</label>
                <input class="form-control col-lg-5" type="text" name="databaseuser" value="'.(!empty($databaseuser)?$databaseuser:'').'">
            </div>
            
            <div class="form-group col-xs-12 row">
                <label for="mysqlpassword" class="col-lg-2 row">Database Password</label>
                <input class="form-control col-lg-5" type="password" name="databasepassword" value="'.(!empty($databasepassword)?$databasepassword:'').'">
            </div>
        </div>
        
        <hr />
        
        <div class="well clearfix">
            <h4>Define the password for the user admin</h4>
            <p>
                This user is used to log in to the DNSCP webapplication. <br /> 
                Choose a secure password in productive use (minimal length 4)
            </p>
            <div class="form-group col-xs-12 row">
                <label for="adminpassword" class="col-lg-2 row">Password for admin</label>
                <input class="form-control col-lg-5" type="password" name="adminpassword" '.(!empty($adminpassword)?'value="'.$adminpassword.'"':'placeholder="securepassword"').'>
            </div>
        </div>
        
        <hr />
        
        <div class="well clearfix">
            <h4>Define your security salt for securing hashed user passwords in the database</h4>
            <p>You can use the randomly generated salt or change it to something you like (alphanumeric, length from 8 to 32)</p>
            <div class="form-group col-xs-12 row">
                <label for="securitysalt" class="col-lg-2 row">Security salt</label>
                <input class="form-control col-lg-5" type="text" name="securitysalt" value="'.(!empty($securitysalt)?$securitysalt:randomStr(16)).'">
            </div>
        </div>
        
        <hr />
        
        <div class="well clearfix">
            <h4>Define your key for signing communication between the app and the openvz hosts</h4>
            <p>You can use the randomly generated key or change it to something you like (alphanumeric, length from 16 to 64)</p>
            <div class="form-group col-xs-12 row">
                <label for="jwtsigningkey" class="col-lg-2 row">JWT signing key</label>
                <input class="form-control col-lg-6" type="text" name="jwtsigningkey" value="'.(!empty($jwtsigningkey)?$jwtsigningkey:randomStr(32)).'">
            </div>
        </div>
        
        <hr />
        
        <div class="well clearfix">
            <h4>Define your shared secret for encryption of sensitive values between the app and the openvz hosts</h4>
            <p>You can use the randomly generated key or change it to something you like (alphanumeric, length from 16 to 64)</p>
            <div class="form-group col-xs-12 row">
                <label for="sharedsecret" class="col-lg-2 row">Shared Secret</label>
                <input class="form-control col-lg-6" type="text" name="sharedsecret" value="'.(!empty($sharedsecret)?$sharedsecret:randomStr(32)).'">
            </div>
        </div>
        
        <hr />
                    
        <div class="well clearfix">
            <h4>(Optional) Specify the mailconfiguration for receiving additional error mails</h4>
            <p>
            This configuration is not crucial for the functionality of DNSCP. You can absolutely skip it and change it later manually in the config.<br/>
            (The rootalias is used i.e. to send an email to with the output of a cronjob running under root user, the relayhost is used for sending mails over a real mailserver to do not run in anti-spam problems)
            </p>
            <div class="form-group col-xs-12 row">
                <label for="relayhost" class="col-lg-2 row">Relayhost</label>
                <input class="form-control col-lg-5" type="text" name="relayhost" '.(!empty($relayhost)?'value="'.$relayhost.'"':'placeholder="smarthost.domain.tld"').'>
            </div>
            
            <div class="form-group col-xs-12 row">
                <label for="rootalias" class="col-lg-2 row">Rootalias</label>
                <input class="form-control col-lg-5" type="text" name="rootalias" '.(!empty($rootalias)?'value="'.$rootalias.'"':'placeholder="user@domain.tld"').'>
            </div>
        </div>
        
        <div class="well clearfix">
            <h4>Define your DNS settings</h4>
            <p>Specify your DNS Master</p> 
            <div class="form-group col-xs-12 row">
                <label for="dnsmaster" class="col-lg-2 row">DNS Master</label>
                <input class="form-control col-lg-5 type="text" name="dnsmaster" '.(!empty($dnsmaster)?'value="'.$dnsmaster.'"':'placeholder="nsmaster.domain.tld"').'>
            </div>
            <p>Specify your primary DNS Server and the E-Mail address of the responsible people for the SOA record in the DNS Zones.</p>
            <div class="form-group col-xs-12 row">
                <label for="soaPrimary" class="col-lg-2 row">Primary DNS</label>
                <input class="form-control col-lg-5 type="text" name="soaPrimary" '.(!empty($soaPrimary)?'value="'.$soaPrimary.'"':'placeholder="ns1.domain.tld"').'>
            </div>
            <div class="form-group col-xs-12 row">
                <label for="soaEmail" class="col-lg-2 row">E-Mail for SOA</label>
                <input class="form-control col-lg-5 type="email" name="soaEmail" '.(!empty($soaEmail)?'value="'.$soaEmail.'"':'placeholder="user@domain.tld"').'>
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    ';
    
    renderHTML($content);
}

function renderInstalled() {
    $content = '
        The DNS Control Panel is now successfully installed. Please delete the install folder. <br /><br />
        <a href="/login" title="Continue to login" class="btn btn-primary">Continue</a>
    ';
    renderHTML($content);
}
?>
