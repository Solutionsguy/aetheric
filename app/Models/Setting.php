<?php

namespace App\Models;

use Cache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function add($key, $val, $type = 'string')
    {
        if (self::has($key)) {
            return self::set($key, $val, $type);
        }
        return self::create(['name' => $key, 'val' => $val, 'type' => $type]) ? $val : false;
    }

    public static function has($key)
    {
        return (bool) self::getAllSettings()->whereStrict('name', $key)->count();
    }

    public static function getAllSettings()
    {
        return Cache::rememberForever('settings.all', function () {
            if (! \App\Support\AppInstall::dbConnectionCheck()) {
                return collect();
            }
            return self::all();
        });
    }

    public static function set($key, $val, $type = 'string')
    {
        if ($setting = self::getAllSettings()->where('name', $key)->first()) {
            return $setting->update(['name' => $key, 'val' => $val, 'type' => $type]) ? $val : false;
        }
        return self::add($key, $val, $type);
    }

    public static function remove($key)
    {
        if (self::has($key)) {
            return self::whereName($key)->delete();
        }
        return false;
    }

    public static function getValidationRules($section)
    {
        return self::getDefinedSettingFields($section)->pluck('rules', 'name')
            ->reject(fn($val) => is_null($val))->toArray();
    }

    private static function getDefinedSettingFields($section)
    {
        return collect(config('setting')[$section]['elements']);
    }

    public static function getDataType($field, $section)
    {
        $type = self::getDefinedSettingFields($section)->pluck('data', 'name')->get($field);
        return is_null($type) ? 'string' : $type;
    }

    public static function get($key, $section = null, $default = null)
    {
        if (self::has($key)) {
            $setting = self::getAllSettings()->where('name', $key)->first();
            return self::castValue($setting->val, $setting->type);
        }
        return self::getDefaultValue($key, $section, $default);
    }

    private static function castValue($val, $castTo)
    {
        switch ($castTo) {
            case 'int':
            case 'integer': return intval($val);
            case 'bool':
            case 'boolean': return boolval($val);
            default: return $val;
        }
    }

    private static function getDefaultValue($key, $section, $default)
    {
        return is_null($default) ? self::getDefaultValueForField($key, $section) : $default;
    }

    public static function getDefaultValueForField($field, $section)
    {
        return self::getDefinedSettingFields($section)->pluck('value', 'name')->get($field);
    }

    protected static function boot()
    {
        parent::boot();
        static::updated(fn() => self::flushCache());
        static::created(fn() => self::flushCache());
    }

    public static function flushCache()
    {
        Cache::forget('settings.all');
    }

    public function otp_verification()
    {
        return false;
    }
}