<?php

namespace App\Utils;

use App\Barcode;
use App\Business;
use App\BusinessLocation;
use App\Contact;
use App\Currency;
use App\InvoiceLayout;
use App\InvoiceScheme;
use App\NotificationTemplate;
use App\Printer;
use App\Unit;
use App\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\VariationLocationDetails;

use App\Utils\UnitsUtil;


class BusinessUtil extends Util
{
    /**
     * Adds a default settings/resources for a new business
     *
     * @param  int  $business_id
     * @param  int  $user_id
     * @return bool
     */
    public function newBusinessDefaultResources($business_id, $user_id)
    {
        $user = User::find($user_id);

        //create Admin role and assign to user
        $role = Role::create(['name' => 'Admin#'.$business_id,
            'business_id' => $business_id,
            'guard_name' => 'web', 'is_default' => 1,
        ]);
        $user->assignRole($role->name);

        //Create Cashier role for a new business
        $cashier_role = Role::create(['name' => 'Cashier#'.$business_id,
            'business_id' => $business_id,
            'guard_name' => 'web',
        ]);
        $cashier_role->syncPermissions(['sell.view', 'sell.create', 'sell.update', 'sell.delete', 'access_all_locations', 'view_cash_register', 'close_cash_register']);

        $business = Business::findOrFail($business_id);

        //Update reference count
        $ref_count = $this->setAndGetReferenceCount('contacts', $business_id);
        $contact_id = $this->generateReferenceNumber('contacts', $ref_count, $business_id);

        //Add Default/Walk-In Customer for new business
        $customer = [
            'business_id' => $business_id,
            'type' => 'customer',
            'name' => 'Consumidor Final',
            'created_by' => $user_id,
            'is_default' => 1,
            'contact_id' => 222222222222,
            'email' => 'default@gmail.com',
            'credit_limit' => 0,
        ];
        Contact::create($customer);

        //create default invoice setting for new business
        InvoiceScheme::create(['name' => 'Default',
            'scheme_type' => 'blank',
            'prefix' => 'FV',
            'start_number' => 1,
            'total_digits' => 4,
            'is_default' => 1,
            'business_id' => $business_id,
        ]);
        //create default invoice layour for new business
        InvoiceLayout::create(['name' => 'Default',
            'header_text' => null,
            'invoice_no_prefix' => 'Factura No.',
            'invoice_heading' => 'Factura',
            'sub_total_label' => 'Subtotal',
            'discount_label' => 'Descuento',
            'tax_label' => 'Impuesto',
            'total_label' => 'Total',
            'show_landmark' => 1,
            'show_city' => 1,
            'show_state' => 1,
            'show_zip_code' => 1,
            'show_country' => 1,
            'highlight_color' => '#000000',
            'footer_text' => '',
            'is_default' => 1,
            'business_id' => $business_id,
            'invoice_heading_not_paid' => '',
            'invoice_heading_paid' => '',
            'total_due_label' => 'Total Deuda',
            'paid_label' => 'Total Pagado',
            'show_payments' => 1,
            'show_customer' => 1,
            'customer_label' => 'Cliente',
            'table_product_label' => 'Producto',
            'table_qty_label' => 'Cantidad',
            'table_unit_price_label' => 'Precio Unit',
            'table_subtotal_label' => 'Subtotal',
            'date_label' => 'Fecha',
        ]);


        //Add Default Unit for new business

        $units = [
            [
                'business_id' => $business_id, 'actual_name' => 'Spray pequeño', 'short_name' => 'Sp', 'allow_decimal' => 0, 'code_dian' => "1", 'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Levantar',
                'short_name' => 'Lv',
                'allow_decimal' => 0,
                'code_dian' => "2",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Lote calor',
                'short_name' => 'Lc',
                'allow_decimal' => 0,
                'code_dian' => "3",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Grupo',
                'short_name' => '10',
                'allow_decimal' => 0,
                'code_dian' => "4",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Equipar',
                'short_name' => '11',
                'allow_decimal' => 0,
                'code_dian' => "5",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Ración',
                'short_name' => '13',
                'allow_decimal' => 0,
                'code_dian' => "6",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Disparo',
                'short_name' => '14',
                'allow_decimal' => 0,
                'code_dian' => "7",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Palo',
                'short_name' => '15',
                'allow_decimal' => 0,
                'code_dian' => "8",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Tambor de ciento quince kg',
                'short_name' => '16',
                'allow_decimal' => 0,
                'code_dian' => "9",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Tambor de cien libras',
                'short_name' => '17',
                'allow_decimal' => 0,
                'code_dian' => "10",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Tambor de cincuenta y cinco galones (US)',
                'short_name' => '18',
                'allow_decimal' => 0,
                'code_dian' => "11",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Camión cisterna',
                'short_name' => '19',
                'allow_decimal' => 0,
                'code_dian' => "12",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Contenedor de veinte pies',
                'short_name' => '20',
                'allow_decimal' => 0,
                'code_dian' => "13",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Contenedor de cuarenta pies',
                'short_name' => '21',
                'allow_decimal' => 0,
                'code_dian' => "14",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Decilitro por gramo',
                'short_name' => '22',
                'allow_decimal' => 0,
                'code_dian' => "15",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Gramo por centímetro cúbico',
                'short_name' => '23',
                'allow_decimal' => 0,
                'code_dian' => "16",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'libra teórica',
                'short_name' => '24',
                'allow_decimal' => 0,
                'code_dian' => "17",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'gramo por centímetro cuadrado',
                'short_name' => '25',
                'allow_decimal' => 0,
                'code_dian' => "18",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'tonelada real',
                'short_name' => '26',
                'allow_decimal' => 0,
                'code_dian' => "19",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'tonelada teórica',
                'short_name' => '27',
                'allow_decimal' => 0,
                'code_dian' => "20",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'kilogramo por metro cuadrado',
                'short_name' => '28',
                'allow_decimal' => 0,
                'code_dian' => "21",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'libra por mil pies cuadrados',
                'short_name' => '29',
                'allow_decimal' => 0,
                'code_dian' => "22",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Día de potencia del caballo por tonelada métrica seca al aire',
                'short_name' => '30',
                'allow_decimal' => 0,
                'code_dian' => "23",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'coger peso',
                'short_name' => '31',
                'allow_decimal' => 0,
                'code_dian' => "24",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'kilogramo por aire seco tonelada métrica',
                'short_name' => '32',
                'allow_decimal' => 0,
                'code_dian' => "25",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'kilopascales metros cuadrados por gramo',
                'short_name' => '33',
                'allow_decimal' => 0,
                'code_dian' => "26",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'kilopascales por milímetro',
                'short_name' => '34',
                'allow_decimal' => 0,
                'code_dian' => "27",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'mililitros por centímetro cuadrado segundo',
                'short_name' => '35',
                'allow_decimal' => 0,
                'code_dian' => "28",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'pies cúbicos por minuto por pie cuadrado',
                'short_name' => '36',
                'allow_decimal' => 0,
                'code_dian' => "29",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Onza por pie cuadrado',
                'short_name' => '37',
                'allow_decimal' => 0,
                'code_dian' => "30",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Onzas por pie cuadrado por 0,01 pulgadas',
                'short_name' => '38',
                'allow_decimal' => 0,
                'code_dian' => "31",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Mililitro por segundo',
                'short_name' => '40',
                'allow_decimal' => 0,
                'code_dian' => "32",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Mililitro por minuto',
                'short_name' => '41',
                'allow_decimal' => 0,
                'code_dian' => "33",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Bolsa súper a granel',
                'short_name' => '43',
                'allow_decimal' => 0,
                'code_dian' => "34",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Bolsa a granel de quinientos kg',
                'short_name' => '44',
                'allow_decimal' => 0,
                'code_dian' => "35",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Bolsa a granel de trescientos kg',
                'short_name' => '45',
                'allow_decimal' => 0,
                'code_dian' => "36",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Bolsa a granel de cincuenta libras',
                'short_name' => '46',
                'allow_decimal' => 0,
                'code_dian' => "37",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Bolsa de cincuenta libras',
                'short_name' => '47',
                'allow_decimal' => 0,
                'code_dian' => "38",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Carga de automóviles a granel',
                'short_name' => '48',
                'allow_decimal' => 0,
                'code_dian' => "39",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Kilogramos teóricos',
                'short_name' => '53',
                'allow_decimal' => 0,
                'code_dian' => "40",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Tonelada teórica',
                'short_name' => '54',
                'allow_decimal' => 0,
                'code_dian' => "41",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Sitas',
                'short_name' => '56',
                'allow_decimal' => 0,
                'code_dian' => "42",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Malla',
                'short_name' => '57',
                'allow_decimal' => 0,
                'code_dian' => "43",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Kilogramo neto',
                'short_name' => '58',
                'allow_decimal' => 0,
                'code_dian' => "44",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Parte por millón',
                'short_name' => '59',
                'allow_decimal' => 0,
                'code_dian' => "45",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Porcentaje de peso',
                'short_name' => '60',
                'allow_decimal' => 0,
                'code_dian' => "46",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Parte por billón (US)',
                'short_name' => '61',
                'allow_decimal' => 0,
                'code_dian' => "47",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Porcentaje por 1000 horas',
                'short_name' => '62',
                'allow_decimal' => 0,
                'code_dian' => "48",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Tasa de fracaso en el tiempo',
                'short_name' => '63',
                'allow_decimal' => 0,
                'code_dian' => "49",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Libra por pulgada cuadrada, calibre',
                'short_name' => '64',
                'allow_decimal' => 0,
                'code_dian' => "50",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Oersted',
                'short_name' => '66',
                'allow_decimal' => 0,
                'code_dian' => "51",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Prueba de escala específica',
                'short_name' => '69',
                'allow_decimal' => 0,
                'code_dian' => "52",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Voltio amperio por libra',
                'short_name' => '71',
                'allow_decimal' => 0,
                'code_dian' => "53",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Vatio por libra',
                'short_name' => '72',
                'allow_decimal' => 0,
                'code_dian' => "54",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Amperio tum por centímetro',
                'short_name' => '73',
                'allow_decimal' => 0,
                'code_dian' => "55",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Milipascal',
                'short_name' => '74',
                'allow_decimal' => 0,
                'code_dian' => "56",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Gauss',
                'short_name' => '76',
                'allow_decimal' => 0,
                'code_dian' => "57",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Mili pulgadas',
                'short_name' => '77',
                'allow_decimal' => 0,
                'code_dian' => "58",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Kilogauss',
                'short_name' => '78',
                'allow_decimal' => 0,
                'code_dian' => "59",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Libras por pulgada cuadrada absoluta',
                'short_name' => '80',
                'allow_decimal' => 0,
                'code_dian' => "60",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Enrique',
                'short_name' => '81',
                'allow_decimal' => 0,
                'code_dian' => "61",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Kilopound por pulgada cuadrada',
                'short_name' => '84',
                'allow_decimal' => 0,
                'code_dian' => "62",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Fuerza libra pie',
                'short_name' => '85',
                'allow_decimal' => 0,
                'code_dian' => "63",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Libra por pie cúbico',
                'short_name' => '87',
                'allow_decimal' => 0,
                'code_dian' => "64",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Equilibrio',
                'short_name' => '89',
                'allow_decimal' => 0,
                'code_dian' => "65",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Saybold segundo universal',
                'short_name' => '90',
                'allow_decimal' => 0,
                'code_dian' => "66",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Alimenta',
                'short_name' => '91',
                'allow_decimal' => 0,
                'code_dian' => "67",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Calorías por centímetro cúbico',
                'short_name' => '92',
                'allow_decimal' => 0,
                'code_dian' => "68",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Calorías por gramo',
                'short_name' => '93',
                'allow_decimal' => 0,
                'code_dian' => "69",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Unidad',
                'short_name' => '94',
                'allow_decimal' => 0,
                'code_dian' => "70",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Veinte mil galones (US) de carros',
                'short_name' => '95',
                'allow_decimal' => 0,
                'code_dian' => "71",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Diez mil galones (US) de carros',
                'short_name' => '96',
                'allow_decimal' => 0,
                'code_dian' => "72",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Tambor de diez kg',
                'short_name' => '97',
                'allow_decimal' => 0,
                'code_dian' => "73",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Tambor de quince kg',
                'short_name' => '98',
                'allow_decimal' => 0,
                'code_dian' => "74",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Milla de coche',
                'short_name' => '1A',
                'allow_decimal' => 0,
                'code_dian' => "75",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Recuento de coches',
                'short_name' => '1B',
                'allow_decimal' => 0,
                'code_dian' => "76",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Recuento de locomotoras',
                'short_name' => '1C',
                'allow_decimal' => 0,
                'code_dian' => "77",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Recuento de cabos',
                'short_name' => '1D',
                'allow_decimal' => 0,
                'code_dian' => "78",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Carro vacio',
                'short_name' => '1E',
                'allow_decimal' => 0,
                'code_dian' => "79",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Millas de tren',
                'short_name' => '1F',
                'allow_decimal' => 0,
                'code_dian' => "80",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Uso de combustible galón (US)',
                'short_name' => '1G',
                'allow_decimal' => 0,
                'code_dian' => "81",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Milla del caboose',
                'short_name' => '1H',
                'allow_decimal' => 0,
                'code_dian' => "82",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Tipo de interés fijo',
                'short_name' => '1I',
                'allow_decimal' => 0,
                'code_dian' => "83",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Tonelada milla',
                'short_name' => '1J',
                'allow_decimal' => 0,
                'code_dian' => "84",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Milla locomotora',
                'short_name' => '1K',
                'allow_decimal' => 0,
                'code_dian' => "85",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Recuento total de coches',
                'short_name' => '1L',
                'allow_decimal' => 0,
                'code_dian' => "86",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Milla de coche total',
                'short_name' => '1M',
                'allow_decimal' => 0,
                'code_dian' => "87",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Cuarto de milla',
                'short_name' => '1X',
                'allow_decimal' => 0,
                'code_dian' => "88",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Radianes por segundo',
                'short_name' => '2A',
                'allow_decimal' => 0,
                'code_dian' => "89",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Radianes por segundo al cuadrado',
                'short_name' => '2B',
                'allow_decimal' => 0,
                'code_dian' => "90",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Röntgen',
                'short_name' => '2C',
                'allow_decimal' => 0,
                'code_dian' => "91",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Unidad térmica británica por hora',
                'short_name' => '2I',
                'allow_decimal' => 0,
                'code_dian' => "92",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Centímetro cúbico por segundo',
                'short_name' => '2J',
                'allow_decimal' => 0,
                'code_dian' => "93",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Pie cúbico por hora',
                'short_name' => '2K',
                'allow_decimal' => 0,
                'code_dian' => "94",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Pie cúbico por minuto',
                'short_name' => '2L',
                'allow_decimal' => 0,
                'code_dian' => "95",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Centímetro por segundo',
                'short_name' => '2M',
                'allow_decimal' => 0,
                'code_dian' => "96",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Decibel',
                'short_name' => '2N',
                'allow_decimal' => 0,
                'code_dian' => "97",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Kilobyte',
                'short_name' => '2P',
                'allow_decimal' => 0,
                'code_dian' => "98",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Kilobecquerel',
                'short_name' => '2Q',
                'allow_decimal' => 0,
                'code_dian' => "99",
                'created_by' => $user_id,
            ],
            [
                'business_id' => $business_id,
                'actual_name' => 'Kilocurie',
                'short_name' => '2R',
                'allow_decimal' => 0,
                'code_dian' => "100",
                'created_by' => $user_id,
            ],


            //Galon - 213
            [
                'business_id' => $business_id,
                'actual_name' => 'Galón',
                'short_name' => 'A76',
                'allow_decimal' => 0,
                'code_dian' => "213",
                'created_by' => $user_id,
            ],

            //	botella - 372
            [
                'business_id' => $business_id,
                'actual_name' => 'Botella',
                'short_name' => 'BO',
                'allow_decimal' => 0,
                'code_dian' => "372",
                'created_by' => $user_id,
            ],
            //Caja - 381
            [
                'business_id' => $business_id,
                'actual_name' => 'Caja',
                'short_name' => 'BX',
                'allow_decimal' => 0,
                'code_dian' => "381",
                'created_by' => $user_id,
            ],

            [
                'business_id' => $business_id,
                'actual_name' => 'Centímetro',
                'short_name' => 'CMT',
                'allow_decimal' => 0,
                'code_dian' => "495",
                'created_by' => $user_id,
            ],

            [
                'business_id' => $business_id,
                'actual_name' => 'Libro',
                'short_name' => 'D63',
                'allow_decimal' => 0,
                'code_dian' => "567",
                'created_by' => $user_id,
            ],

            [
                'business_id' => $business_id,
                'actual_name' => 'Tambor',
                'short_name' => 'DR',
                'allow_decimal' => 0,
                'code_dian' => "624",
                'created_by' => $user_id,
            ],

            [
                'business_id' => $business_id,
                'actual_name' => 'Docena',
                'short_name' => 'DZN',
                'allow_decimal' => 0,
                'code_dian' => "636",
                'created_by' => $user_id,
            ],

            [
                'business_id' => $business_id,
                'actual_name' => 'Pulgada',
                'short_name' => 'INH',
                'allow_decimal' => 0,
                'code_dian' => "739",
                'created_by' => $user_id,
            ],

            [
                'business_id' => $business_id,
                'actual_name' => 'Kilogramo',
                'short_name' => 'KGM',
                'allow_decimal' => 0,
                'code_dian' => "767",
                'created_by' => $user_id,
            ],

            [
                'business_id' => $business_id,
                'actual_name' => 'Libra',
                'short_name' => 'LBR',
                'allow_decimal' => 0,
                'code_dian' => "802",
                'created_by' => $user_id,
            ],

            [
                'business_id' => $business_id,
                'actual_name' => 'Litro',
                'short_name' => 'LTR',
                'allow_decimal' => 0,
                'code_dian' => "821",
                'created_by' => $user_id,
            ],

            [
                'business_id' => $business_id,
                'actual_name' => 'Onza',
                'short_name' => 'ONZ',
                'allow_decimal' => 0,
                'code_dian' => "907",
                'created_by' => $user_id,
            ],

            [
                'business_id' => $business_id,
                'actual_name' => 'Saco',
                'short_name' => 'SA',
                'allow_decimal' => 0,
                'code_dian' => "986",
                'created_by' => $user_id,
            ],

            [
                'business_id' => $business_id,
                'actual_name' => 'Barril',
                'short_name' => 'Z3',
                'allow_decimal' => 0,
                'code_dian' => "1087",
                'created_by' => $user_id,
            ],
        ];

        DB::table('units')->insert($units);


        //Create default notification templates
        $notification_templates = NotificationTemplate::defaultNotificationTemplates($business_id);
        foreach ($notification_templates as $notification_template) {
            NotificationTemplate::create($notification_template);
        }

        return true;
    }

