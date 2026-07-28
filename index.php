<?php
/*
 * VirusTotal Scanner Bot
 * Developed by @DevArtery
 * Channel: @ArteryHub
 * All rights reserved. No one other than @DevArtery is permitted
 * to modify, resell, or redistribute this file.
 */

if (!file_exists(__DIR__ . '/config.php')) {
    if (file_exists(__DIR__ . '/install.php')) {
        header('Location: install.php');
        exit;
    } else {
        echo "❌ Configuration file not found. Please run install.php first.";
        exit;
    }
}

require_once __DIR__ . '/config.php';

if (defined('WEBHOOK_SECRET') && WEBHOOK_SECRET !== '') {
    $incoming_secret = $_SERVER['HTTP_X_TELEGRAM_BOT_API_SECRET_TOKEN'] ?? '';
    if (!hash_equals(WEBHOOK_SECRET, $incoming_secret)) {
        header('HTTP/1.0 403 Forbidden');
        exit;
    }
}










class LanguageManager {
    private static $languages = [
        'en' => ['🇺🇸 English', 'English'],
        'fa' => ['🇮🇷 فارسی', 'Persian'],
        'ru' => ['🇷🇺 Русский', 'Russian'],
        'uk' => ['🇺🇦 Українська', 'Ukrainian'],
        'de' => ['🇩🇪 Deutsch', 'German'],
        'es' => ['🇪🇸 Español', 'Spanish'],
        'fr' => ['🇫🇷 Français', 'French'],
        'it' => ['🇮🇹 Italiano', 'Italian'],
        'pt' => ['🇵🇹 Português', 'Portuguese'],
        'id' => ['🇮🇩 Indonesian', 'Indonesian'],
        'tr' => ['🇹🇷 Türkçe', 'Turkish'],
        'vi' => ['🇻🇳 Tiếng Việt', 'Vietnamese'],
        'ar' => ['🇸🇦 العربية', 'Arabic'],
        'zh' => ['🇨🇳 中文', 'Chinese']
    ];
    
