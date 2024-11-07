<?php

namespace App\Services\Logto;

use Illuminate\Support\Facades\Session;
use Logto\Sdk\Storage\Storage;
use Logto\Sdk\Storage\StorageKey;

class LogtoStorageService implements Storage
{
    public function get(StorageKey $key): ?string
    {
        return Session::get($key->value);
    }

    public function set(StorageKey $key, ?string $value): void
    {
        if ($value === null) {
            $this->delete($key);
        } else {
            Session::put($key->value, $value);
        }
    }

    public function delete(StorageKey $key): void
    {
        Session::forget($key->value);
    }
}
