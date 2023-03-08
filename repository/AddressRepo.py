

class AddressRepo:

    def __init__(self, mysql):
        self.__conn = mysql

    def getProvinces(self):
        sql = ("""  select id, provinsi as name from address_mapping
                    group by provinsi """)
        return self.__conn.fetch_rows(sql, (), ck='get_province', ttl=3600, many=1)

    def getCity(self, province):
        sql = (""" select id, kota as name from address_mapping
                    where provinsi = %s
                    group by kota  """)
        return self.__conn.fetch_rows(sql, (province,), ck='get_city_{}'.format(province), ttl=3600, many=1)

    def getKecamatan(self, province, city):
        sql = (""" select id, kecamatan as name from address_mapping
                    where provinsi = %s
                    and kota = %s
                    group by kecamatan  """)
        return self.__conn.fetch_rows(sql, (province, city,), ck='get_kecamatan_{}_{}'.format(province, city),
                                      ttl=3600, many=1)

    def getKelurahan(self, province, city, kecamatan):
        sql = ("""  select id, kelurahan as name from address_mapping
                    where provinsi = %s
                    and kota = %s
                    and kecamatan = %s
                    group by kelurahan """)
        return self.__conn.fetch_rows(sql, (province, city, kecamatan,), ck='get_kelurahan_{}_{}_{}'.format(province, city, kecamatan),
                                      ttl=3600, many=1)

    def getPostalCode(self, province, city, kecamatan, kelurahan):

        sql = (""" select id, postal_code as name from address_mapping
                    where provinsi = %s
                    and kota = %s
                    and kecamatan = %s
                    and kelurahan = %s
                    group by postal_code  """)
        return self.__conn.fetch_rows(sql, (province, city, kecamatan, kelurahan,),
                                      ck='get_postalcode_{}_{}_{}_{}'.format(province, city, kecamatan, kelurahan),
                                      ttl=3600, many=1)