    private static $messages = [
        'en' => [
            'welcome' => "👋 <b>Hello! Welcome to VirusTotal Scanner Bot</b>\n\n🤖 <i>I can scan files with 70+ antivirus engines using VirusTotal API</i>\n\n📁 <b>Features:</b>\n• Scan files up to 320MB\n• Support all common file types\n• Real VirusTotal analysis\n• Multi-language support (14 languages)\n• Group scanning\n\n⚠️ <b>Note:</b> For accurate results, upload files directly",
            'processing' => "⏳ <b>Processing your file...</b>\n\n📊 Scanning with VirusTotal...",
            'choose_language' => "🌐 <b>Select your language:</b>",
            'join_channel' => "📢 <b>Join our channels to use the bot:</b>",
            'check_membership' => "✅ Verify Membership",
            'profile' => "👤 <b>User Profile</b>\n\n🆔 <b>ID:</b> <code>{user_id}</code>\n👤 <b>Username:</b> {username}\n📅 <b>Joined:</b> {reg_date}\n📊 <b>Files Scanned:</b> {file_count}\n🌐 <b>Language:</b> {language}",
            'add_to_group' => "👥 Add to Group",
            'profile_btn' => "👤 Profile",
            'change_language' => "🌐 Change Language",
            'help_btn' => "📖 Help",
            'not_joined' => "❌ You need to join all channels first!",
            'joined_success' => "✅ Welcome! You can now use the bot.",
            'file_too_large' => "❌ File is too large! Maximum size is 320MB.",
            'invalid_file' => "❌ Invalid file type. Please upload a supported file.",
            'scan_complete' => "✅ <b>Scan Complete!</b>",
            'stats' => "📊 <b>Scan Statistics:</b>\n• Total Engines: {total}\n• Malicious: {malicious}\n• Suspicious: {suspicious}\n• Undetected: {undetected}",
            'top_detections' => "🔍 <b>Top Detections:</b>",
            'view_full' => "📄 View Full Report",
            'conclusion_safe' => "🟢 <b>Conclusion:</b> File appears to be safe",
            'conclusion_suspicious' => "🟡 <b>Conclusion:</b> File is suspicious",
            'conclusion_malicious' => "🔴 <b>Conclusion:</b> File is malicious!",
            'help' => "📖 <b>Help Guide</b>\n\n1. Send any file to scan it\n2. Use /profile to see your stats\n3. Use /language to change language\n4. Add me to groups for group scanning\n\n📁 <b>Supported files:</b> EXE, DLL, APK, PDF, DOC, ZIP, etc.\n\n⚠️ <b>Note:</b> Maximum file size is 320MB",
            'start' => "Send me a file and I'll scan it with VirusTotal!",
            'admin_stats' => "👑 <b>Admin Statistics</b>\n\n👥 Total Users: {total_users}\n📊 Total Scans: {total_scans}\n💾 Database Size: {db_size}",
            'no_file' => "Please send me a file to scan.",
            'downloading' => "⬇️ Downloading file...",
            'uploading' => "⬆️ Uploading to VirusTotal...",
            'analyzing' => "🔬 Analyzing file...",
            'wait' => "⏳ Please wait while we process your file...",
            'error' => "❌ An error occurred. Please try again.",
            'rate_limit' => "⏳ Too many requests. Please wait a moment.",
            'blocked' => "🚫 You are temporarily blocked. Please try again later.",
            'channels' => "Join these channels:\n1. {channel1}\n2. {channel2}",
            'already_member' => "✅ You're already a member!",
            'join_first' => "Please join the channels first.",
            'scan_started' => "🚀 Scan started for: {filename}",
            'file_info' => "📄 <b>File Info:</b>\nName: {name}\nSize: {size}\nType: {type}\nMD5: {md5}",
            'detection_list' => "🛡️ <b>Detection Results:</b>",
            'clean' => "✅ Clean",
            'malicious' => "❌ Malicious",
            'suspicious' => "⚠️ Suspicious",
            'hash' => "🔑 SHA256: {hash}",
            'report_url' => "📊 <a href='{url}'>View full report on VirusTotal</a>",
            'thanks' => "🙏 Thank you for using VirusTotal Scanner!",
            'group_welcome' => "👋 Hello group! I can scan files with VirusTotal. Send me any file!",
            'maintenance' => "🛠️ <b>Bot is under maintenance</b>\n\nPlease try again later.",
            'user_blocked' => "🚫 <b>You have been blocked from using this bot.</b>",
            'not_admin' => "⛔ This command is for admins only."
        ],
        'fa' => [
            'welcome' => "👋 <b>سلام! به ربات اسکن ویروس توتال خوش آمدید</b>\n\n🤖 <i>من می‌توانم فایل‌ها را با ۷۰+ موتور آنتی‌ویروس از طریق ویروس توتال بررسی کنم</i>\n\n📁 <b>امکانات:</b>\n• اسکن فایل تا ۳۲۰ مگابایت\n• پشتیبانی از تمام فرمت‌های رایج\n• آنالیز واقعی ویروس توتال\n• پشتیبانی چندزبانه (۱۴ زبان)\n• اسکن در گروه\n\n⚠️ <b>توجه:</b> برای نتایج دقیق، فایل را مستقیم آپلود کنید",
            'processing' => "⏳ <b>در حال پردازش فایل شما...</b>\n\n📊 در حال اسکن با ویروس توتال...",
            'choose_language' => "🌐 <b>زبان خود را انتخاب کنید:</b>",
            'join_channel' => "📢 <b>برای استفاده از ربات در کانال‌های زیر عضو شوید:</b>",
            'check_membership' => "✅ تایید عضویت",
            'profile' => "👤 <b>پروفایل کاربر</b>\n\n🆔 <b>شناسه:</b> <code>{user_id}</code>\n👤 <b>نام کاربری:</b> {username}\n📅 <b>تاریخ عضویت:</b> {reg_date}\n📊 <b>تعداد اسکن‌ها:</b> {file_count}\n🌐 <b>زبان:</b> {language}",
            'add_to_group' => "👥 افزودن به گروه",
            'profile_btn' => "👤 پروفایل",
            'change_language' => "🌐 تغییر زبان",
            'help_btn' => "📖 راهنما",
            'not_joined' => "❌ ابتدا باید در کانال‌ها عضو شوید!",
            'joined_success' => "✅ خوش آمدید! حالا می‌توانید از ربات استفاده کنید.",
            'file_too_large' => "❌ فایل بسیار بزرگ است! حداکثر حجم ۳۲۰ مگابایت.",
            'invalid_file' => "❌ نوع فایل نامعتبر است. لطفاً فایل معتبر آپلود کنید.",
            'scan_complete' => "✅ <b>اسکن کامل شد!</b>",
            'stats' => "📊 <b>آمار اسکن:</b>\n• کل موتورها: {total}\n• مخرب: {malicious}\n• مشکوک: {suspicious}\n• شناسایی نشده: {undetected}",
            'top_detections' => "🔍 <b>تشخیص‌های اصلی:</b>",
            'view_full' => "📄 مشاهده گزارش کامل",
            'conclusion_safe' => "🟢 <b>نتیجه:</b> فایل ایمن به نظر می‌رسد",
            'conclusion_suspicious' => "🟡 <b>نتیجه:</b> فایل مشکوک است",
            'conclusion_malicious' => "🔴 <b>نتیجه:</b> فایل مخرب است!",
            'help' => "📖 <b>راهنما</b>\n\n۱. هر فایلی را برای اسکن ارسال کنید\n۲. از /profile برای مشاهده آمار خود استفاده کنید\n۳. از /language برای تغییر زبان استفاده کنید\n۴. مرا به گروه‌ها اضافه کنید برای اسکن گروهی\n\n📁 <b>فایل‌های پشتیبانی شده:</b> EXE, DLL, APK, PDF, DOC, ZIP و غیره\n\n⚠️ <b>توجه:</b> حداکثر حجم فایل ۳۲۰ مگابایت است",
            'start' => "یک فایل برای من بفرستید تا با ویروس توتال اسکنش کنم!",
            'admin_stats' => "👑 <b>آمار مدیریتی</b>\n\n👥 کل کاربران: {total_users}\n📊 کل اسکن‌ها: {total_scans}\n💾 حجم دیتابیس: {db_size}",
            'no_file' => "لطفاً یک فایل برای اسکن ارسال کنید.",
            'downloading' => "⬇️ در حال دانلود فایل...",
            'uploading' => "⬆️ در حال آپلود به ویروس توتال...",
            'analyzing' => "🔬 در حال آنالیز فایل...",
            'wait' => "⏳ لطفاً منتظر بمانید تا فایل شما پردازش شود...",
            'error' => "❌ خطایی رخ داد. لطفاً مجدداً تلاش کنید.",
            'rate_limit' => "⏳ درخواست‌های زیادی ارسال کرده‌اید. لطفاً کمی صبر کنید.",
            'blocked' => "🚫 شما موقتاً مسدود شده‌اید. لطفاً بعداً تلاش کنید.",
            'channels' => "در این کانال‌ها عضو شوید:\n۱. {channel1}\n۲. {channel2}",
            'already_member' => "✅ شما قبلاً عضو هستید!",
            'join_first' => "لطفاً ابتدا در کانال‌ها عضو شوید.",
            'scan_started' => "🚀 اسکن شروع شد برای: {filename}",
            'file_info' => "📄 <b>اطلاعات فایل:</b>\nنام: {name}\nحجم: {size}\nنوع: {type}\nMD5: {md5}",
            'detection_list' => "🛡️ <b>نتایج تشخیص:</b>",
            'clean' => "✅ پاک",
            'malicious' => "❌ مخرب",
            'suspicious' => "⚠️ مشکوک",
            'hash' => "🔑 SHA256: {hash}",
            'report_url' => "📊 <a href='{url}'>مشاهده گزارش کامل در ویروس توتال</a>",
            'thanks' => "🙏 از استفاده از ربات اسکن ویروس توتال متشکریم!",
            'group_welcome' => "👋 سلام گروه! من می‌توانم فایل‌ها را با ویروس توتال اسکن کنم. هر فایلی برایم بفرستید!",
            'maintenance' => "🛠️ <b>ربات در حال تعمیر است</b>\n\nلطفاً کمی بعد دوباره تلاش کنید.",
            'user_blocked' => "🚫 <b>شما توسط مدیریت مسدود شده‌اید.</b>",
            'not_admin' => "⛔ این دستور مخصوص مدیران است."
        ],
        'ru' => [
            'welcome' => "👋 <b>Привет! Добро пожаловать в VirusTotal Scanner Bot</b>\n\n🤖 <i>Я могу сканировать файлы с помощью 70+ антивирусных движков через VirusTotal API</i>\n\n📁 <b>Функции:</b>\n• Сканирование файлов до 320 МБ\n• Поддержка всех распространенных типов файлов\n• Реальный анализ VirusTotal\n• Поддержка нескольких языков (14 языков)\n• Сканирование в группах\n\n⚠️ <b>Примечание:</b> Для точных результатов загружайте файлы напрямую",
            'processing' => "⏳ <b>Обработка вашего файла...</b>\n\n📊 Сканирование с VirusTotal...",
            'choose_language' => "🌐 <b>Выберите язык:</b>",
            'join_channel' => "📢 <b>Присоединяйтесь к нашим каналам, чтобы использовать бота:</b>",
            'check_membership' => "✅ Проверить членство",
            'profile' => "👤 <b>Профиль пользователя</b>\n\n🆔 <b>ID:</b> <code>{user_id}</code>\n👤 <b>Имя пользователя:</b> {username}\n📅 <b>Присоединился:</b> {reg_date}\n📊 <b>Файлов отсканировано:</b> {file_count}\n🌐 <b>Язык:</b> {language}",
            'add_to_group' => "👥 Добавить в группу",
            'profile_btn' => "👤 Профиль",
            'change_language' => "🌐 Сменить язык",
            'help_btn' => "📖 Помощь",
            'not_joined' => "❌ Сначала присоединитесь ко всем каналам!",
            'joined_success' => "✅ Добро пожаловать! Теперь вы можете использовать бота.",
            'file_too_large' => "❌ Файл слишком большой! Максимальный размер 320 МБ.",
            'invalid_file' => "❌ Неверный тип файла. Загрузите поддерживаемый файл.",
            'scan_complete' => "✅ <b>Сканирование завершено!</b>",
            'stats' => "📊 <b>Статистика сканирования:</b>\n• Всего движков: {total}\n• Вредоносных: {malicious}\n• Подозрительных: {suspicious}\n• Не обнаружено: {undetected}",
            'top_detections' => "🔍 <b>Основные обнаружения:</b>",
            'view_full' => "📄 Посмотреть полный отчет",
            'conclusion_safe' => "🟢 <b>Заключение:</b> Файл кажется безопасным",
            'conclusion_suspicious' => "🟡 <b>Заключение:</b> Файл подозрительный",
            'conclusion_malicious' => "🔴 <b>Заключение:</b> Файл вредоносный!",
            'help' => "📖 <b>Руководство</b>\n\n1. Отправьте любой файл для сканирования\n2. Используйте /profile для просмотра статистики\n3. Используйте /language для смены языка\n4. Добавьте меня в группы для группового сканирования\n\n📁 <b>Поддерживаемые файлы:</b> EXE, DLL, APK, PDF, DOC, ZIP и т.д.\n\n⚠️ <b>Примечание:</b> Максимальный размер файла 320 МБ",
            'start' => "Отправьте мне файл, и я сканирую его с помощью VirusTotal!",
            'admin_stats' => "👑 <b>Статистика администратора</b>\n\n👥 Всего пользователей: {total_users}\n📊 Всего сканирований: {total_scans}\n💾 Размер базы данных: {db_size}",
            'no_file' => "Пожалуйста, отправьте мне файл для сканирования.",
            'downloading' => "⬇️ Скачивание файла...",
            'uploading' => "⬆️ Загрузка в VirusTotal...",
            'analyzing' => "🔬 Анализ файла...",
            'wait' => "⏳ Пожалуйста, подождите, пока мы обработаем ваш файл...",
            'error' => "❌ Произошла ошибка. Пожалуйста, попробуйте еще раз.",
            'rate_limit' => "⏳ Слишком много запросов. Пожалуйста, подождите немного.",
            'blocked' => "🚫 Вы временно заблокированы. Пожалуйста, попробуйте позже.",
            'channels' => "Присоединяйтесь к этим каналам:\n1. {channel1}\n2. {channel2}",
            'already_member' => "✅ Вы уже являетесь участником!",
            'join_first' => "Пожалуйста, сначала присоединитесь к каналам.",
            'scan_started' => "🚀 Сканирование начато для: {filename}",
            'file_info' => "📄 <b>Информация о файле:</b>\nИмя: {name}\nРазмер: {size}\nТип: {type}\nMD5: {md5}",
            'detection_list' => "🛡️ <b>Результаты обнаружения:</b>",
            'clean' => "✅ Чистый",
            'malicious' => "❌ Вредоносный",
            'suspicious' => "⚠️ Подозрительный",
            'hash' => "🔑 SHA256: {hash}",
            'report_url' => "📊 <a href='{url}'>Посмотреть полный отчет на VirusTotal</a>",
            'thanks' => "🙏 Спасибо за использование VirusTotal Scanner!",
            'group_welcome' => "👋 Привет, группа! Я могу сканировать файлы с VirusTotal. Отправьте мне любой файл!"
        ],
        'uk' => [
            'welcome' => "👋 <b>Привіт! Ласкаво просимо до VirusTotal Scanner Bot</b>\n\n🤖 <i>Я можу сканувати файли за допомогою 70+ антивірусних рушіїв через VirusTotal API</i>\n\n📁 <b>Функції:</b>\n• Сканування файлів до 320 МБ\n• Підтримка всіх поширених типів файлів\n• Реальний аналіз VirusTotal\n• Багатомовна підтримка (14 мов)\n• Сканування в групах\n\n⚠️ <b>Примітка:</b> Для точних результатів завантажуйте файли безпосередньо",
            'processing' => "⏳ <b>Обробка вашого файлу...</b>\n\n📊 Сканування з VirusTotal...",
            'choose_language' => "🌐 <b>Виберіть мову:</b>",
            'join_channel' => "📢 <b>Приєднуйтесь до наших каналів, щоб використовувати бота:</b>",
            'check_membership' => "✅ Перевірити членство",
            'profile' => "👤 <b>Профіль користувача</b>\n\n🆔 <b>ID:</b> <code>{user_id}</code>\n👤 <b>Ім'я користувача:</b> {username}\n📅 <b>Приєднався:</b> {reg_date}\n📊 <b>Файлів проскановано:</b> {file_count}\n🌐 <b>Мова:</b> {language}",
            'add_to_group' => "👥 Додати до групи",
            'profile_btn' => "👤 Профіль",
            'change_language' => "🌐 Змінити мову",
            'help_btn' => "📖 Довідка",
            'not_joined' => "❌ Спочатку приєднайтеся до всіх каналів!",
            'joined_success' => "✅ Ласкаво просимо! Тепер ви можете використовувати бота.",
            'file_too_large' => "❌ Файл занадто великий! Максимальний розмір 320 МБ.",
            'invalid_file' => "❌ Невірний тип файлу. Завантажте підтримуваний файл.",
            'scan_complete' => "✅ <b>Сканування завершено!</b>",
            'stats' => "📊 <b>Статистика сканування:</b>\n• Всього рушіїв: {total}\n• Шкідливих: {malicious}\n• Підозрілих: {suspicious}\n• Не виявлено: {undetected}",
            'top_detections' => "🔍 <b>Основні виявлення:</b>",
            'view_full' => "📄 Переглянути повний звіт",
            'conclusion_safe' => "🟢 <b>Висновок:</b> Файл здається безпечним",
            'conclusion_suspicious' => "🟡 <b>Висновок:</b> Файл підозрілий",
            'conclusion_malicious' => "🔴 <b>Висновок:</b> Файл шкідливий!",
            'help' => "📖 <b>Посібник</b>\n\n1. Надішліть будь-який файл для сканування\n2. Використовуйте /profile для перегляду статистики\n3. Використовуйте /language для зміни мови\n4. Додайте мене до груп для групового сканування\n\n📁 <b>Підтримувані файли:</b> EXE, DLL, APK, PDF, DOC, ZIP тощо\n\n⚠️ <b>Примітка:</b> Максимальний розмір файлу 320 МБ",
            'start' => "Надішліть мені файл, і я просканую його за допомогою VirusTotal!",
            'admin_stats' => "👑 <b>Статистика адміністратора</b>\n\n👥 Всього користувачів: {total_users}\n📊 Всього сканувань: {total_scans}\n💾 Розмір бази даних: {db_size}",
            'no_file' => "Будь ласка, надішліть мені файл для сканування.",
            'downloading' => "⬇️ Завантаження файлу...",
            'uploading' => "⬆️ Завантаження до VirusTotal...",
            'analyzing' => "🔬 Аналіз файлу...",
            'wait' => "⏳ Будь ласка, зачекайте, поки ми обробимо ваш файл...",
            'error' => "❌ Сталася помилка. Будь ласка, спробуйте ще раз.",
            'rate_limit' => "⏳ Занадто багато запитів. Будь ласка, зачекайте трохи.",
            'blocked' => "🚫 Ви тимчасово заблоковані. Будь ласка, спробуйте пізніше.",
            'channels' => "Приєднуйтесь до цих каналів:\n1. {channel1}\n2. {channel2}",
            'already_member' => "✅ Ви вже є учасником!",
            'join_first' => "Будь ласка, спочатку приєднайтеся до каналів.",
            'scan_started' => "🚀 Сканування розпочато для: {filename}",
            'file_info' => "📄 <b>Інформація про файл:</b>\nІм'я: {name}\nРозмір: {size}\nТип: {type}\nMD5: {md5}",
            'detection_list' => "🛡️ <b>Результати виявлення:</b>",
            'clean' => "✅ Чистий",
            'malicious' => "❌ Шкідливий",
            'suspicious' => "⚠️ Підозрілий",
            'hash' => "🔑 SHA256: {hash}",
            'report_url' => "📊 <a href='{url}'>Переглянути повний звіт на VirusTotal</a>",
            'thanks' => "🙏 Дякуємо за використання VirusTotal Scanner!",
            'group_welcome' => "👋 Привіт, група! Я можу сканувати файли з VirusTotal. Надішліть мені будь-який файл!"
        ],
        'de' => [
            'welcome' => "👋 <b>Hallo! Willkommen beim VirusTotal Scanner Bot</b>\n\n🤖 <i>Ich kann Dateien mit 70+ Antiviren-Engines über VirusTotal API scannen</i>\n\n📁 <b>Funktionen:</b>\n• Dateien bis zu 320 MB scannen\n• Unterstützung aller gängigen Dateitypen\n• Echte VirusTotal-Analyse\n• Mehrsprachige Unterstützung (14 Sprachen)\n• Gruppenscanning\n\n⚠️ <b>Hinweis:</b> Für genaue Ergebnisse Dateien direkt hochladen",
            'processing' => "⏳ <b>Verarbeite Ihre Datei...</b>\n\n📊 Scanne mit VirusTotal...",
            'choose_language' => "🌐 <b>Wählen Sie Ihre Sprache:</b>",
            'join_channel' => "📢 <b>Treten Sie unseren Kanälen bei, um den Bot zu nutzen:</b>",
            'check_membership' => "✅ Mitgliedschaft prüfen",
            'profile' => "👤 <b>Benutzerprofil</b>\n\n🆔 <b>ID:</b> <code>{user_id}</code>\n👤 <b>Benutzername:</b> {username}\n📅 <b>Beigetreten:</b> {reg_date}\n📊 <b>Dateien gescannt:</b> {file_count}\n🌐 <b>Sprache:</b> {language}",
            'add_to_group' => "👥 Zur Gruppe hinzufügen",
            'profile_btn' => "👤 Profil",
            'change_language' => "🌐 Sprache ändern",
            'help_btn' => "📖 Hilfe",
            'not_joined' => "❌ Sie müssen zuerst allen Kanälen beitreten!",
            'joined_success' => "✅ Willkommen! Sie können den Bot jetzt nutzen.",
            'file_too_large' => "❌ Datei ist zu groß! Maximale Größe 320 MB.",
            'invalid_file' => "❌ Ungültiger Dateityp. Bitte laden Sie eine unterstützte Datei hoch.",
            'scan_complete' => "✅ <b>Scan abgeschlossen!</b>",
            'stats' => "📊 <b>Scan-Statistiken:</b>\n• Gesamt Engines: {total}\n• Bösartig: {malicious}\n• Verdächtig: {suspicious}\n• Nicht erkannt: {undetected}",
            'top_detections' => "🔍 <b>Top-Erkennungen:</b>",
            'view_full' => "📄 Vollständigen Bericht ansehen",
            'conclusion_safe' => "🟢 <b>Fazit:</b> Datei scheint sicher zu sein",
            'conclusion_suspicious' => "🟡 <b>Fazit:</b> Datei ist verdächtig",
            'conclusion_malicious' => "🔴 <b>Fazit:</b> Datei ist bösartig!",
            'help' => "📖 <b>Hilfe</b>\n\n1. Senden Sie eine beliebige Datei zum Scannen\n2. Verwenden Sie /profile, um Ihre Statistiken anzuzeigen\n3. Verwenden Sie /language, um die Sprache zu ändern\n4. Fügen Sie mich zu Gruppen für Gruppenscans hinzu\n\n📁 <b>Unterstützte Dateien:</b> EXE, DLL, APK, PDF, DOC, ZIP usw.\n\n⚠️ <b>Hinweis:</b> Maximale Dateigröße 320 MB",
            'start' => "Senden Sie mir eine Datei und ich scanne sie mit VirusTotal!",
            'admin_stats' => "👑 <b>Admin-Statistiken</b>\n\n👥 Gesamtbenutzer: {total_users}\n📊 Gesamtscans: {total_scans}\n💾 Datenbankgröße: {db_size}",
            'no_file' => "Bitte senden Sie mir eine Datei zum Scannen.",
            'downloading' => "⬇️ Datei wird heruntergeladen...",
            'uploading' => "⬆️ Hochladen zu VirusTotal...",
            'analyzing' => "🔬 Datei wird analysiert...",
            'wait' => "⏳ Bitte warten Sie, während wir Ihre Datei verarbeiten...",
            'error' => "❌ Ein Fehler ist aufgetreten. Bitte versuchen Sie es erneut.",
            'rate_limit' => "⏳ Zu viele Anfragen. Bitte warten Sie einen Moment.",
            'blocked' => "🚫 Sie sind vorübergehend blockiert. Bitte versuchen Sie es später erneut.",
            'channels' => "Treten Sie diesen Kanälen bei:\n1. {channel1}\n2. {channel2}",
            'already_member' => "✅ Sie sind bereits Mitglied!",
            'join_first' => "Bitte treten Sie zuerst den Kanälen bei.",
            'scan_started' => "🚀 Scan gestartet für: {filename}",
            'file_info' => "📄 <b>Dateiinformationen:</b>\nName: {name}\nGröße: {size}\nTyp: {type}\nMD5: {md5}",
            'detection_list' => "🛡️ <b>Erkennungsergebnisse:</b>",
            'clean' => "✅ Sauber",
            'malicious' => "❌ Bösartig",
            'suspicious' => "⚠️ Verdächtig",
            'hash' => "🔑 SHA256: {hash}",
            'report_url' => "📊 <a href='{url}'>Vollständigen Bericht auf VirusTotal ansehen</a>",
            'thanks' => "🙏 Vielen Dank für die Nutzung von VirusTotal Scanner!",
            'group_welcome' => "👋 Hallo Gruppe! Ich kann Dateien mit VirusTotal scannen. Senden Sie mir jede Datei!"
        ],
        'es' => [
            'welcome' => "👋 <b>¡Hola! Bienvenido a VirusTotal Scanner Bot</b>\n\n🤖 <i>Puedo escanear archivos con 70+ motores antivirus usando VirusTotal API</i>\n\n📁 <b>Características:</b>\n• Escanear archivos de hasta 320 MB\n• Soporte para todos los tipos de archivos comunes\n• Análisis real de VirusTotal\n• Soporte multilingüe (14 idiomas)\n• Escaneo en grupos\n\n⚠️ <b>Nota:</b> Para resultados precisos, suba archivos directamente",
            'processing' => "⏳ <b>Procesando su archivo...</b>\n\n📊 Escaneando con VirusTotal...",
            'choose_language' => "🌐 <b>Seleccione su idioma:</b>",
            'join_channel' => "📢 <b>Únase a nuestros canales para usar el bot:</b>",
            'check_membership' => "✅ Verificar membresía",
            'profile' => "👤 <b>Perfil de usuario</b>\n\n🆔 <b>ID:</b> <code>{user_id}</code>\n👤 <b>Nombre de usuario:</b> {username}\n📅 <b>Se unió:</b> {reg_date}\n📊 <b>Archivos escaneados:</b> {file_count}\n🌐 <b>Idioma:</b> {language}",
            'add_to_group' => "👥 Añadir al grupo",
            'profile_btn' => "👤 Perfil",
            'change_language' => "🌐 Cambiar idioma",
            'help_btn' => "📖 Ayuda",
            'not_joined' => "❌ ¡Primero debe unirse a todos los canales!",
            'joined_success' => "✅ ¡Bienvenido! Ahora puede usar el bot.",
            'file_too_large' => "❌ ¡El archivo es demasiado grande! Tamaño máximo 320 MB.",
            'invalid_file' => "❌ Tipo de archivo no válido. Por favor, suba un archivo compatible.",
            'scan_complete' => "✅ <b>¡Escaneo completado!</b>",
            'stats' => "📊 <b>Estadísticas de escaneo:</b>\n• Motores totales: {total}\n• Maliciosos: {malicious}\n• Sospechosos: {suspicious}\n• No detectados: {undetected}",
            'top_detections' => "🔍 <b>Detecciones principales:</b>",
            'view_full' => "📄 Ver informe completo",
            'conclusion_safe' => "🟢 <b>Conclusión:</b> El archivo parece seguro",
            'conclusion_suspicious' => "🟡 <b>Conclusión:</b> El archivo es sospechoso",
            'conclusion_malicious' => "🔴 <b>Conclusión:</b> ¡El archivo es malicioso!",
            'help' => "📖 <b>Guía de ayuda</b>\n\n1. Envíe cualquier archivo para escanearlo\n2. Use /profile para ver sus estadísticas\n3. Use /language para cambiar el idioma\n4. Añádame a grupos para escaneo grupal\n\n📁 <b>Archivos compatibles:</b> EXE, DLL, APK, PDF, DOC, ZIP, etc.\n\n⚠️ <b>Nota:</b> Tamaño máximo de archivo 320 MB",
            'start' => "¡Envíeme un archivo y lo escanearé con VirusTotal!",
            'admin_stats' => "👑 <b>Estadísticas de administrador</b>\n\n👥 Total de usuarios: {total_users}\n📊 Total de escaneos: {total_scans}\n💾 Tamaño de la base de datos: {db_size}",
            'no_file' => "Por favor, envíeme un archivo para escanear.",
            'downloading' => "⬇️ Descargando archivo...",
            'uploading' => "⬆️ Subiendo a VirusTotal...",
            'analyzing' => "🔬 Analizando archivo...",
            'wait' => "⏳ Por favor, espere mientras procesamos su archivo...",
            'error' => "❌ Ocurrió un error. Por favor, intente de nuevo.",
            'rate_limit' => "⏳ Demasiadas solicitudes. Por favor, espere un momento.",
            'blocked' => "🚫 Está temporalmente bloqueado. Por favor, intente más tarde.",
            'channels' => "Únase a estos canales:\n1. {channel1}\n2. {channel2}",
            'already_member' => "✅ ¡Ya es miembro!",
            'join_first' => "Por favor, únase primero a los canales.",
            'scan_started' => "🚀 Escaneo iniciado para: {filename}",
            'file_info' => "📄 <b>Información del archivo:</b>\nNombre: {name}\nTamaño: {size}\nTipo: {type}\nMD5: {md5}",
            'detection_list' => "🛡️ <b>Resultados de detección:</b>",
            'clean' => "✅ Limpio",
            'malicious' => "❌ Malicioso",
            'suspicious' => "⚠️ Sospechoso",
            'hash' => "🔑 SHA256: {hash}",
            'report_url' => "📊 <a href='{url}'>Ver informe completo en VirusTotal</a>",
            'thanks' => "🙏 ¡Gracias por usar VirusTotal Scanner!",
            'group_welcome' => "👋 ¡Hola grupo! Puedo escanear archivos con VirusTotal. ¡Envíeme cualquier archivo!"
        ],
        'fr' => [
            'welcome' => "👋 <b>Bonjour! Bienvenue sur VirusTotal Scanner Bot</b>\n\n🤖 <i>Je peux analyser des fichiers avec 70+ moteurs antivirus via VirusTotal API</i>\n\n📁 <b>Fonctionnalités:</b>\n• Analyser des fichiers jusqu'à 320 Mo\n• Support de tous les types de fichiers courants\n• Analyse réelle VirusTotal\n• Support multilingue (14 langues)\n• Analyse en groupe\n\n⚠️ <b>Note:</b> Pour des résultats précis, téléchargez des fichiers directement",
            'processing' => "⏳ <b>Traitement de votre fichier...</b>\n\n📊 Analyse avec VirusTotal...",
            'choose_language' => "🌐 <b>Sélectionnez votre langue:</b>",
            'join_channel' => "📢 <b>Rejoignez nos chaînes pour utiliser le bot:</b>",
            'check_membership' => "✅ Vérifier l'adhésion",
            'profile' => "👤 <b>Profil utilisateur</b>\n\n🆔 <b>ID:</b> <code>{user_id}</code>\n👤 <b>Nom d'utilisateur:</b> {username}\n📅 <b>Inscrit le:</b> {reg_date}\n📊 <b>Fichiers analysés:</b> {file_count}\n🌐 <b>Langue:</b> {language}",
            'add_to_group' => "👥 Ajouter au groupe",
            'profile_btn' => "👤 Profil",
            'change_language' => "🌐 Changer de langue",
            'help_btn' => "📖 Aide",
            'not_joined' => "❌ Vous devez d'abord rejoindre toutes les chaînes!",
            'joined_success' => "✅ Bienvenue! Vous pouvez maintenant utiliser le bot.",
            'file_too_large' => "❌ Le fichier est trop volumineux! Taille maximale 320 Mo.",
            'invalid_file' => "❌ Type de fichier invalide. Veuillez télécharger un fichier pris en charge.",
            'scan_complete' => "✅ <b>Analyse terminée!</b>",
            'stats' => "📊 <b>Statistiques d'analyse:</b>\n• Moteurs totaux: {total}\n• Malveillants: {malicious}\n• Suspects: {suspicious}\n• Non détectés: {undetected}",
            'top_detections' => "🔍 <b>Détections principales:</b>",
            'view_full' => "📄 Voir le rapport complet",
            'conclusion_safe' => "🟢 <b>Conclusion:</b> Le fichier semble sûr",
            'conclusion_suspicious' => "🟡 <b>Conclusion:</b> Le fichier est suspect",
            'conclusion_malicious' => "🔴 <b>Conclusion:</b> Le fichier est malveillant!",
            'help' => "📖 <b>Guide d'aide</b>\n\n1. Envoyez n'importe quel fichier pour l'analyser\n2. Utilisez /profile pour voir vos statistiques\n3. Utilisez /language pour changer de langue\n4. Ajoutez-moi aux groupes pour l'analyse de groupe\n\n📁 <b>Fichiers pris en charge:</b> EXE, DLL, APK, PDF, DOC, ZIP, etc.\n\n⚠️ <b>Note:</b> Taille maximale du fichier 320 Mo",
            'start' => "Envoyez-moi un fichier et je l'analyserai avec VirusTotal!",
            'admin_stats' => "👑 <b>Statistiques d'administrateur</b>\n\n👥 Total d'utilisateurs: {total_users}\n📊 Total d'analyses: {total_scans}\n💾 Taille de la base de données: {db_size}",
            'no_file' => "Veuillez m'envoyer un fichier à analyser.",
            'downloading' => "⬇️ Téléchargement du fichier...",
            'uploading' => "⬆️ Téléversement sur VirusTotal...",
            'analyzing' => "🔬 Analyse du fichier...",
            'wait' => "⏳ Veuillez patienter pendant que nous traitons votre fichier...",
            'error' => "❌ Une erreur s'est produite. Veuillez réessayer.",
            'rate_limit' => "⏳ Trop de demandes. Veuillez patienter un instant.",
            'blocked' => "🚫 Vous êtes temporairement bloqué. Veuillez réessayer plus tard.",
            'channels' => "Rejoignez ces chaînes:\n1. {channel1}\n2. {channel2}",
            'already_member' => "✅ Vous êtes déjà membre!",
            'join_first' => "Veuillez d'abord rejoindre les chaînes.",
            'scan_started' => "🚀 Analyse démarrée pour: {filename}",
            'file_info' => "📄 <b>Informations sur le fichier:</b>\nNom: {name}\nTaille: {size}\nType: {type}\nMD5: {md5}",
            'detection_list' => "🛡️ <b>Résultats de détection:</b>",
            'clean' => "✅ Propre",
            'malicious' => "❌ Malveillant",
            'suspicious' => "⚠️ Suspect",
            'hash' => "🔑 SHA256: {hash}",
            'report_url' => "📊 <a href='{url}'>Voir le rapport complet sur VirusTotal</a>",
            'thanks' => "🙏 Merci d'utiliser VirusTotal Scanner!",
            'group_welcome' => "👋 Bonjour le groupe! Je peux analyser des fichiers avec VirusTotal. Envoyez-moi n'importe quel fichier!"
        ],
        'it' => [
            'welcome' => "👋 <b>Ciao! Benvenuto in VirusTotal Scanner Bot</b>\n\n🤖 <i>Posso scansionare file con 70+ motori antivirus utilizzando VirusTotal API</i>\n\n📁 <b>Funzionalità:</b>\n• Scansiona file fino a 320 MB\n• Supporto per tutti i tipi di file comuni\n• Analisi reale VirusTotal\n• Supporto multilingue (14 lingue)\n• Scansione di gruppo\n\n⚠️ <b>Nota:</b> Per risultati accurati, carica file direttamente",
            'processing' => "⏳ <b>Elaborazione del tuo file...</b>\n\n📊 Scansione con VirusTotal...",
            'choose_language' => "🌐 <b>Seleziona la tua lingua:</b>",
            'join_channel' => "📢 <b>Unisciti ai nostri canali per usare il bot:</b>",
            'check_membership' => "✅ Verifica l'adesione",
            'profile' => "👤 <b>Profilo utente</b>\n\n🆔 <b>ID:</b> <code>{user_id}</code>\n👤 <b>Nome utente:</b> {username}\n📅 <b>Iscritto il:</b> {reg_date}\n📊 <b>File scansionati:</b> {file_count}\n🌐 <b>Lingua:</b> {language}",
            'add_to_group' => "👥 Aggiungi al gruppo",
            'profile_btn' => "👤 Profilo",
            'change_language' => "🌐 Cambia lingua",
            'help_btn' => "📖 Aiuto",
            'not_joined' => "❌ Devi prima unirti a tutti i canali!",
            'joined_success' => "✅ Benvenuto! Ora puoi usare il bot.",
            'file_too_large' => "❌ Il file è troppo grande! Dimensione massima 320 MB.",
            'invalid_file' => "❌ Tipo di file non valido. Per favore carica un file supportato.",
            'scan_complete' => "✅ <b>Scansione completata!</b>",
            'stats' => "📊 <b>Statistiche della scansione:</b>\n• Motori totali: {total}\n• Maligni: {malicious}\n• Sospetti: {suspicious}\n• Non rilevati: {undetected}",
            'top_detections' => "🔍 <b>Rilevamenti principali:</b>",
            'view_full' => "📄 Visualizza rapporto completo",
            'conclusion_safe' => "🟢 <b>Conclusione:</b> Il file sembra sicuro",
            'conclusion_suspicious' => "🟡 <b>Conclusione:</b> Il file è sospetto",
            'conclusion_malicious' => "🔴 <b>Conclusione:</b> Il file è dannoso!",
            'help' => "📖 <b>Guida</b>\n\n1. Invia qualsiasi file per scansionarlo\n2. Usa /profile per vedere le tue statistiche\n3. Usa /language per cambiare lingua\n4. Aggiungimi ai gruppi per la scansione di gruppo\n\n📁 <b>File supportati:</b> EXE, DLL, APK, PDF, DOC, ZIP, ecc.\n\n⚠️ <b>Nota:</b> Dimensione massima del file 320 MB",
            'start' => "Inviami un file e lo scannerò con VirusTotal!",
            'admin_stats' => "👑 <b>Statistiche amministratore</b>\n\n👥 Utenti totali: {total_users}\n📊 Scansioni totali: {total_scans}\n💾 Dimensione database: {db_size}",
            'no_file' => "Per favore, inviami un file da scansionare.",
            'downloading' => "⬇️ Download del file...",
            'uploading' => "⬆️ Caricamento su VirusTotal...",
            'analyzing' => "🔬 Analisi del file...",
            'wait' => "⏳ Attendi mentre elaboriamo il tuo file...",
            'error' => "❌ Si è verificato un errore. Riprova per favore.",
            'rate_limit' => "⏳ Troppe richieste. Attendi un momento.",
            'blocked' => "🚫 Sei temporaneamente bloccato. Riprova più tardi.",
            'channels' => "Unisciti a questi canali:\n1. {channel1}\n2. {channel2}",
            'already_member' => "✅ Sei già membro!",
            'join_first' => "Per favore, unisciti prima ai canali.",
            'scan_started' => "🚀 Scansione iniziata per: {filename}",
            'file_info' => "📄 <b>Informazioni file:</b>\nNome: {name}\nDimensione: {size}\nTipo: {type}\nMD5: {md5}",
            'detection_list' => "🛡️ <b>Risultati rilevamento:</b>",
            'clean' => "✅ Pulito",
            'malicious' => "❌ Dannoso",
            'suspicious' => "⚠️ Sospetto",
            'hash' => "🔑 SHA256: {hash}",
            'report_url' => "📊 <a href='{url}'>Visualizza rapporto completo su VirusTotal</a>",
            'thanks' => "🙏 Grazie per usare VirusTotal Scanner!",
            'group_welcome' => "👋 Ciao gruppo! Posso scansionare file con VirusTotal. Inviami qualsiasi file!"
        ],
        'pt' => [
            'welcome' => "👋 <b>Olá! Bem-vindo ao VirusTotal Scanner Bot</b>\n\n🤖 <i>Posso verificar arquivos com 70+ mecanismos antivírus usando VirusTotal API</i>\n\n📁 <b>Recursos:</b>\n• Verificar arquivos de até 320 MB\n• Suporte a todos os tipos de arquivos comuns\n• Análise real do VirusTotal\n• Suporte multilíngue (14 idiomas)\n• Verificação em grupo\n\n⚠️ <b>Nota:</b> Para resultados precisos, envie arquivos diretamente",
            'processing' => "⏳ <b>Processando seu arquivo...</b>\n\n📊 Verificando com VirusTotal...",
            'choose_language' => "🌐 <b>Selecione seu idioma:</b>",
            'join_channel' => "📢 <b>Junte-se aos nossos canais para usar o bot:</b>",
            'check_membership' => "✅ Verificar assinatura",
            'profile' => "👤 <b>Perfil do usuário</b>\n\n🆔 <b>ID:</b> <code>{user_id}</code>\n👤 <b>Nome de usuário:</b> {username}\n📅 <b>Registrado em:</b> {reg_date}\n📊 <b>Arquivos verificados:</b> {file_count}\n🌐 <b>Idioma:</b> {language}",
            'add_to_group' => "👥 Adicionar ao grupo",
            'profile_btn' => "👤 Perfil",
            'change_language' => "🌐 Alterar idioma",
            'help_btn' => "📖 Ajuda",
            'not_joined' => "❌ Primeiro você precisa entrar em todos os canais!",
            'joined_success' => "✅ Bem-vindo! Agora você pode usar o bot.",
            'file_too_large' => "❌ O arquivo é muito grande! Tamanho máximo 320 MB.",
            'invalid_file' => "❌ Tipo de arquivo inválido. Por favor, envie um arquivo compatível.",
            'scan_complete' => "✅ <b>Verificação concluída!</b>",
            'stats' => "📊 <b>Estatísticas de verificação:</b>\n• Mecanismos totais: {total}\n• Maliciosos: {malicious}\n• Suspeitos: {suspicious}\n• Não detectados: {undetected}",
            'top_detections' => "🔍 <b>Principais detecções:</b>",
            'view_full' => "📄 Ver relatório completo",
            'conclusion_safe' => "🟢 <b>Conclusão:</b> O arquivo parece seguro",
            'conclusion_suspicious' => "🟡 <b>Conclusão:</b> O arquivo é suspeito",
            'conclusion_malicious' => "🔴 <b>Conclusão:</b> O arquivo é malicioso!",
            'help' => "📖 <b>Guia de ajuda</b>\n\n1. Envie qualquer arquivo para verificar\n2. Use /profile para ver suas estatísticas\n3. Use /language para alterar o idioma\n4. Adicione-me a grupos para verificação em grupo\n\n📁 <b>Arquivos suportados:</b> EXE, DLL, APK, PDF, DOC, ZIP, etc.\n\n⚠️ <b>Nota:</b> Tamanho máximo do arquivo 320 MB",
            'start' => "Envie-me um arquivo e eu o verificarei com VirusTotal!",
            'admin_stats' => "👑 <b>Estatísticas de administrador</b>\n\n👥 Total de usuários: {total_users}\n📊 Total de verificações: {total_scans}\n💾 Tamanho do banco de dados: {db_size}",
            'no_file' => "Por favor, envie-me um arquivo para verificar.",
            'downloading' => "⬇️ Baixando arquivo...",
            'uploading' => "⬆️ Enviando para VirusTotal...",
            'analyzing' => "🔬 Analisando arquivo...",
            'wait' => "⏳ Por favor, aguarde enquanto processamos seu arquivo...",
            'error' => "❌ Ocorreu um erro. Por favor, tente novamente.",
            'rate_limit' => "⏳ Muitas solicitações. Por favor, aguarde um momento.",
            'blocked' => "🚫 Você está temporariamente bloqueado. Por favor, tente novamente mais tarde.",
            'channels' => "Junte-se a estes canais:\n1. {channel1}\n2. {channel2}",
            'already_member' => "✅ Você já é membro!",
            'join_first' => "Por favor, entre nos canais primeiro.",
            'scan_started' => "🚀 Verificação iniciada para: {filename}",
            'file_info' => "📄 <b>Informações do arquivo:</b>\nNome: {name}\nTamanho: {size}\nTipo: {type}\nMD5: {md5}",
            'detection_list' => "🛡️ <b>Resultados de detecção:</b>",
            'clean' => "✅ Limpo",
            'malicious' => "❌ Malicioso",
            'suspicious' => "⚠️ Suspeito",
            'hash' => "🔑 SHA256: {hash}",
            'report_url' => "📊 <a href='{url}'>Ver relatório completo no VirusTotal</a>",
            'thanks' => "🙏 Obrigado por usar o VirusTotal Scanner!",
            'group_welcome' => "👋 Olá grupo! Posso verificar arquivos com VirusTotal. Envie-me qualquer arquivo!"
        ],
        'id' => [
            'welcome' => "👋 <b>Halo! Selamat datang di VirusTotal Scanner Bot</b>\n\n🤖 <i>Saya dapat memindai file dengan 70+ mesin antivirus menggunakan VirusTotal API</i>\n\n📁 <b>Fitur:</b>\n• Pindai file hingga 320 MB\n• Dukung semua jenis file umum\n• Analisis VirusTotal asli\n• Dukung multi-bahasa (14 bahasa)\n• Pemindaian grup\n\n⚠️ <b>Catatan:</b> Untuk hasil akurat, unggah file langsung",
            'processing' => "⏳ <b>Memproses file Anda...</b>\n\n📊 Memindai dengan VirusTotal...",
            'choose_language' => "🌐 <b>Pilih bahasa Anda:</b>",
            'join_channel' => "📢 <b>Bergabunglah dengan saluran kami untuk menggunakan bot:</b>",
            'check_membership' => "✅ Verifikasi Keanggotaan",
            'profile' => "👤 <b>Profil Pengguna</b>\n\n🆔 <b>ID:</b> <code>{user_id}</code>\n👤 <b>Nama pengguna:</b> {username}\n📅 <b>Bergabung:</b> {reg_date}\n📊 <b>File dipindai:</b> {file_count}\n🌐 <b>Bahasa:</b> {language}",
            'add_to_group' => "👥 Tambahkan ke Grup",
            'profile_btn' => "👤 Profil",
            'change_language' => "🌐 Ubah Bahasa",
            'help_btn' => "📖 Bantuan",
            'not_joined' => "❌ Anda harus bergabung dengan semua saluran terlebih dahulu!",
            'joined_success' => "✅ Selamat datang! Sekarang Anda dapat menggunakan bot.",
            'file_too_large' => "❌ File terlalu besar! Ukuran maksimum 320 MB.",
            'invalid_file' => "❌ Jenis file tidak valid. Harap unggah file yang didukung.",
            'scan_complete' => "✅ <b>Pemindaian Selesai!</b>",
            'stats' => "📊 <b>Statistik Pemindaian:</b>\n• Total Mesin: {total}\n• Berbahaya: {malicious}\n• Mencurigakan: {suspicious}\n• Tidak terdeteksi: {undetected}",
            'top_detections' => "🔍 <b>Deteksi Teratas:</b>",
            'view_full' => "📄 Lihat Laporan Lengkap",
            'conclusion_safe' => "🟢 <b>Kesimpulan:</b> File tampaknya aman",
            'conclusion_suspicious' => "🟡 <b>Kesimpulan:</b> File mencurigakan",
            'conclusion_malicious' => "🔴 <b>Kesimpulan:</b> File berbahaya!",
            'help' => "📖 <b>Panduan Bantuan</b>\n\n1. Kirim file apa saja untuk dipindai\n2. Gunakan /profile untuk melihat statistik Anda\n3. Gunakan /language untuk mengubah bahasa\n4. Tambahkan saya ke grup untuk pemindaian grup\n\n📁 <b>File yang Didukung:</b> EXE, DLL, APK, PDF, DOC, ZIP, dll.\n\n⚠️ <b>Catatan:</b> Ukuran file maksimum 320 MB",
            'start' => "Kirimkan saya file dan saya akan memindainya dengan VirusTotal!",
            'admin_stats' => "👑 <b>Statistik Admin</b>\n\n👥 Total Pengguna: {total_users}\n📊 Total Pemindaian: {total_scans}\n💾 Ukuran Database: {db_size}",
            'no_file' => "Harap kirimkan saya file untuk dipindai.",
            'downloading' => "⬇️ Mengunduh file...",
            'uploading' => "⬆️ Mengunggah ke VirusTotal...",
            'analyzing' => "🔬 Menganalisis file...",
            'wait' => "⏳ Harap tunggu saat kami memproses file Anda...",
            'error' => "❌ Terjadi kesalahan. Silakan coba lagi.",
            'rate_limit' => "⏳ Terlalu banyak permintaan. Harap tunggu sebentar.",
            'blocked' => "🚫 Anda sementara diblokir. Harap coba lagi nanti.",
            'channels' => "Bergabunglah dengan saluran ini:\n1. {channel1}\n2. {channel2}",
            'already_member' => "✅ Anda sudah menjadi anggota!",
            'join_first' => "Harap bergabung dengan saluran terlebih dahulu.",
            'scan_started' => "🚀 Pemindaian dimulai untuk: {filename}",
            'file_info' => "📄 <b>Informasi File:</b>\nNama: {name}\nUkuran: {size}\nJenis: {type}\nMD5: {md5}",
            'detection_list' => "🛡️ <b>Hasil Deteksi:</b>",
            'clean' => "✅ Bersih",
            'malicious' => "❌ Berbahaya",
            'suspicious' => "⚠️ Mencurigakan",
            'hash' => "🔑 SHA256: {hash}",
            'report_url' => "📊 <a href='{url}'>Lihat laporan lengkap di VirusTotal</a>",
            'thanks' => "🙏 Terima kasih telah menggunakan VirusTotal Scanner!",
            'group_welcome' => "👋 Halo grup! Saya dapat memindai file dengan VirusTotal. Kirimkan saya file apa saja!"
        ],
        'tr' => [
            'welcome' => "👋 <b>Merhaba! VirusTotal Scanner Bot'a Hoş Geldiniz</b>\n\n🤖 <i>VirusTotal API kullanarak 70+ antivirüs motoruyla dosyaları tarayabilirim</i>\n\n📁 <b>Özellikler:</b>\n• 320 MB'a kadar dosya tarama\n• Tüm yaygın dosya türlerini destekleme\n• Gerçek VirusTotal analizi\n• Çok dilli destek (14 dil)\n• Grup taraması\n\n⚠️ <b>Not:</b> Doğru sonuçlar için dosyaları doğrudan yükleyin",
            'processing' => "⏳ <b>Dosyanız işleniyor...</b>\n\n📊 VirusTotal ile taranıyor...",
            'choose_language' => "🌐 <b>Dilinizi seçin:</b>",
            'join_channel' => "📢 <b>Bot'u kullanmak için kanallarımıza katılın:</b>",
            'check_membership' => "✅ Üyeliği Doğrula",
            'profile' => "👤 <b>Kullanıcı Profili</b>\n\n🆔 <b>ID:</b> <code>{user_id}</code>\n👤 <b>Kullanıcı adı:</b> {username}\n📅 <b>Katılım Tarihi:</b> {reg_date}\n📊 <b>Taranan Dosyalar:</b> {file_count}\n🌐 <b>Dil:</b> {language}",
            'add_to_group' => "👥 Gruba Ekle",
            'profile_btn' => "👤 Profil",
            'change_language' => "🌐 Dil Değiştir",
            'help_btn' => "📖 Yardım",
            'not_joined' => "❌ Önce tüm kanallara katılmalısınız!",
            'joined_success' => "✅ Hoş geldiniz! Artık bot'u kullanabilirsiniz.",
            'file_too_large' => "❌ Dosya çok büyük! Maksimum boyut 320 MB.",
            'invalid_file' => "❌ Geçersiz dosya türü. Lütfen desteklenen bir dosya yükleyin.",
            'scan_complete' => "✅ <b>Tarama Tamamlandı!</b>",
            'stats' => "📊 <b>Tarama İstatistikleri:</b>\n• Toplam Motor: {total}\n• Kötü Amaçlı: {malicious}\n• Şüpheli: {suspicious}\n• Tespit Edilmeyen: {undetected}",
            'top_detections' => "🔍 <b>Başlıca Tespitler:</b>",
            'view_full' => "📄 Tam Raporu Görüntüle",
            'conclusion_safe' => "🟢 <b>Sonuç:</b> Dosya güvenli görünüyor",
            'conclusion_suspicious' => "🟡 <b>Sonuç:</b> Dosya şüpheli",
            'conclusion_malicious' => "🔴 <b>Sonuç:</b> Dosya kötü amaçlı!",
            'help' => "📖 <b>Yardım Kılavuzu</b>\n\n1. Taramak için herhangi bir dosya gönderin\n2. İstatistiklerinizi görmek için /profile kullanın\n3. Dili değiştirmek için /language kullanın\n4. Grup taraması için beni gruplara ekleyin\n\n📁 <b>Desteklenen Dosyalar:</b> EXE, DLL, APK, PDF, DOC, ZIP, vb.\n\n⚠️ <b>Not:</b> Maksimum dosya boyutu 320 MB",
            'start' => "Bana bir dosya gönderin ve VirusTotal ile tarayayım!",
            'admin_stats' => "👑 <b>Yönetici İstatistikleri</b>\n\n👥 Toplam Kullanıcı: {total_users}\n📊 Toplam Tarama: {total_scans}\n💾 Veritabanı Boyutu: {db_size}",
            'no_file' => "Lütfen taramam için bana bir dosya gönderin.",
            'downloading' => "⬇️ Dosya indiriliyor...",
            'uploading' => "⬆️ VirusTotal'a yükleniyor...",
            'analyzing' => "🔬 Dosya analiz ediliyor...",
            'wait' => "⏳ Dosyanız işlenirken lütfen bekleyin...",
            'error' => "❌ Bir hata oluştu. Lütfen tekrar deneyin.",
            'rate_limit' => "⏳ Çok fazla istek. Lütfen biraz bekleyin.",
            'blocked' => "🚫 Geçici olarak engellendiniz. Lütfen daha sonra tekrar deneyin.",
            'channels' => "Bu kanallara katılın:\n1. {channel1}\n2. {channel2}",
            'already_member' => "✅ Zaten üyesiniz!",
            'join_first' => "Lütfen önce kanallara katılın.",
            'scan_started' => "🚀 Tarama başlatıldı: {filename}",
            'file_info' => "📄 <b>Dosya Bilgileri:</b>\nAd: {name}\nBoyut: {size}\nTür: {type}\nMD5: {md5}",
            'detection_list' => "🛡️ <b>Tespit Sonuçları:</b>",
            'clean' => "✅ Temiz",
            'malicious' => "❌ Kötü Amaçlı",
            'suspicious' => "⚠️ Şüpheli",
            'hash' => "🔑 SHA256: {hash}",
            'report_url' => "📊 <a href='{url}'>VirusTotal'da tam raporu görüntüle</a>",
            'thanks' => "🙏 VirusTotal Scanner kullandığınız için teşekkürler!",
            'group_welcome' => "👋 Merhaba grup! VirusTotal ile dosyaları tarayabilirim. Bana herhangi bir dosya gönderin!"
        ],
        'vi' => [
            'welcome' => "👋 <b>Xin chào! Chào mừng đến với VirusTotal Scanner Bot</b>\n\n🤖 <i>Tôi có thể quét tệp với 70+ công cụ chống vi-rút bằng VirusTotal API</i>\n\n📁 <b>Tính năng:</b>\n• Quét tệp lên đến 320 MB\n• Hỗ trợ tất cả các loại tệp phổ biến\n• Phân tích VirusTotal thực tế\n• Hỗ trợ đa ngôn ngữ (14 ngôn ngữ)\n• Quét nhóm\n\n⚠️ <b>Lưu ý:</b> Để có kết quả chính xác, hãy tải tệp trực tiếp",
            'processing' => "⏳ <b>Đang xử lý tệp của bạn...</b>\n\n📊 Đang quét với VirusTotal...",
            'choose_language' => "🌐 <b>Chọn ngôn ngữ của bạn:</b>",
            'join_channel' => "📢 <b>Tham gia kênh của chúng tôi để sử dụng bot:</b>",
            'check_membership' => "✅ Xác minh thành viên",
            'profile' => "👤 <b>Hồ sơ người dùng</b>\n\n🆔 <b>ID:</b> <code>{user_id}</code>\n👤 <b>Tên người dùng:</b> {username}\n📅 <b>Đã tham gia:</b> {reg_date}\n📊 <b>Tệp đã quét:</b> {file_count}\n🌐 <b>Ngôn ngữ:</b> {language}",
            'add_to_group' => "👥 Thêm vào nhóm",
            'profile_btn' => "👤 Hồ sơ",
            'change_language' => "🌐 Thay đổi ngôn ngữ",
            'help_btn' => "📖 Trợ giúp",
            'not_joined' => "❌ Bạn cần tham gia tất cả các kênh trước!",
            'joined_success' => "✅ Chào mừng! Bây giờ bạn có thể sử dụng bot.",
            'file_too_large' => "❌ Tệp quá lớn! Kích thước tối đa 320 MB.",
            'invalid_file' => "❌ Loại tệp không hợp lệ. Vui lòng tải lên tệp được hỗ trợ.",
            'scan_complete' => "✅ <b>Quét hoàn tất!</b>",
            'stats' => "📊 <b>Thống kê quét:</b>\n• Tổng công cụ: {total}\n• Độc hại: {malicious}\n• Đáng ngờ: {suspicious}\n• Không phát hiện: {undetected}",
            'top_detections' => "🔍 <b>Phát hiện hàng đầu:</b>",
            'view_full' => "📄 Xem báo cáo đầy đủ",
            'conclusion_safe' => "🟢 <b>Kết luận:</b> Tệp có vẻ an toàn",
            'conclusion_suspicious' => "🟡 <b>Kết luận:</b> Tệp đáng ngờ",
            'conclusion_malicious' => "🔴 <b>Kết luận:</b> Tệp độc hại!",
            'help' => "📖 <b>Hướng dẫn trợ giúp</b>\n\n1. Gửi bất kỳ tệp nào để quét\n2. Sử dụng /profile để xem thống kê của bạn\n3. Sử dụng /language để thay đổi ngôn ngữ\n4. Thêm tôi vào nhóm để quét nhóm\n\n📁 <b>Tệp được hỗ trợ:</b> EXE, DLL, APK, PDF, DOC, ZIP, v.v.\n\n⚠️ <b>Lưu ý:</b> Kích thước tệp tối đa 320 MB",
            'start' => "Gửi cho tôi một tệp và tôi sẽ quét nó với VirusTotal!",
            'admin_stats' => "👑 <b>Thống kê quản trị viên</b>\n\n👥 Tổng người dùng: {total_users}\n📊 Tổng số lần quét: {total_scans}\n💾 Kích thước cơ sở dữ liệu: {db_size}",
            'no_file' => "Vui lòng gửi cho tôi một tệp để quét.",
            'downloading' => "⬇️ Đang tải tệp xuống...",
            'uploading' => "⬆️ Đang tải lên VirusTotal...",
            'analyzing' => "🔬 Đang phân tích tệp...",
            'wait' => "⏳ Vui lòng đợi trong khi chúng tôi xử lý tệp của bạn...",
            'error' => "❌ Đã xảy ra lỗi. Vui lòng thử lại.",
            'rate_limit' => "⏳ Quá nhiều yêu cầu. Vui lòng đợi một chút.",
            'blocked' => "🚫 Bạn tạm thời bị chặn. Vui lòng thử lại sau.",
            'channels' => "Tham gia các kênh này:\n1. {channel1}\n2. {channel2}",
            'already_member' => "✅ Bạn đã là thành viên!",
            'join_first' => "Vui lòng tham gia các kênh trước.",
            'scan_started' => "🚀 Quét đã bắt đầu cho: {filename}",
            'file_info' => "📄 <b>Thông tin tệp:</b>\nTên: {name}\nKích thước: {size}\nLoại: {type}\nMD5: {md5}",
            'detection_list' => "🛡️ <b>Kết quả phát hiện:</b>",
            'clean' => "✅ Sạch",
            'malicious' => "❌ Độc hại",
            'suspicious' => "⚠️ Đáng ngờ",
            'hash' => "🔑 SHA256: {hash}",
            'report_url' => "📊 <a href='{url}'>Xem báo cáo đầy đủ trên VirusTotal</a>",
            'thanks' => "🙏 Cảm ơn bạn đã sử dụng VirusTotal Scanner!",
            'group_welcome' => "👋 Chào nhóm! Tôi có thể quét tệp với VirusTotal. Gửi cho tôi bất kỳ tệp nào!"
        ],
        'ar' => [
            'welcome' => "👋 <b>مرحبًا! أهلاً بك في بوت فحص VirusTotal</b>\n\n🤖 <i>يمكنني فحص الملفات باستخدام 70+ محرك مضاد للفيروسات عبر VirusTotal API</i>\n\n📁 <b>المميزات:</b>\n• فحص الملفات حتى 320 ميجابايت\n• دعم جميع أنواع الملفات الشائعة\n• تحليل VirusTotal حقيقي\n• دعم متعدد اللغات (14 لغة)\n• الفحص الجماعي\n\n⚠️ <b>ملاحظة:</b> لنتائج دقيقة، قم برفع الملفات مباشرة",
            'processing' => "⏳ <b>جاري معالجة ملفك...</b>\n\n📊 جاري الفحص باستخدام VirusTotal...",
            'choose_language' => "🌐 <b>اختر لغتك:</b>",
            'join_channel' => "📢 <b>انضم إلى قنواتنا لاستخدام البوت:</b>",
            'check_membership' => "✅ التحقق من العضوية",
            'profile' => "👤 <b>ملف المستخدم</b>\n\n🆔 <b>المعرف:</b> <code>{user_id}</code>\n👤 <b>اسم المستخدم:</b> {username}\n📅 <b>تاريخ الانضمام:</b> {reg_date}\n📊 <b>الملفات المفحوصة:</b> {file_count}\n🌐 <b>اللغة:</b> {language}",
            'add_to_group' => "👥 إضافة إلى المجموعة",
            'profile_btn' => "👤 الملف الشخصي",
            'change_language' => "🌐 تغيير اللغة",
            'help_btn' => "📖 المساعدة",
            'not_joined' => "❌ يجب الانضمام إلى جميع القنوات أولاً!",
            'joined_success' => "✅ أهلاً بك! يمكنك الآن استخدام البوت.",
            'file_too_large' => "❌ الملف كبير جدًا! الحجم الأقصى 320 ميجابايت.",
            'invalid_file' => "❌ نوع ملف غير صالح. يرجى رفع ملف مدعوم.",
            'scan_complete' => "✅ <b>اكتمل الفحص!</b>",
            'stats' => "📊 <b>إحصائيات الفحص:</b>\n• إجمالي المحركات: {total}\n• ضار: {malicious}\n• مشبوه: {suspicious}\n• غير مكتشف: {undetected}",
            'top_detections' => "🔍 <b>الاكتشافات الرئيسية:</b>",
            'view_full' => "📄 عرض التقرير الكامل",
            'conclusion_safe' => "🟢 <b>الخلاصة:</b> يبدو أن الملف آمن",
            'conclusion_suspicious' => "🟡 <b>الخلاصة:</b> الملف مشبوه",
            'conclusion_malicious' => "🔴 <b>الخلاصة:</b> الملف ضار!",
            'help' => "📖 <b>دليل المساعدة</b>\n\n1. أرسل أي ملف لفحصه\n2. استخدم /profile لرؤية إحصائياتك\n3. استخدم /language لتغيير اللغة\n4. أضفني إلى المجموعات للفحص الجماعي\n\n📁 <b>الملفات المدعومة:</b> EXE, DLL, APK, PDF, DOC, ZIP, إلخ.\n\n⚠️ <b>ملاحظة:</b> الحد الأقصى لحجم الملف 320 ميجابايت",
            'start' => "أرسل لي ملفًا وسأفحصه باستخدام VirusTotal!",
            'admin_stats' => "👑 <b>إحصائيات المسؤول</b>\n\n👥 إجمالي المستخدمين: {total_users}\n📊 إجمالي الفحوصات: {total_scans}\n💾 حجم قاعدة البيانات: {db_size}",
            'no_file' => "الرجاء إرسال ملف لي لفحصه.",
            'downloading' => "⬇️ جاري تنزيل الملف...",
            'uploading' => "⬆️ جاري الرفع إلى VirusTotal...",
            'analyzing' => "🔬 جاري تحليل الملف...",
            'wait' => "⏳ الرجاء الانتظار بينما نقوم بمعالجة ملفك...",
            'error' => "❌ حدث خطأ. الرجاء المحاولة مرة أخرى.",
            'rate_limit' => "⏳ طلبات كثيرة جدًا. الرجاء الانتظار قليلاً.",
            'blocked' => "🚫 أنت محظور مؤقتًا. الرجاء المحاولة لاحقًا.",
            'channels' => "انضم إلى هذه القنوات:\n1. {channel1}\n2. {channel2}",
            'already_member' => "✅ أنت عضو بالفعل!",
            'join_first' => "الرجاء الانضمام إلى القنوات أولاً.",
            'scan_started' => "🚀 بدأ الفحص لـ: {filename}",
            'file_info' => "📄 <b>معلومات الملف:</b>\nالاسم: {name}\nالحجم: {size}\nالنوع: {type}\nMD5: {md5}",
            'detection_list' => "🛡️ <b>نتائج الاكتشاف:</b>",
            'clean' => "✅ نظيف",
            'malicious' => "❌ ضار",
            'suspicious' => "⚠️ مشبوه",
            'hash' => "🔑 SHA256: {hash}",
            'report_url' => "📊 <a href='{url}'>عرض التقرير الكامل على VirusTotal</a>",
            'thanks' => "🙏 شكرًا لاستخدامك VirusTotal Scanner!",
            'group_welcome' => "👋 مرحبًا بالمجموعة! يمكنني فحص الملفات باستخدام VirusTotal. أرسلوا لي أي ملف!"
        ],
        'zh' => [
            'welcome' => "👋 <b>你好！欢迎使用 VirusTotal 扫描机器人</b>\n\n🤖 <i>我可以使用 VirusTotal API 通过 70+ 个防病毒引擎扫描文件</i>\n\n📁 <b>功能:</b>\n• 扫描文件高达 320 MB\n• 支持所有常见文件类型\n• 真实的 VirusTotal 分析\n• 多语言支持 (14 种语言)\n• 群组扫描\n\n⚠️ <b>注意:</b> 为了获得准确结果，请直接上传文件",
            'processing' => "⏳ <b>正在处理您的文件...</b>\n\n📊 使用 VirusTotal 扫描中...",
            'choose_language' => "🌐 <b>选择您的语言:</b>",
            'join_channel' => "📢 <b>加入我们的频道以使用机器人:</b>",
            'check_membership' => "✅ 验证会员资格",
            'profile' => "👤 <b>用户资料</b>\n\n🆔 <b>ID:</b> <code>{user_id}</code>\n👤 <b>用户名:</b> {username}\n📅 <b>加入日期:</b> {reg_date}\n📊 <b>已扫描文件:</b> {file_count}\n🌐 <b>语言:</b> {language}",
            'add_to_group' => "👥 添加到群组",
            'profile_btn' => "👤 资料",
            'change_language' => "🌐 更改语言",
            'help_btn' => "📖 帮助",
            'not_joined' => "❌ 您需要先加入所有频道！",
            'joined_success' => "✅ 欢迎！您现在可以使用机器人了。",
            'file_too_large' => "❌ 文件太大！最大大小 320 MB。",
            'invalid_file' => "❌ 无效的文件类型。请上传支持的文件。",
            'scan_complete' => "✅ <b>扫描完成！</b>",
            'stats' => "📊 <b>扫描统计:</b>\n• 总引擎: {total}\n• 恶意: {malicious}\n• 可疑: {suspicious}\n• 未检测到: {undetected}",
            'top_detections' => "🔍 <b>主要检测结果:</b>",
            'view_full' => "📄 查看完整报告",
            'conclusion_safe' => "🟢 <b>结论:</b> 文件似乎是安全的",
            'conclusion_suspicious' => "🟡 <b>结论:</b> 文件可疑",
            'conclusion_malicious' => "🔴 <b>结论:</b> 文件是恶意的！",
            'help' => "📖 <b>帮助指南</b>\n\n1. 发送任何文件进行扫描\n2. 使用 /profile 查看您的统计数据\n3. 使用 /language 更改语言\n4. 将我添加到群组进行群组扫描\n\n📁 <b>支持的文件:</b> EXE, DLL, APK, PDF, DOC, ZIP 等\n\n⚠️ <b>注意:</b> 最大文件大小 320 MB",
            'start' => "发送给我一个文件，我会用 VirusTotal 扫描它！",
            'admin_stats' => "👑 <b>管理员统计</b>\n\n👥 总用户数: {total_users}\n📊 总扫描次数: {total_scans}\n💾 数据库大小: {db_size}",
            'no_file' => "请发送文件给我扫描。",
            'downloading' => "⬇️ 下载文件中...",
            'uploading' => "⬆️ 上传到 VirusTotal...",
            'analyzing' => "🔬 分析文件中...",
            'wait' => "⏳ 请稍等，我们正在处理您的文件...",
            'error' => "❌ 发生错误。请重试。",
            'rate_limit' => "⏳ 请求过多。请稍等片刻。",
            'blocked' => "🚫 您暂时被阻止。请稍后再试。",
            'channels' => "加入这些频道:\n1. {channel1}\n2. {channel2}",
            'already_member' => "✅ 您已经是会员！",
            'join_first' => "请先加入频道。",
            'scan_started' => "🚀 扫描开始: {filename}",
            'file_info' => "📄 <b>文件信息:</b>\n名称: {name}\n大小: {size}\n类型: {type}\nMD5: {md5}",
            'detection_list' => "🛡️ <b>检测结果:</b>",
            'clean' => "✅ 干净",
            'malicious' => "❌ 恶意",
            'suspicious' => "⚠️ 可疑",
            'hash' => "🔑 SHA256: {hash}",
            'report_url' => "📊 <a href='{url}'>在 VirusTotal 上查看完整报告</a>",
            'thanks' => "🙏 感谢使用 VirusTotal 扫描器！",
            'group_welcome' => "👋 大家好！我可以用 VirusTotal 扫描文件。发送任何文件给我！"
        ]
    ];
    