    /**
     * Gives a list of all currencies
     *
     * @return array
     */
    public function allCurrencies()
    {
        $currencies = Currency::select('id', DB::raw("concat(country, ' - ',currency, '(', code, ') ') as info"))
                ->orderBy('country')
                ->pluck('info', 'id');

        return $currencies;
    }

    /**
     * Gives a list of all timezone
     *
     * @return array
     */
    public function allTimeZones()
    {
        $datetime = new \DateTimeZone('EDT');

        $timezones = $datetime->listIdentifiers();
        $timezone_list = [];
        foreach ($timezones as $timezone) {
            $timezone_list[$timezone] = $timezone;
        }

        return $timezone_list;
    }

    /**
     * Gives a list of all accouting methods
     *
     * @return array
     */
    public function allAccountingMethods()
    {
        return [
            'fifo' => __('business.fifo'),
            'lifo' => __('business.lifo'),
        ];
    }

    /**
     * Creates new business with default settings.
     *
     * @return array
     */
    public function createNewBusiness($business_details)
    {
        $business_details['sell_price_tax'] = 'includes';

        $business_details['default_profit_percent'] = 25;

        //Add POS shortcuts
        $business_details['keyboard_shortcuts'] = '{"pos":{"express_checkout":"shift+e","pay_n_ckeckout":"shift+p","draft":"shift+d","cancel":"shift+c","edit_discount":"shift+i","edit_order_tax":"shift+t","add_payment_row":"shift+r","finalize_payment":"shift+f","recent_product_quantity":"f2","add_new_product":"f4"}}';

        //Add prefixes
        $business_details['ref_no_prefixes'] = [
            'purchase' => 'PO',
            'stock_transfer' => 'ST',
            'stock_adjustment' => 'SA',
            'sell_return' => 'CN',
            'expense' => 'EP',
            'contacts' => 'CO',
            'purchase_payment' => 'PP',
            'sell_payment' => 'SP',
            'business_location' => 'BL',
        ];

        //Disable inline tax editing
        $business_details['enable_inline_tax'] = 0;

        $business = Business::create_business($business_details);

        return $business;
    }

