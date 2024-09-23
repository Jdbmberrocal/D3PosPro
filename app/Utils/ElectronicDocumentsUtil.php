<?php

namespace App\Utils;

use Illuminate\Support\Facades\File;
use App\Business;
use App\InvoiceScheme;
use App\Contact;
use App\Product;
use App\TaxRate;
use App\Transaction;
use Carbon\Carbon;
use App\Utils\TransactionUtil;


class ElectronicDocumentsUtil
{
    /**
     * Leer un archivo JSON desde una ruta específica
     *
     * @param string $path
     * @return array|null
     */
    public static function convert_numeric($number)
    {
        return  str_replace(',', '', $number);
    }

    public static function tax($number,$percent)
    {
        $base = 1000;
        // $porcentaje = 19;
        $factor = 1 + ($percent / 100);

        $resultado = $number * $factor;

        return  $resultado - $number;
    }

    public static function round_number($valor) {
        
        return round($valor,2);
    }

    public static function separarLetrasYNumeros($input) {
        $letras = preg_replace('/[^a-zA-Z]/', '', $input);
        $numeros = preg_replace('/[^0-9]/', '', $input);
        return array($letras, $numeros);
    }
    
    public static function resend_invoice($transaction_before, $business_id, $contact_id, $input,$prefix, $number, $resolution)
    {
        $customer_data = Contact::findOrFail($contact_id);
        $business_data = Business::find($business_id);

        //validamos si se va a enviar factua electronica o no
        if($transaction_before->is_valid != 1 && $transaction_before->cufe == '' && $transaction_before->status == "final" && $transaction_before->is_suspend == "0")//final
        // if($transaction_before->is_valid == 1  && $transaction_before->status == "final" && $transaction_before->is_suspend == "0")//final
        {

            
            $actual_date = Carbon::now('America/Bogota')->format('Y-m-d');
            $actual_hous = Carbon::now('America/Bogota')->format('H:m:s');


            $total_tax_products = 0;
            $total_not_tax_products = 0;
            // $total_not_tax_products = 0;
            $line_extension_amount = 0;
            $tax_inclusive_amount = 0;
            $tax_exclusive_amount = 0;
            // $taxes = [];//impuesto por linea de producto
            $payable_amount = 0;
            

            $invoiceLines = array();

            $tax_totals_map = [];//array para agregar y sumar los impuestos a nivel de factura

            $tax_total_invoice = [];


            if(isset($input))
            {
                foreach ($input as $product){
                    $tax_totals = [];//impuestos totales de la factura
                    // $total_product = 0;
                    // $tax_total_product = 0;

                    $product_db = Product::findOrFail($product['product_id']);

                    $unit_price = self::convert_numeric($product['unit_price']);

                    //calculo de los campos de cada linea convert_numeric($number)
                    $line_extension_amount_product = (intval($product['quantity']) * floatval($unit_price));

                    //CONSTRUCCIÓN DEL JSON DE IMPUESTOS
                    if(isset($product['tax_id'])){
                        $tax = TaxRate::find($product['tax_id']);

                        $tax_amount_product = self::tax($line_extension_amount_product,floatval($tax['amount']));
                        // $tax_total_product = $tax_amount_product + $line_extension_amount_product;

                        $tax_totals[] = [
                            // "tax_id" =>intval($product['tax_id']),//ERROR AQUI
                            "tax_id" =>$tax->code,
                            "tax_amount" => self::round_number($tax_amount_product),
                            "taxable_amount" => self::round_number($line_extension_amount_product),//valor del producto sin impuesto
                            "percent" => intval($tax['amount'])
                        ];

                        // Sumar el impuesto al total de impuestos de la factura
                        $tax_key = intval($tax['code']) . '_' . floatval($tax['amount']);
                        if (isset($tax_totals_map[$tax_key])) {
                            // $tax_totals_map[$tax_key]['tax_id'] = intval($tax['tax_id']);
                            $tax_totals_map[$tax_key]['tax_amount'] += self::round_number($tax_amount_product);
                            $tax_totals_map[$tax_key]['taxable_amount'] += self::round_number($line_extension_amount_product);
                        } else {
                            $tax_totals_map[$tax_key] = [
                                "tax_id" => $tax->code,
                                "tax_amount" => self::round_number($tax_amount_product),
                                "taxable_amount" => self::round_number($line_extension_amount_product),
                                "percent" => floatval($tax['amount'])
                            ];
                        }


                        //sumamos el total de las bases productos con impuestos
                        $tax_exclusive_amount +=  $line_extension_amount_product;

                        //sumamos el excedente del impuesto al total de la linea
                        $line_extension_amount_product += $tax_amount_product;


                        
                    }
                    $total_line = intval($product['quantity']) * $unit_price;
                    
                    if(isset($product['tax_id'])){
                        $invoiceLines[] = [
                            "unit_measure_id" => 70,
                            "invoiced_quantity" => intval($product['quantity']),
                            "line_extension_amount" => self::round_number($total_line),//Valor total de la línea. Cantidad x Precio Unidad menos descuentos más recargos que apliquen para la línea.
                            // "line_extension_amount" => $this->round_number($line_extension_amount_product),//Valor total de la línea. Cantidad x Precio Unidad menos descuentos más recargos que apliquen para la línea.
                            "free_of_charge_indicator" => false,
                            
                            "description" => $product_db->name,
                            "code" => $product_db->sku,
                            "type_item_identification_id" => 4,
                            "price_amount" => self::round_number($line_extension_amount_product),//Valor de la linea de la factura
                            "base_quantity" =>intval($product['quantity']),
                            "tax_totals" => $tax_totals

                        ];
                        unset($tax_totals);
                    }else{
                        $invoiceLines[] = [
                            "unit_measure_id" => 70,
                            "invoiced_quantity" => intval($product['quantity']),
                            "line_extension_amount" => self::round_number($total_line),//Valor total de la línea. Cantidad x Precio Unidad menos descuentos más recargos que apliquen para la línea.
                            "free_of_charge_indicator" => false,
                            
                            "description" => $product_db->name,
                            "code" => $product_db->sku,
                            "type_item_identification_id" => 4,
                            "price_amount" => self::round_number($line_extension_amount_product),//Valor de la linea de la factura
                            "base_quantity" =>intval($product['quantity']),

                        ];
                    }


                    $tax_inclusive_amount += $line_extension_amount_product;
                }

            }

            // Convertir el mapa de impuestos a un array de totales de impuestos
            $tax_total_invoice = array_values($tax_totals_map);

            //calcular los invoice line
            if(isset($invoiceLines)){
                foreach($invoiceLines as $invoice_product)
                {
                    if(isset($invoice_product['tax_id']))
                    {
                        $total_tax_products += floatval($invoice_product['line_extension_amount']);
                    }else{
                        $total_not_tax_products +=  floatval($invoice_product['line_extension_amount']);
                    }
                    $line_extension_amount += floatval($invoice_product['line_extension_amount']);

                    //calculñar el total de la factura
                    $payable_amount = $payable_amount + $invoice_product['price_amount'];
                }
            }


            //ENVIO DE FE zposs.co

            $date = $actual_date;
            $time = $actual_hous;
            $sendmail = true;
            
            if($customer_data->contact_id == 222222222222)
            {
                $customer = array(
                    "identification_number" => "222222222222",
                    "name" => "Consumidor Final",
                    "merchant_registration" => "0000000-00",
                );
            }else{
                $contact_type = 0;
                $name = '';
                if($customer_data->contact_type == 'individual')
                {
                    $contact_type = 2;
                    $name = $customer_data->name;
                }else{
                    $contact_type = 1;
                    $name = $customer_data->supplier_business_name;
                }
                $customer = array(
                    "identification_number" => $customer_data->contact_id,
                    "dv" => $customer_data->dv,
                    "name" => $name,
                    "type_organization_id" => $contact_type,
                    "phone" => $customer_data->mobile,
                    "merchant_registration" => ($customer_data->merchant_registration)?$customer_data->merchant_registration : "0000000",
                    "type_document_identification_id" => ($customer_data->type_document_identification_id)?$customer_data->type_document_identification_id : "",
                    "type_regime_id" => ($customer_data->type_regime_id)?$customer_data->type_regime_id : "",
                    "municipality_id" => ($customer_data->municipality_id)?$customer_data->municipality_id : "",
                    "email" => $customer_data->email,
                    "address" => ($customer_data->address_line_1)? $customer_data->address_line_1: 'no'
                );
                $sendmail = true;
            }
            //leer los metodos y formas de pago
            // $payment_form = 1;
            // if($input['payment']['change_return']['method'] == 'cash')//efectivo
            // {
            //     $payment_form = 1;
            // }else{
            //     $payment_form = 2;//credito
            // }
            $paymentForm = array(
                "duration_measure" => 1,//dias de plazo para pago
                "payment_form_id" => 1,//1 contado 2 credito
                "payment_method_id" => 1,
                "payment_due_date" => $actual_date
            );
            // $previousBalance = "0";
            $legalMonetaryTotals = array(
                "line_extension_amount" => self::round_number($line_extension_amount),
                "tax_exclusive_amount" => self::round_number($tax_exclusive_amount),//
                "tax_inclusive_amount" => self::round_number($tax_inclusive_amount),
                "charge_total_amount" => "0.00",
                // "payable_amount" => $this->round_number($final_total),
                "payable_amount" => self::round_number($tax_inclusive_amount),
                "allowance_total_amount" => "0.00"
            );

        


            // Construcción del JSON dinámicamente
            $data = array(
                "number" => $number,
                "prefix" => $prefix,
                "type_document_id" => 1,
                "date" => $date,
                "time" => $time,
                "sendmail" => $sendmail,
                "resolution_number" => $resolution,
                "customer" => $customer,
                "payment_form" => $paymentForm,
                // "previous_balance" => $previousBalance,
                "legal_monetary_totals" => $legalMonetaryTotals,
                // "allowance_charges" => $allowanceCharges,
            );

            if (!empty($invoiceLines)) {
                $data["invoice_lines"] = $invoiceLines;
            }

            if (!empty($tax_total_invoice)) {
                $data["tax_totals"] = $tax_total_invoice;
            }

            // return $data;

            $jsonData = json_encode($data);
            // return $jsonData;
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => env('APP_API_FE').'/api/ubl2.1/invoice',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $jsonData,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: Bearer '.$business_data->token
            ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                return ['success' => 0, 'msg' => "cURL Error: {$err}"];
            }

            $respuesta = json_decode($response);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return ['success' => 0, 'msg' => 'Error decoding API response'];
            }