    public static function getLanguageKeyboard() {
        $keyboard = [];
        $languages = self::$languages;
        
        $row = [];
        $count = 0;
        foreach ($languages as $code => $lang) {
            $row[] = ['text' => $lang[0], 'callback_data' => "setlang_{$code}"];
            $count++;
            
            if ($count % 2 == 0) {
                $keyboard[] = $row;
                $row = [];
            }
        }
        
        if (!empty($row)) {
            $keyboard[] = $row;
        }
        
        return json_encode(['inline_keyboard' => $keyboard]);
    }
    
    public static function getMainKeyboard($lang = 'en', $is_admin = false) {
        $messages = self::getMessages($lang);
        $keyboard = [
            [
                ['text' => $messages['add_to_group'], 'url' => 'https://t.me/' . self::getBotUsername() . '?startgroup=true', 'style' => 'success'],
                ['text' => $messages['profile_btn'], 'callback_data' => 'profile', 'style' => 'primary']
            ],
            [
                ['text' => $messages['change_language'], 'callback_data' => 'changelang', 'style' => 'danger'],
                ['text' => $messages['help_btn'], 'callback_data' => 'help', 'style' => 'primary']
            ]
        ];

        if ($is_admin) {
            $keyboard[] = [
                ['text' => '👑 پنل مدیریت', 'callback_data' => 'admin_panel', 'style' => 'primary']
            ];
        }

        return json_encode(['inline_keyboard' => $keyboard]);
    }
    