    /**
     * Gives details for a business
     *
     * @return object
     */
    public function getDetails($business_id)
    {
        $details = Business::leftjoin('tax_rates AS TR', 'business.default_sales_tax', 'TR.id')
                        ->leftjoin('currencies AS cur', 'business.currency_id', 'cur.id')
                        ->leftjoin('type_document_identifications AS tdi', 'business.type_document_identification_id', 'tdi.id')
                        ->leftjoin('type_organizations AS to', 'business.type_organization_id', 'to.id')
                        ->leftjoin('type_regimes AS treg', 'business.type_regime_id', 'treg.id')
                        ->select(
                            'business.*',
                            'tdi.name as type_document',
                            'to.name as type_organization',
                            'treg.name as type_regime',
                            'cur.code as currency_code',
                            'cur.symbol as currency_symbol',
                            'thousand_separator',
                            'decimal_separator',
                            'TR.amount AS tax_calculation_amount',
                            'business.default_sales_discount'
                        )
                        ->where('business.id', $business_id)
                        ->first();

        return $details;
    }

    /**
     * Gives current financial year
     *
     * @return array
     */
    public function getCurrentFinancialYear($business_id)
    {
        $business = Business::where('id', $business_id)->first();
        $start_month = $business->fy_start_month;
        $end_month = $start_month - 1;
        if ($start_month == 1) {
            $end_month = 12;
        }

        $start_year = date('Y');
        //if current month is less than start month change start year to last year
        if (date('n') < $start_month) {
            $start_year = $start_year - 1;
        }

        $end_year = date('Y');
        //if current month is greater than end month change end year to next year
        if (date('n') > $end_month) {
            $end_year = $start_year + 1;
        }
        $start_date = $start_year.'-'.str_pad($start_month, 2, 0, STR_PAD_LEFT).'-01';
        $end_date = $end_year.'-'.str_pad($end_month, 2, 0, STR_PAD_LEFT).'-01';
        $end_date = date('Y-m-t', strtotime($end_date));

        $output = [
            'start' => $start_date,
            'end' => $end_date,
        ];

        return $output;
    }

