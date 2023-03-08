from fastapi import APIRouter, Header
from routers import ContextIncludedRoute
from utils.sqlpool import Mysql
from responses.BaseResponse import *
from dto.addressmapping import *
from repository.AddressRepo import AddressRepo
from const.appcfg import *

router = APIRouter(route_class=ContextIncludedRoute)

@router.post('/mapping')
def mapping(data: AddressMap):
    res = None
    mysql = Mysql()
    am = AddressRepo(mysql)
    try:
        if data.provinsi != '' and data.kota != '' and data.kecamatan != '' and data.kelurahan != '':
            res = am.getPostalCode(data.provinsi, data.kota, data.kecamatan, data.kelurahan)
        elif data.provinsi != '' and data.kota != '' and data.kecamatan != '' and data.kelurahan == '':
            res = am.getKelurahan(data.provinsi, data.kota, data.kecamatan)
        elif data.provinsi != '' and data.kota != '' and data.kecamatan == '' and data.kelurahan == '':
            res = am.getKecamatan(data.provinsi, data.kota)
        elif data.provinsi != '' and data.kota == '' and data.kecamatan == '' and data.kelurahan == '':
            res = am.getCity(data.provinsi)
        else:
            res = am.getProvinces()
    except Exception as e:
        print(e)

    mysql.dispose()
    mysql.closing()

    return res