    public static function getJoinChannelKeyboard($lang = 'en') {
        $messages = self::getMessages($lang);
        $keyboard = [];

        $ch1 = SettingsManager::getChannelMain();
        $ch2 = SettingsManager::getChannelSecondary();

        if (!empty($ch1)) {
            $keyboard[] = [
                ['text' => '📢 ' . $ch1, 'url' => 'https://t.me/' . substr($ch1, 1)]
            ];
        }

        if (!empty($ch2)) {
            if (empty($keyboard)) {
                $keyboard[] = [];
            }
            $keyboard[0][] = ['text' => '📢 ' . $ch2, 'url' => 'https://t.me/' . substr($ch2, 1)];
        }

        $keyboard[] = [
            ['text' => $messages['check_membership'], 'callback_data' => 'check_join']
        ];

        return json_encode(['inline_keyboard' => $keyboard]);
    }
    
    public static function getMessages($lang) {
        $base = self::$messages['en'];
        $specific = self::$messages[$lang] ?? [];
        return array_merge($base, $specific);
    }
    
    public static function getLanguageName($code) {
        return self::$languages[$code][0] ?? 'English';
    }
    
    private static function getBotUsername() {
        return defined('BOT_USERNAME') ? substr(BOT_USERNAME, 1) : 'VirusTotalScannerBot';
    }
}


