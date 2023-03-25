<?php

namespace Database\Seeders;

use App\Models\Criteria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class CriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $criterias = [
            [
                "code" => "C1",
                "name" => "Absensi",
                "weight" => 25,
                "attribute" => Criteria::ATTRIBUTE_COST,
                "created_at" => now()->toDateTimeString(),
                "updated_at" => now()->toDateTimeString(),
                "sub_criterias" => [
                    [
                        "description" => "Secara Konsisten hadir tepat waktu dengan tingkat absensi 0%",
                        "comment" => "Sangat Baik",
                        "value" => 4,
                    ],
                    [
                        "description" => "Selalu hadir tepat waktu dan absensi dibawah 7%",
                        "comment" => "Baik",
                        "value" => 3,
                    ],
                    [
                        "description" => "Selalu hadir kerap terlambat dan melakukan absensi dengan alasan yang jelas",
                        "comment" => "Cukup",
                        "value" => 2,
                    ],
                    [
                        "description" => "Sering terlambat dan tidak hadir tanpa alasan yang jelas",
                        "comment" => "Kurang",
                        "value" => 1,
                    ],
                ]
            ],
            [
                "code" => "C2",
                "name" => "Penguasaan Kerja",
                "weight" => 20,
                "attribute" => Criteria::ATTRIBUTE_BENEFIT,
                "created_at" => now()->toDateTimeString(),
                "updated_at" => now()->toDateTimeString(),
                "sub_criterias" => [
                    [
                        "description" => "Mengerjakan tugas dengan effort yang luar biasa dan dapat mempertanggung jawabkan pekerjaanya",
                        "comment" => "Sangat Baik",
                        "value" => 4,
                    ],
                    [
                        "description" => "Mampu mengerjakan tugas lebih baik dari yang diharapkan",
                        "comment" => "Baik",
                        "value" => 3,
                    ],
                    [
                        "description" => "Mampu mengerjakan tugas sesuai yang diharapkan",
                        "comment" => "Cukup",
                        "value" => 2,
                    ],
                    [
                        "description" => "Mengabaikan tugas yang dimiliki sesuai dengan devisi yang ditempati",
                        "comment" => "Kurang",
                        "value" => 1,
                    ],
                ]
            ],
            [
                "code" => "C3",
                "name" => "Tanggung Jawab",
                "weight" => 20,
                "attribute" => Criteria::ATTRIBUTE_BENEFIT,
                "created_at" => now()->toDateTimeString(),
                "updated_at" => now()->toDateTimeString(),
                "sub_criterias" => [
                    [
                        "description" => "Selalu mengerjakan tugas tepat waktu dan sesuai instruksi",
                        "comment" => "Sangat Baik",
                        "value" => 4,
                    ],
                    [
                        "description" => "Selalu mengerjakan tugas tepat waktu walaupun sesekali melakukan kesalahan",
                        "comment" => "Baik",
                        "value" => 3,
                    ],
                    [
                        "description" => "Mengerjakan tugas yang diberikan kerap terlambat namun masih dapat ditoleransi",
                        "comment" => "Cukup",
                        "value" => 2,
                    ],
                    [
                        "description" => "Sering tidak mengerjakan tugas yang diberikan dan banyak melakukan kesalahan",
                        "comment" => "Kurang",
                        "value" => 1,
                    ],
                ]
            ],
            [
                "code" => "C4",
                "name" => "Kerja Sama Tim",
                "weight" => 15,
                "attribute" => Criteria::ATTRIBUTE_BENEFIT,
                "created_at" => now()->toDateTimeString(),
                "updated_at" => now()->toDateTimeString(),
                "sub_criterias" => [
                    [
                        "description" => "Mampu berkomunikasi dan berkoordinasi dengan berbagai pihak dan menghargai pendapat dan masukan karyawan lainnya",
                        "comment" => "Sangat Baik",
                        "value" => 4,
                    ],
                    [
                        "description" => "Mengetahui apa yang menjadi tugas bersama dan mampu berkoordinasi dan mau mempertimbangkan usulan karyawan lain",
                        "comment" => "Baik",
                        "value" => 3,
                    ],
                    [
                        "description" => "Mengetahui apa yang menjadi tugas bersama dan mampu berkoordinasi",
                        "comment" => "Cukup",
                        "value" => 2,
                    ],
                    [
                        "description" => "Tidak mampu membangun komunikasi dan berkoordinasi bersama karyawan lainnya",
                        "comment" => "Kurang",
                        "value" => 1,
                    ],
                ]
            ],
            [
                "code" => "C5",
                "name" => "Kualitas Kerja",
                "weight" => 10,
                "attribute" => Criteria::ATTRIBUTE_BENEFIT,
                "created_at" => now()->toDateTimeString(),
                "updated_at" => now()->toDateTimeString(),
                "sub_criterias" => [
                    [
                        "description" => "Memiliki keterampilan dan kedislipinan sehingga menghasilkan kinerja yang diharapkan",
                        "comment" => "Sangat Baik",
                        "value" => 4,
                    ],
                    [
                        "description" => "Kinerja yang dihasilkan memenuhi standar yang diinginkan",
                        "comment" => "Baik",
                        "value" => 3,
                    ],
                    [
                        "description" => "Kinerja yang dihasilkan baik namun masih kurang untuk memenuhi standar yang diinginkan",
                        "comment" => "Cukup",
                        "value" => 2,
                    ],
                    [
                        "description" => "Hasil pekerjaan yang dihasilkan jauh dari standar yang diinginkan",
                        "comment" => "Kurang",
                        "value" => 1,
                    ],
                ]
            ],
            [
                "code" => "C6",
                "name" => "Penampilan",
                "weight" => 10,
                "attribute" => Criteria::ATTRIBUTE_BENEFIT,
                "created_at" => now()->toDateTimeString(),
                "updated_at" => now()->toDateTimeString(),
                "sub_criterias" => [
                    [
                        "description" => "Secara konsisten mentaati aturan yang telah ditetapkan dalam hal penampilan",
                        "comment" => "Sangat Baik",
                        "value" => 4,
                    ],
                    [
                        "description" => "Mentaati aturan namun ada beberapa hal kecil yang dilanggar",
                        "comment" => "Baik",
                        "value" => 3,
                    ],
                    [
                        "description" => "Tidak mengikuti aturan yang telah ditetapkan dengan alasan yang masih bisa diterima",
                        "comment" => "Cukup",
                        "value" => 2,
                    ],
                    [
                        "description" => "Sering melanggar aturan yang diterapkan oleh pihak restaurant",
                        "comment" => "Kurang",
                        "value" => 1,
                    ],
                ]
            ],
        ];

        foreach ($criterias as $item) {
            DB::transaction(function () use ($item) {
                $criteria = new Criteria(Arr::except($item, ['created_at', 'updated_at', 'sub_criterias']));
                $criteria->save();

                $criteria->subCriterias()->createMany($item['sub_criterias']);
            });
        }
    }
}
