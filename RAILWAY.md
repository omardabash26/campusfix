# رفع CampusFix على Railway (مجاناً)

دليل خطوة بخطوة لرفع المشروع على Railway مباشرة من GitHub.

---

## الخطوة 1: إنشاء حساب
1. روح [railway.com](https://railway.com) → **Login** → **Login with GitHub**.
2. فعّل الحساب (Verify) — رصيد مجاني شهري يكفي للعرض.

## الخطوة 2: إنشاء المشروع من GitHub
1. **New Project** → **Deploy from GitHub repo**.
2. اختر ريبو `campusfix`.
3. Railway رح يبدأ يبني المشروع تلقائياً (بيكتشف Laravel + PHP 8.3 من composer.json).

## الخطوة 3: إضافة قاعدة بيانات MySQL
1. جوّا المشروع: **New** → **Database** → **Add MySQL**.
2. رح تنشأ قاعدة MySQL تلقائياً بنفس المشروع.

## الخطوة 4: متغيّرات البيئة (Variables)
افتح خدمة الويب (campusfix) → تبويب **Variables** → أضف:

```
APP_NAME=CampusFix
APP_ENV=production
APP_KEY=base64:SoDsM0dF2k0B1OZAMVwDfujIt3XtZTrGcVXR2EjgmpU=
APP_DEBUG=false
APP_LOCALE=he

DB_CONNECTION=mysql
DB_HOST=${{MySQL.MYSQLHOST}}
DB_PORT=${{MySQL.MYSQLPORT}}
DB_DATABASE=${{MySQL.MYSQLDATABASE}}
DB_USERNAME=${{MySQL.MYSQLUSER}}
DB_PASSWORD=${{MySQL.MYSQLPASSWORD}}

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
LOG_CHANNEL=stderr
```

> الـ`${{MySQL.*}}` بتربط تلقائياً ببيانات قاعدة الـMySQL اللي عملتها بالخطوة 3.

## الخطوة 5: الدومين
1. خدمة الويب → **Settings** → **Networking** → **Generate Domain**.
2. رح يطلعلك رابط زي `https://campusfix-production.up.railway.app`.
3. ارجع لـ**Variables** وأضف:
   ```
   APP_URL=https://your-railway-domain.up.railway.app
   ```
4. الـProcfile بالمشروع بيشغّل `migrate` تلقائياً عند كل نشر، فالجداول رح تنبني لحالها.

## الخطوة 6: تعبئة البيانات الأساسية (مرة وحدة)
عشان يصير في حساب أدمن + مواقع + فئات:
1. خدمة الويب → القائمة (⋮) → **Run a command** (أو من تبويب الـDeployments).
2. شغّل:
   ```
   php artisan db:seed --force
   ```

> بديل: استورد ملف `campusfix_backup.sql` على قاعدة Railway عبر برنامج زي TablePlus (بتلاقي بيانات الاتصال بتبويب MySQL → Connect).

## الخطوة 7: جرّب
1. افتح رابط Railway → صفحة تسجيل الدخول.
2. ادخل: `000000000` / `admin1234`.
3. غيّر كلمات السر الافتراضية بعد أول دخول.

---

## ملاحظات
- أي تعديل بتدفعه (push) لـGitHub، Railway بيعيد النشر تلقائياً.
- لو وقف الموقع، تأكد من الرصيد المجاني بحسابك.
- الـQR بيشتغل على الموبايل تلقائياً (بياخد دومين Railway).
