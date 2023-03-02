import os
from datetime import datetime, timedelta

import jwt

SECRET_KEY = os.getenv('SECRET_KEY', 'ZmFlNDA1NjQ1ZGFlMTRkOWZlOTU0NTIxODc2YzVmN2YwNGVkMTgxOTRmMWUwYjk2MzY5NDU5NDA3YTBlYzZiZA==')

now = datetime.utcnow() + timedelta(minutes=30)

a = jwt.encode(
            {'message': 'ifg-life'}, SECRET_KEY
        ).encode().decode("utf-8")

print(a)
