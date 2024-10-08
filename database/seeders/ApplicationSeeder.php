<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
                $groupArea1 = DB::table('group_areas')->where('short_name', 'SIG')->first()->id;
                $groupArea2 = DB::table('group_areas')->where('short_name', 'SG')->first()->id;
                $groupArea3 = DB::table('group_areas')->where('short_name', 'SP')->first()->id;
                $groupArea4 = DB::table('group_areas')->where('short_name', 'ST')->first()->id;

                // $companyId1 = DB::table('companies')->where('short_name', 'SISI')->first()->id;
                // $companyId2 = DB::table('companies')->where('short_name', 'SBI')->first()->id;
                // $companyId3 = DB::table('companies')->where('short_name', 'UTSG')->first()->id;
                // $companyId4 = DB::table('companies')->where('short_name', 'PP')->first()->id;
                // $companyId5 = DB::table('companies')->where('short_name', 'ADHI')->first()->id;


                DB::table('applications')->insert([
                    'id' => (string) Str::uuid(),
                'short_name' => 'TPM',
                'long_name' => 'Total Productive Maintenance',
                'slug' => Str::slug('Total Productive Maintenance'),
                'image' =>  '/images/product01.png',
                'description' => 'Sistem aplikasi TPM berbasis mobile dan web-based ini dikembangkan untuk 
                                memenuhi kebutuhan pabrik dalam melakukan pemeliharaan peralatan serta optimasi untuk meningkatkan 
                                produktivitas di area kerja.',
                'status' => 'up',
                'category' => 'sap',
                'platform' => 'mobile',
                'url_prod' => 'https://tpm.com',
                'url_dev' => 'https://dev.example.com',
                'vm_prod' => 'VM Prod',
                'vm_dev' => 'VM Dev',
                'tier' => '10',
                'business_process' => 'Business Process 1',
                'db_connection_path' => 'DB Connection Path 1',
                'sap_connection_path' => 'SAP Connection Path 1',
                'ad_connection_path' => 'AD Connection Path 1',
                'user_login' => 'login sso',
                'technical_doc' => 'https://example.com',
                'user_doc' => 'https://example.com',
                'other_doc' => 'https://example.com',
                'information' => 'this app is not working anymore',
                'group_area' => $groupArea1,
                'company' => "SISI",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null, 
            ]);
            DB::table('applications')->insert([
                'id' => (string) Str::uuid(),
                'short_name' => 'Aplikasi dua',
                'long_name' => 'Aplikasi dua',
                'slug' => Str::slug('Aplikasi dua'),
                'image' =>  '/images/product02.png',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                                Ut enim ad minim veniam,',
                'status' => 'up',
                'category' => 'sap',
                'platform' => 'website',
                'url_prod' => 'https://example.com',
                'url_dev' => 'https://dev.example.com',
                'vm_prod' => 'VM Prod',
                'vm_dev' => 'VM Dev',
                'tier' => '5',
                'business_process' => 'Business Process 1',
                'db_connection_path' => 'DB Connection Path 1',
                'sap_connection_path' => 'SAP Connection Path 1',
                'ad_connection_path' => 'AD Connection Path 1',
                'user_login' => 'login sso',
                'technical_doc' => 'https://example.com',
                'user_doc' => 'https://example.com',
                'other_doc' => 'https://example.com',
                'information' => 'this app is not working anymore',
                'group_area' => $groupArea1,
                'company' => "SBI",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null, 
            ]);
            DB::table('applications')->insert([
                'id' => (string) Str::uuid(),
                'short_name' => 'Aplikasi tiga',
                'long_name' => 'Aplikasi tigaaaaaaaaaaaaaaaaaaaa',
                'slug' => Str::slug('Aplikasi tiga'),
                'image' =>  '/images/product03.png',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                                Ut enim ad minim veniam,',
                'status' => 'up',
                'category' => 'sap',
                'platform' => 'dekstop',
                'url_prod' => 'https://example.com',
                'url_dev' => 'https://dev.example.com',
                'vm_prod' => 'VM Prod',
                'vm_dev' => 'VM Dev',
                'tier' => '2',
                'business_process' => 'Business Process 1',
                'db_connection_path' => 'DB Connection Path 1',
                'sap_connection_path' => 'SAP Connection Path 1',
                'ad_connection_path' => 'AD Connection Path 1',
                'user_login' => 'login sso',
                'technical_doc' => 'https://example.com',
                'user_doc' => 'https://example.com',
                'other_doc' => 'https://example.com',
                'information' => 'this app is not working anymore',
                'group_area' => $groupArea2,
                'company' => "UTSG",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null, 
            ]);
            DB::table('applications')->insert([
                'id' => (string) Str::uuid(),
                'short_name' => 'Aplikasi empat',
                'long_name' => 'Aplikasi empaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaat',
                'slug' => Str::slug('Aplikasi empaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaat'),
                'image' =>  '/images/product04.png',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                                Ut enim ad minim veniam,',
                'status' => 'up',
                'category' => 'non sap',
                'platform' => 'dekstop',
                'url_prod' => 'https://example.com',
                'url_dev' => 'https://dev.example.com',
                'vm_prod' => 'VM Prod',
                'vm_dev' => 'VM Dev',
                'tier' => '2',
                'business_process' => 'Business Process 1',
                'db_connection_path' => 'DB Connection Path 1',
                'sap_connection_path' => 'SAP Connection Path 1',
                'ad_connection_path' => 'AD Connection Path 1',
                'user_login' => 'login ad',
                'technical_doc' => 'https://example.com',
                'user_doc' => 'https://example.com',
                'other_doc' => 'https://example.com',
                'information' => 'this app is not working anymore',
                'group_area' => $groupArea3,
                'company' => "PP",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null, 
            ]);
            DB::table('applications')->insert([
                'id' => (string) Str::uuid(),
                'short_name' => 'Aplikasi lima',
                'long_name' => 'Aplikasi limaaaaaaaaaaaaaaaaaaaaaaa',
                'slug' => Str::slug('Aplikasi limaaaaaaaaaaaaaaaaaaaaaaa'),
                'image' =>  '/images/product05.png',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                                Ut enim ad minim veniam,',
                'status' => 'maintenance',
                'category' => 'non sap',
                'platform' => 'website',
                'url_prod' => 'https://example.com',
                'url_dev' => 'https://dev.example.com',
                'vm_prod' => 'VM Prod',
                'vm_dev' => 'VM Dev',
                'tier' => '2',
                'business_process' => 'Business Process 1',
                'db_connection_path' => 'DB Connection Path 1',
                'sap_connection_path' => 'SAP Connection Path 1',
                'ad_connection_path' => 'AD Connection Path 1',
                'user_login' => 'login sso',
                'technical_doc' => 'https://example.com',
                'user_doc' => 'https://example.com',
                'other_doc' => 'https://example.com',
                'information' => 'this app is not working anymore',
                'group_area' => $groupArea4,
                'company' => "ADHI",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null, 
            ]);
            DB::table('applications')->insert([
                'id' => (string) Str::uuid(),
                'short_name' => 'Aplikasi enam',
                'long_name' => 'Aplikasi enammmmmmmmmmmmmmm',
                'slug' => Str::slug('Aplikasi enammmmmmmmmmmmmmm'),
                'image' =>  '/images/product06.png',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                                Ut enim ad minim veniam,',
                'status' => 'maintenance',
                'category' => 'collaboration',
                'platform' => 'website',
                'url_prod' => 'https://example.com',
                'url_dev' => 'https://dev.example.com',
                'vm_prod' => 'VM Prod',
                'vm_dev' => 'VM Dev',
                'tier' => '2',
                'business_process' => 'Business Process 1',
                'db_connection_path' => 'DB Connection Path 1',
                'sap_connection_path' => 'SAP Connection Path 1',
                'ad_connection_path' => 'AD Connection Path 1',
                'user_login' => 'internal apps',
                'technical_doc' => 'https://example.com',
                'user_doc' => 'https://example.com',
                'other_doc' => 'https://example.com',
                'information' => 'this app is not working anymore',
                'group_area' => $groupArea4,
                'company' => "PP",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null, 
            ]);
            DB::table('applications')->insert([
                'id' => (string) Str::uuid(),
                'short_name' => 'Aplikasi tujuh',
                'long_name' => 'Aplikasi tujuhhhhhhhhhhhhhhhh',
                'slug' => Str::slug('Aplikasi tujuhhhhhhhhhhhhhhhh'),
                'image' =>  '/images/product07.png',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                                Ut enim ad minim veniam,',
                'status' => 'maintenance',
                'category' => 'collaboration',
                'platform' => 'mobile',
                'url_prod' => 'https://example.com',
                'url_dev' => 'https://dev.example.com',
                'vm_prod' => 'VM Prod',
                'vm_dev' => 'VM Dev',
                'tier' => '2',
                'business_process' => 'Business Process 1',
                'db_connection_path' => 'DB Connection Path 1',
                'sap_connection_path' => 'SAP Connection Path 1',
                'ad_connection_path' => 'AD Connection Path 1',
                'user_login' => 'internal apps',
                'technical_doc' => 'https://example.com',
                'user_doc' => 'https://example.com',
                'other_doc' => 'https://example.com',
                'information' => 'this app is not working anymore',
                'group_area' => $groupArea3,
                'company' => "UTSG",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null, 
            ]);
            DB::table('applications')->insert([
                'id' => (string) Str::uuid(),
                'short_name' => 'Aplikasi delapan',
                'long_name' => 'Aplikasi delapannnnnnnnnnnnnnnn',
                'slug' => Str::slug('Aplikasi delapannnnnnnnnnnnnnnn'),
                'image' =>  '/images/product08.png',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                                Ut enim ad minim veniam,',
                'status' => 'maintenance',
                'category' => 'collaboration',
                'platform' => 'dekstop',
                'url_prod' => 'https://example.com',
                'url_dev' => 'https://dev.example.com',
                'vm_prod' => 'VM Prod',
                'vm_dev' => 'VM Dev',
                'tier' => '2',
                'business_process' => 'Business Process 1',
                'db_connection_path' => 'DB Connection Path 1',
                'sap_connection_path' => 'SAP Connection Path 1',
                'ad_connection_path' => 'AD Connection Path 1',
                'user_login' => 'login sso',
                'technical_doc' => 'https://example.com',
                'user_doc' => 'https://example.com',
                'other_doc' => 'https://example.com',
                'information' => 'this app is not working anymore',
                'group_area' => $groupArea2,
                'company' => "SBI",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null, 
            ]);
            DB::table('applications')->insert([
                'id' => (string) Str::uuid(),
                'short_name' => 'Aplikasi sembilan',
                'long_name' => 'Aplikasi sembilan',
                'slug' => Str::slug('Aplikasi sembilan'),
                'image' =>  '/images/product09.png',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                                Ut enim ad minim veniam,',
                'status' => 'down',
                'category' => 'collaboration',
                'platform' => 'mobile',
                'url_prod' => 'https://example.com',
                'url_dev' => 'https://dev.example.com',
                'vm_prod' => 'VM Prod',
                'vm_dev' => 'VM Dev',
                'tier' => '2',
                'business_process' => 'Business Process 1',
                'db_connection_path' => 'DB Connection Path 1',
                'sap_connection_path' => 'SAP Connection Path 1',
                'ad_connection_path' => 'AD Connection Path 1',
                'user_login' => 'login ad',
                'technical_doc' => 'https://example.com',
                'user_doc' => 'https://example.com',
                'other_doc' => 'https://example.com',
                'information' => 'this app is not working anymore',
                'group_area' => $groupArea1,
                'company' => "SISI",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null, 
            ]);
            DB::table('applications')->insert([
                'id' => (string) Str::uuid(),
                'short_name' => 'Aplikasi sepuluh',
                'long_name' => 'Aplikasi sepuluh',
                'slug' => Str::slug('Aplikasi sepuluh'),
                'image' =>  '/images/product10.png',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                                Ut enim ad minim veniam,',
                'status' => 'down',
                'category' => 'ot/it',
                'platform' => 'mobile',
                'url_prod' => 'https://example.com',
                'url_dev' => 'https://dev.example.com',
                'vm_prod' => 'VM Prod',
                'vm_dev' => 'VM Dev',
                'tier' => '2',
                'business_process' => 'Business Process 1',
                'db_connection_path' => 'DB Connection Path 1',
                'sap_connection_path' => 'SAP Connection Path 1',
                'ad_connection_path' => 'AD Connection Path 1',
                'user_login' => 'login sso',
                'technical_doc' => 'https://example.com',
                'user_doc' => 'https://example.com',
                'other_doc' => 'https://example.com',
                'information' => 'this app is not working anymore',
                'group_area' => $groupArea2,
                'company' => "SBI",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null, 
            ]);
            DB::table('applications')->insert([
                'id' => (string) Str::uuid(),
                'short_name' => 'Aplikasi sebelas',
                'long_name' => 'Aplikasi sebelas',
                'slug' => Str::slug('Aplikasi sebelas'),
                'image' =>  '/images/product11.png',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                                Ut enim ad minim veniam,',
                'status' => 'down',
                'category' => 'ot/it',
                'platform' => 'website',
                'url_prod' => 'https://example.com',
                'url_dev' => 'https://dev.example.com',
                'vm_prod' => 'VM Prod',
                'vm_dev' => 'VM Dev',
                'tier' => '2',
                'business_process' => 'Business Process 1',
                'db_connection_path' => 'DB Connection Path 1',
                'sap_connection_path' => 'SAP Connection Path 1',
                'ad_connection_path' => 'AD Connection Path 1',
                'user_login' => 'internal apps',
                'technical_doc' => 'https://example.com',
                'user_doc' => 'https://example.com',
                'other_doc' => 'https://example.com',
                'information' => 'this app is not working anymore',
                'group_area' => $groupArea3,
                'company' => "UTSG",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null, 
            ]);
            DB::table('applications')->insert([
                'id' => (string) Str::uuid(),
                'short_name' => 'Aplikasi dua belas',
                'long_name' => 'Aplikasi dua belas',
                'slug' => Str::slug('Aplikasi dua belas'),
                'image' =>  '/images/product12.png',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                                Ut enim ad minim veniam,',
                'status' => 'down',
                'category' => 'ot/it',
                'platform' => 'dekstop',
                'url_prod' => 'https://example.com',
                'url_dev' => 'https://dev.example.com',
                'vm_prod' => 'VM Prod',
                'vm_dev' => 'VM Dev',
                'tier' => '2',
                'business_process' => 'Business Process 1',
                'db_connection_path' => 'DB Connection Path 1',
                'sap_connection_path' => 'SAP Connection Path 1',
                'ad_connection_path' => 'AD Connection Path 1',
                'user_login' => 'login ad',
                'technical_doc' => 'https://example.com',
                'user_doc' => 'https://example.com',
                'other_doc' => 'https://example.com',
                'information' => 'this app is not working anymore',
                'group_area' => $groupArea4,
                'company' => "UTSG",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null, 
            ]);
    }
}
