import redis
import json
import datetime
from const.appcfg import *
from const.ck import *


class Tredis(object):

    def __init__(self):
        self.mc = redis.StrictRedis(host=REDIS_HOST,
                                    port=REDIS_PORT,
                                    db=REDIS_DB,
                                    password=REDIS_PWD)

    def set_cache(self, memkey, content, ttl_seconds=TTLSHORT):
        return self.mc.set(memkey, json.dumps(content, default=self.__date_escape), ttl_seconds)

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

    def sets_add(self, sets_name, value):
        return self.mc.sadd(sets_name, value)

    def sets_is_member(self, sets_name, value):
        return self.mc.sismember(sets_name, value)

    def sets_delete(self, sets_name, value):
        return self.mc.srem(sets_name, value)

    def sets_members(self, sets_name):
        return self.mc.smembers(sets_name)

    def get_ttl(self, memkey):
        return self.mc.ttl(memkey)

    def incr(self, memkey):
        return self.mc.incr(memkey)

    def __date_escape(self, o):
        if isinstance(o, datetime.datetime):
            return o.__str__()


