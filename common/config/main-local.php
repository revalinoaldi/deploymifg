<?php
require '../../vendor/autoload.php';

use Aws\SecretsManager\SecretsManagerClient; 
use Aws\Exception\AwsException;
$client = new SecretsManagerClient([
    'version' => 'latest',
    'region' => 'ap-southeast-3',
]);

$secretName = 'arn:aws:secretsmanager:ap-southeast-3:402663288391:secret:prd/legacy/mifg-SL5M0O';

try {
    $result = $client->getSecretValue([
        'SecretId' => $secretName,
    ]);

} catch (AwsException $e) {
    $error = $e->getAwsErrorCode();
    if ($error == 'DecryptionFailureException') {
        // Secrets Manager can't decrypt the protected secret text using the provided AWS KMS key.
        // Handle the exception here, and/or rethrow as needed.
        throw $e;
    }
    if ($error == 'InternalServiceErrorException') {
        // An error occurred on the server side.
        // Handle the exception here, and/or rethrow as needed.
        throw $e;
    }
    if ($error == 'InvalidParameterException') {
        // You provided an invalid value for a parameter.
        // Handle the exception here, and/or rethrow as needed.
        throw $e;
    }
    if ($error == 'InvalidRequestException') {
        // You provided a parameter value that is not valid for the current state of the resource.
        // Handle the exception here, and/or rethrow as needed.
        throw $e;
    }
    if ($error == 'ResourceNotFoundException') {
        // We can't find the resource that you asked for.
        // Handle the exception here, and/or rethrow as needed.
        throw $e;
    }
}
if (isset($result['SecretString'])) {
    $secret = json_decode($result['SecretString'], true);
} else {
    $secret = json_decode(base64_decode($result['SecretBinary']), true);
}

return [
    'components' => [
        /*
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=database-mifg-nprd.ifg-life.id;dbname=ifgdb',
            'username' => 'admin',
            'password' => 'Password09',
            'charset' => 'utf8',
        ],
        */
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=10.10.20.239;dbname=ifgdb',
            'username' => $secret['username'],
            'password' => $secret['password'],
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
    ],
];
