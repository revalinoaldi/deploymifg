<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "closing_statement".
 *
 * @property int $id
 * @property string $no_spaj
 * @property string $no_agent
 * @property string $nama_agent
 * @property string $no_lisensi
 * @property string $phone
 * @property string $kenal_pp_selama
 * @property string $kenal_sebagai
 * @property string $kenal_tertanggung_selama
 * @property string $kenal_tertanggung_sebagai
 * @property string $kenal_pembayar_premi_selama
 * @property string $kenal_pembayar_premi_sebagai
 * @property string $kesehatan_tertanggung
 * @property string $kondisi_keuangan_sesuai
 * @property string $awal_penutupan_oleh
 * @property string $lokasi_closing
 * @property string $tanggal_closing
 * @property string $created_date
 */
class ClosingStatement extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'closing_statement';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kenal_pp_selama', 'kenal_sebagai', 'kenal_tertanggung_selama', 'kenal_tertanggung_sebagai', 'kenal_pembayar_premi_selama', 'kenal_pembayar_premi_sebagai', 'kesehatan_tertanggung', 'kondisi_keuangan_sesuai', 'awal_penutupan_oleh'], 'required'],
            [['tanggal_closing', 'created_date'], 'safe'],
            [['no_spaj', 'no_agent', 'phone', 'kenal_pp_selama', 'kenal_sebagai', 'kenal_tertanggung_selama', 'kenal_tertanggung_sebagai', 'kenal_pembayar_premi_selama', 'kenal_pembayar_premi_sebagai', 'kesehatan_tertanggung', 'kondisi_keuangan_sesuai', 'awal_penutupan_oleh', 'lokasi_closing'], 'string', 'max' => 50],
            [['nama_agent', 'no_lisensi'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'no_spaj' => 'No Spaj',
            'no_agent' => 'No Agent',
            'nama_agent' => 'Nama Agent',
            'no_lisensi' => 'No Lisensi',
            'phone' => 'Phone',
            'kenal_pp_selama' => 'Kenal Pp Selama',
            'kenal_sebagai' => 'Kenal Sebagai',
            'kenal_tertanggung_selama' => 'Kenal Tertanggung Selama',
            'kenal_tertanggung_sebagai' => 'Kenal Tertanggung Sebagai',
            'kenal_pembayar_premi_selama' => 'Kenal Pembayar Premi Selama',
            'kenal_pembayar_premi_sebagai' => 'Kenal Pembayar Premi Sebagai',
            'kesehatan_tertanggung' => 'Kesehatan Tertanggung',
            'kondisi_keuangan_sesuai' => 'Kondisi Keuangan Sesuai',
            'awal_penutupan_oleh' => 'Awal Penutupan Oleh',
            'lokasi_closing' => 'Lokasi Closing',
            'tanggal_closing' => 'Tanggal Closing',
            'created_date' => 'Created Date',
        ];
    }
}
