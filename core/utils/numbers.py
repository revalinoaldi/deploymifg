import random
from starlette.responses import StreamingResponse


def random_number(digit):
    return ''.join(random.sample('0123456789', digit))
