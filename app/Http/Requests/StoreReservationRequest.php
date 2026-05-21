<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
         return auth()->check();
    
     }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
        'id_chambre' => 'required|exists:chambres,id_chambre',
        'date_debut' => 'required|date|after_or_equal:today',
        'date_fin' => 'required|date|after:date_debut'
    ];
    }

    public function messages(): array
{
    return [
        'id_chambre.required' => __('messages.room_required'),
        'id_chambre.exists' => __('messages.room_not_found'),
        'date_debut.after_or_equal' => __('messages.invalid_start_date'),
        'date_fin.after' => __('messages.invalid_end_date'),
    ];
}

}
