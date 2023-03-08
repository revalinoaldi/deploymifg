import os
from dotenv import load_dotenv
load_dotenv(override=True)

IFG_ENDPOINT = 'https://asuransi.ifg-life.id/api/'
username = os.getenv('IFG_ENDPOINT_USERNAME')
password = os.getenv('IFG_ENDPOINT_PASSWORD')