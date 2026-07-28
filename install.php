<?php
/*
 * VirusTotal Scanner Bot — Installer
 * Developed by @DevArtery
 * Channel: @ArteryHub
 * All rights reserved. No one other than @DevArtery is permitted
 * to modify, resell, or redistribute this file.
 */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {





header('Content-Type: application/json');


$bot_token = $_POST['bot_token'] ?? '';
$vt_api_key = $_POST['vt_api_key'] ?? '';
$channel1 = $_POST['channel1'] ?? '';
$channel2 = $_POST['channel2'] ?? '';
$admin_id = $_POST['admin_id'] ?? '';
$webhook_url = $_POST['webhook_url'] ?? '';
$creator_name = trim($_POST['creator_name'] ?? '');
$creator_channel = trim($_POST['creator_channel'] ?? '');


$default_api_key = '92e97911ec44c86d799490be6a05966f11dcb39af904784d47db591861391167';


if (empty($vt_api_key) || $vt_api_key === $default_api_key) {
    $vt_api_key = $default_api_key;
}


$errors = [];

if (empty($bot_token)) {
    $errors[] = 'Bot token is required';
} elseif (!preg_match('/^\d+:[A-Za-z0-9_-]+$/', $bot_token)) {
    $errors[] = 'Invalid bot token format';
}

if (empty($vt_api_key) || !preg_match('/^[a-f0-9]{64}$/i', $vt_api_key)) {
    $errors[] = 'Invalid VirusTotal API key format (must be 64 hex characters)';
}

if (empty($channel1)) {
    $errors[] = 'Channel 1 is required';
} elseif (!preg_match('/^@[A-Za-z0-9_]+$/', $channel1)) {
    $errors[] = 'Channel 1 must start with @ and contain only letters, numbers and underscores';
}

if (!empty($channel2) && !preg_match('/^@[A-Za-z0-9_]+$/', $channel2)) {
    $errors[] = 'Channel 2 must start with @ and contain only letters, numbers and underscores';
}

if (empty($admin_id) || !is_numeric($admin_id)) {
    $errors[] = 'Valid admin ID is required';
}

if (!empty($errors)) {
    echo json_encode(['success' => false, 'message' => implode(', ', $errors)]);
    exit;
}

try {
    
    if (file_exists('config.php')) {
        echo json_encode(['success' => false, 'message' => 'Bot is already installed. Delete config.php to reinstall.']);
        exit;
    }
    
    
    $bot_info_url = "https://api.telegram.org/bot{$bot_token}/getMe";
    
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $bot_info_url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_USERAGENT => 'VirusTotalBotInstaller/2.0'
    ]);
    
    $bot_info_response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if (!$bot_info_response) {
        echo json_encode(['success' => false, 'message' => 'Cannot connect to Telegram API']);
        exit;
    }
    
    $bot_info = json_decode($bot_info_response, true);
    
    if (!$bot_info || !$bot_info['ok']) {
        $error_msg = $bot_info['description'] ?? 'Invalid bot token';
        echo json_encode(['success' => false, 'message' => 'Telegram API error: ' . $error_msg]);
        exit;
    }
    
    $bot_username = $bot_info['result']['username'];
    $bot_name = $bot_info['result']['first_name'];
    
    
    $vt_test_url = 'https://www.virustotal.com/api/v3/users/' . urlencode($vt_api_key);
    
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $vt_test_url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            'x-apikey: ' . $vt_api_key,
            'Accept: application/json'
        ],
        CURLOPT_TIMEOUT => 10,
        CURLOPT_SSL_VERIFYPEER => true
    ]);
    
    $vt_test_response = curl_exec($ch);
    $vt_http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    $vt_test_data = json_decode($vt_test_response, true);
    
    
    $webhook_secret = bin2hex(random_bytes(16));

    $config_content = '<?php
/*
 * VirusTotal Scanner Bot — Config
 * Developed by @DevArtery | Channel: @ArteryHub
 * All rights reserved. No one other than @DevArtery is permitted
 * to modify, resell, or redistribute this file.
 */

