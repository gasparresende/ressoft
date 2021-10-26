<?php

use Illuminate\Support\Facades\Storage;

require_once "Crypt_HMAC2-1.0.0/Crypt_HMAC2-1.0.0/Crypt/HMAC2.php";


function chavePrivada()
{

    return "MIICXAIBAAKBgQDWCvQ3GM1IPRC7cQlwdYHTbmqiOBklVzAciKSM+ph7Cg5leg6p
rgogxXlR8HR7LEzGKjNuYV5paamHvoKcpg4I9RHY8tMgBWgr4xKu3mI0rIlqxwqH
Br28+JObzQ8HK+HLytPMJaYVAYF2jZKllXlzPWuICMYXgy/+RhJgwHK7BQIDAQAB
AoGBAMj0u9jGxmUeQAlb1TrqeBtjvWXUOXefZiJEAAoEdQh/poiLkhyotAWUoZTW
puXF78bVdDgb3qIle+9gZAxisyTp2GL6c1jlN3/cUaGfAPAjp2l0NZ4n23Ec2fd7
QoQF0U4I2KAP1PZRfx7/PSftBE4nWs3DCHNrHX5o4m091GkBAkEA88xwDzcOicYX
ybHaPEn0CprWSLTAA4hZnNwVn4L8di76liictXduaSYLFTIMQl3OkH1hpb/0f/PI
cqQ5D3cp5QJBAODBSH3MkQ904+U/ln8eX0B8In7SUYUpWgmQ6aKs6/HyRl3n0VUe
G5JmyNC46AibmdfBVgBGrHaN2/seYTS9uqECQFH5Z6R2CrlglhcHai3jX99A+NQx
km6dpiQMDGk6DdFfMnrS5P5PThyk4g0aauzVxeLnhbHJvVhYjAmgFl+Q3dECQAqz
KPBUPNOvjOntDQ0gNQis4DeJa7gbL94kt/q2oMTz88Wks6KJvGZL3mORafp+7eQH
oECDHNLIDiD2YUpRfgECQHsEUgtBo2hyt4gdwI+yo9RCZ1TLFMKLDlp/puo16eNj
4Iw1WfMck1Pud1M7UaiXJtmWSPTLVXoQ8LQXbFcWNkw=";
}

function chavePublica()
{

    return "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDWCvQ3GM1IPRC7cQlwdYHTbmqi
OBklVzAciKSM+ph7Cg5leg6prgogxXlR8HR7LEzGKjNuYV5paamHvoKcpg4I9RHY
8tMgBWgr4xKu3mI0rIlqxwqHBr28+JObzQ8HK+HLytPMJaYVAYF2jZKllXlzPWuI
CMYXgy/+RhJgwHK7BQIDAQAB";
}

function assinar()
{
    $key = "jefhgj53457f897457h4g409f5j59d8jk58f345098kdf45893d94583j45f3495j309f4dk0958409k409659685968546fjjggikgjdt";
    $crypt = new Crypt_HMAC2($key, 'sha1');
    $data = '9338';
    $hmac = $crypt->hash($data);

    return $hmac;

}


function getSHA($dados)
{
    //"openssl dgst -sha1 -sign ChavePrivada.pem -out Registo1.sha1 Registo1.txt";
    $data = chavePrivada() . $dados;
    return hash("sha512", $data, false);
}

function assinarHash64($dados)
{
    return base64_encode(getSHA($dados));
}

function verificarHash()
{
    //openssl_verify(chavePrivada() . "2018-05-18;2018-05-18T11:22:19;FAC 001/18;53.002", getSHA(), chavePublica(), "sha512")
}


function pegar1_11_21_31($textoHash)
{
    $dados = str_split($textoHash);
    $res = "";
    for ($i = 0; $i <= count($dados); $i++) {
        if (($i == 1 - 1) || ($i == 11 - 1) || ($i == 21 - 1) || ($i == 31 - 1)) {
            $res .= $dados[$i];
        }
    }
    return ($res != "") ? $res . "-" : null;
}

function certificacaoAGT($hash)
{
    return pegar1_11_21_31($hash) . "Processado por programa validado nº 282/AGT/2020 ZETASOFT";
}

function generateKeys()
{
    //Create RSA Key-Pair
    $keypair = openssl_pkey_new([
        'private_key_bits' => 1024,
        'private_key_type' => OPENSSL_KEYTYPE_RSA,
    ]);


    openssl_pkey_export($keypair, $privkey);

//Get generate keys
    $private_key = $privkey;
    $public_key = openssl_pkey_get_details($keypair);
    $public_key = $public_key['key'];

// SAVE KEYS TO LOCAL DISK
    Storage::disk('local')->put('public.pem', $public_key);
    Storage::disk('local')->put('private.pem', $private_key);

}

// Function to encrypt data
function assinarAGT($data = null, $d_method = 'SHA1')
{

    $private_key = Storage::disk('public')->get('ChavePrivada.pem');

    $digest = openssl_digest($data, 'SHA1');

    openssl_sign($digest, $signature, $private_key, $d_method);

    $final = base64_encode($signature);

    return $final;

}