            if(!isset($respuesta->success)){
            // dd($respuesta);
            // if(!in_array('success', $respuesta)){
                if(isset($respuesta->ResponseDian))
                {
                    

                    $response_dian =  $respuesta->ResponseDian;
                    $IsValid = $response_dian->Envelope->Body->SendBillSyncResponse->SendBillSyncResult->IsValid;
                    $ErrorRules = isset($response_dian->Envelope->Body->SendBillSyncResponse->SendBillSyncResult->ErrorMessage->string)? $response_dian->Envelope->Body->SendBillSyncResponse->SendBillSyncResult->ErrorMessage->string : '';
                    $cufe = $respuesta->cufe;
                    $QRStr = $respuesta->QRStr;
                    $ErrorRules = '';
                    $message = '';
                    $code = '';


                    if($IsValid == "true")
                    {
                        //guardamos el cufe de la factura y cambiamos estado de la facturA en el sistema
                        $transaction = Transaction::find($transaction_before->id);
                        $transaction->cufe = $cufe;
                        $transaction->is_valid = true;
                        $transaction->qrstr = $QRStr;
                        $transaction->save();

                        $message = 'Factura aceptada por la DIAN';
                        $code = 1;
                    }else{
                        $ErrorRules = isset($response_dian->Envelope->Body->SendBillSyncResponse->SendBillSyncResult->ErrorMessage)? $response_dian->Envelope->Body->SendBillSyncResponse->SendBillSyncResult->ErrorMessage->string : '';
                        $message = $ErrorRules;
                        $code = 0;
                    }

                    $output = [
                        'success' =>$code, 
                        'msg' => $message,  
                        'input_curl'=> $data, 
                        'input_factura'=> $input, 
                        'response' => ($respuesta) ? $respuesta : '',  
                        'cufe' => ($cufe) ? $cufe : '',
                        'IsValid' => ($IsValid) ? $IsValid : '',
                        'QRStr' => ($QRStr) ? $QRStr : '',
                        'ErrorMessage' => $ErrorRules
                    ];
                    return $output;
                }else{

                    
                    $output = [
                        'success' => 0, 
                        // 'msg' => $respuesta->error[0], 
                        'msg' => $respuesta->error[0], 
                        'input_curl'=> $data, 
                    ];
                    return $output;
                }
            }else{
                $output = [
                    'success' => 1, 
                    'msg' => $respuesta->message, 
                ];
                return $output;
            }
        }else{
            $output = [
                'success' => 1, 
                'msg' => 'No es una factura electrónica o ya fue enviada anteriormente', 
            ];
            return $output;
        }
    }
    
    public static function send_invoice($invoice_scheme_id, $business_id, $contact_id, $input, $transaction)
    {
        $i_echeme = '';
        if(!empty($invoice_scheme_id))
        {
            //consultar datos de la empresa 
            $business_data = Business::find($business_id);

            //consultar el tipo de factura
            $invoice_scheme = InvoiceScheme::findOrFail($invoice_scheme_id);
            $i_echeme = $invoice_scheme->is_fe;
            //consultar los datos del cliente
            $customer_data = Contact::findOrFail($contact_id);
        }else{
            $invoice_scheme = InvoiceScheme::where('business_id',$business_id)->where('is_default',1)->get();
            $i_echeme == $invoice_scheme->is_fe;
        }
        

        //validamos si se va a enviar factua electronica o no
        if($i_echeme == 'si' && $input['status'] == "final" && $input['is_suspend'] == "0")//final
        {

            
            $actual_date = Carbon::now('America/Bogota')->format('Y-m-d');
            $actual_hous = Carbon::now('America/Bogota')->format('H:m:s');

            $invoice_number = intval($invoice_scheme->start_number) + intval($invoice_scheme->invoice_count) -1;

            $total_tax_products = 0;
            $total_not_tax_products = 0;
            // $total_not_tax_products = 0;
            $line_extension_amount = 0;
            $tax_inclusive_amount = 0;
            $tax_exclusive_amount = 0;
            // $taxes = [];//impuesto por linea de producto
            $payable_amount = 0;
            

            $invoiceLines = array();

            $tax_totals_map = [];//array para agregar y sumar los impuestos a nivel de factura

            $tax_total_invoice = [];

            
            // $final_total = $this->convert_numeric($input['final_total']);



            if(isset($input['products']))
            {
                foreach ($input['products'] as $product){
                    $tax_totals = [];//impuestos totales de la factura
                    // $total_product = 0;
                    // $tax_total_product = 0;

                    $product_db = Product::findOrFail($product['product_id']);

                    $unit_price = self::convert_numeric($product['unit_price']);

                    //calculo de los campos de cada linea convert_numeric($number)
                    $line_extension_amount_product = (intval($product['quantity']) * floatval($unit_price));

                    //CONSTRUCCIÓN DEL JSON DE IMPUESTOS
                    if(isset($product['tax_id'])){
                        $tax = TaxRate::find($product['tax_id']);

                        $tax_amount_product = self::tax($line_extension_amount_product,floatval($tax['amount']));
                        // $tax_total_product = $tax_amount_product + $line_extension_amount_product;

                        $tax_totals[] = [
                            // "tax_id" =>intval($product['tax_id']),//ERROR AQUI
                            "tax_id" =>$tax->code,
                            "tax_amount" => self::round_number($tax_amount_product),
                            "taxable_amount" => self::round_number($line_extension_amount_product),//valor del producto sin impuesto
                            "percent" => intval($tax['amount'])
                        ];

                        // Sumar el impuesto al total de impuestos de la factura
                        $tax_key = intval($tax['code']) . '_' . floatval($tax['amount']);
                        if (isset($tax_totals_map[$tax_key])) {
                            // $tax_totals_map[$tax_key]['tax_id'] = intval($tax['tax_id']);
                            $tax_totals_map[$tax_key]['tax_amount'] += self::round_number($tax_amount_product);
                            $tax_totals_map[$tax_key]['taxable_amount'] += self::round_number($line_extension_amount_product);
                        } else {
                            $tax_totals_map[$tax_key] = [
                                "tax_id" => $tax->code,
                                "tax_amount" => self::round_number($tax_amount_product),
                                "taxable_amount" => self::round_number($line_extension_amount_product),
                                "percent" => floatval($tax['amount'])
                            ];
                        }


                        //sumamos el total de las bases productos con impuestos
                        $tax_exclusive_amount +=  $line_extension_amount_product;

                        //sumamos el excedente del impuesto al total de la linea
                        $line_extension_amount_product += $tax_amount_product;


                        
                    }
                    $total_line = intval($product['quantity']) * $unit_price;
                    
                    if(isset($product['tax_id'])){
                        $invoiceLines[] = [
                            "unit_measure_id" => 70,
                            "invoiced_quantity" => intval($product['quantity']),
                            "line_extension_amount" => self::round_number($total_line),//Valor total de la línea. Cantidad x Precio Unidad menos descuentos más recargos que apliquen para la línea.
                            // "line_extension_amount" => $this->round_number($line_extension_amount_product),//Valor total de la línea. Cantidad x Precio Unidad menos descuentos más recargos que apliquen para la línea.
                            "free_of_charge_indicator" => false,
                            
                            "description" => $product_db->name,
                            "code" => $product_db->sku,
                            "type_item_identification_id" => 4,
                            "price_amount" => self::round_number($line_extension_amount_product),//Valor de la linea de la factura
                            "base_quantity" =>intval($product['quantity']),
                            "tax_totals" => $tax_totals

                        ];
                        unset($tax_totals);
                    }else{
                        $invoiceLines[] = [
                            "unit_measure_id" => 70,
                            "invoiced_quantity" => intval($product['quantity']),
                            "line_extension_amount" => self::round_number($total_line),//Valor total de la línea. Cantidad x Precio Unidad menos descuentos más recargos que apliquen para la línea.
                            "free_of_charge_indicator" => false,
                            
                            "description" => $product_db->name,
                            "code" => $product_db->sku,
                            "type_item_identification_id" => 4,
                            "price_amount" => self::round_number($line_extension_amount_product),//Valor de la linea de la factura
                            "base_quantity" =>intval($product['quantity']),

                        ];
                    }


                    $tax_inclusive_amount += $line_extension_amount_product;
                }

            }

            // Convertir el mapa de impuestos a un array de totales de impuestos
            $tax_total_invoice = array_values($tax_totals_map);

            //calcular los invoice line
            if(isset($invoiceLines)){
                foreach($invoiceLines as $invoice_product)
                {
                    if(isset($invoice_product['tax_id']))
                    {
                        $total_tax_products += floatval($invoice_product['line_extension_amount']);
                    }else{
                        $total_not_tax_products +=  floatval($invoice_product['line_extension_amount']);
                    }
                    $line_extension_amount += floatval($invoice_product['line_extension_amount']);

                    //calculñar el total de la factura
                    $payable_amount = $payable_amount + $invoice_product['price_amount'];
                }
            }


            //ENVIO DE FE zposs.co
        

            // Parámetros dinámicos
            $invoiceNumber = $invoice_number;
            // $invoiceNumber = 3;
            $prefix = $invoice_scheme->prefix;
            $typeDocumentId = 1;
            $date = $actual_date;
            $time = $actual_hous;
            $sendmail = false;
            $resolutionNumber = $invoice_scheme->resolution;
            if($customer_data->contact_id == 222222222222)
            {
                $customer = array(
                    "identification_number" => "222222222222",
                    "name" => "Consumidor Final",
                    "merchant_registration" => "0000000-00",
                );
            }else{
                $contact_type = 0;
                $name = '';
                if($customer_data->contact_type == 'individual')
                {
                    $contact_type = 2;
                    $name = $customer_data->name;
                }else{
                    $contact_type = 1;
                    $name = $customer_data->supplier_business_name;
                }
                $customer = array(
                    "identification_number" => $customer_data->contact_id,
                    "dv" => $customer_data->dv,
                    "name" => $name,
                    "type_organization_id" => $contact_type,
                    "phone" => $customer_data->mobile,
                    "merchant_registration" => ($customer_data->merchant_registration)?$customer_data->merchant_registration : "0000000-00",
                    "type_document_identification_id" => ($customer_data->type_document_identification_id)?$customer_data->type_document_identification_id : "",
                    "type_regime_id" => ($customer_data->type_regime_id)?$customer_data->type_regime_id : "",
                    "type_liability_id" => ($customer_data->liability_id)?$customer_data->liability_id : "",
                    "municipality_id" => ($customer_data->municipality_id)?$customer_data->municipality_id : "",
                    "email" => $customer_data->email,
                    "address" => ($customer_data->address_line_1)? $customer_data->address_line_1: 'no'
                );
                $sendmail = true;
            }
            //leer los metodos y formas de pago
            // $payment_form = 1;
            // if($input['payment']['change_return']['method'] == 'cash')//efectivo
            // {
            //     $payment_form = 1;
            // }else{
            //     $payment_form = 2;//credito
            // }
            $paymentForm = array(
                "duration_measure" => 1,//dias de plazo para pago
                "payment_form_id" => 1,//1 contado 2 credito
                "payment_method_id" => 1,
                "payment_due_date" => $actual_date
            );
            // $previousBalance = "0";
            $legalMonetaryTotals = array(
                "line_extension_amount" => self::round_number($line_extension_amount),
                "tax_exclusive_amount" => self::round_number($tax_exclusive_amount),//
                "tax_inclusive_amount" => self::round_number($tax_inclusive_amount),
                "charge_total_amount" => "0.00",
                // "payable_amount" => $this->round_number($final_total),
                "payable_amount" => self::round_number($tax_inclusive_amount),
                "allowance_total_amount" => "0.00"
            );

        


            // Construcción del JSON dinámicamente
            $data = array(
                "number" => $invoiceNumber,
                // "number" => 990000486,
                "prefix" => $prefix,
                "type_document_id" => $typeDocumentId,
                "date" => $date,
                "time" => $time,
                "sendmail" => $sendmail,
                "resolution_number" => $resolutionNumber,
                "customer" => $customer,
                "payment_form" => $paymentForm,
                // "previous_balance" => $previousBalance,
                "legal_monetary_totals" => $legalMonetaryTotals,
                // "allowance_charges" => $allowanceCharges,
            );

            if (!empty($invoiceLines)) {
                $data["invoice_lines"] = $invoiceLines;
            }

            if (!empty($tax_total_invoice)) {
                $data["tax_totals"] = $tax_total_invoice;
            }

            // return $data;

            $jsonData = json_encode($data);
            // return $jsonData;
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => env('APP_API_FE').'/api/ubl2.1/invoice',
            // CURLOPT_URL => 'https://jl-technology.online/api/ubl2.1/invoice',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $jsonData,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json',
                // 'Authorization: Bearer 35ce3c09a915c29752359f33455b43bed988a47c35ee347de5947a2192e793a7'
                'Authorization: Bearer '.$business_data->token
            ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                return ['success' => 0, 'msg' => "cURL Error: {$err}"];
            }

            $respuesta = json_decode($response);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return ['success' => 0, 'msg' => 'Error decoding API response'];
            }

            if(!isset($respuesta->success)){

                if(isset($respuesta->ResponseDian))
                {
                    

                    $response_dian =  $respuesta->ResponseDian;
                    $IsValid = $response_dian->Envelope->Body->SendBillSyncResponse->SendBillSyncResult->IsValid;
                    // $ErrorRules = isset($response_dian->Envelope->Body->SendBillSyncResponse->SendBillSyncResult->ErrorMessage)? $response_dian->Envelope->Body->SendBillSyncResponse->SendBillSyncResult->ErrorMessage->string : '';
                    $cufe = $respuesta->cufe;
                    $QRStr = $respuesta->QRStr;
                    $ErrorRules = '';
                    $message = '';
                    $code = '';

                    if($IsValid == "true")
                    {
                        //guardamos el cufe de la factura y cambiamos estado de la facturA en el sistema
                        $transaction = Transaction::find($transaction->id);
                        $transaction->cufe = $cufe;
                        $transaction->is_valid = true;
                        $transaction->qrstr = $QRStr;
                        $transaction->save();

                        $message = 'Factura aceptada por la DIAN';
                        $code = 1;
                    }else{
                        $ErrorRules = isset($response_dian->Envelope->Body->SendBillSyncResponse->SendBillSyncResult->ErrorMessage)? $response_dian->Envelope->Body->SendBillSyncResponse->SendBillSyncResult->ErrorMessage->string : '';
                        $message = $ErrorRules;
                        $code = 0;
                    }

                    $output = [
                        'success' =>$code, 
                        'msg' => $message, 
                        'input_curl'=> $data, 
                        'input_factura'=> $input, 
                        'response' => ($respuesta) ? $respuesta : '',  
                        'cufe' => ($cufe) ? $cufe : '',
                        'IsValid' => ($IsValid) ? $IsValid : '',
                        'QRStr' => ($QRStr) ? $QRStr : '',
                        'ErrorMessage' => $ErrorRules
                    ];
                    return $output;
                }else{

                    
                    $output = [
                        'success' => 0, 
                        // 'msg' => $respuesta->error[0], 
                        'msg' => $respuesta, 
                        'input_curl'=> $data, 
                    ];
                    return $output;
                }
            }else{
                $output = [
                    'success' => 1, 
                    'msg' => $respuesta->message, 
                ];
                return $output;
            }

        }else{


            $output = [
                'success' => 1, 
                'msg' => 'No es una factura electrónica', 
                // 'receipt' => $receipt
            ];
            return $output;
        }

    }


    public static function send_credit_note($invoice_scheme_id, $business_id, $contact_id, $input, $transaction)
    {
        $i_echeme = '';
        if(!empty($invoice_scheme_id))
        {
            //consultar datos de la empresa 
            $business_data = Business::find($business_id);

            //consultar el tipo de factura
            $invoice_scheme = InvoiceScheme::findOrFail($invoice_scheme_id);
            $i_echeme = $invoice_scheme->is_fe;
            //consultar los datos del cliente
            $customer_data = Contact::findOrFail($contact_id);
        }else{
            $invoice_scheme = InvoiceScheme::where('business_id',$business_id)->where('is_default',1)->get();
            $i_echeme == $invoice_scheme->is_fe;
        }
        

        //validamos si se va a enviar factua electronica o no
        if($i_echeme == 'si' && $input['status'] == "final" && $input['is_suspend'] == "0")//final
        {

            
            $actual_date = Carbon::now('America/Bogota')->format('Y-m-d');
            $actual_hous = Carbon::now('America/Bogota')->format('H:m:s');

            $invoice_number = intval($invoice_scheme->start_number) + intval($invoice_scheme->invoice_count) -1;

            $total_tax_products = 0;
            $total_not_tax_products = 0;
            // $total_not_tax_products = 0;
            $line_extension_amount = 0;
            $tax_inclusive_amount = 0;
            $tax_exclusive_amount = 0;
            // $taxes = [];//impuesto por linea de producto
            $payable_amount = 0;
            

            $invoiceLines = array();

            $tax_totals_map = [];//array para agregar y sumar los impuestos a nivel de factura

            $tax_total_invoice = [];

            
            // $final_total = $this->convert_numeric($input['final_total']);



            if(isset($input['products']))
            {
                foreach ($input['products'] as $product){
                    $tax_totals = [];//impuestos totales de la factura
                    // $total_product = 0;
                    // $tax_total_product = 0;

                    $product_db = Product::findOrFail($product['product_id']);

                    $unit_price = self::convert_numeric($product['unit_price']);

                    //calculo de los campos de cada linea convert_numeric($number)
                    $line_extension_amount_product = (intval($product['quantity']) * floatval($unit_price));

                    //CONSTRUCCIÓN DEL JSON DE IMPUESTOS
                    if(isset($product['tax_id'])){
                        $tax = TaxRate::find($product['tax_id']);

                        $tax_amount_product = self::tax($line_extension_amount_product,floatval($tax['amount']));
                        // $tax_total_product = $tax_amount_product + $line_extension_amount_product;

                        $tax_totals[] = [
                            // "tax_id" =>intval($product['tax_id']),//ERROR AQUI
                            "tax_id" =>$tax->code,
                            "tax_amount" => self::round_number($tax_amount_product),
                            "taxable_amount" => self::round_number($line_extension_amount_product),//valor del producto sin impuesto
                            "percent" => intval($tax['amount'])
                        ];

                        // Sumar el impuesto al total de impuestos de la factura
                        $tax_key = intval($tax['code']) . '_' . floatval($tax['amount']);
                        if (isset($tax_totals_map[$tax_key])) {
                            // $tax_totals_map[$tax_key]['tax_id'] = intval($tax['tax_id']);
                            $tax_totals_map[$tax_key]['tax_amount'] += self::round_number($tax_amount_product);
                            $tax_totals_map[$tax_key]['taxable_amount'] += self::round_number($line_extension_amount_product);
                        } else {
                            $tax_totals_map[$tax_key] = [
                                "tax_id" => $tax->code,
                                "tax_amount" => self::round_number($tax_amount_product),
                                "taxable_amount" => self::round_number($line_extension_amount_product),
                                "percent" => floatval($tax['amount'])
                            ];
                        }


                        //sumamos el total de las bases productos con impuestos
                        $tax_exclusive_amount +=  $line_extension_amount_product;

                        //sumamos el excedente del impuesto al total de la linea
                        $line_extension_amount_product += $tax_amount_product;


                        
                    }
                    $total_line = intval($product['quantity']) * $unit_price;
                    
                    if(isset($product['tax_id'])){
                        $invoiceLines[] = [
                            "unit_measure_id" => 70,
                            "invoiced_quantity" => intval($product['quantity']),
                            "line_extension_amount" => self::round_number($total_line),//Valor total de la línea. Cantidad x Precio Unidad menos descuentos más recargos que apliquen para la línea.
                            // "line_extension_amount" => $this->round_number($line_extension_amount_product),//Valor total de la línea. Cantidad x Precio Unidad menos descuentos más recargos que apliquen para la línea.
                            "free_of_charge_indicator" => false,
                            
                            "description" => $product_db->name,
                            "code" => $product_db->sku,
                            "type_item_identification_id" => 4,
                            "price_amount" => self::round_number($line_extension_amount_product),//Valor de la linea de la factura
                            "base_quantity" =>intval($product['quantity']),
                            "tax_totals" => $tax_totals

                        ];
                        unset($tax_totals);
                    }else{
                        $invoiceLines[] = [
                            "unit_measure_id" => 70,
                            "invoiced_quantity" => intval($product['quantity']),
                            "line_extension_amount" => self::round_number($total_line),//Valor total de la línea. Cantidad x Precio Unidad menos descuentos más recargos que apliquen para la línea.
                            "free_of_charge_indicator" => false,
                            
                            "description" => $product_db->name,
                            "code" => $product_db->sku,
                            "type_item_identification_id" => 4,
                            "price_amount" => self::round_number($line_extension_amount_product),//Valor de la linea de la factura
                            "base_quantity" =>intval($product['quantity']),

                        ];
                    }


                    $tax_inclusive_amount += $line_extension_amount_product;
                }

            }

            // Convertir el mapa de impuestos a un array de totales de impuestos
            $tax_total_invoice = array_values($tax_totals_map);

            //calcular los invoice line
            if(isset($invoiceLines)){
                foreach($invoiceLines as $invoice_product)
                {
                    if(isset($invoice_product['tax_id']))
                    {
                        $total_tax_products += floatval($invoice_product['line_extension_amount']);
                    }else{
                        $total_not_tax_products +=  floatval($invoice_product['line_extension_amount']);
                    }
                    $line_extension_amount += floatval($invoice_product['line_extension_amount']);

                    //calculñar el total de la factura
                    $payable_amount = $payable_amount + $invoice_product['price_amount'];
                }
            }


            // Parámetros dinámicos para notas credito
            $billing_reference = array(
                "number" => "SETP990000937",//numero de la factura
                "uuid" => "",//cufe de la factura
                "issue_date" => "2024-01-17",//fecha de la factura
            );
            $invoiceNumber = $invoice_number;
            $discrepancyResponseDescription = "descripcion del motivo de la nota credito";//codigo motivo de la nota credito
            $discrepancyResponseCode = 2;
            
            $prefix = $invoice_scheme->prefix;
            $typeDocumentId = 4;
            $date = $actual_date;
            $time = $actual_hous;
            $sendmail = false;
            // $resolutionNumber = $invoice_scheme->resolution;
            if($customer_data->contact_id == 222222222222)
            {
                $customer = array(
                    "identification_number" => "222222222222",
                    "name" => "Consumidor Final",
                    "merchant_registration" => "0000000-00",
                );
            }else{
                $contact_type = 0;
                $name = '';
                if($customer_data->contact_type == 'individual')
                {
                    $contact_type = 2;
                    $name = $customer_data->name;
                }else{
                    $contact_type = 1;
                    $name = $customer_data->supplier_business_name;
                }
                $customer = array(
                    "identification_number" => $customer_data->contact_id,
                    "dv" => $customer_data->dv,
                    "name" => $name,
                    "type_organization_id" => $contact_type,
                    "phone" => $customer_data->mobile,
                    "merchant_registration" => ($customer_data->merchant_registration)?$customer_data->merchant_registration : "0000000-00",
                    "type_document_identification_id" => ($customer_data->type_document_identification_id)?$customer_data->type_document_identification_id : "",
                    "type_regime_id" => ($customer_data->type_regime_id)?$customer_data->type_regime_id : "",
                    "type_liability_id" => ($customer_data->liability_id)?$customer_data->liability_id : "",
                    "municipality_id" => ($customer_data->municipality_id)?$customer_data->municipality_id : "",
                    "email" => $customer_data->email,
                    "address" => ($customer_data->address_line_1)? $customer_data->address_line_1: 'no'
                );
                $sendmail = true;
            }
            //leer los metodos y formas de pago
            // $payment_form = 1;
            // if($input['payment']['change_return']['method'] == 'cash')//efectivo
            // {
            //     $payment_form = 1;
            // }else{
            //     $payment_form = 2;//credito
            // }
            $paymentForm = array(
                "duration_measure" => 1,//dias de plazo para pago
                "payment_form_id" => 1,//1 contado 2 credito
                "payment_method_id" => 1,
                "payment_due_date" => $actual_date
            );
            // $previousBalance = "0";
            $legalMonetaryTotals = array(
                "line_extension_amount" => self::round_number($line_extension_amount),
                "tax_exclusive_amount" => self::round_number($tax_exclusive_amount),//
                "tax_inclusive_amount" => self::round_number($tax_inclusive_amount),
                "charge_total_amount" => "0.00",
                // "payable_amount" => $this->round_number($final_total),
                "payable_amount" => self::round_number($tax_inclusive_amount),
                "allowance_total_amount" => "0.00"
            );

        


            // Construcción del JSON dinámicamente
            $data = array(
                "number" => $invoiceNumber,
                "prefix" => $prefix,
                "type_document_id" => $typeDocumentId,
                "discrepancyresponsecode" => $discrepancyResponseCode,
                "discrepancyresponsedescription" => $discrepancyResponseDescription,
                "date" => $date,
                "time" => $time,
                "sendmail" => $sendmail,
                // "resolution_number" => $resolutionNumber,
                "customer" => $customer,
                "payment_form" => $paymentForm,
                // "previous_balance" => $previousBalance,
                "legal_monetary_totals" => $legalMonetaryTotals,
                // "allowance_charges" => $allowanceCharges,
            );

            if (!empty($invoiceLines)) {
                $data["credit_note_lines"] = $invoiceLines;
            }

            if (!empty($tax_total_invoice)) {
                $data["tax_totals"] = $tax_total_invoice;
            }

            // return $data;

            $jsonData = json_encode($data);
            // return $jsonData;
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => env('APP_API_FE').'/api/ubl2.1/credit-note',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $jsonData,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: Bearer '.$business_data->token
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            $respuesta = json_decode($response);

            if(!isset($respuesta->success) || $respuesta->success){
                if(isset($respuesta->ResponseDian))
                {
                    

                    $response_dian =  $respuesta->ResponseDian;
                    $IsValid = $response_dian->Envelope->Body->SendBillSyncResponse->SendBillSyncResult->IsValid;
                    // $ErrorRules = isset($response_dian->Envelope->Body->SendBillSyncResponse->SendBillSyncResult->ErrorMessage)? $response_dian->Envelope->Body->SendBillSyncResponse->SendBillSyncResult->ErrorMessage->string : '';
                    $cufe = $respuesta->cufe;
                    $QRStr = $respuesta->QRStr;
                    $ErrorRules = '';

                    if($IsValid == "true")
                    {
                        //guardamos el cufe de la factura y cambiamos estado de la facturA en el sistema
                        $transaction = Transaction::find($transaction->id);
                        $transaction->cufe = $cufe;
                        $transaction->is_valid = true;
                        $transaction->qrstr = $QRStr;
                        $transaction->save();

                        
                    }else{
                        $ErrorRules = isset($response_dian->Envelope->Body->SendBillSyncResponse->SendBillSyncResult->ErrorMessage)? $response_dian->Envelope->Body->SendBillSyncResponse->SendBillSyncResult->ErrorMessage->string : '';
                    }

                    $output = [
                        'success' => 1, 
                        'msg' => 'Factura aceptada por la DIAN', 
                        'input_curl'=> $data, 
                        'input_factura'=> $input, 
                        'response' => ($respuesta) ? $respuesta : '',  
                        'cufe' => ($cufe) ? $cufe : '',
                        'IsValid' => ($IsValid) ? $IsValid : '',
                        'QRStr' => ($QRStr) ? $QRStr : '',
                        'ErrorMessage' => $ErrorRules
                    ];
                    return $output;
                }else{

                    
                    $output = [
                        'success' => 0, 
                        'msg' => $respuesta->error[0], 
                        'input_curl'=> $data, 
                    ];
                    return $output;
                }
            }else{
                $output = [
                    'success' => 1, 
                    'msg' => $respuesta->message, 
                ];
                return $output;
            }

        }else{


            $output = [
                'success' => 1, 
                'msg' => 'No es una factura electrónica', 
                // 'receipt' => $receipt
            ];
            return $output;
        }

    }
}
