<?php

namespace Ajifatur\FaturHelper\Seeders;

use Illuminate\Database\Seeder;
use Ajifatur\FaturHelper\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            ['code' => 'name', 'content' => 'FaturHelper'],
            ['code' => 'tagline', 'content' => ''],
            ['code' => 'timezone', 'content' => 'UTC'],
            ['code' => 'address', 'content' => ''],
            ['code' => 'city', 'content' => ''],
            ['code' => 'email', 'content' => ''],
            ['code' => 'phone_number', 'content' => ''],
            ['code' => 'whatsapp', 'content' => ''],
            ['code' => 'instagram', 'content' => ''],
            ['code' => 'youtube', 'content' => ''],
            ['code' => 'facebook', 'content' => ''],
            ['code' => 'twitter', 'content' => ''],
            ['code' => 'google_maps', 'content' => ''],
            ['code' => 'google_tag_manager', 'content' => ''],
            ['code' => 'theme', 'content' => 'default'],
            ['code' => 'brand_name', 'content' => 'Spandiv Digital'],
            ['code' => 'brand_url', 'content' => 'https://spandiv.xyz'],
            ['code' => 'brand_visibility', 'content' => '1'],
            ['code' => 'period_alias', 'content' => 'Periode'],
            ['code' => 'period_visibility', 'content' => '0'],
            ['code' => 'icon', 'content' => ''],
            ['code' => 'logo', 'content' => ''],
            ['code' => 'size', 'content' => 'small'],
            ['code' => 'multiple_roles', 'content' => '0'],
            ['code' => 'n_gender_visibility', 'content' => '1'],
            ['code' => 'allow_login_by_email', 'content' => '0'],
            ['code' => 'non_admin_can_login', 'content' => '0'],
            ['code' => 'socialite', 'content' => '0'],
            ['code' => 'socialite_default_role', 'content' => 'member'],
            ['code' => 'allow_unregistered_account', 'content' => '0'],
            ['code' => 'font_family', 'content' => 'default'],
        ];

        foreach($settings as $setting) {
            Setting::firstOrCreate(
                ['code' => $setting['code']],
                ['content' => $setting['content']]
            );
        }
    }
}