    /**
     * Adds a new location to a business
     *
     * @param  int  $business_id
     * @param  array  $location_details
     * @param  int  $invoice_layout_id default null
     * @return location object
     */
    public function addLocation($business_id, $location_details, $invoice_scheme_id = null, $invoice_layout_id = null)
    {
        if (empty($invoice_scheme_id)) {
            $layout = InvoiceLayout::where('is_default', 1)
                                    ->where('business_id', $business_id)
                                    ->first();
            $invoice_layout_id = $layout->id;
        }

        if (empty($invoice_scheme_id)) {
            $scheme = InvoiceScheme::where('is_default', 1)
                                    ->where('business_id', $business_id)
                                    ->first();
            $invoice_scheme_id = $scheme->id;
        }

        //Update reference count
        $ref_count = $this->setAndGetReferenceCount('business_location', $business_id);
        $location_id = $this->generateReferenceNumber('business_location', $ref_count, $business_id);

        //Enable all payment methods by default
        $payment_types = $this->payment_types();
        $location_payment_types = [];
        foreach ($payment_types as $key => $value) {
            $location_payment_types[$key] = [
                'is_enabled' => 1,
                'account' => null,
            ];
        }
        $location = BusinessLocation::create(['business_id' => $business_id,
            'name' => $location_details['name'],
            'landmark' => $location_details['landmark'],
            'city' => $location_details['city'],
            'state' => $location_details['state'],
            'zip_code' => $location_details['zip_code'],
            'country' => $location_details['country'],
            'invoice_scheme_id' => $invoice_scheme_id,
            'invoice_layout_id' => $invoice_layout_id,
            'sale_invoice_layout_id' => $invoice_layout_id,
            'mobile' => ! empty($location_details['mobile']) ? $location_details['mobile'] : '',
            'alternate_number' => ! empty($location_details['alternate_number']) ? $location_details['alternate_number'] : '',
            'website' => ! empty($location_details['website']) ? $location_details['website'] : '',
            'email' => '',
            'location_id' => $location_id,
            'default_payment_accounts' => json_encode($location_payment_types),
        ]);

        return $location;
    }

