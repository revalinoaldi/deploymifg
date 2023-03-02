# -*- coding: utf-8 -*-

from fastapi.routing import APIRouter

from apps.ifg.views.ifgtok import router as router_token
from apps.ifg.views.ifgapi import router as ifgapi
from apps.ifg.views.ifgmaster import router as ifgmaster


router = APIRouter()
routerapi = APIRouter()
routermaster = APIRouter()
router.include_router(router_token)
routerapi.include_router(ifgapi)
routermaster.include_router(ifgmaster)