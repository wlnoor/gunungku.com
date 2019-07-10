<?php

namespace app\models;

use Yii;
use yii\helpers\StringHelper;

/**
 * This is the model class for table "gunung".
 *
 * @property int $id
 * @property string $nama
 * @property string $deskripsi
 * @property int $ketinggian
 * @property int $id_jenis_gunung
 * @property int $status_aktif
 * @property int $status
 * @property int $kuota
 * @property string $deskripsi_izin
 * @property string $deskripsi_wajib
 * @property string $deskripsi_dilarang
 * @property string $deskripsi_sanksi
 * @property JenisGunung $jenisGunung
 * @property string $statusGunungAktif
 * @property string $statusGunung
 * @property string $ketinggianMdpl
 * @property string $deskripsi_kontak
 */
class Gunung extends \yii\db\ActiveRecord
{
    use ListableTrait;

    const GUNUNG_AKTIF = 10;
    const GUNUNG_NON_AKTIF = 20;

    const DIBUKA = 10;
    const DITUTUP = 20;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gunung';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['nama','unique'],
            [['nama', 'deskripsi', 'ketinggian', 'id_jenis_gunung','status_aktif', 'status'], 'required'],
            [['deskripsi', 'deskripsi_izin', 'deskripsi_wajib', 'deskripsi_dilarang', 'deskripsi_sanksi', 'deskripsi_kontak'], 'string'],
            [['ketinggian', 'id_jenis_gunung', 'status_aktif', 'status', 'kuota'], 'integer'],
            [['nama'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nama' => Yii::t('app', 'Nama'),
            'deskripsi' => Yii::t('app', 'Deskripsi'),
            'ketinggian' => Yii::t('app', 'Ketinggian'),
            'id_jenis_gunung' => Yii::t('app', 'Jenis Gunung'),
            'status_aktif' => Yii::t('app', 'Status Gunung'),
            'status' => Yii::t('app', 'Status'),
            'kuota' => Yii::t('app', 'Kuota Pendaki'),
            'deskripsi_izin' => Yii::t('app', 'Deskripsi Izin'),
            'deskripsi_wajib' => Yii::t('app', 'Deskripsi Wajib'),
            'deskripsi_dilarang' => Yii::t('app', 'Deskripsi Dilarang'),
            'deskripsi_sanksi' => Yii::t('app', 'Deskripsi Sanksi'),
            'deskripsi_kontak' => Yii::t('app', 'Deskripsi Kontak'),
        ];
    }

    public function getKetinggianMdpl()
    {
        return $this->ketinggian.' mdpl';
    }

    public function getJenisGunung()
    {
        return $this->hasOne(JenisGunung::class,['id' => 'id_jenis_gunung']);
    }

    public function getStatusGunungAktif()
    {
        if ($this->status_aktif == self::GUNUNG_AKTIF) {
            return 'Aktif';
        } else {
            return 'Tidak Aktif';
        }
    }

    public function getStatusGunung()
    {
        if ($this->status == self::DIBUKA) {
            return 'Dibuka';
        } else {
            return 'Ditutup';
        }
    }

    public function getDeskripsiTruncate($lenght=250)
    {
        return StringHelper::truncate($this->deskripsi, $lenght);
    }
}
