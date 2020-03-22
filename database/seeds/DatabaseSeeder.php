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
