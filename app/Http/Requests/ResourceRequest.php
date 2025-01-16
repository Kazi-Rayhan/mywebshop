<?php

namespace App\Http\Requests;

use App\Models\Resource;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ResourceRequest extends FormRequest
{
    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $days = collect($this->days)
            ->map(function ($day) {

                $day['from_time'] = $this->formatTime($day['from_time']);
                $day['to_time'] = $this->formatTime($day['to_time']);

                if ($this->filled('always_open')) {
                    $day['from_time'] = $this->formatTime('00:00');
                    $day['to_time'] = $this->formatTime('23:59');
                }

                $day['is_open'] = isset($day['is_open']);

                return $day;
            })
            ->toArray();

        $this->merge([
            'days' => $days,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $resourceId = $this->resource->id ?? null;

        return [
            'name' => [
                'required',
                Rule::unique(Resource::class)
                    ->where(function ($query) {
                        $query->where('shop_id', $this->user()->shop->id);
                    })
                    ->ignore($resourceId)
            ],
            'available_seats' => ['required', 'numeric'],
            'days' => ['array', 'required', 'max:7'],
            'days.*.day' => [
                'required',
                'string',
                'in:saturday,sunday,monday,tuesday,wednesday,thursday,friday'
            ],
            'days.*.from_time' => ['nullable', 'date_format:H:i:s'],
            'days.*.is_open' => ['required', 'boolean'],
            'days.*.to_time' => [
                'nullable',
                'date_format:H:i:s',
                function ($attribute, $value, $fail) {
                    $fromTimeKey = str_replace('to_time', 'from_time', $attribute);

                    $toTime = strtotime($value);
                    $fromTime = strtotime($this->{$fromTimeKey});

                    if ($fromTime >= $toTime) {
                        $fail('Please insert bigger for to time');
                    }
                }
            ],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'days.required' => 'Select at least one day with time',
            'days.*.from_time.required' => 'Please set from time for selected days',
            'days.*.from_time.date' => 'date',
            'days.*.to_time.required' => 'Please set to time for selected days',
            'days.*.to_time.gt' => 'Please set to time bigger than from time',
        ];
    }

    public function validated($key = null, $default = null)
    {
        $validated = parent::validated();

        $resource = [
            'name' => $validated['name'],
            'available_seats' => $validated['available_seats']
        ];

        return [
            'resource' => $resource,
            'schedule' => $validated['days'],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->shop->user_id === $this->user()->id;
    }

    private function formatTime($time)
    {
        if (!$time) {
            return null;
        }

        $time = strtotime($time);

        return date('H:i:s', $time);
    }
}
