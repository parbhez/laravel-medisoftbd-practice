<?php

namespace App\Models\Diagnostic;

use Illuminate\Database\Eloquent\Model;

class SaleInvoice extends Model
{
    public function saleInvoiceDetails()
    {
    	return $this->hasMany('App\Models\Diagnostic\SaleInvoiceDetail','sale_invoice_id','sale_invoice_id');
    }
}
