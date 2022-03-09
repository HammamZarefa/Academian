<!DOCTYPE html>
<html>
<head>
    <title>Install Microelephant App</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">   
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">   

</head>
<style>
    body{
       font-family: 'Open Sans', sans-serif !important;
       background: #eee;
    }
    .main-content{
        background-color: #fff;
        padding: 20px;
        margin-top: 10%;
    }
  
    .required {
        color: red;
    }

    .fa-check-circle {
        color: green;
    }

    .fa-exclamation-triangle {
        color: red;
    }

    
</style>
<body>
<?php

$reqList = array(
    'php'           => '7.1.3',    
    'openssl'       => true,
    'pdo'           => true,
    'mbstring'      => true,
    'tokenizer'     => true,
    'xml'           => true,
    'ctype'         => true,
    'json'          => true,    
    'gd'            => true,
    'imap'          => true
    
);




$strOk = '<i class="fas fa-check-circle"></i>';
$strFail = '<i class="fas fa-exclamation-triangle"></i>';
$strUnknown = '<i class="fas fa-question"></i>';

$requirements = [];
// PHP Version
$requirements['php']        = version_compare(PHP_VERSION, $reqList['php'], ">=");

// OpenSSL PHP Extension
$requirements['openssl']    = extension_loaded("openssl");

// PDO PHP Extension
$requirements['pdo']        = defined('PDO::ATTR_DRIVER_NAME');

// Mbstring PHP Extension
$requirements['mbstring']   = extension_loaded("mbstring");

// Tokenizer PHP Extension
$requirements['tokenizer']  = extension_loaded("tokenizer");

// XML PHP Extension
$requirements['xml']        = extension_loaded("xml");

// CTYPE PHP Extension
$requirements['ctype']      = extension_loaded("ctype");

// JSON PHP Extension
$requirements['json']       = extension_loaded("json");

// GD
$requirements['gd']         = extension_loaded("gd");

// GD
$requirements['imap']       = extension_loaded("imap");

// mod_rewrite
$requirements['mod_rewrite'] = null;

if (function_exists('apache_get_modules')) 
{
    $requirements['mod_rewrite'] = in_array('mod_rewrite', apache_get_modules());
}



$err = 0;

// Finding Errors
foreach ($reqList as $key => $value) 
{
    if(!$requirements[$key])
    {       
        $err++;
    }
}


// End of Findining errors 
?>
<div class="container">
   <div class="row">
      <div class="col-md-12">
         <div class="mx-auto" style="background: #fff; width: 40%; padding: 20px;  margin-bottom: 10%; font-size: 13px;">
            <h3>Server Requirements</h3>
            <hr>
            <p>PHP >=    <?php echo $reqList['php']. ' ' . ($requirements['php'] ? $strOk : $strFail); ?></p>
            <table class="table table-sm table-bordered">
               <thead>
                  <tr>
                     <th scope="col">PHP Extensions</th>
                     <th scope="col"></th>
                  </tr>
               </thead>
               <tbody style="font-size: 13px;">
                  <?php if ($reqList['openssl']) : ?>
                  <tr>
                     <td>OpenSSL PHP Extension</td>
                     <td><?php echo $requirements['openssl'] ? $strOk : $strFail; ?></td>
                  </tr>
                  <?php endif; ?>
                  <?php if ($reqList['pdo']) : ?>
                  <tr>
                     <td>PDO PHP Extension</td>
                     <td> <?php echo $requirements['pdo'] ? $strOk : $strFail; ?></td>
                  </tr>
                  <?php endif ?>
                  <?php if ($reqList['mbstring']) : ?>
                  <tr>
                     <td>Mbstring PHP Extension</td>
                     <td> <?php echo $requirements['mbstring'] ? $strOk : $strFail; ?></td>
                  </tr>
                  <?php endif ?>
                  <?php if ($reqList['tokenizer']) : ?>
                  <tr>
                     <td>Tokenizer PHP Extension</td>
                     <td> <?php echo $requirements['tokenizer'] ? $strOk : $strFail; ?></td>
                  </tr>
                  <?php endif ?>
                  <?php if ($reqList['xml']) : ?>
                  <tr>
                     <td>XML PHP Extension</td>
                     <td> <?php echo $requirements['xml'] ? $strOk : $strFail; ?></td>
                  </tr>
                  <?php endif ?>
                  <?php if ($reqList['ctype']) : ?>
                  <tr>
                     <td>CTYPE PHP Extension</td>
                     <td> <?php echo $requirements['ctype'] ? $strOk : $strFail; ?></td>
                  </tr>
                  <?php endif ?>
                  <?php if ($reqList['json']) : ?>
                  <tr>
                     <td>JSON PHP Extension</td>
                     <td> <?php echo $requirements['json'] ? $strOk : $strFail; ?></td>
                  </tr>
                  <?php endif ?>
                  <?php if ($reqList['gd']) : ?>
                  <tr>
                     <td>GD Library</td>
                     <td> <?php echo $requirements['gd'] ? $strOk : $strFail; ?></td>
                  </tr>
                  <?php endif ?>
                  <?php if ($reqList['imap']) : ?>
                  <tr>
                     <td>Imap</td>
                     <td> <?php echo $requirements['imap'] ? $strOk : $strFail; ?></td>
                  </tr>
                  <?php endif ?>
                  <?php if (!empty($reqList['obs'])): ?>
                  <tr>
                     <td colspan="2"><?php echo $reqList['obs'] ?></td>
                  </tr>
                  <?php endif; ?>
               </tbody>
            </table>



             <div>
                  <?php
                    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

                    if($err > 0)
                    {
                       ?>
                            <h6 style="color: red;">Your server do not match all the requirements</h6>
                       <?php
                    }
                    else
                    {
                        header("location:" .$actual_link. 'system-check');
                    }

                    ?>
            </div>

         </div>
      </div>


     
   </div>
</div>






</body>
</html>