    /**
     * Return the invoice layout details
     *
     * @param  int  $business_id
     * @param  array  $layout_id = null
     * @return location object
     */
    public function invoiceLayout($business_id, $layout_id = null)
    {
        $layout = null;
        if (! empty($layout_id)) {
            $layout = InvoiceLayout::find($layout_id);
        }

        //If layout is not found (deleted) then get the default layout for the business
        if (empty($layout)) {
            $layout = InvoiceLayout::where('business_id', $business_id)
                        ->where('is_default', 1)
                        ->first();
        }
        //$output = []
        return $layout;
    }

    /**
     * Return the printer configuration
     *
     * @param  int  $business_id
     * @param  int  $printer_id
     * @return array
     */
    public function printerConfig($business_id, $printer_id)
    {
        $printer = Printer::where('business_id', $business_id)
                    ->find($printer_id);

        $output = [];

        if (! empty($printer)) {
            $output['connection_type'] = $printer->connection_type;
            $output['capability_profile'] = $printer->capability_profile;
            $output['char_per_line'] = $printer->char_per_line;
            $output['ip_address'] = $printer->ip_address;
            $output['port'] = $printer->port;
            $output['path'] = $printer->path;
            $output['server_url'] = $printer->server_url;
        }

        return $output;
    }

    /**
     * Return the date range for which editing of transaction for a business is allowed.
     *
     * @param  int  $business_id
     * @param  char  $edit_transaction_period
     * @return array
     */
    public function editTransactionDateRange($business_id, $edit_transaction_period)
    {
        if (is_numeric($edit_transaction_period)) {
            return ['start' => \Carbon::today()
                ->subDays($edit_transaction_period),
                'end' => \Carbon::today(),
            ];
        } elseif ($edit_transaction_period == 'fy') {
            //Editing allowed for current financial year
            return $this->getCurrentFinancialYear($business_id);
        }

        return false;
    }

    /**
     * Return the default setting for the pos screen.
     *
     * @return array
     */
    public function defaultPosSettings()
    {
        return ['disable_pay_checkout' => 0, 'disable_draft' => 0, 'disable_express_checkout' => 0, 'hide_product_suggestion' => 0, 'hide_recent_trans' => 0, 'disable_discount' => 0, 'disable_order_tax' => 0, 'is_pos_subtotal_editable' => 0];
    }

    /**
     * Return the default setting for the email.
     *
     * @return array
     */
    public function defaultEmailSettings()
    {
        return ['mail_host' => '', 'mail_port' => '', 'mail_username' => '', 'mail_password' => '', 'mail_encryption' => '', 'mail_from_address' => '', 'mail_from_name' => ''];
    }

    /**
     * Return the default setting for the email.
     *
     * @return array
     */
    public function defaultSmsSettings()
    {
        return ['url' => '', 'send_to_param_name' => 'to', 'msg_param_name' => 'text', 'request_method' => 'post', 'param_1' => '', 'param_val_1' => '', 'param_2' => '', 'param_val_2' => '', 'param_3' => '', 'param_val_3' => '', 'param_4' => '', 'param_val_4' => '', 'param_5' => '', 'param_val_5' => ''];
    }

}