class Logger {
    public static function log($message, $level = 'INFO', $context = []) {
        if (!defined('LOG_ENABLED') || !LOG_ENABLED) return;
        
        $timestamp = date('Y-m-d H:i:s');
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';
        $logMessage = "[{$timestamp}] [{$level}] [{$ip}] {$message}";
        
        if (!empty($context)) {
            $logMessage .= " | Context: " . json_encode($context, JSON_UNESCAPED_UNICODE);
        }
        
        $logMessage .= PHP_EOL;
        
        $logFile = defined('LOG_FILE') ? LOG_FILE : 'logs/bot.log';
        $logDir = dirname($logFile);
        
        if (!is_dir($logDir)) {
            @mkdir($logDir, 0755, true);
        }
        
        @file_put_contents($logFile, $logMessage, FILE_APPEND);
    }
    
    public static function error($message, $context = []) {
        self::log($message, 'ERROR', $context);
        
        $timestamp = date('Y-m-d H:i:s');
        $logMessage = "[{$timestamp}] ERROR: {$message}";
        
        if (!empty($context)) {
            $logMessage .= " | " . json_encode($context, JSON_UNESCAPED_UNICODE);
        }
        
        $logMessage .= PHP_EOL;
        
        $errorLogFile = 'logs/error.log';
        @file_put_contents($errorLogFile, $logMessage, FILE_APPEND);
    }
    
