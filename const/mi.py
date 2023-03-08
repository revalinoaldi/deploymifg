import os
from dotenv import load_dotenv
load_dotenv(override=True)

BASE_URL = 'https://development.inhealth.co.id/intracoins_services/api/'
CLIENT_ID = os.getenv('MANDIRI_ENDPOINT_CLIENT_ID')
CLIENT_PASSWORD = os.getenv('MANDIRI_ENDPOINT_CLIENT_PASSWORD')
SECRET_KEY = os.getenv('MANDIRI_ENDPOINT_SECRET_KEY')