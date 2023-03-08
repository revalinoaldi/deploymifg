from enum import Enum

class UserLevel(Enum):
    CLUSTER = 1
    CVS = 2
    KCP = 3

class UserScopes(Enum):
    REGULER = 0
    KYC = 1
    BORROWER = 2