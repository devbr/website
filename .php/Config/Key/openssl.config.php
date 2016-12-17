<?php
$SSLcnf = array(
            'config' => __DIR__.'/openssl.cnf',
            'encrypt_key' => true,
            'private_key_type' => OPENSSL_KEYTYPE_RSA,
            'digest_alg' => 'sha512',
            'x509_extensions' => 'v3_ca',
            'private_key_bits' => 2048
         );

// Fill in data for the distinguished name to be used in the cert
// You must change the values of these keys to match your name and
// company, or more precisely, the name and company of the person/site
// that you are generating the certificate for.
// For SSL certificates, the commonName is usually the domain name of
// that will be using the certificate, but for S/MIME certificates,
// the commonName will be the name of the individual who will use the
// certificate.

$dn = array(
    "countryName" => "BR",
    "stateOrProvinceName" => "Rio de Janeiro",
    "localityName" => "Mage",
    "organizationName" => "ACME PHP web site",
    "organizationalUnitName" => "Security",
    "commonName" => "base.loc",
    "emailAddress" => "admin@base.loc"
);
