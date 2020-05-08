<?php

//     $paysafeApiKeyId = 'your-key-id';
//     $paysafeApiKeySecret = 'your-key-secret';
//     $paysafeAccountNumber = 'your-account-number';
// // The currencyCode should match the currency of your Paysafe account.
// // The currencyBaseUnitsMultipler should in turn match the currencyCode.
// // Since the API accepts only integer values, the currencyBaseUnitMultiplier is used convert the decimal amount into the accepted base units integer value.
//     $currencyCode = 'your-account-currency-code'; // for example: CAD
//     $currencyBaseUnitsMultiplier = 'currency-base-units-multiplier'; // for example: 100


    $paysafeApiKeyId = 'test_niteshjain';
    $paysafeApiKeySecret = 'B-qa2-0-5ca1e67e-0-302d0214768ff803002244b5a085fad352fbc8ced2759e3c0215008afea87fd732c437c714adc4ccfed1f3082685b5';
    $paysafeAccountNumber = '1001363210';

// The currencyCode should match the currency of your Paysafe account.
// The currencyBaseUnitsMultipler should in turn match the currencyCode.
// Since the API accepts only integer values, the currencyBaseUnitMultiplier is used convert the decimal amount into the accepted base units integer value.
     $currencyCode = 'EUR'; // for example: CAD
     $currencyBaseUnitsMultiplier = '60'; // for example: 100
   require_once('./paysafe/source/paysafe.php');
    ?>
    