<?php

return [
    'DecryptionContext' => [
        'update' => 'string',
        'finalize' => 'string',
    ],
    'DigestContext' => [
        'update' => 'void',
        'keyUpdate' => 'void',
        'finalize' => 'string',
    ],
    'EncryptionContext' => [
        'update' => 'string',
        'finalize' => 'string',
    ],
    'Key' => [
        'initializeSignature' => 'void',
        'initializeVerification' => 'void',
        'initializeEncryption' => 'void',
        'initializeDecryption' => 'void',
        'encrypt' => 'string',
        'decrypt' => 'string',
        'wrap' => 'string',
        'unwrap' => 'void',
        'sign' => 'string',
        'verify' => 'bool',
        'derive' => 'void',
        'getAttributeValue',
        'getSize',
    ],
    'Mechanism' => [
        '__debugInfo' => 'array',
    ],
    'Module' => [
        'getInfo' => 'array',
        'getSlots' => 'array',
        'getSlotList' => 'array',
        'getSlotInfo' => 'array',
        'getTokenInfo' => 'array',
        'getMechanismList' => 'array',
        'getMechanismInfo' => 'array',
        'initToken',
        'openSession' => '\Pkcs11\Session',
        'waitForSlotEvent',
        'C_GetInfo' => 'array',
        'C_GetSlotList' => 'array',
        'C_GetSlotInfo',
        'C_GetTokenInfo',
        'C_GetMechanismList' => 'array',
        'C_GetMechanismInfo',
        'C_InitToken',
        'C_SetPIN',
        'C_InitPIN',
        'C_OpenSession' => '\Pkcs11\Session',
        'C_CloseSession',
        'C_GetSessionInfo',
        'C_Login',
        'C_Logout',
        'C_WaitForSlotEvent',
        'C_GenerateKey',
        'C_GenerateKeyPair',
        'C_DigestInit',
        'C_Digest',
        'C_DigestUpdate',
        'C_DigestKey',
        'C_DigestFinal',
        'C_SignInit',
        'C_Sign',
        'C_VerifyInit',
        'C_Verify',
        'C_EncryptInit',
        'C_Encrypt',
        'C_DecryptInit',
        'C_Decrypt',
        'C_Wrap',
        'C_Unwrap',
        'C_GenerateRandom',
        'C_SeedRandom',
        'C_CreateObject',
        'C_FindObjectsInit',
        'C_FindObjects',
        'C_FindObjectsFinal',
        'C_GetAttributeValue',
        'C_CopyObject',
        'C_DestroyObject',
    ],
    'P11Object' => [
        'getAttributeValue',
        'getSize',
    ],
    'Session' => [
        'login',
        'getInfo',
        'logout',
        'initPin',
        'setPin',
        'findObjects' => 'array',
        'createObject',
        'copyObject',
        'destroyObject',
        'digest',
        'initializeDigest',
        'generateKey',
        'generateKeyPair',
        'seedRandom',
        'generateRandom' => 'string',
        'openUri',
        '__debugInfo' => 'array',
    ],
    'SignatureContext' => [
        'update' => 'void',
        'finalize' => 'string',
    ],
    'VerificationContext' => [
        'update' => 'void',
        'finalize' => 'bool',
    ],
];