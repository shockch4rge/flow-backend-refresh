<?php

namespace App\Models\Traits;

// https://www.nick-basile.com/blog/post/how-to-use-and-test-traits-in-laravel/
use Ramsey\Uuid\Uuid;

trait UuidAsKey
{
    /**
     * Generate UUID v4 when creating model.
     */
    protected static function boot()
    {
        parent::boot();

        self::uuid();
    }

    /**
     * Use if boot() is overridden in the model.
     */
    protected static function uuid()
    {
        static::creating(function ($model) {
            $model->{self::uuidField()} = Uuid::uuid4()->toString();
        });
    }

    /**
     * Defines the UUID field for the model.
     * @return string
     */
    protected static function uuidField(): string
    {
        return 'id';
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }
}
