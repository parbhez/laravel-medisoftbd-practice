<?php

namespace App\Models\Diagnostic;

use Illuminate\Database\Eloquent\Model;

class SaleInvoiceDetail extends Model
{
    public function saleInvoiceDetails()
    {
    	return $this->belongsTo('App\Models\Diagnostic\SaleInvoice','sale_invoice_id','sale_invoice_id');
    }
}
