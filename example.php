<?php

require 'vendor/autoload.php';

use Rvdv\Ews\Client;

$client = new Client('[SERVER]', '[USERNAME]', '[PASSWORD]');

$result = $client->FindItem(array(
    'Traversal' => 'Shallow',
    'ItemShape' => array(
        'BaseShape' => 'IdOnly',
        'AdditionalProperties' => array(
            'FieldURI' => array(
                'FieldURI' => 'item:Subject',
            ),
        ),
    ),
    'IndexedPageItemView' => array(
        'MaxEntriesReturned' => '10',
        'Offset' => '0',
        'BasePoint' => 'Beginning',
    ),
    'Restriction' => array(
        'IsEqualTo' => array(
            'FieldURI' => array(
                'FieldURI' => 'message:IsRead',
            ),
            'FieldURIOrConstant' => array(
                'Constant' => array(
                    'Value' => '1',
                ),
            ),
        ),
    ),
    'ParentFolderIds' => array(
        'DistinguishedFolderId' => array(
            'Id' => 'inbox',
        )
    ),
));

var_dump($result);
