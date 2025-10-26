<?php
// database/seeders/DatabaseSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Warga;
use App\Models\Rw;
use App\Models\Rt;
use App\Models\LembagaDesa;
use App\Models\JabatanLembaga;
use App\Models\AnggotaLembaga;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing data
        $this->clearData();

        // Create Users
        $this->createUsers();

        // Create RW and RT
        $rws = $this->createRwRt();

        // Create Warga
        $wargas = $this->createWargas($rws);

        // Update RW and RT dengan ketua
        $this->updateKetua($rws, $wargas);

        // Create Lembaga Desa
        $lembagas = $this->createLembagaDesa();

        // Create Jabatan Lembaga
        $jabatans = $this->createJabatanLembaga($lembagas);

        // Create Anggota Lembaga
        $this->createAnggotaLembaga($lembagas, $jabatans, $wargas);
    }

    private function clearData(): void
    {
        AnggotaLembaga::query()->delete();
        JabatanLembaga::query()->delete();
        LembagaDesa::query()->delete();
        Warga::query()->delete();
        Rt::query()->delete();
        Rw::query()->delete();
        User::query()->delete();
    }

    private function createUsers(): void
    {
        User::create([
            'username' => 'admin',
            'password' => Hash::make('password'),
            'nama_lengkap' => 'Administrator Sistem',
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::create([
            'username' => 'operator',
            'password' => Hash::make('password'),
            'nama_lengkap' => 'Budi Santoso - Operator Desa',
            'role' => 'operator',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->command->info('Users created successfully!');
    }

    private function createRwRt(): array
    {
        $rws = [];

        // Create 3 RW
        for ($i = 1; $i <= 3; $i++) {
            $rws[$i] = Rw::create([
                'nomor_rw' => str_pad($i, 2, '0', STR_PAD_LEFT),
                'ketua_rw_warga_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Create 3 RT untuk setiap RW
            for ($j = 1; $j <= 3; $j++) {
                Rt::create([
                    'rw_id' => $rws[$i]->id,
                    'nomor_rt' => str_pad($j, 3, '0', STR_PAD_LEFT),
                    'ketua_rt_warga_id' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        $this->command->info('RW and RT created successfully!');
        return $rws;
    }

    private function createWargas(array $rws): array
    {
        $wargas = [];
        $faker = \Faker\Factory::create('id_ID');

        $namaLaki = [
            'Budi Santoso',
            'Ahmad Wijaya',
            'Surya Dharma',
            'Joko Prasetyo',
            'Rudi Hartono',
            'Eko Purnomo',
            'Agus Setiawan',
            'Dedi Kusnadi',
            'Hendra Gunawan',
            'Fajar Nugroho',
            'Irwan Susanto',
            'Mulyadi',
            'Nugroho',
            'Oki Setiawan',
            'Puji Raharjo'
        ];

        $namaPerempuan = [
            'Siti Rahayu',
            'Dewi Lestari',
            'Maya Sari',
            'Rina Wati',
            'Linda Kusuma',
            'Ani Setiawati',
            'Rini Handayani',
            'Yuni Astuti',
            'Marta Wijaya',
            'Nina Permata',
            'Kartika Sari',
            'Lestari',
            'Putri Ayu',
            'Sari Dewi',
            'Wulan Sari'
        ];

        $alamat = [
            'Jl. Merdeka No. 123',
            'Jl. Sudirman No. 45',
            'Jl. Pahlawan No. 67',
            'Jl. Diponegoro No. 89',
            'Jl. Gatot Subroto No. 12',
            'Jl. Ahmad Yani No. 34',
            'Jl. Hayam Wuruk No. 56',
            'Jl. Gajah Mada No. 78',
            'Jl. Thamrin No. 90',
            'Jl. Kebon Sirih No. 11'
        ];

        $wargaCount = 0;

        // Create warga untuk setiap RW dan RT
        foreach ($rws as $rwIndex => $rw) {
            $rts = Rt::where('rw_id', $rw->id)->get();

            foreach ($rts as $rtIndex => $rt) {
                // Create 5-8 warga per RT
                $jumlahWarga = rand(5, 8);

                for ($i = 0; $i < $jumlahWarga; $i++) {
                    $isMale = rand(0, 1);
                    $nama = $isMale ? $namaLaki[array_rand($namaLaki)] : $namaPerempuan[array_rand($namaPerempuan)];

                    $tglLahir = $faker->dateTimeBetween('-70 years', '-18 years');
                    $usia = $tglLahir->diff(new \DateTime())->y;

                    $warga = Warga::create([
                        'nik' => $faker->unique()->numerify('32##############'),
                        'nama' => $nama,
                        'tgl_lahir' => $tglLahir->format('Y-m-d'),
                        'jenis_kelamin' => $isMale ? 'Laki-laki' : 'Perempuan',
                        'alamat' => $alamat[array_rand($alamat)] . ' RT ' . $rt->nomor_rt . ' RW ' . $rw->nomor_rw,
                        'rw_id' => $rw->id,
                        'rt_id' => $rt->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    $wargas[] = $warga;
                    $wargaCount++;
                }
            }
        }

        $this->command->info("{$wargaCount} wargas created successfully!");
        return $wargas;
    }

    private function updateKetua(array $rws, array $wargas): void
    {
        foreach ($rws as $rw) {
            // Cari warga dari RW ini untuk dijadikan ketua RW
            $wargaRw = Warga::where('rw_id', $rw->id)->inRandomOrder()->first();
            if ($wargaRw) {
                $rw->update(['ketua_rw_warga_id' => $wargaRw->id]);
            }

            // Update ketua untuk setiap RT di RW ini
            $rts = Rt::where('rw_id', $rw->id)->get();
            foreach ($rts as $rt) {
                $wargaRt = Warga::where('rt_id', $rt->id)->inRandomOrder()->first();
                if ($wargaRt) {
                    $rt->update(['ketua_rt_warga_id' => $wargaRt->id]);
                }
            }
        }

        $this->command->info('Ketua RW and RT updated successfully!');
    }

    private function createLembagaDesa(): array
    {
        $lembagas = [];

        $dataLembaga = [
            [
                'nama_lembaga' => 'Badan Permusyawaratan Desa (BPD)',
                'deskripsi' => 'Lembaga yang merupakan perwujudan demokrasi dalam penyelenggaraan pemerintahan desa, berfungsi menetapkan Peraturan Desa bersama Kepala Desa, menampung dan menyalurkan aspirasi masyarakat.',
                'kontak' => '081234567890',
            ],
            [
                'nama_lembaga' => 'Pemberdayaan Kesejahteraan Keluarga (PKK)',
                'deskripsi' => 'Lembaga kemasyarakatan yang memberdayakan wanita untuk meningkatkan kesejahteraan keluarga melalui 10 program pokok PKK.',
                'kontak' => '081234567891',
            ],
            [
                'nama_lembaga' => 'Karang Taruna',
                'deskripsi' => 'Organisasi kepemudaan di Indonesia yang beranggotakan pemuda dan pemudi, bergerak di bidang sosial, ekonomi, dan budaya.',
                'kontak' => '081234567892',
            ],
            [
                'nama_lembaga' => 'Lembaga Pemberdayaan Masyarakat (LPM)',
                'deskripsi' => 'Lembaga yang dibentuk oleh masyarakat sebagai mitra pemerintah desa dalam menampung dan mewujudkan aspirasi masyarakat.',
                'kontak' => '081234567893',
            ],
            [
                'nama_lembaga' => 'Kelompok Tani Desa Sumber Makmur',
                'deskripsi' => 'Kelompok tani yang beranggotakan petani di desa untuk meningkatkan produktivitas pertanian dan kesejahteraan petani.',
                'kontak' => '081234567894',
            ],
            [
                'nama_lembaga' => 'Tim Penggerak PKK Desa',
                'deskripsi' => 'Tim yang menggerakkan program PKK di tingkat desa dengan fokus pada peningkatan kesejahteraan keluarga.',
                'kontak' => '081234567895',
            ]
        ];

        foreach ($dataLembaga as $data) {
            $lembagas[] = LembagaDesa::create([
                'nama_lembaga' => $data['nama_lembaga'],
                'deskripsi' => $data['deskripsi'],
                'kontak' => $data['kontak'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('Lembaga desa created successfully!');
        return $lembagas;
    }

    private function createJabatanLembaga(array $lembagas): array
    {
        $allJabatans = [];

        $strukturJabatan = [
            // BPD
            [
                'lembaga_index' => 0,
                'jabatans' => [
                    ['nama_jabatan' => 'Ketua BPD', 'level' => 'Ketua'],
                    ['nama_jabatan' => 'Wakil Ketua BPD', 'level' => 'Ketua'],
                    ['nama_jabatan' => 'Sekretaris BPD', 'level' => 'Sekretaris'],
                    ['nama_jabatan' => 'Bendahara BPD', 'level' => 'Bendahara'],
                    ['nama_jabatan' => 'Anggota BPD', 'level' => 'Anggota'],
                    ['nama_jabatan' => 'Anggota BPD', 'level' => 'Anggota'],
                ]
            ],
            // PKK
            [
                'lembaga_index' => 1,
                'jabatans' => [
                    ['nama_jabatan' => 'Ketua PKK', 'level' => 'Ketua'],
                    ['nama_jabatan' => 'Wakil Ketua PKK', 'level' => 'Ketua'],
                    ['nama_jabatan' => 'Sekretaris PKK', 'level' => 'Sekretaris'],
                    ['nama_jabatan' => 'Bendahara PKK', 'level' => 'Bendahara'],
                    ['nama_jabatan' => 'Koordinator Bidang Pendidikan', 'level' => 'Anggota'],
                    ['nama_jabatan' => 'Koordinator Bidang Kesehatan', 'level' => 'Anggota'],
                    ['nama_jabatan' => 'Koordinator Bidang Ekonomi', 'level' => 'Anggota'],
                ]
            ],
            // Karang Taruna
            [
                'lembaga_index' => 2,
                'jabatans' => [
                    ['nama_jabatan' => 'Ketua Karang Taruna', 'level' => 'Ketua'],
                    ['nama_jabatan' => 'Wakil Ketua', 'level' => 'Ketua'],
                    ['nama_jabatan' => 'Sekretaris Umum', 'level' => 'Sekretaris'],
                    ['nama_jabatan' => 'Bendahara Umum', 'level' => 'Bendahara'],
                    ['nama_jabatan' => 'Koordinator Bidang Olahraga', 'level' => 'Anggota'],
                    ['nama_jabatan' => 'Koordinator Bidang Seni Budaya', 'level' => 'Anggota'],
                    ['nama_jabatan' => 'Koordinator Bidang Sosial', 'level' => 'Anggota'],
                    ['nama_jabatan' => 'Anggota Aktif', 'level' => 'Anggota'],
                    ['nama_jabatan' => 'Anggota Aktif', 'level' => 'Anggota'],
                ]
            ],
            // LPM
            [
                'lembaga_index' => 3,
                'jabatans' => [
                    ['nama_jabatan' => 'Ketua LPM', 'level' => 'Ketua'],
                    ['nama_jabatan' => 'Sekretaris LPM', 'level' => 'Sekretaris'],
                    ['nama_jabatan' => 'Bendahara LPM', 'level' => 'Bendahara'],
                    ['nama_jabatan' => 'Anggota LPM', 'level' => 'Anggota'],
                    ['nama_jabatan' => 'Anggota LPM', 'level' => 'Anggota'],
                ]
            ],
            // Kelompok Tani
            [
                'lembaga_index' => 4,
                'jabatans' => [
                    ['nama_jabatan' => 'Ketua Kelompok Tani', 'level' => 'Ketua'],
                    ['nama_jabatan' => 'Sekretaris', 'level' => 'Sekretaris'],
                    ['nama_jabatan' => 'Bendahara', 'level' => 'Bendahara'],
                    ['nama_jabatan' => 'Anggota Petani', 'level' => 'Anggota'],
                    ['nama_jabatan' => 'Anggota Petani', 'level' => 'Anggota'],
                    ['nama_jabatan' => 'Anggota Petani', 'level' => 'Anggota'],
                ]
            ],
            // TP PKK
            [
                'lembaga_index' => 5,
                'jabatans' => [
                    ['nama_jabatan' => 'Ketua TP PKK', 'level' => 'Ketua'],
                    ['nama_jabatan' => 'Sekretaris', 'level' => 'Sekretaris'],
                    ['nama_jabatan' => 'Bendahara', 'level' => 'Bendahara'],
                    ['nama_jabatan' => 'Anggota', 'level' => 'Anggota'],
                    ['nama_jabatan' => 'Anggota', 'level' => 'Anggota'],
                ]
            ]
        ];

        foreach ($strukturJabatan as $struktur) {
            $lembaga = $lembagas[$struktur['lembaga_index']];

            foreach ($struktur['jabatans'] as $jabatanData) {
                $allJabatans[] = JabatanLembaga::create([
                    'lembaga_id' => $lembaga->id,
                    'nama_jabatan' => $jabatanData['nama_jabatan'],
                    'level' => $jabatanData['level'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        $this->command->info('Jabatan lembaga created successfully!');
        return $allJabatans;
    }

    private function createAnggotaLembaga(array $lembagas, array $jabatans, array $wargas): void
    {
        $anggotaCount = 0;
        $faker = \Faker\Factory::create('id_ID');

        // Kelompokkan jabatan berdasarkan lembaga_id
        $jabatanByLembaga = [];
        foreach ($jabatans as $jabatan) {
            $jabatanByLembaga[$jabatan->lembaga_id][] = $jabatan;
        }

        foreach ($lembagas as $lembaga) {
            if (!isset($jabatanByLembaga[$lembaga->id])) {
                continue;
            }

            $jabatansLembaga = $jabatanByLembaga[$lembaga->id];
            $wargaAvailable = $wargas;

            // Acak urutan warga untuk diversifikasi
            shuffle($wargaAvailable);

            foreach ($jabatansLembaga as $jabatan) {
                if (empty($wargaAvailable)) {
                    break;
                }

                // Ambil warga dari awal array
                $warga = array_shift($wargaAvailable);

                // Tentukan tanggal mulai dan selesai
                $tglMulai = $faker->dateTimeBetween('-2 years', '-6 months');
                $tglSelesai = null;

                // 30% kemungkinan memiliki tanggal selesai (masa jabatan berakhir)
                if (rand(1, 100) <= 30) {
                    $tglSelesai = $faker->dateTimeBetween($tglMulai, 'now');
                }

                AnggotaLembaga::create([
                    'lembaga_id' => $lembaga->id,
                    'warga_id' => $warga->id,
                    'jabatan_id' => $jabatan->id,
                    'tgl_mulai' => $tglMulai->format('Y-m-d'),
                    'tgl_selesai' => $tglSelesai ? $tglSelesai->format('Y-m-d') : null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $anggotaCount++;
            }
        }

        $this->command->info("{$anggotaCount} anggota lembaga created successfully!");
    }
}
