<div align="center">

# 🛡️ VirusTotal Scanner Bot

**A production-ready Telegram bot that scans any file against 70+ antivirus engines using the VirusTotal API.**

[![PHP](https://img.shields.io/badge/PHP-8.0%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/)
[![Telegram](https://img.shields.io/badge/Telegram-Bot%20API-26A5E4?style=for-the-badge&logo=telegram&logoColor=white)](https://core.telegram.org/bots/api)
[![VirusTotal](https://img.shields.io/badge/VirusTotal-API%20v3-394EFF?style=for-the-badge)](https://www.virustotal.com/)
[![License](https://img.shields.io/badge/License-Proprietary-red?style=for-the-badge)](#-license)

[Features](#-features) • [Installation](#-installation) • [Configuration](#-configuration) • [Commands](#-commands) • [Screenshots](#-screenshots) • [License](#-license)

</div>

---

## ✨ Features

- 🔍 **Real VirusTotal Analysis** — scans files with 70+ antivirus engines, no mock data
- 📁 **Up to 320MB per file** — supports EXE, DLL, APK, PDF, DOC, ZIP, and dozens more formats
- 🌐 **14 Languages** — English, Persian, Russian, Ukrainian, German, Spanish, French, Italian, Portuguese, Indonesian, Turkish, Vietnamese, Arabic, Chinese
- 👥 **Group Scanning** — add the bot to any group and scan files collaboratively
- 🔐 **Mandatory Channel Join** — gate bot access behind one or two required channels
- 👤 **User Profiles** — per-user scan history and stats
- 👑 **Admin Panel** — manage channels, view stats, and moderate users from inside Telegram
- 🎨 **Color-coded Buttons** — clear green/blue/red visual cues throughout the UI
- ⚙️ **One-click Web Installer** — no manual config editing required
- 🤖 **Auto Command Registration** — `/start`, `/profile`, `/language`, `/help` are registered with Telegram automatically on install

---

## 🚀 Installation

1. Upload all project files to your PHP-enabled hosting (PHP 8.0+, cURL enabled).
2. Open `install.php` in your browser.
3. Create a bot with [@BotFather](https://t.me/BotFather) and copy its token.
4. (Optional) Get your own [VirusTotal API key](https://www.virustotal.com/gui/my-apikey) — a default key is pre-configured if you skip this.
5. Fill in the installer form:
   - Bot Token
   - VirusTotal API Key *(optional)*
   - Required Channel(s)
   - Your Telegram Admin ID
   - Your developer name/channel *(optional — shown on scan reports)*
6. Click **Install Bot**. The installer will:
   - Validate your bot token and API key
   - Generate `config.php` automatically
   - Set the Telegram webhook
   - Register bot commands in English
7. **Delete `install.php` immediately after installation for security.**

---

## ⚙️ Configuration

All configuration lives in the auto-generated `config.php` — you should never need to edit it by hand. Key values include:

| Constant | Description |
|---|---|
| `BOT_TOKEN` | Your Telegram bot token |
| `VT_API_KEY` | Your VirusTotal API key |
| `CHANNEL_MAIN` / `CHANNEL_SECONDARY` | Required channels for bot access |
| `ADMIN_IDS` | Telegram user IDs with admin panel access |
| `CREATOR_NAME` / `CREATOR_CHANNEL` | Your branding, shown on scan reports |
| `MAX_FILE_SIZE` | Max upload size (default 320MB) |
| `RATE_LIMIT_PER_MINUTE/HOUR/DAY` | Abuse protection thresholds |

---

## 💬 Commands

| Command | Description |
|---|---|
| `/start` | Start the bot and see the welcome message |
| `/profile` | View your scan history and stats |
| `/language` | Change the bot's language (14 supported) |
| `/help` | Open the help guide |

---

## 🖼️ Screenshots

> Add screenshots of the bot in action, the installer, and the admin panel here.

---

## 🛠️ Tech Stack

- **Backend:** PHP 8+ (webhook-based, no polling)
- **Storage:** Flat JSON files (`data/users.json`, `data/stats.json`, `data/blocked.json`)
- **API:** [Telegram Bot API](https://core.telegram.org/bots/api) + [VirusTotal API v3](https://developers.virustotal.com/reference)

---

## 📜 License

This project is **proprietary** and maintained by **[@DevArtery](https://t.me/DevArtery)**.

No modification, resale, or redistribution of this source code is permitted without explicit written permission. See [`LICENSE`](./LICENSE) for full terms.

<div align="center">

**Developed by [@DevArtery](https://t.me/DevArtery)** · **Channel: [@ArteryHub](https://t.me/ArteryHub)**

</div>
