<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'תקלת חשמל',         'default_priority' => 'critical', 'description' => 'תקלות חשמל, קצר, אין חשמל'],
            ['name' => 'תקלת מחשב / IT',     'default_priority' => 'high',     'description' => 'מחשב לא עובד, רשת, תוכנה'],
            ['name' => 'תקלת מקרן',          'default_priority' => 'high',     'description' => 'מקרן לא עובד או לא מוצג'],
            ['name' => 'תקלת מזגן',          'default_priority' => 'medium',   'description' => 'מזגן מקולקל או לא מפעיל'],
            ['name' => 'תקלת אינסטלציה',     'default_priority' => 'medium',   'description' => 'דליפת מים, ברז מקולקל'],
            ['name' => 'תקלת תאורה',         'default_priority' => 'medium',   'description' => 'נורה שרופה, אין תאורה'],
            ['name' => 'ריהוט ותשתית',       'default_priority' => 'low',      'description' => 'כיסא שבור, שולחן פגום'],
            ['name' => 'ניקיון',              'default_priority' => 'low',      'description' => 'בעיות ניקיון בכיתה'],
            ['name' => 'אחר',                'default_priority' => 'low',      'description' => 'תקלה שאינה משתייכת לקטגוריה אחרת'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}