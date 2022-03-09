@extends('installer.template')
@section('title', "Server Requirements")
@section('content')

<?php

$reqList = array(
    'php'           => "7.2.5",
    'bcmath' => true,
    'ctype' => true,
    'fileinfo'=> true,
    'json' => true,
    'mbstring' => true,
    'openssl' => true,
    'pdo' => true,
    'tokenizer' => true,
    'xml' => true,
    
);


//echo substr(phpversion(), 0, 5) . "<br>";
// versionCompare(PHP_VERSION, '>=', $reqList['php']) ."<br>";


$strOk = '<i class="fas fa-check-circle"></i>';
$strFail = '<i class="fas fa-exclamation-triangle"></i>';
$strUnknown = '<i class="fas fa-question"></i>';

$requirements = [];
// PHP Version
//$requirements['php'] = versionCompare(PHP_VERSION, '>=', $reqList['php']);

$requirements['php'] = (version_compare(PHP_VERSION, $reqList['php']) >= 0);

$requirements['bcmath'] = extension_loaded("bcmath");

// CTYPE PHP Extension
$requirements['ctype'] = extension_loaded("ctype");

// CTYPE PHP Extension
$requirements['fileinfo'] = extension_loaded("fileinfo");

// JSON PHP Extension
$requirements['json'] = extension_loaded("json");


// Mbstring PHP Extension
$requirements['mbstring'] = extension_loaded("mbstring");

// OpenSSL PHP Extension
$requirements['openssl'] = extension_loaded("openssl");

// PDO PHP Extension
$requirements['pdo'] = defined('PDO::ATTR_DRIVER_NAME');

// Tokenizer PHP Extension
$requirements['tokenizer'] = extension_loaded("tokenizer");

// XML PHP Extension
$requirements['xml'] = extension_loaded("xml");

// GD
$requirements['gd'] = extension_loaded("gd");

// imap
$requirements['imap'] = extension_loaded("imap");



// mod_rewrite
$requirements['mod_rewrite'] = null;

if (function_exists('apache_get_modules')) 
{
    $requirements['mod_rewrite'] = in_array('mod_rewrite', apache_get_modules());
}

function check_folder_permissions($folders)
{
    $i = 0;
    foreach ($folders as $folder=>$full_path) 
    {
        $data[$i]['isSet']  = (is_dir($full_path) && is_writable($full_path)) ? TRUE : FALSE;
       
        $data[$i]['folder'] = $folder;
        $i++;
    }
   return $data;
}

function versionCompare($version1, $operator, $version2) {
   
    $_fv = intval ( trim ( str_replace ( '.', '', $version1 ) ) );
    $_sv = intval ( trim ( str_replace ( '.', '', $version2 ) ) );
   
    if (strlen ( $_fv ) > strlen ( $_sv )) {
        $_sv = str_pad ( $_sv, strlen ( $_fv ), 0 );
    }
   
    if (strlen ( $_fv ) < strlen ( $_sv )) {
        $_fv = str_pad ( $_fv, strlen ( $_sv ), 0 );
    }
   
    return version_compare ( ( string ) $_fv, ( string ) $_sv, $operator );
}



   $folder_permissions = check_folder_permissions([
        'storage/framework/'     => storage_path(). '/framework',
        'storage/logs/'          => storage_path(). '/logs',
        'bootstrap/cache/'       => base_path(). '/bootstrap/cache/'
    ]);

   $err = 0;

// Finding Errors
foreach ($reqList as $key => $value) 
{
    if(!$requirements[$key])
    {       
        $err++;
    }
}
foreach($folder_permissions as $row)
{
    if(!($row['isSet'] == 1))
    {
        $err++;
    }
}
 
if(!($data['sym_link_eanabled'] == TRUE) )
{
    $err++;
}

// End of Findining errors 
?>