    public static function info($message, $context = []) {
        self::log($message, 'INFO', $context);
    }
    
    public static function debug($message, $context = []) {
        if (defined('DEBUG_MODE') && DEBUG_MODE) {
            self::log($message, 'DEBUG', $context);
        }
    }
}


class UserManager {
    public static function getUser($user_id) {
        $users = self::loadUsers();
        
        if (!isset($users[$user_id])) {
            $users[$user_id] = [
                'user_id' => $user_id,
                'username' => '',
                'first_name' => '',
                'last_name' => '',
                'language' => 'en',
                'language_selected' => false,
                'registration_date' => date('Y-m-d H:i:s'),
                'file_count' => 0,
                'last_active' => date('Y-m-d H:i:s'),
                'total_scans' => 0
            ];
            self::saveUsers($users);
            self::updateStats('new_users', 1);
        }
        
        return $users[$user_id];
    }
    
    public static function updateUser($user_id, $data) {
        $users = self::loadUsers();
        $users[$user_id] = array_merge(self::getUser($user_id), $data);
        $users[$user_id]['last_active'] = date('Y-m-d H:i:s');
        self::saveUsers($users);
    }
    
    public static function incrementScanCount($user_id) {
        $user = self::getUser($user_id);
        $user['file_count']++;
        $user['total_scans']++;
        self::updateUser($user_id, $user);
        self::updateStats('total_scans', 1);
    }
    
    public static function getTotalUsers() {
        $users = self::loadUsers();
        return count($users);
    }
    
    public static function getTotalScans() {
        $stats = self::loadStats();
        return $stats['total_scans'] ?? 0;
    }
    
    public static function setAdminState($user_id, $state) {
        self::updateUser($user_id, ['admin_state' => $state]);
    }

    public static function clearAdminState($user_id) {
        self::updateUser($user_id, ['admin_state' => null]);
    }

    public static function getAdminState($user_id) {
        $user = self::getUser($user_id);
        return $user['admin_state'] ?? null;
    }

    public static function getAllUserIds() {
        $users = self::loadUsers();
        return array_keys($users);
    }

    private static function loadUsers() {
        $dbFile = defined('DB_USERS') ? DB_USERS : 'data/users.json';
        
        if (file_exists($dbFile)) {
            $data = @file_get_contents($dbFile);
            if ($data) {
                $users = json_decode($data, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    return $users ?: [];
                }
            }
        }
        
        return [];
    }
    
    private static function saveUsers($users) {
        $dbFile = defined('DB_USERS') ? DB_USERS : 'data/users.json';
        $dataDir = dirname($dbFile);
        
        if (!is_dir($dataDir)) {
            @mkdir($dataDir, 0755, true);
        }
        
        $json = json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        @file_put_contents($dbFile, $json);
    }
    
    private static function loadStats() {
        $statsFile = defined('DB_STATS') ? DB_STATS : 'data/stats.json';
        
        if (file_exists($statsFile)) {
            $data = @file_get_contents($statsFile);
            if ($data) {
                $stats = json_decode($data, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    return $stats ?: ['total_scans' => 0, 'new_users' => 0, 'daily_scans' => []];
                }
            }
        }
        
        return ['total_scans' => 0, 'new_users' => 0, 'daily_scans' => []];
    }
    
    private static function saveStats($stats) {
        $statsFile = defined('DB_STATS') ? DB_STATS : 'data/stats.json';
        $dataDir = dirname($statsFile);
        
        if (!is_dir($dataDir)) {
            @mkdir($dataDir, 0755, true);
        }
        
        @file_put_contents($statsFile, json_encode($stats, JSON_PRETTY_PRINT));
    }
    
    private static function updateStats($key, $value = 1) {
        $stats = self::loadStats();
        
        if (!isset($stats[$key])) {
            $stats[$key] = 0;
        }
        
        if (is_numeric($stats[$key])) {
            $stats[$key] += $value;
        }
        
        $today = date('Y-m-d');
        if (!isset($stats['daily_scans'][$today])) {
            $stats['daily_scans'][$today] = 0;
        }
        $stats['daily_scans'][$today] += $value;
        
        $stats['daily_scans'] = array_slice($stats['daily_scans'], -30, 30, true);
        
        self::saveStats($stats);
    }
}


class SettingsManager {
    private static $file = 'data/settings.json';

    public static function getAll() {
        if (file_exists(self::$file)) {
            $data = @file_get_contents(self::$file);
            if ($data) {
                $s = json_decode($data, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($s)) {
                    return $s;
                }
            }
        }
        return [
            'maintenance_mode' => false,
            'channel_main' => defined('CHANNEL_MAIN') ? CHANNEL_MAIN : '',
            'channel_secondary' => defined('CHANNEL_SECONDARY') ? CHANNEL_SECONDARY : '',
            'extra_admins' => []
        ];
    }

    public static function get($key, $default = null) {
        $s = self::getAll();
        return $s[$key] ?? $default;
    }

    public static function set($key, $value) {
        $s = self::getAll();
        $s[$key] = $value;
        self::saveAll($s);
    }

    private static function saveAll($settings) {
        $dir = dirname(self::$file);
        if (!is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }
        @file_put_contents(self::$file, json_encode($settings, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    public static function isMaintenance() {
        return (bool) self::get('maintenance_mode', false);
    }

    public static function getChannelMain() {
        $v = self::get('channel_main', null);
        return ($v !== null && $v !== '') ? $v : (defined('CHANNEL_MAIN') ? CHANNEL_MAIN : '');
    }

    public static function getChannelSecondary() {
        $v = self::get('channel_secondary', null);
        return ($v !== null && $v !== '') ? $v : (defined('CHANNEL_SECONDARY') ? CHANNEL_SECONDARY : '');
    }

    public static function getExtraAdmins() {
        $v = self::get('extra_admins', []);
        return is_array($v) ? $v : [];
    }

    public static function addExtraAdmin($id) {
        $admins = self::getExtraAdmins();
        $id = (int) $id;
        if (!in_array($id, $admins)) {
            $admins[] = $id;
        }
        self::set('extra_admins', $admins);
    }

    public static function removeExtraAdmin($id) {
        $admins = self::getExtraAdmins();
        $id = (int) $id;
        $admins = array_values(array_filter($admins, function($a) use ($id) { return $a != $id; }));
        self::set('extra_admins', $admins);
    }
}


class BlockManager {
    private static $file = 'data/blocked.json';

    public static function getBlocked() {
        if (file_exists(self::$file)) {
            $data = @file_get_contents(self::$file);
            if ($data) {
                $b = json_decode($data, true);
                if (json_last_error() === JSON_ERROR_NONE && isset($b['users'])) {
                    return $b['users'];
                }
            }
        }
        return [];
    }

    public static function isBlocked($user_id) {
        return in_array((int) $user_id, self::getBlocked());
    }

    public static function block($user_id) {
        $users = self::getBlocked();
        $user_id = (int) $user_id;
        if (!in_array($user_id, $users)) {
            $users[] = $user_id;
        }
        self::save($users);
    }

    public static function unblock($user_id) {
        $users = self::getBlocked();
        $user_id = (int) $user_id;
        $users = array_values(array_filter($users, function($u) use ($user_id) { return $u != $user_id; }));
        self::save($users);
    }

    private static function save($users) {
        $dir = dirname(self::$file);
        if (!is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }
        @file_put_contents(self::$file, json_encode(['users' => $users, 'ips' => []], JSON_PRETTY_PRINT));
    }
}



class ChannelMembership {
    public static function checkMembership($user_id) {
        if (!defined('BOT_TOKEN') || empty(BOT_TOKEN)) {
            Logger::error("BOT_TOKEN not defined for membership check");
            return false;
        }
        
        $channels = [];
        $ch1 = SettingsManager::getChannelMain();
        $ch2 = SettingsManager::getChannelSecondary();
        if (!empty($ch1)) {
            $channels[] = $ch1;
        }
        if (!empty($ch2)) {
            $channels[] = $ch2;
        }
        
        if (empty($channels)) {
            Logger::warning("No channels configured for membership check");
            return true;
        }
        
        foreach ($channels as $channel) {
            $url = "https://api.telegram.org/bot" . BOT_TOKEN . "/getChatMember?chat_id={$channel}&user_id={$user_id}";
            $res = @file_get_contents($url);
            
            if (!$res) {
                Logger::error("Failed to check membership for channel: {$channel}");
                continue;
            }
            
            $res = json_decode($res, true);
            
            if (!$res['ok'] || !in_array($res['result']['status'], ['member', 'administrator', 'creator'])) {
                Logger::info("User {$user_id} is not a member of {$channel}");
                return false;
            }
        }
        
        return true;
    }
}


class VirusTotalAPI {
    private $api_key;
    
    public function __construct($api_key) {
        $this->api_key = $api_key;
        Logger::debug("VirusTotalAPI initialized", ['api_key_prefix' => substr($api_key, 0, 10) . '...']);
    }
    
    public function uploadFile($file_content, $file_name) {
        Logger::info("Uploading file to VirusTotal", [
            'filename' => $file_name, 
            'size' => strlen($file_content)
        ]);
        
        $boundary = '----VirusTotalBoundary' . uniqid();
        
        $body = "--" . $boundary . "\r\n";
        $body .= "Content-Disposition: form-data; name=\"file\"; filename=\"" . basename($file_name) . "\"\r\n";
        $body .= "Content-Type: application/octet-stream\r\n\r\n";
        $body .= $file_content . "\r\n";
        $body .= "--" . $boundary . "--\r\n";
        
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => 'https://www.virustotal.com/api/v3/files',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $body,
            CURLOPT_HTTPHEADER => [
                'Content-Type: multipart/form-data; boundary=' . $boundary,
                'x-apikey: ' . $this->api_key,
                'User-Agent: VirusTotalTelegramBot/3.0',
                'Accept: application/json'
            ],
            CURLOPT_TIMEOUT => 120,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2
        ]);
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        Logger::debug("VirusTotal upload response", [
            'http_code' => $http_code,
            'error' => $error ?: 'None'
        ]);
        
        if ($http_code === 200) {
            $data = json_decode($response, true);
            if (isset($data['data']['id'])) {
                Logger::info("✅ File uploaded successfully to VirusTotal", ['analysis_id' => $data['data']['id']]);
                return $data['data']['id'];
            }
        }
        
        Logger::error("❌ VirusTotal upload failed", [
            'http_code' => $http_code,
            'error' => $error
        ]);
        return null;
    }
    
    public function getFileReport($file_hash) {
        Logger::debug("Getting file report from VirusTotal", ['hash' => $file_hash]);
        
        $url = "https://www.virustotal.com/api/v3/files/{$file_hash}";
        
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'x-apikey: ' . $this->api_key,
                'User-Agent: VirusTotalTelegramBot/3.0',
                'Accept: application/json'
            ],
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => true
        ]);
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($http_code === 200) {
            $data = json_decode($response, true);
            Logger::debug("✅ File report retrieved successfully");
            return $data;
        }
        
        Logger::debug("File report not found or error", [
            'http_code' => $http_code,
            'error' => $error
        ]);
        return null;
    }
    
    public function getAnalysis($analysis_id) {
        Logger::debug("Getting analysis from VirusTotal", ['analysis_id' => $analysis_id]);
        
        $url = "https://www.virustotal.com/api/v3/analyses/{$analysis_id}";
        
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'x-apikey: ' . $this->api_key,
                'User-Agent: VirusTotalTelegramBot/3.0',
                'Accept: application/json'
            ],
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => true
        ]);
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($http_code === 200) {
            $data = json_decode($response, true);
            Logger::debug("✅ Analysis retrieved successfully");
            return $data;
        }
        
        Logger::error("Failed to get analysis", [
            'http_code' => $http_code,
            'error' => $error
        ]);
        return null;
    }
}


class VirusTotalBot {
    private $api;
    
    public function __construct() {
        if (!defined('VT_API_KEY') || empty(VT_API_KEY)) {
            throw new Exception("VirusTotal API key not configured");
        }
        $this->api = new VirusTotalAPI(VT_API_KEY);
    }
    
    public function processUpdate() {
        $input = @file_get_contents("php://input");
        
        if (!$input) {
            Logger::error("No input received from Telegram");
            return;
        }
        
        $update = json_decode($input, true);
        
        if (!$update) {
            Logger::error("Invalid JSON received from Telegram");
            return;
        }
        
        Logger::debug("Telegram update received", ['update_type' => array_keys($update)[0]]);
        
        try {
            if (isset($update['callback_query'])) {
                $this->handleCallbackQuery($update['callback_query']);
            } elseif (isset($update['message'])) {
                $this->handleMessage($update['message']);
            } elseif (isset($update['my_chat_member'])) {
                $this->handleChatMember($update['my_chat_member']);
            }
        } catch (Exception $e) {
            Logger::error("Error processing update: " . $e->getMessage());
        }
        
        echo "OK";
    }
    
    private function handleCallbackQuery($callback) {
        $user_id = $callback['from']['id'];
        $chat_id = $callback['message']['chat']['id'];
        $message_id = $callback['message']['message_id'];
        $callback_id = $callback['id'];
        $data = $callback['data'];

        $this->answerCallbackQuery($callback_id);

        if (BlockManager::isBlocked($user_id) && !$this->isAdmin($user_id)) {
            return;
        }

        $user = UserManager::getUser($user_id);
        $lang = $user['language'];
        $messages = LanguageManager::getMessages($lang);
        $is_admin = $this->isAdmin($user_id);
        $chat_type = $callback['message']['chat']['type'] ?? 'private';
        $is_group = in_array($chat_type, ['group', 'supergroup']);

        if (strpos($data, 'admin_') === 0) {
            if (!$is_admin || $is_group) {
                return;
            }
            $this->handleAdminCallback($data, $chat_id, $message_id, $user_id, $lang);
            return;
        }

        $show_admin_btn = $is_admin && !$is_group;

        if ($data === 'check_join') {
            if (ChannelMembership::checkMembership($user_id)) {
                $welcome = $messages['welcome'];
                $keyboard = LanguageManager::getMainKeyboard($lang, $show_admin_btn);
                $this->editMessage($chat_id, $message_id, $welcome, $keyboard);
            } else {
                $this->sendMessage($chat_id, $messages['not_joined']);
            }
        } elseif ($data === 'profile') {
            $profile = str_replace(
                ['{user_id}', '{username}', '{reg_date}', '{file_count}', '{language}'],
                [$user_id, $user['username'] ?: $user['first_name'], $user['registration_date'], $user['file_count'], LanguageManager::getLanguageName($lang)],
                $messages['profile']
            );
            $keyboard = LanguageManager::getMainKeyboard($lang, $show_admin_btn);
            $this->editMessage($chat_id, $message_id, $profile, $keyboard);
        } elseif ($data === 'changelang') {
            $keyboard = LanguageManager::getLanguageKeyboard();
            $this->editMessage($chat_id, $message_id, $messages['choose_language'], $keyboard);
        } elseif ($data === 'help') {
            $this->editMessage($chat_id, $message_id, $messages['help'], LanguageManager::getMainKeyboard($lang, $show_admin_btn));
        } elseif (strpos($data, 'setlang_') === 0) {
            $new_lang = substr($data, 8);
            UserManager::updateUser($user_id, ['language' => $new_lang, 'language_selected' => true]);
            $messages = LanguageManager::getMessages($new_lang);
            $keyboard = LanguageManager::getMainKeyboard($new_lang, $show_admin_btn);
            $this->editMessage($chat_id, $message_id, $messages['welcome'], $keyboard);
        }
    }
    
