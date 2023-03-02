# -*- coding: utf-8 -*-

from fastapi.routing import APIRouter
from apps.ifg.urls import router as router_token
from apps.ifg.urls import routerapi as router_api
from apps.ifg.urls import routermaster as router_master

router = APIRouter(prefix='/api/v1')
router.include_router(router_token, prefix='/token', tags=['auth'])
router.include_router(router_master, prefix='/ifg-master', tags=['IFG Master'])
router.include_router(router_api, prefix='/ifg', tags=['IFG Apis'])
