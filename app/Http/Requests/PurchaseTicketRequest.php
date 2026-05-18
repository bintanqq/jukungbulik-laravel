<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama'        => ['required', 'string', 'min:3', 'max:100'],
            'whatsapp'    => ['required', 'regex:/^08[0-9]{8,12}$/'],
            'email'       => ['required', 'email:rfc,dns', 'max:150'],
            'category_id' => ['required', 'exists:ticket_categories,id'],
            'quantity'    => ['required', 'integer', 'min:1', 'max:5'],
        ];
    }

    public function messages(): array
    {
        return [
            'whatsapp.regex' => 'Format WhatsApp tidak valid. Gunakan format: 08xxxxxxxxxx',
            'quantity.max'   => 'Maksimal 5 tiket per transaksi.',
        ];
    }
}