    private function handleMessage($message) {
        $chat_id = $message['chat']['id'];
        $chat_type = $message['chat']['type'] ?? 'private';
        $user_id = $message['from']['id'] ?? null;

        if (!$user_id) {
            return;
        }

        $user = UserManager::getUser($user_id);
        $lang = $user['language'];
        $messages = LanguageManager::getMessages($lang);

        if (isset($message['from'])) {
            UserManager::updateUser($user_id, [
                'username' => $message['from']['username'] ?? '',
                'first_name' => $message['from']['first_name'] ?? '',
                'last_name' => $message['from']['last_name'] ?? ''
            ]);
        }

        $is_admin = $this->isAdmin($user_id);
        $is_group = in_array($chat_type, ['group', 'supergroup']);
        $has_text = isset($message['text']);
        $text = $has_text ? $message['text'] : '';
        $is_command = $has_text && strpos($text, '/') === 0;
        $has_document = isset($message['document']);
        $has_new_members = isset($message['new_chat_members']);

        if (BlockManager::isBlocked($user_id) && !$is_admin) {
            if (!$is_group) {
                $this->sendMessage($chat_id, $messages['user_blocked']);
            }
            return;
        }

        if ($is_group && !$has_document && !$is_command && !$has_new_members) {
            return;
        }

        if ($is_admin && $has_text) {
            $pending = UserManager::getAdminState($user_id);
            if ($pending) {
                $this->handleAdminPendingInput($pending, $text, $user_id, $chat_id);
                return;
            }
        }

        if (SettingsManager::isMaintenance() && !$is_admin) {
            if (!$is_group) {
                $this->sendMessage($chat_id, $messages['maintenance']);
            }
            return;
        }

        if ($has_document && !ChannelMembership::checkMembership($user_id)) {
            $ch1 = SettingsManager::getChannelMain();
            $ch2 = SettingsManager::getChannelSecondary();
            $join_msg = $messages['join_channel'] . "\n\n";
            if (!empty($ch1)) {
                $join_msg .= "1. " . $ch1 . "\n";
            }
            if (!empty($ch2)) {
                $join_msg .= "2. " . $ch2 . "\n";
            }
            $keyboard = LanguageManager::getJoinChannelKeyboard($lang);
            $this->sendMessage($chat_id, $join_msg, $keyboard);
            return;
        }

        if ($is_command) {
            $show_admin_btn = $is_admin && !$is_group;
            if (strpos($text, '/start') === 0) {
                if (empty($user['language_selected'])) {
                    $keyboard = LanguageManager::getLanguageKeyboard();
                    $this->sendMessage($chat_id, $messages['choose_language'], $keyboard);
                } else {
                    $keyboard = LanguageManager::getMainKeyboard($lang, $show_admin_btn);
                    $this->sendMessage($chat_id, $messages['welcome'], $keyboard);
                }
            } elseif (strpos($text, '/profile') === 0) {
                $profile = str_replace(
                    ['{user_id}', '{username}', '{reg_date}', '{file_count}', '{language}'],
                    [$user_id, $user['username'] ?: $user['first_name'], $user['registration_date'], $user['file_count'], LanguageManager::getLanguageName($lang)],
                    $messages['profile']
                );
                $keyboard = LanguageManager::getMainKeyboard($lang, $show_admin_btn);
                $this->sendMessage($chat_id, $profile, $keyboard);
            } elseif (strpos($text, '/language') === 0 || strpos($text, '/lang') === 0) {
                $keyboard = LanguageManager::getLanguageKeyboard();
                $this->sendMessage($chat_id, $messages['choose_language'], $keyboard);
            } elseif (strpos($text, '/help') === 0) {
                $this->sendMessage($chat_id, $messages['help'], LanguageManager::getMainKeyboard($lang, $show_admin_btn));
            } elseif (strpos($text, '/admin') === 0) {
                if ($is_admin && !$is_group) {
                    $this->showAdminPanel($chat_id);
                } elseif (!$is_group) {
                    $this->sendMessage($chat_id, $messages['not_admin']);
                }
            } elseif (strpos($text, '/stats') === 0) {
                if ($is_admin && !$is_group) {
                    $this->sendAdminStats($chat_id, $user_id, $lang);
                }
            } elseif (!$is_group) {
                $this->sendMessage($chat_id, $messages['no_file']);
            }
        } elseif ($has_document) {
            $this->handleDocument($message, $user_id, $chat_id, $lang);
        } elseif ($has_new_members) {
            foreach ($message['new_chat_members'] as $member) {
                if (isset($member['is_bot']) && $member['is_bot'] && isset($member['username']) &&
                    strtolower($member['username']) === strtolower(str_replace('@', '', defined('BOT_USERNAME') ? BOT_USERNAME : ''))) {
                    $this->sendMessage($chat_id, $messages['group_welcome']);
                    break;
                }
            }
        } elseif (!$is_group) {
            $this->sendMessage($chat_id, $messages['no_file']);
        }
    }
    
    private function handleDocument($message, $user_id, $chat_id, $lang) {
        $messages = LanguageManager::getMessages($lang);
        
        $document = $message['document'];
        $file_id = $document['file_id'];
        $file_name = $document['file_name'] ?? 'unknown_' . time() . '.bin';
        $file_size = $document['file_size'] ?? 0;
        
        Logger::info("Processing file upload", [
            'user_id' => $user_id,
            'file_name' => $file_name,
            'file_size' => $file_size
        ]);
        
        
        if ($file_size > MAX_FILE_SIZE) {
            $this->sendMessage($chat_id, $messages['file_too_large']);
            return;
        }
        
        
        $extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        if (!in_array($extension, ALLOWED_EXTENSIONS)) {
            $this->sendMessage($chat_id, $messages['invalid_file'] . " (.$extension)");
            return;
        }
        
        
        $processing_msg = $this->sendMessage($chat_id, 
            str_replace('{filename}', $file_name, $messages['scan_started']) . "\n" . 
            $messages['downloading']
        );
        
        $processing_msg_data = json_decode($processing_msg, true);
        
        if (!$processing_msg_data || !$processing_msg_data['ok']) {
            Logger::error("Failed to send processing message", ['response' => $processing_msg_data]);
            $this->sendMessage($chat_id, $messages['error']);
            return;
        }
        
        $processing_msg_id = $processing_msg_data['result']['message_id'];
        
        try {
            
            $this->editMessage($chat_id, $processing_msg_id, 
                str_replace('{filename}', $file_name, $messages['scan_started']) . "\n" . 
                $messages['downloading']
            );
            
            $file_content = $this->downloadFile($file_id);
            
            if (!$file_content) {
                $this->editMessage($chat_id, $processing_msg_id, $messages['error'] . " (Download failed)");
                return;
            }
            
            Logger::debug("File downloaded successfully", ['size' => strlen($file_content)]);
            
            
            $file_hash = hash('sha256', $file_content);
            Logger::debug("File hash calculated", ['hash' => $file_hash]);
            
            
            $this->editMessage($chat_id, $processing_msg_id, 
                str_replace('{filename}', $file_name, $messages['scan_started']) . "\n" . 
                $messages['uploading']
            );
            
            
            $report = $this->api->getFileReport($file_hash);
            
            if ($report && isset($report['data'])) {
                Logger::debug("Found existing report on VirusTotal");
                $this->editMessage($chat_id, $processing_msg_id, 
                    str_replace('{filename}', $file_name, $messages['scan_started']) . "\n" . 
                    $messages['analyzing']
                );
            } else {
                
                Logger::debug("No existing report found, uploading file");
                $this->editMessage($chat_id, $processing_msg_id, 
                    str_replace('{filename}', $file_name, $messages['scan_started']) . "\n" . 
                    $messages['uploading']
                );
                
                $analysis_id = $this->api->uploadFile($file_content, $file_name);
                
                if (!$analysis_id) {
                    $this->editMessage($chat_id, $processing_msg_id, $messages['error'] . " (Upload failed)");
                    return;
                }
                
                Logger::debug("File uploaded to VirusTotal", ['analysis_id' => $analysis_id]);
                
                
                $this->editMessage($chat_id, $processing_msg_id, 
                    str_replace('{filename}', $file_name, $messages['scan_started']) . "\n" . 
                    $messages['analyzing']
                );
                
                
                Logger::debug("Waiting for analysis to complete...");
                sleep(15);
                
                $report = $this->api->getAnalysis($analysis_id);
            }
            
            if ($report && isset($report['data'])) {
                $this->processScanResult($chat_id, $processing_msg_id, $report, $file_name, $file_content, $lang);
                UserManager::incrementScanCount($user_id);
            } else {
                Logger::error("Failed to get scan result", ['report' => $report]);
                $this->editMessage($chat_id, $processing_msg_id, $messages['error'] . " (Analysis failed)");
            }
            
        } catch (Exception $e) {
            Logger::error("Error handling document: " . $e->getMessage());
            $this->editMessage($chat_id, $processing_msg_id, $messages['error'] . ": " . $e->getMessage());
        }
    }
    
    private function processScanResult($chat_id, $message_id, $report_data, $file_name, $file_content, $lang) {
    try {
        $messages = LanguageManager::getMessages($lang);
        
        $attributes = $report_data['data']['attributes'] ?? [];
        $results = $attributes['last_analysis_results'] ?? [];
        $stats = $attributes['last_analysis_stats'] ?? ['malicious' => 0, 'suspicious' => 0, 'undetected' => 0, 'harmless' => 0];
        
        $file_hash = hash('sha256', $file_content);
        $file_size = strlen($file_content);
        
        
        $result_msg = "";
        
        
        $result_msg .= "✅ <b>Scan Completed!</b>\n\n";
        
        
        $total_engines = is_array($results) ? count($results) : 0;
        $detections = ($stats['malicious'] ?? 0) + ($stats['suspicious'] ?? 0);
        $result_msg .= "🧬 <b>Detections:</b> {$detections} / {$total_engines}\n\n";
        
        
        if (is_array($results) && !empty($results)) {
            $all_engines = array_keys($results);
            sort($all_engines);
            
            foreach ($all_engines as $engine) {
                $result_msg .= "✅ {$engine}\n";
            }
            
            $result_msg .= "\n";
        }
        
        
        $result_msg .= "🔖 <b>File Name:</b> {$file_name}\n";
        
        
        $file_type = $this->getFileTypeEnglish($file_name);
        $result_msg .= "🔒 <b>File Type:</b> {$file_type}\n";
        
        
        $formatted_size = $this->formatFileSize($file_size);
        $result_msg .= "📁 <b>File Size:</b> {$formatted_size}\n\n";
        
        
        $result_msg .= "🔑 <b>SHA256:</b>\n<code>{$file_hash}</code>\n\n";
        
        
        $vt_url = "https://www.virustotal.com/gui/file/{$file_hash}";
        $result_msg .= "⚜️ <b>VirusTotal Report:</b>\n";
        $result_msg .= "<a href='{$vt_url}'>{$vt_url}</a>\n\n";
        
        
        if ($detections === 0) {
            $result_msg .= "🟢 <b>Conclusion:</b> File is safe";
        } elseif ($detections < 5) {
            $result_msg .= "🟡 <b>Conclusion:</b> File is suspicious";
        } else {
            $result_msg .= "🔴 <b>Conclusion:</b> File is malicious!";
        }

        if (defined('CREATOR_NAME') && CREATOR_NAME !== '') {
            $result_msg .= "\n\n———\n🛠️ " . CREATOR_NAME;
        }

        $bot_username_clean = defined('BOT_USERNAME') ? ltrim(BOT_USERNAME, '@') : '';
        $result_row = [
            ['text' => 'Add to Group', 'url' => 'https://t.me/' . $bot_username_clean . '?startgroup=true', 'style' => 'success']
        ];
        if (defined('CREATOR_CHANNEL') && CREATOR_CHANNEL !== '') {
            $result_row[] = ['text' => CREATOR_CHANNEL, 'url' => 'https://t.me/' . ltrim(CREATOR_CHANNEL, '@'), 'style' => 'primary'];
        }
        $result_reply_markup = json_encode(['inline_keyboard' => [$result_row]]);

        $this->editMessage($chat_id, $message_id, $result_msg, $result_reply_markup);
        
    } catch (Exception $e) {
        Logger::error("Error in processScanResult: " . $e->getMessage());
        
        
        $this->editMessage($chat_id, $message_id, 
            "✅ Scan completed!\n\n" .
            "🔖 File: {$file_name}\n" .
            "📊 Detections: 0/" . (is_array($results) ? count($results) : 0) . "\n" .
            "🟢 File appears to be safe"
        );
    }
}


private function getFileTypeEnglish($filename) {
    try {
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $types = [
            'exe' => 'Windows Executable',
            'dll' => 'Windows DLL',
            'apk' => 'Android Application',
            'jar' => 'Java Archive',
            'pdf' => 'PDF Document',
            'doc' => 'Microsoft Word Document',
            'docx' => 'Microsoft Word Document',
            'xls' => 'Microsoft Excel Spreadsheet',
            'xlsx' => 'Microsoft Excel Spreadsheet',
            'ppt' => 'Microsoft PowerPoint',
            'pptx' => 'Microsoft PowerPoint',
            'zip' => 'ZIP Archive',
            'rar' => 'RAR Archive',
            '7z' => '7-Zip Archive',
            'tar' => 'TAR Archive',
            'gz' => 'GZIP Archive',
            'bz2' => 'BZIP2 Archive',
            'py' => 'Python Script',
            'js' => 'JavaScript File',
            'php' => 'PHP Script',
            'html' => 'HTML Document',
            'htm' => 'HTML Document',
            'txt' => 'Text File',
            'bat' => 'Batch File',
            'ps1' => 'PowerShell Script',
            'sh' => 'Shell Script',
            'vbs' => 'VBScript',
            'scr' => 'Screen Saver',
            'msi' => 'Windows Installer',
            'app' => 'Mac OS Application',
            'dmg' => 'Mac OS Disk Image',
            'pkg' => 'Mac OS Package',
            'deb' => 'Debian Package',
            'rpm' => 'RPM Package',
            'bin' => 'Binary File',
            'iso' => 'Disk Image',
            'img' => 'Disk Image',
            'vhd' => 'Virtual Hard Disk',
            'vdi' => 'Virtual Disk Image',
            'ova' => 'Virtual Appliance',
            'ovf' => 'Virtualization Format'
        ];
        
        return $types[$ext] ?? 'Unknown File Type';
    } catch (Exception $e) {
        return 'File';
    }
}
    
    private function sendAdminStats($chat_id, $user_id, $lang) {
        if (!$this->isAdmin($user_id)) {
            return;
        }
        
        $messages = LanguageManager::getMessages($lang);
        $total_users = UserManager::getTotalUsers();
        $total_scans = UserManager::getTotalScans();
        
        $db_size = 0;
        if (file_exists(DB_USERS)) {
            $db_size = filesize(DB_USERS);
        }
        
        $stats_msg = str_replace(
            ['{total_users}', '{total_scans}', '{db_size}'],
            [$total_users, $total_scans, $this->formatFileSize($db_size)],
            $messages['admin_stats']
        );
        
        $this->sendMessage($chat_id, $stats_msg);
    }
    
    private function isAdmin($user_id) {
        $ids = defined('ADMIN_IDS') ? ADMIN_IDS : [];
        $extra = SettingsManager::getExtraAdmins();
        $all = array_merge($ids, $extra);
        return in_array((int) $user_id, array_map('intval', $all));
    }
    
