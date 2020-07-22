<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        DB::table('tabelsig')->insert([
            [
              'df' => '3',
              'taraf_sig' => '0.997'
            ],
            [
                'df' => '4',
                'taraf_sig' => '0.950'
            ],
            [
                'df' => '5',
                'taraf_sig' => '0.878'
            ],
            [
                'df' => '6',
                'taraf_sig' => '0.811'
            ],
            [
                'df' => '7',
                'taraf_sig' => '0.754'
            ],
            [
                'df' => '8',
                'taraf_sig' => '0.707'
            ],
            [
                'df' => '9',
                'taraf_sig' => '0.666'
            ],
            [
                'df' => '10',
                'taraf_sig' => '0.632'
            ],
            [
                'df' => '11',
                'taraf_sig' => '0.602'
            ],
            [
                'df' => '12',
                'taraf_sig' => '0.576'
            ],
            [
                'df' => '13',
                'taraf_sig' => '0.553'
            ],
            [
                'df' => '14',
                'taraf_sig' => '0.532'
            ],
            [
                'df' => '15',
                'taraf_sig' => '0.514'
            ],
            [
                'df' => '16',
                'taraf_sig' => '0.497'
            ],
            [
                'df' => '17',
                'taraf_sig' => '0.482'
            ],
            [
                'df' => '18',
                'taraf_sig' => '0.468'
            ],
            [
                'df' => '19',
                'taraf_sig' => '0.456'
            ],
            [
                'df' => '20',
                'taraf_sig' => '0.444'
            ],
            [
                'df' => '21',
                'taraf_sig' => '0.433'
            ],
            [
                'df' => '22',
                'taraf_sig' => '0.423'
            ],
            [
                'df' => '23',
                'taraf_sig' => '0.413'
            ],
            [
                'df' => '24',
                'taraf_sig' => '0.404'
            ],
            [
                'df' => '25',
                'taraf_sig' => '0.396'
            ],
            [
                'df' => '26',
                'taraf_sig' => '0.388'
            ],
            [
                'df' => '27',
                'taraf_sig' => '0.381'
            ],
            [
                'df' => '28',
                'taraf_sig' => '0.374'
            ],
            [
                'df' => '29',
                'taraf_sig' => '0.367'
            ],
            [
                'df' => '30',
                'taraf_sig' => '0.361'
            ],
            [
                'df' => '31',
                'taraf_sig' => '0.355'
            ],
            [
                'df' => '32',
                'taraf_sig' => '0.349'
            ]
        ]);

        DB::table('questions')->insert([
            [
                'pertanyaan' => 'Teman-teman akan membantu ketika saya mendapatkan masalah atau musibah',
                'jenis' => 'Favorable',
                'kategori' => 'Loving'
            ],
            [
                'pertanyaan' => 'Adanya penyakit yang sering muncul membuat aktivitas saya di sekolah menjadi terganggu',
                'jenis' => 'Unfavorable',
                'kategori' => 'Health status'
            ],
            [
                'pertanyaan' => 'Guru sering memberikan tugas yang banyak setiap minggu',
                'jenis' => 'Unfavorable',
                'kategori' => 'Having'
            ],
            [
                'pertanyaan' => 'Saya merasa beberapa guru bersikap tidak adil dalam memberikan kesempatan menjawab terhadap beberapa siswa di kelas',
                'jenis' => 'Unfavorable',
                'kategori' => 'Being'
            ],
            [
                'pertanyaan' => 'Tugas-tugas yang diberikan oleh sekolah sesuai dengan kemampuan saya',
                'jenis' => 'Favorable',
                'kategori' => 'Having'
            ],
            [
                'pertanyaan' => 'Saya sering tiba-tiba merasa cemas',
                'jenis' => 'Unfavorable',
                'kategori' => 'Health status'
            ],
            [
                'pertanyaan' => 'Tidak ada ekstrakurikuler yang sesuai dengan minat saya',
                'jenis' => 'Unfavorable',
                'kategori' => 'Being'
            ],
            [
                'pertanyaan' => 'Sekolah selalu mendorong saya untuk mencoba berbagai hal yang saya sukai',
                'jenis' => 'Favorable',
                'kategori' => 'Being'
            ],
            [
                'pertanyaan' => 'Lingkungan sekolah dapat membuat saya focus dalam belajar',
                'jenis' => 'Favorable',
                'kategori' => 'Having'
            ],
            [
                'pertanyaan' => 'Semua siswa ikut serta dalam membuat kebijakan-kebijakan sekolah',
                'jenis' => 'Favorable',
                'kategori' => 'Being'
            ],
            [
                'pertanyaan' => 'Saya selalu masuk sekolah ketika sakit ',
                'jenis' => 'Favorable',
                'kategori' => 'Health status'
            ],
            [
                'pertanyaan' => 'Saya sering bercerita kepada orangtua mengenai kegiatan saya selama di sekolah ',
                'jenis' => 'Favorable',
                'kategori' => 'Loving'
            ],
            [
                'pertanyaan' => 'Sekolah memberikan kesempatan untuk mengembangkan bakat yang saya miliki ',
                'jenis' => 'Favorable',
                'kategori' => 'Being'
            ],
            [
                'pertanyaan' => 'Ketika berada di sekolah saya sering merasa lesu',
                'jenis' => 'Unfavorable',
                'kategori' => 'Health status'
            ],
            [
                'pertanyaan' => 'Pencahayaan di sekolah cukup terang sehingga saya tidak kesulitan dalam menulis ataupun membaca',
                'jenis' => 'Favorable',
                'kategori' => 'Having'
            ],
            [
                'pertanyaan' => 'Saya merasa canggung untuk bercanda dengan guru di sekolah',
                'jenis' => 'Unfavorable',
                'kategori' => 'Loving'
            ],
            [
                'pertanyaan' => 'Saya akan membantu teman ketika sedang mengalami kesulitan',
                'jenis' => 'Favorable',
                'kategori' => 'Loving'
            ],
            [
                'pertanyaan' => 'Saya sering merasa sakit beberapa minggu ini',
                'jenis' => 'Unfavorable',
                'kategori' => 'Health status'
            ],
            [
                'pertanyaan' => 'Saya memiliki hubungan yang akrab dengan teman sekelas',
                'jenis' => 'Favorable',
                'kategori' => 'Loving'
            ],
            [
                'pertanyaan' => 'Ukuran kelas menurut saya cukup nyaman untuk belajar',
                'jenis' => 'Favorable',
                'kategori' => 'Having'
            ],
        ]);
    }
}
