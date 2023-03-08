import boto3
import botocore
import botocore.session
from botocore.exceptions import ClientError
from aws_secretsmanager_caching import SecretCache, SecretCacheConfig
import json

def get_secret():
    secret_name = "arn:aws:secretsmanager:ap-southeast-3:402663288391:secret:prd/legacy/mifg-SL5M0O"
    region_name = "ap-southeast-3"

    client = botocore.session.get_session().create_client('secretsmanager',region_name=region_name)
    cache_config = SecretCacheConfig()
    cache = SecretCache(config=cache_config, client=client)

    try:
        secret = cache.get_secret_string(secret_name)
    except ClientError as e:
        if e.response['Error']['Code'] == 'ResourceNotFoundException':
            print("The requested secret " + secret_name + " was not found")
        elif e.response['Error']['Code'] == 'InvalidRequestException':
            print("The request was invalid due to:", e)
        elif e.response['Error']['Code'] == 'InvalidParameterException':
            print("The request had invalid params:", e)
        elif e.response['Error']['Code'] == 'DecryptionFailure':
            print("The requested secret can't be decrypted using the provided KMS key:", e)
        elif e.response['Error']['Code'] == 'InternalServiceError':
            print("An error occurred on service side:", e)
    else:
        # Secrets Manager decrypts the secret value using the associated KMS CMK
        # Depending on whether the secret was a string or binary, only one of these fields will be populated
        if 'SecretString' in get_secret_value_response:
            text_secret_data = get_secret_value_response['SecretString']
        else:
            text_secret_data = get_secret_value_response['SecretBinary']
        return text_secret_data

print(get_secret())
#secret = json.loads(get_secret())
#print(secret['username'])
#print(secret['password'])
#print(secret.password)
