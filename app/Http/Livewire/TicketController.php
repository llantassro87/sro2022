<?php

namespace App\Http\Livewire;

use App\Models\Company;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Livewire\Component;
/*
Conector para windows*/
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

/* Connector para linux
use Mike42\Escpos\PrintConnectors\FilePrintConnector; */
use Mike42\Escpos\Printer;


class TicketController extends Component
{
/*     public function render()
    {
        return view('livewire.ticket-controller');
    } */

    public function ticket($saleID)
    {
/*         $company = Company::find(1);
        $sale = Sale::find($saleID);

        $user = User::find($sale->user_id);
        $products = Sale::join('sale_details as sd', 'sales.id', 'sd.sale_id')
            ->join('products as p', 'sd.product_id', 'p.id')
            ->select('sd.price', 'sd.quantity', 'sd.discount', 'p.name as product')
            ->where('sd.sale_id', $sale->id)
            ->get();

        $printerName = env("PRINTER_NAME");
        $connector = new WindowsPrintConnector($printerName);
        $printer = new Printer($connector);
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->setEmphasis(true);
        $printer->text('"SRO"');
        $printer->text("\n");
        $printer->text($company->name . "\n");
        $printer->text("\n");
        $printer->text($company->address . "\n");
        $printer->text("\n");
        $printer->text("NIT: " . $company->taxpayer_id . "\n");
        $printer->text("NRC: 158682-9\n");
        $printer->text("\n");
        $printer->text("Cel: WhatsApp " . $company->phone . "\n");
        $printer->text("Email: srollanteria2016@gmail.com\n");
        $printer->text("\n");
        $printer->text("Ticket de venta #" . $saleID . "\n");
        $printer->text("\n");
        $printer->text($sale->created_at . "\n");
        $printer->setEmphasis(false);
        $printer->text("\n");
        $printer->text("\n------------------------------------------");
        $header = sprintf('%5s %-5s %15s %10s', 'Cant', 'Articulo', 'Precio U.', 'Subtotal');
        $printer->text($header);
        $printer->text("\n"); 
        $printer->text("\n------------------------------------------");
        $total = 0;
        $items = 0;
        foreach ($products as $product) {
            
            if ($product->discount > 0) {
                $subtotal = ((100 - $product->discount) * $product->price) / 100;
                $subtotal = $subtotal * $product->quantity;
            } else {
                $subtotal = $product->quantity * $product->price;
            }
            
            $items += $product->quantity;
            $total += $subtotal;
 
            $format = sprintf('%5.0f %-50.40s %15.s %10.s', $product->quantity, $product->product, "$" . number_format($product->price, 2), "$" . number_format($subtotal, 2));
            $printer->text($format . "\n");
            $printer->text("\n"); 
        }
        $printer->setEmphasis(true);
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("\n------------------------------------------");
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $header = sprintf('%5s %-5s %15s %10s', $items, 'total de productos', '', '');
        $printer->text($header);
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("\n------------------------------------------");
        $printer->setJustification(Printer::JUSTIFY_RIGHT);
        $printer->text("Total: $" . number_format($total, 2) . "\n");
        $printer->text("Efectivo: $" . number_format($sale->cash, 2) . "\n");
        $printer->text("Cambio: $" . number_format($sale->change, 2) . "\n");
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("\n------------------------------------------");
        $printer->text("\n");
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->setTextSize(1, 1);
        $printer->text("\n"); 
        $printer->text("¡Gracias por su compra!\n");
        $printer->feed(5);
        $printer->cut();
        $printer->close(); */

        return Redirect::to("http://localhost/?id=$saleID");
    }
}
