import logging
from logging import handlers


def loggerHandler():
    fname = "log/error.log"
    formatLoging = logging.Formatter('%(asctime)s - %(name)s - %(levelname)s - %(message)s')
    handler = handlers.TimedRotatingFileHandler(fname, when='midnight')
    handler.setFormatter(formatLoging)
    return handler

def loggingError(msg):
    print(msg)
    logger = logging.getLogger(__name__)
    logger.setLevel(logging.ERROR)
    logger.addHandler(loggerHandler())
    logger.error(msg, exc_info=True)