if (basename(__FILE__) == basename($_SERVER[\'PHP_SELF\'])) {
    header(\'HTTP/1.0 403 Forbidden\');
    die(\'Access forbidden\');
}

define(\'BOT_TOKEN\', \'' . addslashes($bot_token) . '\');
define(\'BOT_USERNAME\', \'@' . addslashes($bot_username) . '\');

define(\'VT_API_KEY\', \'' . addslashes($vt_api_key) . '\');

define(\'CHANNEL_MAIN\', \'' . addslashes($channel1) . '\');
define(\'CHANNEL_SECONDARY\', \'' . addslashes($channel2) . '\');

define(\'ADMIN_IDS\', [' . intval($admin_id) . ']);

define(\'WEBHOOK_SECRET\', \'' . addslashes($webhook_secret) . '\');

define(\'CREATOR_NAME\', \'' . addslashes($creator_name) . '\');
define(\'CREATOR_CHANNEL\', \'' . addslashes($creator_channel) . '\');

define(\'MAX_FILE_SIZE\', 320 * 1024 * 1024);
define(\'ALLOWED_EXTENSIONS\', [\'exe\', \'dll\', \'apk\', \'jar\', \'pdf\', \'doc\', \'docx\', \'xls\', \'xlsx\', \'ppt\', \'pptx\', \'zip\', \'rar\', \'7z\', \'tar\', \'gz\', \'bz2\', \'py\', \'js\', \'php\', \'html\', \'htm\', \'txt\', \'bat\', \'ps1\', \'sh\', \'vbs\', \'scr\', \'msi\', \'app\', \'dmg\', \'pkg\', \'deb\', \'rpm\', \'bin\', \'iso\', \'img\', \'vhd\', \'vdi\', \'ova\', \'ovf\']);
define(\'LOG_ENABLED\', true);
define(\'DEBUG_MODE\', true);

define(\'DB_USERS\', \'data/users.json\');
define(\'DB_STATS\', \'data/stats.json\');
define(\'DB_BLOCKED\', \'data/blocked.json\');
define(\'LOG_FILE\', \'logs/bot.log\');

define(\'BLOCK_SUSPICIOUS_IPS\', true);
define(\'MAX_IP_REQUESTS_PER_HOUR\', 100);

if (!file_exists(\'data\')) mkdir(\'data\', 0755, true);
if (!file_exists(\'logs\')) mkdir(\'logs\', 0755, true);
if (!file_exists(\'cache\')) mkdir(\'cache\', 0755, true);
if (!file_exists(\'backups\')) mkdir(\'backups\', 0755, true);

if (!file_exists(DB_USERS)) file_put_contents(DB_USERS, \'{}\');
if (!file_exists(DB_STATS)) file_put_contents(DB_STATS, \'{"total_scans": 0, "new_users": 0, "daily_scans": {}}\');
if (!file_exists(DB_BLOCKED)) file_put_contents(DB_BLOCKED, \'{"users": [], "ips": []}\');
if (!file_exists(LOG_FILE)) file_put_contents(LOG_FILE, \'\');

$directories = [\'data\', \'logs\', \'cache\', \'backups\'];
foreach ($directories as $dir) {
    $index_file = $dir . \'/index.php\';
    if (!file_exists($index_file)) {
        file_put_contents($index_file, \'<?php header("HTTP/1.0 403 Forbidden"); die("Access forbidden"); ?>\');
    }
}
/*
 * End of file — VirusTotal Scanner Bot Config
 * Developed by @DevArtery | Channel: @ArteryHub
 */
?>';

    
    if (file_put_contents('config.php', $config_content) === false) {
        echo json_encode(['success' => false, 'message' => 'Failed to write config.php. Check directory permissions.']);
        exit;
    }
    
    
    $dirs = ['data', 'logs', 'cache', 'backups'];
    foreach ($dirs as $dir) {
        if (!file_exists($dir)) {
            @mkdir($dir, 0755, true);
        }
        
        @file_put_contents($dir . '/index.php', '<?php header("HTTP/1.0 403 Forbidden"); die("Access forbidden"); ?>');
    }
    
    
    $webhook_set = false;
    $webhook_message = '';

    $set_webhook_url = "https://api.telegram.org/bot{$bot_token}/setWebhook";

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $set_webhook_url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => [
            'url' => $webhook_url,
            'max_connections' => 40,
            'secret_token' => $webhook_secret,
            'allowed_updates' => json_encode(['message', 'callback_query', 'chat_member'])
        ],
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_USERAGENT => 'VirusTotalBotWebhook/1.0'
    ]);

    $webhook_result = curl_exec($ch);
    $webhook_http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    $webhook_data = json_decode($webhook_result, true);
    
    if ($webhook_data && $webhook_data['ok']) {
        $webhook_set = true;
        $webhook_message = 'Webhook successfully configured';
    } else {
        $webhook_message = $webhook_data['description'] ?? 'Webhook setup failed';
    }
    
    
    $bot_commands = [
        ['command' => 'start', 'description' => 'Start the bot'],
        ['command' => 'profile', 'description' => 'View your scan profile and stats'],
        ['command' => 'language', 'description' => 'Change the bot language'],
        ['command' => 'help', 'description' => 'Show the help guide'],
    ];

    $set_commands_url = "https://api.telegram.org/bot{$bot_token}/setMyCommands";

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $set_commands_url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => [
            'commands' => json_encode($bot_commands)
        ],
        CURLOPT_TIMEOUT => 15,
        CURLOPT_SSL_VERIFYPEER => true
    ]);
    curl_exec($ch);
    curl_close($ch);

    $check_webhook_url = "https://api.telegram.org/bot{$bot_token}/getWebhookInfo";
    $check_result = @file_get_contents($check_webhook_url);
    $check_data = json_decode($check_result, true);
    
    $webhook_status = 'Unknown';
    if ($check_data && $check_data['ok']) {
        $webhook_status = $check_data['result']['url'] ? 'Active' : 'Inactive';
    }
    
    
    $info_content = "╔══════════════════════════════════════╗\n";
    $info_content .= "║       VIRUSTOTAL BOT INSTALLATION      ║\n";
    $info_content .= "╠══════════════════════════════════════╣\n";
    $info_content .= "║ Bot: @{$bot_username} ({$bot_name})\n";
    $info_content .= "║ Installation: " . date('Y-m-d H:i:s') . "\n";
    $info_content .= "║ Admin: {$admin_id}\n";
    $info_content .= "║ Channel 1: {$channel1}\n";
    if (!empty($channel2)) {
        $info_content .= "║ Channel 2: {$channel2}\n";
    }
    $info_content .= "║ Webhook URL: {$webhook_url}\n";
    $info_content .= "║ Webhook Status: " . ($webhook_set ? '✅ SET' : '❌ NOT SET') . "\n";
    $info_content .= "║ API Key: " . (strlen($vt_api_key) > 20 ? substr($vt_api_key, 0, 20) . '...' : $vt_api_key) . "\n";
    $info_content .= "╚══════════════════════════════════════╝\n\n";
    $info_content .= "=== IMPORTANT ===\n";
    $info_content .= "1. Make bot admin in your channels\n";
    $info_content .= "2. Test your bot: https://t.me/{$bot_username}\n";
    if (!$webhook_set) {
        $info_content .= "3. Set webhook manually:\n";
        $info_content .= "   https://api.telegram.org/bot{$bot_token}/setWebhook?url=" . urlencode($webhook_url) . "&secret_token=" . urlencode($webhook_secret) . "\n";
    }
    $info_content .= "4. Delete install.php for security\n";
    
    @file_put_contents('installation_info.txt', $info_content);
    
    
    $response = [
        'success' => true,
        'message' => 'Installation completed successfully',
        'bot_username' => $bot_username,
        'bot_name' => $bot_name,
        'webhook_set' => $webhook_set,
        'webhook_message' => $webhook_message,
        'webhook_status' => $webhook_status,
        'api_key_type' => ($vt_api_key === $default_api_key) ? 'default' : 'custom',
        'bot_url' => "https://t.me/{$bot_username}",
        'creator_name' => $creator_name,
        'creator_channel' => $creator_channel,
        'manual_webhook_url' => "https://api.telegram.org/bot{$bot_token}/setWebhook?url=" . urlencode($webhook_url) . "&secret_token=" . urlencode($webhook_secret),
        'test_commands' => [
            '/start' => "Test bot start",
            '/help' => "Get help guide",
            '/language' => "Change language"
        ]
    ];
    
    echo json_encode($response);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Installation error: ' . $e->getMessage()]);
}

    exit;
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نصب ربات VirusTotal | Installation</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        :root {
            --primary: #6366f1;
            --secondary: #8b5cf6;
            --accent: #06b6d4;
            --gold: #f59e0b;
            --danger: #ef4444;
            --success: #10b981;
            --text-primary: #f1f5f9;
            --text-secondary: #cbd5e1;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Vazirmatn', sans-serif;
            background: #0a0a1a;
            min-height: 100vh;
            padding: 2rem;
            position: relative;
            overflow-x: hidden;
            transition: all 0.3s ease;
        }

        body.ltr {
            direction: ltr;
        }

        .animated-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            overflow: hidden;
        }

        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(120px);
            opacity: 0.35;
            animation: float 20s infinite ease-in-out;
        }

        .orb-1 {
            width: 700px;
            height: 700px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            top: -250px;
            right: -150px;
            animation-delay: 0s;
        }

        .orb-2 {
            width: 600px;
            height: 600px;
            background: linear-gradient(135deg, #06b6d4, #10b981);
            bottom: -200px;
            left: -150px;
            animation-delay: -8s;
        }

        .orb-3 {
            width: 500px;
            height: 500px;
            background: linear-gradient(135deg, #f59e0b, #ef4444);
            top: 45%;
            left: 45%;
            transform: translate(-50%, -50%);
            animation-delay: -15s;
            opacity: 0.25;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(60px, -60px) scale(1.1); }
            50% { transform: translate(-40px, 40px) scale(0.9); }
            75% { transform: translate(-60px, -40px) scale(1.05); }
        }

        .grid-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px);
            background-size: 60px 60px;
            z-index: 1;
            pointer-events: none;
        }

        .main-container {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 900px;
            margin: 0 auto;
        }

        .lang-switcher-wrapper {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 1.5rem;
        }

        body.ltr .lang-switcher-wrapper {
            justify-content: flex-start;
        }

        .lang-switch-btn {
            background: rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            padding: 0.7rem 1.5rem;
            border-radius: 2.5rem;
            cursor: pointer;
            font-family: 'Vazirmatn', sans-serif;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            min-width: 130px;
            justify-content: center;
        }

        .lang-switch-btn:hover {
            background: rgba(255, 255, 255, 0.12);
            border-color: rgba(255, 255, 255, 0.4);
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(35px);
            -webkit-backdrop-filter: blur(35px);
            border-radius: 3rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 
                0 25px 70px rgba(0, 0, 0, 0.6),
                inset 0 1px 0 rgba(255, 255, 255, 0.08),
                0 0 50px rgba(99, 102, 241, 0.08);
            padding: 3rem 2.8rem;
            position: relative;
            overflow: hidden;
        }

        .glass-panel::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at 25% 20%, rgba(99,102,241,0.08), transparent 50%),
                        radial-gradient(circle at 75% 80%, rgba(6,182,212,0.08), transparent 50%);
            animation: shimmer 12s infinite linear;
            pointer-events: none;
        }

        @keyframes shimmer {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .header {
            position: relative;
            z-index: 2;
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .version-badge {
            display: inline-block;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            padding: 0.5rem 2rem;
            border-radius: 2rem;
            font-weight: 700;
            font-size: 0.95rem;
            color: white;
            margin-bottom: 1rem;
            box-shadow: 0 8px 25px rgba(99,102,241,0.3);
        }

        .main-title {
            font-size: 2.5rem;
            font-weight: 900;
            background: linear-gradient(135deg, #6366f1, #06b6d4, #10b981);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.8rem;
            line-height: 1.4;
        }

        .subtitle {
            color: var(--text-secondary);
            font-size: 1.1rem;
            font-weight: 400;
        }

        .section {
            position: relative;
            z-index: 2;
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-radius: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.08);
            padding: 2rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }

        .section:hover {
            background: rgba(255, 255, 255, 0.06);
            border-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.4);
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .step-number {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 900;
            color: white;
            box-shadow: 0 8px 20px rgba(99,102,241,0.3);
            flex-shrink: 0;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
        }

        .info-box {
            background: rgba(99,102,241,0.1);
            border: 1px solid rgba(99,102,241,0.3);
            border-radius: 1rem;
            padding: 1.2rem;
            margin: 1rem 0;
            backdrop-filter: blur(10px);
        }

        .info-box.warning {
            background: rgba(245,158,11,0.1);
            border-color: rgba(245,158,11,0.4);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: white;
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 1rem;
        }

        .form-label .required {
            color: #ef4444;
        }

        .form-label .optional {
            color: #94a3b8;
            font-weight: 400;
            font-size: 0.85rem;
        }

        .form-input {
            width: 100%;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 1rem;
            padding: 0.9rem 1.2rem;
            color: white;
            font-family: 'Vazirmatn', sans-serif;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-input:focus {
            border-color: #6366f1;
            box-shadow: 0 0 20px rgba(99,102,241,0.2);
            background: rgba(0, 0, 0, 0.6);
        }

        .form-input::placeholder {
            color: rgba(255,255,255,0.3);
        }

        .help-text {
            font-size: 0.85rem;
            color: #94a3b8;
            margin-top: 0.3rem;
        }

        .submit-btn {
            width: 100%;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            padding: 1rem;
            border-radius: 2rem;
            font-weight: 700;
            font-size: 1.1rem;
            cursor: pointer;
            border: none;
            font-family: 'Vazirmatn', sans-serif;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(99,102,241,0.3);
            margin-top: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(99,102,241,0.5);
        }

        .submit-btn:active {
            transform: scale(0.98);
        }

        .submit-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .btn-group {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            margin-top: 1.5rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.9rem 2rem;
            border-radius: 2.5rem;
            font-weight: 600;
            font-size: 1rem;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-family: 'Vazirmatn', sans-serif;
            backdrop-filter: blur(10px);
        }

        .btn-primary {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            box-shadow: 0 8px 25px rgba(99,102,241,0.3);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(99,102,241,0.5);
        }

        .btn-telegram {
            background: linear-gradient(135deg, #0088cc, #0099ff);
            color: white;
            box-shadow: 0 8px 25px rgba(0,136,204,0.3);
        }

        .btn-telegram:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(0,136,204,0.5);
        }

        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.7);
            backdrop-filter: blur(10px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal {
            background: rgba(20, 20, 40, 0.95);
            backdrop-filter: blur(30px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 2rem;
            padding: 2.5rem;
            max-width: 500px;
            width: 90%;
            text-align: center;
            box-shadow: 0 30px 60px rgba(0,0,0,0.8);
        }

        .modal-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }

        .modal-icon.success {
            color: #10b981;
        }

        .modal h3 {
            color: white;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .modal p {
            color: #cbd5e1;
            margin-bottom: 0.8rem;
            line-height: 1.8;
        }

        .modal code {
            background: rgba(0,0,0,0.5);
            padding: 0.2rem 0.6rem;
            border-radius: 0.4rem;
            color: #ef4444;
            font-family: 'Courier New', monospace;
        }

        .modal .btn {
            margin-top: 1.5rem;
        }

        .lang-content {
            display: none;
        }

        .lang-content.active {
            display: block;
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }
            
            .glass-panel {
                padding: 2rem 1.2rem;
                border-radius: 2rem;
            }
            
            .main-title {
                font-size: 1.8rem;
            }
            
            .section {
                padding: 1.5rem;
            }
            
            .btn-group {
                flex-direction: column;
            }
            
            .btn {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="animated-bg">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
    </div>
    <div class="grid-overlay"></div>

    <!-- مودال موفقیت -->
    <div class="modal-overlay" id="successModal">
        <div class="modal">
            <div class="modal-icon success">✅</div>
            <h3 data-fa="🎉 نصب با موفقیت انجام شد!" data-en="🎉 Installation Successful!">🎉 نصب با موفقیت انجام شد!</h3>
            <p id="modalBotLine" style="color:#cbd5e1;"></p>
            <p id="modalWebhookLine" style="color:#cbd5e1;"></p>
            <div style="background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.3); border-radius: 1rem; padding: 1rem; margin: 1rem 0;">
                <p style="color: #fca5a5; margin: 0;" data-fa='⚠️ حتماً فایل <code>install.php</code> را از هاست خود حذف کنید!' data-en='⚠️ Make sure to delete <code>install.php</code> from your hosting!'>⚠️ حتماً فایل <code>install.php</code> را از هاست خود حذف کنید!</p>
            </div>
            <div class="btn-group" style="justify-content: center;">
                <a href="#" id="modalBotLink" class="btn btn-telegram" target="_blank">
                    <i class="fab fa-telegram-plane"></i>
                    <span data-fa="ورود به ربات" data-en="Enter the Bot">ورود به ربات</span>
                </a>
                <button class="btn btn-primary" onclick="closeModal()">
                    <i class="fas fa-check"></i>
                    <span data-fa="متوجه شدم" data-en="Got it">متوجه شدم</span>
                </button>
            </div>
        </div>
    </div>

    <div class="main-container">
        <!-- دکمه تغییر زبان -->
        <div class="lang-switcher-wrapper">
            <button class="lang-switch-btn" onclick="toggleLang()" id="langToggleBtn">
                <span class="flag-icon">🇮🇷</span>
                <span class="lang-text">English</span>
                <span class="switch-arrow">⇄</span>
            </button>
        </div>

        <div class="glass-panel">
            
            <div class="header">
                <div class="version-badge">⚡ v3.0 Professional</div>
                
                <div class="lang-content active" id="fa-content">
                    <h1 class="main-title">🚀 نصب ربات VirusTotal</h1>
                    <p class="subtitle">فرم نصب و پیکربندی ربات تلگرام بر روی هاست cPanel</p>
                </div>
                
                <div class="lang-content" id="en-content">
                    <h1 class="main-title">🚀 VirusTotal Bot Installation</h1>
                    <p class="subtitle">Installation and configuration form for Telegram bot on cPanel hosting</p>
                </div>
            </div>

            <!-- مرحله 1: ساخت ربات -->
            <div class="section">
                <div class="section-header">
                    <div class="step-number">1</div>
                    <h2 class="section-title" data-fa="🤖 ایجاد ربات تلگرام" data-en="🤖 Create Telegram Bot">🤖 ایجاد ربات تلگرام</h2>
                </div>
                
                <div class="lang-content active" id="fa-step1">
                    <p style="color: #cbd5e1; margin-bottom: 1rem;"><strong>@BotFather</strong> را باز کنید و ربات جدید بسازید:</p>
                    <ol style="color: #94a3b8; padding-right: 1.5rem; line-height: 2.2; margin: 1rem 0;">
                        <li>دستور <code>/newbot</code> را ارسال کنید</li>
                        <li>یک نام برای ربات خود انتخاب کنید</li>
                        <li>نام کاربری با پسوند <code>bot</code> انتخاب کنید</li>
                        <li>توکن API داده شده را کپی کنید</li>
                    </ol>
                </div>
                
                <div class="lang-content" id="en-step1">
                    <p style="color: #cbd5e1; margin-bottom: 1rem;">Open <strong>@BotFather</strong> and create a new bot:</p>
                    <ol style="color: #94a3b8; padding-left: 1.5rem; line-height: 2.2; margin: 1rem 0;">
                        <li>Send the <code>/newbot</code> command</li>
                        <li>Choose a name for your bot</li>
                        <li>Choose a username ending with <code>bot</code></li>
                        <li>Copy the provided API token</li>
                    </ol>
                </div>
            </div>

            <!-- مرحله 2: کلید API -->
            <div class="section">
                <div class="section-header">
                    <div class="step-number">2</div>
                    <h2 class="section-title" data-fa="🛡️ دریافت کلید API ویروس توتال" data-en="🛡️ Get VirusTotal API Key">🛡️ دریافت کلید API ویروس توتال</h2>
                </div>
                
                <div class="lang-content active" id="fa-step2">
                    <p style="color: #cbd5e1; margin-bottom: 1rem;">به <strong>VirusTotal</strong> مراجعه کنید تا کلید API دریافت کنید:</p>
                    
                    <div class="info-box warning">
                        <i class="fas fa-exclamation-triangle" style="color: #f59e0b; margin-left: 0.5rem;"></i>
                        <strong style="color: #fbbf24;">📢 توجه مهم:</strong>
                        <p style="color: #fcd34d; margin-top: 0.3rem; font-size: 0.9rem;">ربات با یک کلید API از پیش پیکربندی شده ارائه می‌شود که باید بلافاصله کار کند. در صورت نیاز می‌توانید از کلید خود برای محدودیت بهتر استفاده کنید.</p>
                    </div>
                </div>
                
                <div class="lang-content" id="en-step2">
                    <p style="color: #cbd5e1; margin-bottom: 1rem;">Visit <strong>VirusTotal</strong> to get an API key:</p>
                    
                    <div class="info-box warning">
                        <i class="fas fa-exclamation-triangle" style="color: #f59e0b; margin-right: 0.5rem;"></i>
                        <strong style="color: #fbbf24;">📢 Important Notice:</strong>
                        <p style="color: #fcd34d; margin-top: 0.3rem; font-size: 0.9rem;">The bot comes with a pre-configured API key that should work immediately. You can use your own key for better limits if needed.</p>
                    </div>
                </div>
            </div>

            <!-- فرم نصب -->
            <div class="section">
                <div class="section-header">
                    <div class="step-number">3</div>
                    <h2 class="section-title" data-fa="⚙️ اطلاعات پیکربندی" data-en="⚙️ Configuration Details">⚙️ اطلاعات پیکربندی</h2>
                </div>
                
                <form onsubmit="handleSubmit(event)" id="installForm">
                    <div id="errorBanner" style="display:none; background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.4); border-radius: 1rem; padding: 1rem; margin-bottom: 1rem; color: #fca5a5;"></div>
                    <!-- توکن ربات -->
                    <div class="form-group">
                        <label class="form-label">
                            🤖 <span data-fa="توکن ربات" data-en="Bot Token">توکن ربات</span> <span class="required">*</span>
                        </label>
                        <input type="text" class="form-input" placeholder="1234567890:ABCdefGHIjklMNOpqrsTUVwxyz" dir="ltr" id="botToken" required>
                        <div class="help-text" data-fa="توکن ربات خود را از BotFather وارد کنید" data-en="Enter your bot token from BotFather">توکن ربات خود را از BotFather وارد کنید</div>
                    </div>

                    <!-- کلید API -->
                    <div class="form-group">
                        <label class="form-label">
                            🛡️ <span data-fa="کلید API ویروس توتال" data-en="VirusTotal API Key">کلید API ویروس توتال</span> <span class="optional">(اختیاری)</span>
                        </label>
                        <input type="text" class="form-input" value="92e97911ec44c86d799490be6a05966f11dcb39af904784d47db591861391167" dir="ltr" id="apiKey">
                        <div class="help-text" data-fa="استفاده از کلید API پیش‌فرض برای تست توصیه می‌شود" data-en="Using the default API key for testing is recommended">استفاده از کلید API پیش‌فرض برای تست توصیه می‌شود</div>
                    </div>

                    <!-- کانال اجباری ۱ -->
                    <div class="form-group">
                        <label class="form-label">
                            📢 <span data-fa="کانال اجباری ۱" data-en="Required Channel 1">کانال اجباری ۱</span> <span class="required">*</span>
                        </label>
                        <input type="text" class="form-input" placeholder="@your_main_channel" dir="ltr" id="channel1" required>
                    </div>

                    <!-- کانال اجباری ۲ -->
                    <div class="form-group">
                        <label class="form-label">
                            📢 <span data-fa="کانال اجباری ۲" data-en="Required Channel 2">کانال اجباری ۲</span> <span class="optional">(اختیاری)</span>
                        </label>
                        <input type="text" class="form-input" placeholder="@your_backup_channel" dir="ltr" id="channel2">
                    </div>

                    <!-- شناسه ادمین -->
                    <div class="form-group">
                        <label class="form-label">
                            👑 <span data-fa="شناسه کاربری ادمین" data-en="Admin User ID">شناسه کاربری ادمین</span> <span class="required">*</span>
                        </label>
                        <input type="text" class="form-input" placeholder="123456789" dir="ltr" id="adminId" required>
                        <div class="help-text" data-fa='شناسه خود را از @userinfobot دریافت کنید' data-en='Get your ID from @userinfobot'>شناسه خود را از @userinfobot دریافت کنید</div>
                    </div>

                    <!-- نام سازنده -->
                    <div class="form-group">
                        <label class="form-label">
                            🛠️ <span data-fa="نام سازنده" data-en="Developer Name">نام سازنده</span> <span class="optional">(اختیاری)</span>
                        </label>
                        <input type="text" class="form-input" placeholder="نام یا برند شما" dir="auto" id="devName">
                        <div class="help-text" data-fa="در پایین هر گزارش اسکن نمایش داده می‌شود" data-en="Displayed at the bottom of each scan report">در پایین هر گزارش اسکن نمایش داده می‌شود</div>
                    </div>

                    <!-- کانال سازنده -->
                    <div class="form-group">
                        <label class="form-label">
                            📢 <span data-fa="کانال سازنده" data-en="Developer Channel">کانال سازنده</span> <span class="optional">(اختیاری)</span>
                        </label>
                        <input type="text" class="form-input" placeholder="@your_channel" dir="ltr" id="devChannel">
                    </div>

                    <!-- دکمه نصب -->
                    <button type="submit" class="submit-btn" id="submitBtn">
                        🚀 <span data-fa="نصب ربات" data-en="Install Bot">نصب ربات</span>
                    </button>
                </form>
            </div>

            <!-- دکمه‌های کانال و ارتباط -->
            <div style="text-align: center; margin: 2rem 0 1rem; position: relative; z-index: 2;">
                <h3 style="color: white; font-size: 1.4rem; margin-bottom: 1.5rem;" data-fa="📢 کانال و ارتباط با سازنده" data-en="📢 Channel & Contact Developer">📢 کانال و ارتباط با سازنده</h3>
                <div class="btn-group" style="justify-content: center;">
                    <a href="https://t.me/ArteryHub" class="btn btn-telegram" target="_blank">
                        <i class="fab fa-telegram-plane"></i>
                        <span data-fa="کانال تلگرام سازنده" data-en="Developer's Telegram Channel">کانال تلگرام سازنده</span>
                    </a>
                    <a href="https://t.me/DevArtery" class="btn btn-primary" target="_blank">
                        <i class="fas fa-user-tie"></i>
                        <span data-fa="ارتباط با سازنده" data-en="Contact Developer">ارتباط با سازنده</span>
                    </a>
                </div>
            </div>

        </div>
    </div>

    <script>
        let currentLang = 'fa';

        function toggleLang() {
            if (currentLang === 'fa') {
                switchLang('en');
            } else {
                switchLang('fa');
            }
        }

        function updateToggleButton(lang) {
            const flagIcon = document.querySelector('#langToggleBtn .flag-icon');
            const langText = document.querySelector('#langToggleBtn .lang-text');
            
            if (lang === 'fa') {
                flagIcon.textContent = '🇮🇷';
                langText.textContent = 'English';
            } else {
                flagIcon.textContent = '🇺🇸';
                langText.textContent = 'فارسی';
            }
        }

        function switchLang(lang) {
            currentLang = lang;
            
            if (lang === 'en') {
                document.body.classList.add('ltr');
                document.documentElement.dir = 'ltr';
            } else {
                document.body.classList.remove('ltr');
                document.documentElement.dir = 'rtl';
            }
            
            updateToggleButton(lang);
            
            document.querySelectorAll('.lang-content').forEach(el => {
                el.classList.remove('active');
            });
            
            if (lang === 'fa') {
                const faContents = document.querySelectorAll('[id^="fa-"]');
                faContents.forEach(el => el.classList.add('active'));
                
                document.querySelectorAll('.section-title').forEach(el => {
                    if (el.getAttribute('data-fa')) {
                        el.innerHTML = el.getAttribute('data-fa');
                    }
                });
                
                document.querySelectorAll('[data-fa]').forEach(el => {
                    if (el.getAttribute('data-fa') && !el.closest('.section-title')) {
                        el.innerHTML = el.getAttribute('data-fa');
                    }
                });
                
            } else {
                const enContents = document.querySelectorAll('[id^="en-"]');
                enContents.forEach(el => el.classList.add('active'));
                
                document.querySelectorAll('.section-title').forEach(el => {
                    if (el.getAttribute('data-en')) {
                        el.innerHTML = el.getAttribute('data-en');
                    }
                });
                
                document.querySelectorAll('[data-en]').forEach(el => {
                    if (el.getAttribute('data-en') && !el.closest('.section-title')) {
                        el.innerHTML = el.getAttribute('data-en');
                    }
                });
            }
        }

        function generateWebhookUrl() {
            const protocol = window.location.protocol;
            const host = window.location.host;
            const path = window.location.pathname.split('/').slice(0, -1).join('/');
            return `${protocol}//${host}${path}/index.php`;
        }

        async function handleSubmit(event) {
            event.preventDefault();

            const errorBanner = document.getElementById('errorBanner');
            errorBanner.style.display = 'none';
            errorBanner.textContent = '';

            const submitBtn = document.getElementById('submitBtn');
            const originalHTML = submitBtn.innerHTML;
            submitBtn.innerHTML = currentLang === 'fa' ? '⏳ در حال نصب...' : '⏳ Installing...';
            submitBtn.disabled = true;

            const formData = new URLSearchParams({
                bot_token: document.getElementById('botToken').value.trim(),
                vt_api_key: document.getElementById('apiKey').value.trim(),
                channel1: document.getElementById('channel1').value.trim(),
                channel2: document.getElementById('channel2').value.trim(),
                admin_id: document.getElementById('adminId').value.trim(),
                webhook_url: generateWebhookUrl(),
                creator_name: document.getElementById('devName').value.trim(),
                creator_channel: document.getElementById('devChannel').value.trim()
            });

            try {
                const response = await fetch('', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: formData
                });
                const result = await response.json();

                submitBtn.innerHTML = originalHTML;
                submitBtn.disabled = false;

                if (!result.success) {
                    errorBanner.textContent = result.message || (currentLang === 'fa' ? 'خطایی رخ داد.' : 'An error occurred.');
                    errorBanner.style.display = 'block';
                    return;
                }

                document.getElementById('modalBotLine').textContent = (currentLang === 'fa' ? '🎉 ربات ایجاد شد: ' : '🎉 Bot created: ') + '@' + result.bot_username;
                document.getElementById('modalWebhookLine').textContent = result.webhook_set
                    ? (currentLang === 'fa' ? '✅ وب‌هوک با موفقیت تنظیم شد.' : '✅ Webhook was set successfully.')
                    : (currentLang === 'fa' ? '⚠️ نیاز به تنظیم دستی وب‌هوک است.' : '⚠️ Manual webhook setup required.');
                document.getElementById('modalBotLink').href = result.bot_url || ('https://t.me/' + result.bot_username);

                document.getElementById('successModal').classList.add('active');
            } catch (err) {
                submitBtn.innerHTML = originalHTML;
                submitBtn.disabled = false;
                errorBanner.textContent = currentLang === 'fa' ? 'اتصال به سرور برقرار نشد.' : 'Could not connect to the server.';
                errorBanner.style.display = 'block';
            }
        }

        function closeModal() {
            document.getElementById('successModal').classList.remove('active');
        }

        document.getElementById('successModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            switchLang('fa');
        });
    </script>
</body>
</html>
<!-- VirusTotal Scanner Bot | Developed by @DevArtery | Channel: @ArteryHub | All rights reserved. -->
