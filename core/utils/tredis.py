import redis
import json


REDIS_HOST = "127.0.0.1"
REDIS_PORT = 6379
REDIS_DB = 3
# REDIS_PWD = "th1s1Ss3cr3tP4SSW0RD"
REDIS_PWD = ""


class Tredis(object):

    def __init__(self):
        self.mc = redis.StrictRedis(host=REDIS_HOST,
                                    port=REDIS_PORT,
                                    db=REDIS_DB,
                                    password=REDIS_PWD)

    def set_cache(self, memkey, content, ttl_seconds):
        return self.mc.set(memkey, json.dumps(content), ttl_seconds)

    def get_cache(self, memkey):
        a = self.mc.get(memkey)
        if not a:
            retval = a
        else:
            retval = a.decode() if a is not None else False
            retval = json.loads(retval)
        return retval

    def del_cache(self, memkey):
        return self.mc.delete(memkey)
