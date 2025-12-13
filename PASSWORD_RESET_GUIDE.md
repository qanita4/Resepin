# Natural Password Reset Testing Guide

Anda sekarang punya workflow password reset yang **natural dan teruji** di development environment.

## How It Works

1. **Log Mailer** (`MAIL_MAILER=log`) — password reset emails ditulis ke `storage/logs/laravel.log`
2. **Extract Link** — script membaca log dan extract URL reset
3. **Test Reset** — click link, isi password baru, login

## Quick Start

### Option A: Via Browser (Most Natural)

```bash
# Terminal 1: Start development server
php artisan serve

# Terminal 2: Generate test user + reset link
php artisan tinker
> $user = \App\Models\User::firstOrCreate(['email' => 'test@example.com'], ['name' => 'Test', 'password' => bcrypt('password123')])
> \Illuminate\Support\Facades\Password::sendResetLink(['email' => 'test@example.com'])
> exit
```

Then go to browser and:
1. Open `http://localhost:8000/forgot-password`
2. Enter: `test@example.com`
3. Click "Kirim Link Reset"
4. Run: `php artisan tinker < show_reset_link.php` (di terminal lain)
5. Copy link dari output
6. Paste di browser
7. Enter password baru
8. Click reset
9. Login dengan email + password baru

### Option B: Quick Terminal Test

```bash
# This extracts and shows the reset link
Get-Content .\show_reset_link.php | php artisan tinker
```

Output:
```
✅ PASSWORD RESET LINK FOUND!
═══════════════════════════════════════════════════
🔗 URL:
http://localhost/reset-password/e743ced6cd1e0fbada...?email=test%40example.com
```

### Option C: Multiple Users

```bash
# Test with different email
php artisan tinker
> \App\Models\User::create(['name'=>'Alice', 'email'=>'alice@test.com', 'password'=>bcrypt('pass')])
> \Illuminate\Support\Facades\Password::sendResetLink(['email'=>'alice@test.com'])
> exit

# Then extract link
Get-Content .\show_reset_link.php | php artisan tinker
```

## Files Created

| File | Purpose |
|------|---------|
| `show_reset_link.php` | Extract reset link dari log (recommended) |
| `debug_reset.php` | Debug password reset status |
| `tinker_reset_test.php` | Old test script |
| `dev_reset_password.php` | Standalone PHP script (experimental) |

## Config

### Current Setup
```
MAIL_MAILER=log
MAIL_FROM_ADDRESS=laravel@example.com
MAIL_FROM_NAME=Resepin
```

### To Switch to Mailtrap (Production-like)
1. Get credentials from [mailtrap.io](https://mailtrap.io)
2. Update `.env`:
   ```
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.mailtrap.io
   MAIL_PORT=2525
   MAIL_USERNAME=your_username
   MAIL_PASSWORD=your_password
   MAIL_ENCRYPTION=tls
   ```
3. Run: `php artisan config:cache`

## Natural Workflow Summary

```
📝 User Action → 🔐 System → 📧 Email → 🔗 Extract Link → 🔄 Reset → ✅ Login
```

1. User clicks "Lupa Password?" on login page
2. Enters email
3. System generates reset token
4. Email sent to `storage/logs/laravel.log`
5. Dev extracts link (manual copy/paste)
6. User opens link, resets password
7. User logs in dengan password baru

This is **realistic** because:
- ✅ Token-based reset (same as production)
- ✅ Link expires after X hours (default 60 min)
- ✅ One-time use (token deleted after use)
- ✅ User must verify email ownership (via link)
- ⚠️ Only difference: email visible in log instead of inbox

## Troubleshooting

### "Reset link not found in log"
- Check `storage/logs/laravel.log` exists
- Make sure you ran forgot-password form (not tinker)
- Clear log first: `del storage/logs/laravel.log`

### "Token invalid"
- Token expires after 60 minutes
- Generate new one: `Get-Content .\show_reset_link.php | php artisan tinker`

### Switch back to Database Mailer
```bash
# If you want emails in database instead of log:
php artisan make:model MailMessage -m
# ... (see earlier setup)
MAIL_MAILER=database
```

## Next: Production Email Services

When ready for staging/prod:
- **Mailtrap** (free sandbox, for testing)
- **SendGrid** (production email service)
- **Mailgun** (production email service)
- **AWS SES** (if using AWS)

For now, `log` mailer is perfect for local dev! 🚀
