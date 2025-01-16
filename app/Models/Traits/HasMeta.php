<?php

namespace App\Models\Traits;

use App\Models\Meta;
use Error;
use Exception;
use Illuminate\Support\Facades\Cache;

trait HasMeta
{
    public function metas()
    {
        return $this->morphMany(Meta::class, 'metable');
    }


    /**
     * Create or Update Single Meta
     *
     * @param  string $key
     * @param  mixed $value
     * @return bool
     */
    public function createMeta(string $key, $value): bool
    {
        try {
            $this->metas()->updateOrCreate(['column_name' => $key], ['column_value' => $value]);
            return true;
        } catch (Exception $e) {
            return false;
        } catch (Error $e) {
            return false;
        }
    }

    /**
     * Create or Update Multiple Meta 
     *
     * @param  array $data
     * @return bool
     */
    public function createMetas(array $data): bool
    {

        try {
            foreach ($data as $key => $value) {
                if (is_array($value)) {
                    $value = json_encode($value);
                } elseif (is_file($value)) {
                    if ($this->metas()->where('column_name', $key)->exists()) {
                        $previousValue = $this->metas()->where('column_name', $key)->first();
                        if (file_exists($previousValue->column_value)) {
                            unlink($previousValue->column_value);
                        }
                    }
                    $value = $value->store('metas');
                }
                $this->metas()->updateOrCreate(['column_name' => $key], ['column_value' => $value]);
            }
            return true;
        } catch (Exception $e) {
            return false;
        } catch (Error $e) {
            return false;
        }
    }



    public function __get($key)
    {
        if (in_array($key, $this->meta_attributes)) {

            $keys = $key . '_' . get_class($this) . '_' . $this->id;
            Cache::remember($keys, 1500, function () use ($key) {
                return $this->metas->firstWhere('column_name', $key)->column_value ?? null;
            });
            return Cache::get($keys);
        }

        return parent::__get($key);
    }

    public function metaId($key){
        return $this->metas->firstWhere('column_name', $key)->id ?? null;
    }
}
