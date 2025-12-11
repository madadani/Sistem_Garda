<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Data diambil dari File Excel yang Anda lampirkan
        // Format: [Nama, Nomor HP]
        // Catatan: Untuk data yang tidak punya HP, saya beri ID Dummy agar tidak error
        $drivers = [
            ['GALUH PARWATI', '089644037015'],
            ['HEZKYA LISTIABUDI', '083102555185'],
            ['MUHAMMAD AMIR', '081329572307'],
            ['DWI SAPUTRO', '085642205549'],
            ['MUHAMMAD SETYO', '088985259151'],
            ['MUHAMMAD TEGUH', '082241949991'],
            ['DAVID CAHYONO', '081287460464'],
            ['ANDI PRASETYO', '087733623996'],
            ['SAID', '081542211548'],
            ['ADE EBROT', '082229998001'],
            ['HENDRO', '081393441449'],
            ['BAMBANG S', '082119810339'],
            ['DARVIKA', '08562812536'],
            ['BAGIYONO', '081218073815'],
            ['EDDY', '081329336161'],
            ['SUSAN', '087836577774'],
            ['AGUS', '082136711568'],
            ['ALIEF PANJI', '081393924964'],
            ['SATRIO', '088806658181'],
            ['SUYANTO DEDY', '082327698881'],
            ['KRISTANTO', '082136078878'],
            ['HANAFI', '082136578135'],
            ['ARIE', '083113096468'],
            ['RUSTIYOTO', '085743638249'],
            ['DHONI', '0882003656568'],
            ['ALFIAN', '085158331362'],
            ['SURANTO', '081393650105'],
            ['ARDIANSYAH', '081225111122'],
            ['HAFIDZ', '085741127152'],
            ['AGUS PURWANTO', '085229032104'],
            ['ARFIAN', '085600026142'],
            ['SUMARNO', '082134358009'],
            ['DWI', '085248569739'],
            ['WIDODO', '085701388519'],
            ['AKIL', '087825223945'],
            ['KHUMAIDI', '081253016020'],
            ['NARDI', '081329583363'],
            ['WAHYUDI', '082226011975'],
            ['AGUS SULISTYANTORO', '082241950979'],
            ['AHMAD TAUFIK', '082220044872'],
            ['ARIS PURYANTO', '082137522228'],
            ['SUMARDI CHOXI', '088215120394'],
            ['MARSUDI SANTOSO', '082124805906'],
            ['EKO PRASETYO', '082324999936'],
            ['LUTHFAN', '082136899396'],
            ['BASUKI', '085229044130'],
            ['BAMBANG', '085640112258'],
            ['IRFAN MISWANTO', '081234997605'],
            ['YAHYA', '081392455843'],
            ['ADE H', '081227941528'],
            ['FITRIANTO', '085228070059'],
            ['FAI', '081393677727'],
            ['HARRIS', '088232082120'],
            ['TEDIK ICHVAN', '082313852347'],
            ['TAMAS JOHN', '081391885121'],
            ['WAGIMAN', '082224369067'],
            ['SUTIMIN', '087853071887'],
            ['WAHYU TRI', '085777742621'],
            ['SAKRI', '082137586707'],
            ['NIDA', '085229339324'],
            ['SATRIO WAHYU', '081393052929'],
            ['PAIDI', '081390255900'],
            ['SIDHIQ', '082136898011'],
            ['DALIMAN', '081225906883'],
            ['ROFIQ ROFI', '0882007732958'],
            ['JOKO MURYONO', '082138495286'],
            ['AGUNG PRASTYO', '000000000001'], // Tidak ada HP di Excel, saya beri ID Dummy
            ['SURATMAN', '082225076898'],
            ['TOTOK', '085786602272'],
            ['EKO CB', '087877207348'],
            ['NURYANTO', '085166989408'],
            ['ARIF', '082245300098'],
            ['SRI WIDODO', '081329650550'],
            ['SENTOT NUGROHO', '081329707693'],
            ['AGUNG PRANOTO', '082137666877'],
            ['EKO BUDIYANTO', '082220491940'],
            ['WAWAN', '081335504875'],
            ['IFAT', '082325568544'],
            ['YULI STIYANTO', '085227846225'],
            ['WARSONO KARSO', '087836944765'],
            ['TOTOK', '082328611339'], // Ada nama TOTOK lagi (duplikat nama beda HP)
            ['ENI LESTARI', '0882005370163'],
            ['EKO AGUS', '081329242303'],
            ['EKO PLETET', '000000000002'], // Tidak ada HP di Excel, saya beri ID Dummy
            ['TUTIK HANDAYANI', '085290601768'],
            ['WAWAN', '081226226022'], // Ada nama WAWAN lagi
            ['SUNOTO', '085229172997'],
            ['RAMADHAN', '081229504663'],
            ['EKO KARSONO', '081393454225'],
            ['MUHAMMAD TIBYANI', '082133190702'],
        ];

        // Timestamp saat ini
        $now = Carbon::now();

        foreach ($drivers as $data) {
            DB::table('drivers')->insert([
                'driver_id_card' => $data[1], // Menggunakan No HP
                'name'           => $data[0], // Menggunakan Nama
                'phone_number'   => $data[1], // Menggunakan No HP
                'instansi'       => $data, // Tambahkan nilai default atau sesuaikan sesuai kebutuhan
                'total_points'   => 0,        // Default 0
                'created_at'     => $now,
                'updated_at'     => $now,
            ]);
        }
    }
}