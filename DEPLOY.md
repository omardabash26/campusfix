# دليل رفع CampusFix على استضافة cPanel

دليل خطوة بخطوة لرفع المشروع على استضافة فيها cPanel (مثل Hostinger / GoDaddy).

---

## قبل ما تبدأ — تأكد من
- إصدار PHP على الاستضافة **8.3 أو أحدث** (من cPanel → **Select PHP Version**)
- التفعيلات (Extensions) المطلوبة مفعّلة: `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`, `fileinfo`
- معك ملف النسخة الاحتياطية: `campusfix_backup.sql`

---

## الخطوة 1: تجهيز ملفات المشروع

1. على لابتوبك، اعمل ضغط (Zip) لكامل مجلّد المشروع **مع مجلّد `vendor`** (عشان ما تحتاج Composer على السيرفر).
   - لا ترفع: `node_modules`, `.git`, `.env` المحلي، `campusfix_backup.sql`.

---

## الخطوة 2: رفع الملفات

أفضل طريقة (الأكثر أماناً): المشروع برّا `public_html`، وبس مجلّد `public` جوّاها.

1. cPanel → **File Manager**.
2. ارفع ملف الـZip وفُكّه. حُط مجلّد المشروع **فوق** `public_html` (مثلاً في `/home/USER/campusfix`).
3. انقل **محتويات** `campusfix/public/` (وليس المجلّد نفسه) إلى `public_html/`.
4. عدّل ملف `public_html/index.php` — غيّر المسارين ليأشّروا على مجلّد المشروع:

```php
require __DIR__.'/../campusfix/vendor/autoload.php';

$app = require_once __DIR__.'/../campusfix/bootstrap/app.php';
```

> بديل أسهل: لو رح تستخدم **subdomain** (مثلاً `app.your-domain.com`)، وقت إنشائه من cPanel حُط الـ **Document Root** يأشّر مباشرة على `campusfix/public` وخلص — بتتجنّب تعديل index.php.

---

## الخطوة 3: قاعدة البيانات

1. cPanel → **MySQL Databases**.
2. أنشئ قاعدة بيانات جديدة (مثلاً `campusfix`). رح يصير اسمها الكامل `cpaneluser_campusfix`.
3. أنشئ **MySQL User** جديد بكلمة سر قوية.
4. اربط اليوزر بالقاعدة وأعطيه **ALL PRIVILEGES**.
5. cPanel → **phpMyAdmin** → اختر القاعدة → تبويب **Import** → ارفع `campusfix_backup.sql` → Go.

> هيك بتنتقل كل البيانات (الحسابات، المواقع، الفئات، التذاكر).
> لو بدك بداية نظيفة بدون التذاكر التجريبية، تجاهل الاستيراد واستعمل الخطوة 5 (Migrations) بدالها.

---

## الخطوة 4: ملف `.env`

1. بـFile Manager، جوّا مجلّد المشروع `campusfix`، أنشئ ملف اسمه `.env`.
2. انسخ محتوى `.env.production.example` فيه، وعدّل:
   - `APP_URL` = دومينك (https)
   - `DB_DATABASE` / `DB_USERNAME` / `DB_PASSWORD` = اللي عملتهم بالخطوة 3
   - `APP_KEY` — لا تتركه فاضي. حُط هالمفتاح:
     ```
     APP_KEY=base64:SoDsM0dF2k0B1OZAMVwDfujIt3XtZTrGcVXR2EjgmpU=
     ```
     (أو ولّد واحد جديد بالخطوة 5 لو في Terminal.)

---

## الخطوة 5: أوامر artisan (لو الاستضافة فيها Terminal)

cPanel → **Terminal**، وروح لمجلّد المشروع:

```bash
cd ~/campusfix
php artisan key:generate        # فقط إذا بدك مفتاح جديد
php artisan migrate --force     # فقط لو ما استوردت الـ SQL بالخطوة 3
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link
```

> ما في Terminal؟ مش مشكلة — حُط `APP_KEY` يدوي بملف `.env` (الخطوة 4)، والداتا استوردتها بالخطوة 3، فبتقدر تتخطّى هالخطوة. (الـcaching اختياري للأداء بس.)

---

## الخطوة 6: الصلاحيات (Permissions)

تأكد إن هالمجلّدين قابلين للكتابة (من File Manager → Permissions → 755 أو 775):
- `campusfix/storage`
- `campusfix/bootstrap/cache`

---

## الخطوة 7: جرّب

1. افتح دومينك → لازم تطلع صفحة تسجيل الدخول.
2. ادخل بحساب الأدمن: `000000000` / `admin1234`.
3. **مهم:** غيّر كلمات سر الحسابات الافتراضية من صفحة المستخدمين بعد أول دخول.

---

## ملاحظات أمان للإنتاج
- `APP_DEBUG=false` دايماً (موجودة بالملف) — عشان ما تنكشف تفاصيل الأخطاء.
- استعمل **HTTPS** (شهادة SSL مجانية من cPanel → SSL/TLS Status → AutoSSL).
- بعد الرفع، الـQR رح يرمّز دومينك تلقائياً ويشتغل على الموبايل.

---

## استكشاف الأخطاء
| المشكلة | الحل |
|--------|------|
| صفحة بيضاء / 500 | تأكد من إصدار PHP، وإن `storage` و`bootstrap/cache` قابلين للكتابة |
| `No application encryption key` | تأكد إن `APP_KEY` موجود بملف `.env` |
| خطأ اتصال قاعدة بيانات | راجع `DB_DATABASE/USERNAME/PASSWORD` وإن اليوزر مربوط بالقاعدة |
| الروابط/الستايل مكسورة | تأكد إن `APP_URL` صح وإنه https |