<h1 class="text-center mt-5 mb-4">Welcome to Prowriters!</h1>
<div class="shadow p-3 mb-5 bg-white rounded mx-auto w-75" style="font-size: 13px;">
 
     
    <h5>Server Requirements.</h5>    
    <hr>
    <p>PHP >= {{   $reqList['php'] }} <?php echo ($requirements['php'] ? $strOk : $strFail); ?></p>    

    <div class="row">
        <div class="col-md-6">
            <table class="table table-sm table-bordered">
                <thead>
                   <tr>
                      <th scope="col">PHP Extensions</th>
                   
                      <th scope="col"></th>
                   </tr>
                </thead>
                <tbody style="font-size: 13px;">
                   
                   <tr>
                       <td>BCMath PHP Extension</td> 
                       <td><?php echo $requirements['bcmath'] ? $strOk : $strFail; ?></td>
                   </tr>
                  
                   <tr>
                       <td>Ctype PHP Extension</td> 
                       <td><?php echo $requirements['ctype'] ? $strOk : $strFail; ?></td>
                   </tr>
       
                   <tr>
                       <td>Fileinfo PHP extension</td> 
                       <td><?php echo $requirements['fileinfo'] ? $strOk : $strFail; ?></td>
                   </tr>
       
       
                   <tr>
                       <td>JSON PHP Extension</td> 
                       <td> <?php echo $requirements['json'] ? $strOk : $strFail; ?></td>
                   </tr>
       
       
                   <tr>
                       <td>Mbstring PHP Extension</td> 
                       <td> <?php echo $requirements['mbstring'] ? $strOk : $strFail; ?></td>
                   </tr>
               
                 
                   <tr>
                       <td>OpenSSL PHP Extension</td> 
                       <td> <?php echo $requirements['openssl'] ? $strOk : $strFail; ?></td>
                   </tr>
                   
              
                   <tr>
                       <td>PDO PHP Extension</td> 
                       <td> <?php echo $requirements['pdo'] ? $strOk : $strFail; ?></td>
                   </tr>           
       
            
                   <tr>
                       <td>Tokenizer PHP Extension</td> 
                       <td> <?php echo $requirements['tokenizer'] ? $strOk : $strFail; ?></td>
                   </tr>
               
                   <tr>
                       <td>XML PHP Extension</td> 
                       <td> <?php echo $requirements['xml'] ? $strOk : $strFail; ?></td>
                   </tr>
       
       
       
                   
       
                   
       
                   
                </tbody>
             </table>

        </div>


        <div class="col-md-6">
            <table class="table table-sm table-bordered">
                <thead>
                   <tr>
                      <th scope="col">Folders</th>
                   
                      <th scope="col"></th>
                   </tr>
                </thead>
                <tbody style="font-size: 13px;">
                   @foreach($folder_permissions as $row)
                   <tr>
                      <td>{{ $row['folder'] }}</td>
                
                      <td class="text-center"><?php echo ($row['isSet'] == 1) ? '<i class="fas fa-check-circle"></i>' : '<i class="fas fa-exclamation-triangle"></i>' ?></td>
                   </tr>
                   @endforeach
                   
                </tbody>
             </table>
       
             <table class="table table-sm table-bordered">
                <thead>
                   <tr>
                      <th scope="col">SymLink</th>
                      <th scope="col"></th>
                   </tr>
                </thead>
                <tbody style="font-size: 13px;">
                   <tr>
                      <td>public/storage  <b>to</b>  storage/app/public</td>
                      <td class="text-center"><?php echo ($data['sym_link_eanabled'] == TRUE) ? '<i class="fas fa-check-circle"></i>' : '<i class="fas fa-exclamation-triangle"></i>' ?></td>
                   </tr>
       
                   
                </tbody>
             </table>
             <p class="text-danger" style="font-size: 14px;">For support please send us an email at <b>support@microelephant.io</b> with your purchase code</p>
             
        </div>
    </div>



    

      
      
      @if($err == 0)
        <a class="btn btn-primary float-md-right" href="{{ route('run_installation_step_2_page') }}"> <i class="fas fa-arrow-circle-right"></i> &nbsp Next  &nbsp &nbsp</a>          
         <div class="clearfix"></div>
      @else
            <p class="text-danger">Your server does not meet all the requirements to install the application</p>   
      @endif


   
</div>


@endsection