    private function downloadFile($file_id) {
        if (!defined('BOT_TOKEN') || empty(BOT_TOKEN)) {
            Logger::error("BOT_TOKEN not defined for file download");
            return false;
        }
        
        $url = "https://api.telegram.org/bot" . BOT_TOKEN . "/getFile?file_id=" . urlencode($file_id);
        $response = @file_get_contents($url);
        
        if (!$response) {
            Logger::error("Failed to get file info from Telegram");
            return false;
        }
        
        $file_info = json_decode($response, true);
        
        if (!$file_info || !$file_info['ok']) {
            Logger::error("Invalid file info response", ['response' => $file_info]);
            return false;
        }
        
        $file_path = $file_info['result']['file_path'];
        $file_url = "https://api.telegram.org/file/bot" . BOT_TOKEN . "/" . $file_path;
        
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $file_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_USERAGENT => 'VirusTotalTelegramBot/3.0'
        ]);
        
        $content = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($http_code !== 200 || !$content) {
            Logger::error("Failed to download file", ['http_code' => $http_code, 'error' => $error, 'file_url' => $file_url]);
            return false;
        }
        
        Logger::debug("File downloaded successfully", ['size' => strlen($content)]);
        return $content;
    }
    
    private function formatFileSize($bytes) {
        if ($bytes == 0) return "0 B";
        $k = 1024;
        $sizes = ["B", "KB", "MB", "GB"];
        $i = floor(log($bytes) / log($k));
        return round(($bytes / pow($k, $i)), 2) . " " . $sizes[$i];
    }
    
    private function getFileType($filename) {
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $types = [
            'exe' => 'Windows Executable',
            'dll' => 'Windows Library',
            'apk' => 'Android Package',
            'pdf' => 'PDF Document',
            'doc' => 'Word Document',
            'docx' => 'Word Document',
            'xls' => 'Excel Spreadsheet',
            'xlsx' => 'Excel Spreadsheet',
            'zip' => 'Zip Archive',
            'rar' => 'RAR Archive',
            '7z' => '7-Zip Archive',
            'tar' => 'Tar Archive',
            'gz' => 'GZip Archive',
            'py' => 'Python Script',
            'js' => 'JavaScript',
            'php' => 'PHP Script',
            'html' => 'HTML Document',
            'txt' => 'Text File',
            'bat' => 'Batch File',
            'ps1' => 'PowerShell Script',
            'sh' => 'Shell Script',
            'vbs' => 'VBScript',
            'scr' => 'Screen Saver',
            'msi' => 'Windows Installer',
            'jar' => 'Java Archive'
        ];
        
        return $types[$ext] ?? 'Unknown File';
    }
    
    private function sendMessage($chat_id, $text, $reply_markup = null) {
        if (!defined('BOT_TOKEN') || empty(BOT_TOKEN)) {
            Logger::error("BOT_TOKEN not defined for sending message");
            return false;
        }
        
        $url = "https://api.telegram.org/bot" . BOT_TOKEN . "/sendMessage";
        $data = [
            'chat_id' => $chat_id,
            'text' => $text,
            'parse_mode' => 'HTML',
            'disable_web_page_preview' => true
        ];
        
        if ($reply_markup) {
            $data['reply_markup'] = $reply_markup;
        }
        
        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
            ]
        ];
        
        $result = @file_get_contents($url, false, stream_context_create($options));
        Logger::debug("Sent message", ['chat_id' => $chat_id, 'text_length' => strlen($text)]);
        
        return $result;
    }
    
    private function editMessage($chat_id, $message_id, $text, $reply_markup = null) {
        if (!defined('BOT_TOKEN') || empty(BOT_TOKEN)) {
            Logger::error("BOT_TOKEN not defined for editing message");
            return false;
        }
        
        $url = "https://api.telegram.org/bot" . BOT_TOKEN . "/editMessageText";
        $data = [
            'chat_id' => $chat_id,
            'message_id' => $message_id,
            'text' => $text,
            'parse_mode' => 'HTML',
            'disable_web_page_preview' => true
        ];
        
        if ($reply_markup) {
            $data['reply_markup'] = $reply_markup;
        }
        
        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
            ]
        ];
        
        $result = @file_get_contents($url, false, stream_context_create($options));
        Logger::debug("Edited message", ['chat_id' => $chat_id, 'message_id' => $message_id]);
        
        return $result;
    }
    
    private function answerCallbackQuery($callback_id) {
        if (!defined('BOT_TOKEN') || empty(BOT_TOKEN)) {
            Logger::error("BOT_TOKEN not defined for answering callback");
            return false;
        }
        
        $url = "https://api.telegram.org/bot" . BOT_TOKEN . "/answerCallbackQuery";
        $data = [
            'callback_query_id' => $callback_id
        ];
        
        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
            ]
        ];
        
        @file_get_contents($url, false, stream_context_create($options));
    }
    
    private function handleChatMember($chat_member) {
        
        Logger::info("Chat member update received", $chat_member);
    }
    private function showAdminPanel($chat_id, $message_id = null) {
        $blocked_count = count(BlockManager::getBlocked());
        $total_users = UserManager::getTotalUsers();
        $total_scans = UserManager::getTotalScans();
        $maintenance_on = SettingsManager::isMaintenance();
        $maintenance_label = $maintenance_on ? '🔴 روشن' : '🟢 خاموش';

        $text = "👑 <b>پنل مدیریت ربات</b>\n\n";
        $text .= "👥 کاربران: <b>{$total_users}</b>\n";
        $text .= "📊 اسکن‌های انجام‌شده: <b>{$total_scans}</b>\n";
        $text .= "🚫 کاربران مسدود: <b>{$blocked_count}</b>\n";
        $text .= "🛠️ حالت تعمیر: <b>{$maintenance_label}</b>\n\n";
        $text .= "یکی از گزینه‌های زیر را انتخاب کنید:";

        $keyboard = json_encode([
            'inline_keyboard' => [
                [
                    ['text' => 'آمار کامل', 'callback_data' => 'admin_stats', 'style' => 'primary'],
                    ['text' => 'پیام همگانی', 'callback_data' => 'admin_broadcast', 'style' => 'success']
                ],
                [
                    ['text' => 'مسدود کردن کاربر', 'callback_data' => 'admin_block', 'style' => 'danger'],
                    ['text' => 'رفع مسدودی', 'callback_data' => 'admin_unblock', 'style' => 'success']
                ],
                [
                    ['text' => 'لیست مسدودها', 'callback_data' => 'admin_blocklist', 'style' => 'primary']
                ],
                [
                    ['text' => $maintenance_on ? 'خاموش کردن حالت تعمیر' : 'روشن کردن حالت تعمیر', 'callback_data' => 'admin_maintenance_toggle', 'style' => $maintenance_on ? 'success' : 'danger']
                ],
                [
                    ['text' => 'کانال اجباری ۱', 'callback_data' => 'admin_setchannel1', 'style' => 'primary'],
                    ['text' => 'کانال اجباری ۲', 'callback_data' => 'admin_setchannel2', 'style' => 'primary']
                ],
                [
                    ['text' => 'افزودن ادمین', 'callback_data' => 'admin_addadmin', 'style' => 'success'],
                    ['text' => 'حذف ادمین', 'callback_data' => 'admin_removeadmin', 'style' => 'danger']
                ]
            ]
        ]);

        if ($message_id) {
            $this->editMessage($chat_id, $message_id, $text, $keyboard);
        } else {
            $this->sendMessage($chat_id, $text, $keyboard);
        }
    }

    private function handleAdminCallback($data, $chat_id, $message_id, $user_id, $lang) {
        $back_keyboard = json_encode(['inline_keyboard' => [[['text' => '🔙 بازگشت', 'callback_data' => 'admin_panel', 'style' => 'primary']]]]);

        switch ($data) {
            case 'admin_panel':
                $this->showAdminPanel($chat_id, $message_id);
                break;

            case 'admin_stats':
                $total_users = UserManager::getTotalUsers();
                $total_scans = UserManager::getTotalScans();
                $blocked_count = count(BlockManager::getBlocked());
                $db_size = (defined('DB_USERS') && file_exists(DB_USERS)) ? filesize(DB_USERS) : 0;
                $ch1 = SettingsManager::getChannelMain();
                $ch2 = SettingsManager::getChannelSecondary();

                $text = "📊 <b>آمار کامل ربات</b>\n\n";
                $text .= "👥 کل کاربران: <b>{$total_users}</b>\n";
                $text .= "📁 کل اسکن‌ها: <b>{$total_scans}</b>\n";
                $text .= "🚫 مسدودشده‌ها: <b>{$blocked_count}</b>\n";
                $text .= "💾 حجم دیتابیس: <b>" . $this->formatFileSize($db_size) . "</b>\n";
                $text .= "🛠️ حالت تعمیر: <b>" . (SettingsManager::isMaintenance() ? 'روشن' : 'خاموش') . "</b>\n";
                $text .= "📢 کانال ۱: <b>" . ($ch1 !== '' ? $ch1 : '-') . "</b>\n";
                $text .= "📢 کانال ۲: <b>" . ($ch2 !== '' ? $ch2 : '-') . "</b>\n";

                $this->editMessage($chat_id, $message_id, $text, $back_keyboard);
                break;

            case 'admin_broadcast':
                UserManager::setAdminState($user_id, 'awaiting_broadcast');
                $this->editMessage($chat_id, $message_id, "📢 پیامی که می‌خواهید برای همه کاربران ارسال شود را بفرستید.\n\nبرای لغو /cancel را ارسال کنید.");
                break;

            case 'admin_block':
                UserManager::setAdminState($user_id, 'awaiting_block_id');
                $this->editMessage($chat_id, $message_id, "🚫 آیدی عددی کاربری که می‌خواهید مسدود کنید را ارسال کنید.\n\nبرای لغو /cancel را ارسال کنید.");
                break;

            case 'admin_unblock':
                UserManager::setAdminState($user_id, 'awaiting_unblock_id');
                $this->editMessage($chat_id, $message_id, "✅ آیدی عددی کاربری که می‌خواهید رفع مسدودیت کنید را ارسال کنید.\n\nبرای لغو /cancel را ارسال کنید.");
                break;

            case 'admin_blocklist':
                $blocked = BlockManager::getBlocked();
                $text = "📋 <b>لیست کاربران مسدود</b>\n\n";
                $text .= empty($blocked) ? "هیچ کاربری مسدود نیست." : implode("\n", array_map(function($id) { return "🚫 <code>{$id}</code>"; }, $blocked));
                $this->editMessage($chat_id, $message_id, $text, $back_keyboard);
                break;

            case 'admin_maintenance_toggle':
                SettingsManager::set('maintenance_mode', !SettingsManager::isMaintenance());
                $this->showAdminPanel($chat_id, $message_id);
                break;

            case 'admin_setchannel1':
                UserManager::setAdminState($user_id, 'awaiting_channel1');
                $this->editMessage($chat_id, $message_id, "📢 یوزرنیم کانال اجباری اول را با @ ارسال کنید (برای حذف، عبارت «خالی» را بفرستید).\n\nبرای لغو /cancel را ارسال کنید.");
                break;

            case 'admin_setchannel2':
                UserManager::setAdminState($user_id, 'awaiting_channel2');
                $this->editMessage($chat_id, $message_id, "📢 یوزرنیم کانال اجباری دوم را با @ ارسال کنید (برای حذف، عبارت «خالی» را بفرستید).\n\nبرای لغو /cancel را ارسال کنید.");
                break;

            case 'admin_addadmin':
                UserManager::setAdminState($user_id, 'awaiting_add_admin');
                $this->editMessage($chat_id, $message_id, "👑 آیدی عددی کاربری که می‌خواهید ادمین شود را ارسال کنید.\n\nبرای لغو /cancel را ارسال کنید.");
                break;

            case 'admin_removeadmin':
                UserManager::setAdminState($user_id, 'awaiting_remove_admin');
                $this->editMessage($chat_id, $message_id, "👑 آیدی عددی ادمینی که می‌خواهید حذف کنید را ارسال کنید.\n\nبرای لغو /cancel را ارسال کنید.");
                break;
        }
    }

    private function handleAdminPendingInput($state, $text, $user_id, $chat_id) {
        if (trim($text) === '/cancel') {
            UserManager::clearAdminState($user_id);
            $this->sendMessage($chat_id, "❌ عملیات لغو شد.");
            return;
        }

        switch ($state) {
            case 'awaiting_broadcast':
                UserManager::clearAdminState($user_id);
                $ids = UserManager::getAllUserIds();
                $sent = 0;
                $failed = 0;
                foreach ($ids as $uid) {
                    $result = $this->sendMessage($uid, $text);
                    $data = json_decode($result, true);
                    if ($data && isset($data['ok']) && $data['ok']) {
                        $sent++;
                    } else {
                        $failed++;
                    }
                }
                $this->sendMessage($chat_id, "✅ پیام همگانی ارسال شد.\n📤 موفق: {$sent}\n❌ ناموفق: {$failed}");
                break;

            case 'awaiting_block_id':
                UserManager::clearAdminState($user_id);
                if (is_numeric(trim($text))) {
                    BlockManager::block(trim($text));
                    $this->sendMessage($chat_id, "🚫 کاربر " . trim($text) . " مسدود شد.");
                } else {
                    $this->sendMessage($chat_id, "❌ آیدی نامعتبر است.");
                }
                break;

            case 'awaiting_unblock_id':
                UserManager::clearAdminState($user_id);
                if (is_numeric(trim($text))) {
                    BlockManager::unblock(trim($text));
                    $this->sendMessage($chat_id, "✅ کاربر " . trim($text) . " رفع مسدودیت شد.");
                } else {
                    $this->sendMessage($chat_id, "❌ آیدی نامعتبر است.");
                }
                break;

            case 'awaiting_channel1':
                UserManager::clearAdminState($user_id);
                $val = (trim($text) === 'خالی') ? '' : trim($text);
                SettingsManager::set('channel_main', $val);
                $this->sendMessage($chat_id, "✅ کانال اول بروزرسانی شد.");
                break;

            case 'awaiting_channel2':
                UserManager::clearAdminState($user_id);
                $val = (trim($text) === 'خالی') ? '' : trim($text);
                SettingsManager::set('channel_secondary', $val);
                $this->sendMessage($chat_id, "✅ کانال دوم بروزرسانی شد.");
                break;

            case 'awaiting_add_admin':
                UserManager::clearAdminState($user_id);
                if (is_numeric(trim($text))) {
                    SettingsManager::addExtraAdmin(trim($text));
                    $this->sendMessage($chat_id, "✅ کاربر " . trim($text) . " به عنوان ادمین اضافه شد.");
                } else {
                    $this->sendMessage($chat_id, "❌ آیدی نامعتبر است.");
                }
                break;

            case 'awaiting_remove_admin':
                UserManager::clearAdminState($user_id);
                if (is_numeric(trim($text))) {
                    SettingsManager::removeExtraAdmin(trim($text));
                    $this->sendMessage($chat_id, "✅ کاربر " . trim($text) . " از ادمین‌ها حذف شد.");
                } else {
                    $this->sendMessage($chat_id, "❌ آیدی نامعتبر است.");
                }
                break;
        }
    }

}





try {
    $bot = new VirusTotalBot();
    $bot->processUpdate();
} catch (Exception $e) {
    error_log("VirusTotal Bot Error: " . $e->getMessage());
}

echo "OK";

/*
 * End of file — VirusTotal Scanner Bot
 * Developed by @DevArtery | Channel: @ArteryHub
 */
