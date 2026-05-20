<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'ticket_code',
        'nama',
        'whatsapp',
        'email',
        'ticket_category_id',
        'presale_period_id',
        'quantity',
        'unit_price',
        'total_price',
        'xendit_invoice_id',
        'xendit_invoice_url',
        'wa_sent',
        'wa_sent_at',
        'email_sent',
        'email_sent_at',
        'notes',
        'ordered_at',
    ];

    protected $casts = [
        'payment_confirmed_at' => 'datetime',
        'scanned_at' => 'datetime',
        'wa_sent' => 'boolean',
        'wa_sent_at' => 'datetime',
        'email_sent' => 'boolean',
        'email_sent_at' => 'datetime',
        'ordered_at' => 'datetime',
    ];

    public function ticketCategory()
    {
        return $this->belongsTo(TicketCategory::class);
    }

    public function presalePeriod()
    {
        return $this->belongsTo(PresalePeriod::class);
    }
}
