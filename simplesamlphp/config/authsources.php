<?php

$config = array(
    // This is a authentication source which handles admin authentication.
    'admin' => array(
        // The default is to use core:AdminPassword, but it can be replaced with
        // any authentication source.

        'core:AdminPassword',
    ),
    // An authentication source which can authenticate against both SAML 2.0
    // and Shibboleth 1.3 IdPs.
    'departments-sp' => array(
        'saml:SP',
        'privatekey' => 'saml.pem',
        'certificate' => 'saml.crt',
        'entityID' => 'https://departments.as.cornell.edu/',
        'idp' => 'https://shibidp-test.cit.cornell.edu/idp/shibboleth',
    ),
);
