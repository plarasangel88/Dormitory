<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\EmailVerificationCode;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class EmailVerificationCodeService
{
    private const CODE_LIFETIME_MINUTES = 10;

    private const MAX_ATTEMPTS = 5;

    public function send(User $user): void
    {
        $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        Cache::put($this->cacheKey($user), [
            'hash' => Hash::make($code),
            'attempts' => 0,
            'expires_at' => now()->addMinutes(self::CODE_LIFETIME_MINUTES)->timestamp,
        ], now()->addMinutes(self::CODE_LIFETIME_MINUTES));

        $user->notify(new EmailVerificationCode($code));
    }

    public function verify(User $user, string $code): bool
    {
        $verification = Cache::get($this->cacheKey($user));

        if (! is_array($verification) || ! isset($verification['hash'], $verification['attempts'], $verification['expires_at'])) {
            return false;
        }

        if (! Hash::check($code, $verification['hash'])) {
            $verification['attempts']++;

            if ($verification['attempts'] >= self::MAX_ATTEMPTS) {
                Cache::forget($this->cacheKey($user));
            } else {
                Cache::put(
                    $this->cacheKey($user),
                    $verification,
                    max(1, $verification['expires_at'] - now()->timestamp),
                );
            }

            return false;
        }

        Cache::forget($this->cacheKey($user));
        $user->markEmailAsVerified();

        return true;
    }

    private function cacheKey(User $user): string
    {
        return 'email-verification-code:'.$user->getKey();
    }
}
