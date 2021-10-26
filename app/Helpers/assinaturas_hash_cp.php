<?php
require_once "Crypt_RSA-1.2.1/Crypt/RSA.php";
require_once "Crypt_HMAC2-1.0.0/Crypt_HMAC2-1.0.0/Crypt/HMAC2.php";

//Generates the pair keys

global $public_key, $private_key;
function generate_key_pair()
{

    $key_pair = new Crypt_RSA_KeyPair(32);
    $crypt = new Crypt_HMAC2();

    //Returns public key from the pair
    $public_key = $key_pair->getPublicKey();

    //Returns private key from the pair
    $private_key = $key_pair->getPrivateKey();
}

function chevePrivada()
{
    //$key = new Crypt_RSA_KeyPair(32);
    return "ok";
}

//Check runtime errors
function check_error(&$obj)
{
    if ($obj->isError()) {
        $error = $obj->getLastError();
        switch ($error->getCode()) {
            case CRYPT_RSA_ERROR_WRONG_TAIL :
                // nothing to do
                break;
            default:
                // echo error message and exit
                echo 'error: ', $error->getMessage();
                exit;
        }
    }
}

generate_key_pair();
$plain_text = "Esta string vai ficar toda baralhada";

echo "A string original é ----> $plain_text </br></br></br>";
//get string represenation of the public key
$key = Crypt_RSA_Key::fromString($public_key->toString());

$rsa_obj = new Crypt_RSA;
check_error($rsa_obj);

//Ecnrypts $plain_text by the key $key.
$encrypted = $rsa_obj->encrypt($plain_text, $key);
echo "The encrypted code was succesfully created ---->    $encrypted  </br>";


//Get string represenation of the private key
$key2 = Crypt_RSA_Key::fromString($private_key->toString());
check_error($key2);

//Check encrypting/decrypting function's behaviour
$rsa_obj->setParams(array('dec_key' => $key2));
check_error($rsa_obj);

//Decrypts $enc_text
$decrypted = $rsa_obj->decrypt($encrypted);
echo "The decrypted code was succesfully created ----> $decrypted  </br>";
