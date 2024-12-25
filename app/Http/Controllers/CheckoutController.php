<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Product\Cart;
use App\Models\Product\Order;
use App\Models\Product\OrderItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class CheckoutController extends Controller
{

    public function checkout()
    {
        return view('products.checkout');
    }

    public function insertCheckout(Request $request)
    {
        Log::info('Checkout form submitted');
        Log::info('Request data: ', $request->all());

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You need to be logged in to checkout.');
        }

        try {
            $validatedData = $request->validate([
                'firstname' => 'required|string|max:255',
                'lastname' => 'required|string|max:255',
                'country' => 'required|string|max:255',
                'state' => 'nullable|string|max:255',
                'street_address' => 'required|string|max:255',
                'street_address1' => 'nullable|string|max:255',
                'towncity' => 'required|string|max:255',
                'postcodezip' => 'required|string|max:10',
                'phone' => 'required|string|max:20',
                'email' => 'required|email|max:255',
                'paymentMethod' => 'required|string|max:255',
                'paymentGateway' => 'required|string|max:255',
                'total_price' => 'required|numeric',
            ]);

            $sessionPrice = (float) Session::get('price', 0);
            Log::info('Price from session: ' . $sessionPrice);

            if (!is_numeric($sessionPrice) || $sessionPrice <= 0) {
                throw new \Exception('Session price is not valid.');
            }

            $order = new Order();
            $order->firstname = $request->firstname;
            $order->lastname = $request->lastname;
            $order->country = $request->country;
            $order->state = $request->state;
            $order->street_address = $request->street_address;
            $order->street_address1 = $request->street_address1;
            $order->towncity = $request->towncity;
            $order->postcodezip = $request->postcodezip;
            $order->phone = $request->phone;
            $order->email = $request->email;
            $order->paymentMethod = $request->paymentMethod;
            $order->paymentGateway = $request->paymentGateway;
            $order->total_price = $sessionPrice;
            $order->user_id = Auth::id();
            $order->save();

            Log::info('Order placed successfully');

            // Here, proceed to the payment process and handle payment errors
            // Redirect based on selected payment gateway
            switch($order->paymentGateway) {
                case "PayPal":
                    return redirect()->route('payment', ['gateway' => 'paypal'])->with('success', 'Your order has been placed successfully! Proceed to PayPal for payment');
                case "Stripe":
                    return redirect()->route('payment', ['gateway' => 'stripe'])->with('success', 'Your order has been placed successfully! Proceed to Stipe for payment');
                default:
                    return redirect()->route('cart.checkout')->with('error', 'Invalid payment gateway selected.');
            }

            // Example: return redirect()->route('payment')->with('success', 'Your order has been placed successfully!');
            // return redirect()->route('payment')->with('success', 'Your order has been placed successfully! Please make payment to complete your purchase.');
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Error placing order: ' . $e->getMessage(), ['exception' => $e]);

            // Forget the session price and redirect to the cart page with error message
            Session::forget('price');

            // Redirect to checkout error route with the error message in the session
            return redirect()->route('checkout.error')->with('error', 'There was an error placing your order. Please try again.');
        }

    }

    public function payment(Request $request, $gateway)
    {
        switch ($gateway) {
            case 'paypal':
                // Load the PayPal payment page
                return view('products.paypal-payment')->with('success', 'Page updated successfully! Kindly make payment with PayPal.'); // Ensure you have a view for PayPal payment
            case 'stripe':
                // Load the Stripe payment page
                return view('products.stripe-payment')->with('success', 'Page updated successfully! Kindly make payment with Stripe.'); // Ensure you have a view for Stripe payment
            default:
                abort(404); // Payment gateway not found
        }
    }

    public function createPaymentIntent(Request $request)
    {
        try {
            // Set your Stripe secret key
            Stripe::setApiKey(config('services.stripe.secret'));

            // Create the payment intent
            $paymentIntent = PaymentIntent::create([
                'amount' => $request->price * 100, // amount in cents
                'currency' => 'usd',
            ]);

            // Respond with the client secret for further use in JavaScript
            return response()->json([
                'success' => true,
                'clientSecret' => $paymentIntent->client_secret,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function success()
    {
        $user = Auth::user();
        $order = Order::where('user_id', $user->id)->latest()->first();

        // Check if the order exists
        if (!$order) {
            return redirect()->route('home')->with('error', 'Order not found');
        }

        // Begin transaction to handle order items and update total price
        DB::beginTransaction();

        try {
            // Get the cart items
            $cartItems = Cart::where('user_id', $user->id)->get();

            $totalPrice = 0;

            // Loop through each cart item and add them to the order_items table
            foreach ($cartItems as $cartItem) {
                // Create order items based on cart items
                OrderItem::create([
                    'order_id' => $order->id, // Link order item to the order
                    'product_name' => $cartItem->name,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->price,
                    'total_price' => $cartItem->quantity * $cartItem->price,
                ]);

                // Accumulate the total price from cart items
                $totalPrice += $cartItem->quantity * $cartItem->price;
            }

            // Apply the discount
            $discount = 3; // Discount amount
            $totalWithDiscount = $totalPrice - $discount;

            // Update the order with the new total price after discount
            $order->total_price = $totalWithDiscount;
            $order->save();

            // Commit the transaction
            DB::commit();

            // Eager load the orderItems relationship
            $order->load('orderItems');

            // Generate PDF receipt
            $pdf = Pdf::loadView('emails.receipt', compact('order', 'totalWithDiscount'));

            // Send email with PDF receipt
            Mail::send('emails.purchase-confirmation', compact('order', 'totalWithDiscount'), function($message) use ($order, $pdf) {
                $message->to($order->email)
                        ->subject('Order Confirmation from ' . env('APP_FULL_NAME'))
                        ->attachData($pdf->output(), 'receipt.pdf');
            });

            // Clear the cart and session price after purchase
            Cart::where('user_id', $user->id)->delete();
            Session::forget('price');

            return view('products.success')->with('success', 'Order processed successfully! A confirmation email has been sent.');

        } catch (\Exception $e) {
            // Log the error message for debugging
            Log::error('Error processing order: ' . $e->getMessage());

            // Rollback transaction in case of an error
            DB::rollBack();

            // Return the error message
            return redirect()->route('home')->with('error', 'An error occurred while processing your order. Please try again.');
        }
    }

    public function paymentError()
    {
        return view('products.payment-error')->with('error', 'Payment failed. Please try again.');
    }

    public function getStates($country)
    {
        $states = [
            'Afghanistan' => ['Badakhshan', 'Badghis', 'Baghlan', 'Balkh', 'Bamyan', 'Daykundi', 'Farah', 'Faryab', 'Ghazni', 'Ghor'],
            'Albania' => ['Berat', 'Diber', 'Durres', 'Elbasan', 'Shkoder', 'Korçë', 'Vlorë'],
            'Algeria' => ['Adrar', 'Chlef', 'Laghouat', 'Oum El Bouaghi', 'Batna', 'Biskra', 'Béjaïa', 'Blida', 'Bouira', 'Tébessa'],
            'Andorra' => ['Andorra la Vella', 'Escaldes-Engordany', 'Encamp', 'Sant Julià de Lòria', 'Ordino', 'Canillo'],
            'Angola' => ['Bengo', 'Benguela', 'Bié', 'Cabinda', 'Huambo', 'Huíla', 'Kwanza Norte', 'Kwanza Sul', 'Luanda', 'Lunda Norte'],
            'Antigua and Barbuda' => ['Saint George', 'Saint John', 'Saint Mary', 'Saint Paul', 'Saint Peter', 'Saint Philip'],
            'Argentina' => ['Buenos Aires', 'Catamarca', 'Chaco', 'Chubut', 'Córdoba', 'Corrientes', 'Entre Ríos', 'Formosa', 'Jujuy', 'La Pampa'],
            'Armenia' => ['Aragatsotn', 'Ararat', 'Armavir', 'Gegharkunik', 'Kotayk', 'Shirak', 'Syunik', 'Vayots Dzor', 'Yerevan'],
            'Australia' => ['Australian Capital Territory', 'New South Wales', 'Northern Territory', 'Queensland', 'South Australia', 'Tasmania', 'Victoria', 'Western Australia'],
            'Austria' => ['Burgenland', 'Kärnten', 'Niederösterreich', 'Oberösterreich', 'Salzburg', 'Steiermark', 'Tirol', 'Vorarlberg', 'Wien'],
            'Bahamas' => ['New Providence', 'Grand Bahama', 'Abaco', 'Exuma', 'Andros', 'Long Island', 'Cat Island', 'Bimini', 'Inagua', 'Mayaguana'],
            'Bahrain' => ['Capital', 'Muharraq', 'Northern', 'Southern'],
            'Bangladesh' => ['Barishal', 'Chandpur', 'Chattogram', 'Dhaka', 'Khulna', 'Mymensingh', 'Rajshahi', 'Rangpur', 'Sylhet'],
            'Barbados' => ['Christ Church', 'Saint Andrew', 'Saint George', 'Saint James', 'Saint John', 'Saint Joseph', 'Saint Lucy', 'Saint Michael', 'Saint Peter', 'Saint Philip'],
            'Belarus' => ['Brest', 'Gomel', 'Minsk', 'Mogilev', 'Vitebsk'],
            'Belgium' => ['Brussels', 'Flanders', 'Wallonia'],
            'Belize' => ['Belize', 'Cayo', 'Corozal', 'Orange Walk', 'Stann Creek', 'Toledo'],
            'Benin' => ['Alibori', 'Atakora', 'Atlantique', 'Borgou', 'Collines', 'Donga', 'Kouffo', 'Littoral', 'Mono', 'Ouémé', 'Plateau', 'Zou'],
            'Bhutan' => ['Bumthang', 'Chhukha', 'Dagana', 'Gasa', 'Haa', 'Paro', 'Punakha', 'Samdrup Jongkhar', 'Samtse', 'Trashi Yangtse', 'Trashi Yangtse', 'Wangdue Phodrang'],
            'Bolivia' => ['Beni', 'Chuquisaca', 'Cochabamba', 'La Paz', 'Oruro', 'Pando', 'Potosí', 'Santa Cruz', 'Tarija'],
            'Bosnia and Herzegovina' => ['Bosansko-Podrinjski Kanton', 'Federacija Bosne i Hercegovine', 'Hercegovina-Neretva', 'Posavina', 'Sarajevo', 'Tuzla', 'Una-Sana', 'West Herzegovina'],
            'Botswana' => ['Central', 'Ghanzi', 'Kgalagadi', 'Kgatleng', 'Kweneng', 'North East', 'North West', 'Southern', 'South East'],
            'Brazil' => ['Acre', 'Alagoas', 'Amapá', 'Amazonas', 'Bahia', 'Ceará', 'Distrito Federal', 'Espírito Santo', 'Goiás', 'Maranhão'],
            'Brunei' => ['Brunei-Muara', 'Belait', 'Temburong', 'Tutong'],
            'Bulgaria' => ['Blagoevgrad', 'Burgas', 'Dobrich', 'Gabrovo', 'Haskovo', 'Kardzhali', 'Kyustendil', 'Lovech', 'Montana', 'Pazardzhik'],
            'Burkina Faso' => ['Boucle du Mouhoun', 'Cascades', 'Centre', 'Centre-Est', 'Centre-Nord', 'Centre-Ouest', 'Centre-Sud', 'Est', 'Nord', 'Sahel'],
            'Burundi' => ['Bujumbura Mairie', 'Bujumbura Rural', 'Cankuzo', 'Cibitoke', 'Gitega', 'Karuzi', 'Kayanza', 'Kirundo', 'Makamba', 'Muramvya'],
            'Cabo Verde' => ['Boa Vista', 'Brava', 'Maio', 'Praia', 'Sal', 'Santo Antão', 'Santiago', 'São Nicolau', 'São Vicente'],
            'Cambodia' => ['Banteay Meanchey', 'Battambang', 'Kampong Cham', 'Kampong Chhnang', 'Kampong Speu', 'Kampong Thom', 'Kandal', 'Kep', 'Koh Kong', 'Krong'],
            'Cameroon' => ['Adamaoua', 'Centre', 'East', 'Far North', 'Littoral', 'North', 'North West', 'South', 'South West'],
            'Canada' => ['Alberta', 'British Columbia', 'Manitoba', 'New Brunswick', 'Newfoundland and Labrador', 'Northwest Territories', 'Nova Scotia', 'Nunavut', 'Ontario', 'Prince Edward Island'],
            'Central African Republic' => ['Bamingui-Bangoran', 'Bangui', 'Basse-Kotto', 'Haut-Mbomou', 'Haut-Oubangui', 'Kémo', 'Lobaye', 'Mambéré-Kadeï', 'Mbomou', 'Nana-Grébizi'],
            'Chad' => ['Bahr el Ghazal', 'Chari-Baguirmi', 'Guéra', 'Kanem', 'Lac', 'Logone Occidental', 'Logone Oriental', 'Mandoul', 'Mayo-Kebbi Est', 'Mayo-Kebbi Ouest'],
            'Chile' => ['Arica y Parinacota', 'Atacama', 'Antofagasta', 'Coquimbo', 'Valparaíso', 'Metropolitana de Santiago', 'O’Higgins', 'Maule', 'Ñuble', 'Biobío'],
            'China' => ['Anhui', 'Beijing', 'Chongqing', 'Fujian', 'Gansu', 'Guangdong', 'Guangxi', 'Guizhou', 'Hainan', 'Hebei'],
            'Colombia' => ['Amazonas', 'Antioquia', 'Arauca', 'Atlántico', 'Bogotá', 'Bolívar', 'Boyacá', 'Caldas', 'Caquetá', 'Casanare'],
            'Comoros' => ['Anjouan', 'Grand Comore', 'Moheli'],
            'Congo (Congo-Brazzaville)' => ['Bouenza', 'Brazzaville', 'Cuvette', 'Kouilou', 'Lékoumou', 'Likouala', 'Niari', 'Plateaux', 'Pool', 'Sangha'],
            'Costa Rica' => ['Alajuela', 'Cartago', 'Guanacaste', 'Heredia', 'Limón', 'Puntarenas', 'San José'],
            'Croatia' => ['Bjelovar-Bilogora', 'Brod-Posavina', 'City of Zagreb', 'Dubrovnik-Neretva', 'Istria', 'Karlovac', 'Koprivnica-Križevci', 'Krapina-Zagorje', 'Lika-Senj', 'Osijek-Baranja'],
            'Cuba' => ['Pinar del Río', 'Havana', 'Matanzas', 'Villa Clara', 'Cienfuegos', 'Camagüey', 'Las Tunas', 'Holguín', 'Granma', 'Santiago de Cuba'],
            'Cyprus' => ['Famagusta', 'Keryneia', 'Larnaca', 'Limassol', 'Nicosia', 'Paphos'],
            'Czech Republic' => ['Hlavní město Praha', 'Jihočeský kraj', 'Jihomoravský kraj', 'Karlovarský kraj', 'Královéhradecký kraj', 'Liberecký kraj', 'Moravskoslezský kraj', 'Olomoucký kraj', 'Pardubický kraj', 'Plzeňský kraj', 'Středočeský kraj', 'Ústecký kraj', 'Vysočina', 'Zlínský kraj'],
            'Denmark' => ['Capital Region', 'Central Denmark', 'North Denmark', 'Region Zealand', 'Southern Denmark'],
            'Djibouti' => ['Ali Sabieh', 'Arta', 'Dikhil', 'Djibouti', 'Obock', 'Tadjourah'],
            'Dominica' => ['Saint Andrew', 'Saint David', 'Saint George', 'Saint John', 'Saint Joseph', 'Saint Luke', 'Saint Mark', 'Saint Patrick', 'Saint Paul', 'Saint Peter'],
            'Dominican Republic' => ['Azua', 'Bahoruco', 'Barahona', 'Dajabón', 'Distrito Nacional', 'Duarte', 'Elias Piña', 'Elías Piña', 'El Seibo', 'Espaillat', 'Hato Mayor', 'La Altagracia', 'La Romana', 'La Vega', 'María Trinidad Sánchez', 'Monte Cristi', 'Pedernales', 'Peravia', 'Puerto Plata', 'Sánchez Ramírez', 'San Cristóbal', 'San Juan', 'San Pedro de Macorís', 'Santiago', 'Santiago Rodríguez', 'Santo Domingo', 'Valverde'],
            'Ecuador' => ['Azuay', 'Bolívar', 'Cañar', 'Carchi', 'Chimborazo', 'Cotopaxi', 'El Oro', 'Esmeraldas', 'Galápagos', 'Guayas', 'Imbabura', 'Loja', 'Los Ríos', 'Manabí', 'Morona Santiago', 'Napo', 'Orellana', 'Pastaza', 'Pichincha', 'Santa Elena', 'Santo Domingo de los Tsáchilas', 'Sucumbíos', 'Tungurahua', 'Zamora-Chinchipe'],
            'Egypt' => ['Alexandria', 'Aswan', 'Asyut', 'Beheira', 'Beni Suef', 'Cairo', 'Dakahlia', 'Damietta', 'Faiyum', 'Gharbia', 'Giza', 'Ismailia', 'Kafr el-Sheikh', 'Minya', 'Monufia', 'New Valley', 'North Sinai', 'Port Said', 'Qalyubia', 'Qena', 'Red Sea', 'Suez', 'South Sinai'],
            'El Salvador' => ['Ahuachapan', 'Cabañas', 'Chalatenango', 'Cuscatlán', 'La Libertad', 'La Paz', 'La Unión', 'Morazán', 'San Miguel', 'San Salvador', 'San Vicente', 'Santa Ana', 'Sonsonate', 'Usulután'],
            'Equatorial Guinea' => ['Annobón', 'Bioko Norte', 'Bioko Sur', 'Centro Sur', 'Kié-Ntem', 'Litoral', 'Wele-Nzas'],
            'Eritrea' => ['Anseba', 'Debub', 'Debubawi Keyih Bahri', 'Gash-Barka', 'Maekel', 'Southern Red Sea'],
            'Estonia' => ['Harju', 'Hiiu', 'Ida-Viru', 'Jõgeva', 'Järva', 'Lääne', 'Lääne-Viru', 'Põlva', 'Pärnu', 'Rapla', 'Saare', 'Tartu', 'Valga', 'Viljandi', 'Võru'],
            'Eswatini' => ['Hhohho', 'Lubombo', 'Manzini', 'Shiselweni'],
            'Ethiopia' => ['Addis Ababa', 'Afar', 'Amhara', 'Benishangul-Gumuz', 'Dire Dawa', 'Gambela', 'Harari', 'Oromia', 'Sidama', 'Somali', 'South West Ethiopia', 'Southern Nations, Nationalities, and Peoples', 'Tigray'],
            'Fiji' => ['Central', 'Eastern', 'Northern', 'Western'],
            'Finland' => ['Åland', 'Etelä-Karjala', 'Etelä-Pohjanmaa', 'Etelä-Savo', 'Kainuu', 'Kanta-Häme', 'Kymenlaakso', 'Lappi', 'Länsi-Uusimaa', 'Ostrobothnia', 'Päijät-Häme', 'Pirkanmaa', 'Satakunta', 'Uusimaa', 'Varsinais-Suomi'],
            'France' => ['Auvergne-Rhône-Alpes', 'Bourgogne-Franche-Comté', 'Brittany', 'Centre-Val de Loire', 'Corsica', 'Grand Est', 'Hauts-de-France', 'Île-de-France', 'Normandy', 'Nouvelle-Aquitaine', 'Occitanie', 'Pays de la Loire', 'Provence-Alpes-Côte d\'Azur'],
            'Gabon' => ['Estuaire', 'Haut-Ogooué', 'Moyen-Ogooué', 'Ngounié', 'Ogooué-Ivindo', 'Ogooué-Lolo', 'Ogooué-Maritime', 'Woleu-Ntem'],
            'Gambia' => ['Banjul', 'Basse', 'Brikama', 'Kanifing', 'Kerewan', 'Mansakonko', 'Western'],
            'Georgia' => ['Abkhazia', 'Adjara', 'Guria', 'Imereti', 'Kakheti', 'Kvemo Kartli', 'Mtskheta-Mtianeti', 'Racha-Lechkhumi and Kvemo Svaneti', 'Samegrelo-Zemo Svaneti', 'Shida Kartli', 'Tbilisi'],
            'Germany' => ['Baden-Württemberg', 'Bavaria', 'Berlin', 'Brandenburg', 'Bremen', 'Hamburg', 'Hesse', 'Lower Saxony', 'Mecklenburg-Vorpommern', 'North Rhine-Westphalia', 'Rhineland-Palatinate', 'Saarland', 'Saxony', 'Saxony-Anhalt', 'Schleswig-Holstein', 'Thuringia'],
            'Ghana' => ['Ashanti', 'Brong-Ahafo', 'Central', 'Eastern', 'Greater Accra', 'Northern', 'Western', 'Western North', 'Upper East', 'Upper West'],
            'Greece' => ['Attica', 'Central Greece', 'Central Macedonia', 'Crete', 'Eastern Macedonia and Thrace', 'Ionian Islands', 'Northern Aegean', 'Peloponnese', 'Southern Aegean', 'Western Greece', 'Western Macedonia'],
            'Grenada' => ['Saint Andrew', 'Saint David', 'Saint George', 'Saint John', 'Saint Mark', 'Saint Patrick'],
            'Guatemala' => ['Alta Verapaz', 'Baja Verapaz', 'Chimaltenango', 'Chiquimula', 'El Progreso', 'Escuintla', 'Guatemala', 'Huehuetenango', 'Izabal', 'Jalapa', 'Jutiapa', 'Petén', 'Quetzaltenango', 'Quiché', 'San Marcos', 'Santa Rosa', 'Solalá', 'Suchitepéquez', 'Totonicapán', 'Zacapa'],
            'Guinea' => ['Beyla', 'Boffa', 'Boké', 'Conakry', 'Faranah', 'Kankan', 'Kissidougou', 'Labé', 'Labe', 'Mamou', 'Nzérékoré'],
            'Guinea-Bissau' => ['Bafata', 'Biombo', 'Bissau', 'Bolama', 'Cacheu', 'Gabu', 'Oio', 'Tombali'],
            'Guyana' => ['Barima-Waini', 'Cuyuni-Mazaruni', 'Demerara-Mahaica', 'East Berbice-Corentyne', 'Essequibo Islands-West Demerara', 'Mahaica-Berbice', 'Pomeroon-Supenaam', 'Upper Demerara-Berbice'],
            'Haiti' => ['Artibonite', 'Centre', 'Grand\'Anse', 'Nippes', 'Nord', 'Nord-Est', 'Nord-Ouest', 'Ouest', 'Sud', 'Sud-Est'],
            'Honduras' => ['Atlántida', 'Choluteca', 'Colón', 'Comayagua', 'Copán', 'Cortes', 'Gracias a Dios', 'Islas de la Bahía', 'La Paz', 'Lempira', 'Ocotepeque', 'Santa Bárbara', 'Valle', 'Yoro'],
            'Hungary' => ['Bács-Kiskun', 'Békés', 'Borsod-Abaúj-Zemplén', 'Budapest', 'Csongrád', 'Fejér', 'Győr-Moson-Sopron', 'Hajdú-Bihar', 'Heves', 'Jász-Nagykun-Szolnok', 'Komárom-Esztergom', 'Nógrád', 'Pest', 'Somogy', 'Szabolcs-Szatmár-Bereg', 'Tolna', 'Vas', 'Veszprém', 'Zala'],
            'Iceland' => ['Capital Region', 'Eastfjords', 'Northeast', 'Northwest', 'South', 'Westfjords', 'West'],
            'India' => ['Andaman and Nicobar Islands', 'Andhra Pradesh', 'Arunachal Pradesh', 'Assam', 'Bihar', 'Chandigarh', 'Chhattisgarh', 'Dadra and Nagar Haveli and Daman and Diu', 'Delhi', 'Goa', 'Gujarat', 'Haryana', 'Himachal Pradesh', 'Jammu and Kashmir', 'Jharkhand', 'Karnataka', 'Kerala', 'Ladakh', 'Lakshadweep', 'Madhya Pradesh', 'Maharashtra', 'Manipur', 'Meghalaya', 'Mizoram', 'Nagaland', 'Odisha', 'Puducherry', 'Punjab', 'Rajasthan', 'Sikkim', 'Tamil Nadu', 'Telangana', 'Tripura', 'Uttar Pradesh', 'Uttarakhand', 'West Bengal'],
            'Indonesia' => ['Bali', 'Banten', 'Bengkulu', 'Gorontalo', 'Jakarta', 'Jambi', 'Jawa Barat', 'Jawa Tengah', 'Jawa Timur', 'Kalimantan Barat', 'Kalimantan Selatan', 'Kalimantan Tengah', 'Kalimantan Timur', 'Kalimantan Utara', 'Kepulauan Bangka Belitung', 'Kepulauan Riau', 'Lampung', 'Maluku', 'Maluku Utara', 'Nusa Tenggara Barat', 'Nusa Tenggara Timur', 'Papua', 'Papua Barat', 'Riau', 'Sulawesi Barat', 'Sulawesi Selatan', 'Sulawesi Tengah', 'Sulawesi Tenggara', 'Sulawesi Utara', 'Sumatera Barat', 'Sumatera Selatan', 'Sumatera Utara'],
            'Iran' => ['Alborz', 'Ardabil', 'Bushehr', 'Chahar Mahal and Bakhtiari', 'Fars', 'Gilan', 'Golestan', 'Hamadan', 'Hormozgan', 'Ilam', 'Isfahan', 'Kerman', 'Kermanshah', 'Khuzestan', 'Kohgiluyeh and Boyer-Ahmad', 'Kurdistan', 'Lorestan', 'Markazi', 'Mazandaran', 'North Khorasan', 'Qazvin', 'Qom', 'Razavi Khorasan', 'Semnan', 'Sistan and Baluchestan', 'South Khorasan', 'Tehran', 'Yazd', 'Zanjan'],
            'Iraq' => ['Anbar', 'Baghdad', 'Basra', 'Dhi Qar', 'Diyala', 'Erbil', 'Karbala', 'Kirkuk', 'Muthanna', 'Najaf', 'Nineveh', 'Qadisiyyah', 'Salah ad-Din', 'Sulaymaniyah', 'Wasit'],
            'Ireland' => ['Carlow', 'Cavan', 'Clare', 'Cork', 'Donegal', 'Dublin', 'Galway', 'Kerry', 'Kildare', 'Kilkenny', 'Laois', 'Leitrim', 'Limerick', 'Longford', 'Louth', 'Mayo', 'Meath', 'Monaghan', 'Offaly', 'Roscommon', 'Sligo', 'Tipperary', 'Waterford', 'Westmeath', 'Wexford', 'Wicklow'],
            'Israel' => ['Central District', 'Haifa', 'Jerusalem District', 'Northern District', 'Southern District', 'Tel Aviv District'],
            'Italy' => ['Abruzzo', 'Basilicata', 'Calabria', 'Campania', 'Emilia-Romagna', 'Friuli Venezia Giulia', 'Lazio', 'Liguria', 'Lombardy', 'Marche', 'Molise', 'Piedmont', 'Puglia', 'Sardinia', 'Sicily', 'Tuscany', 'Trentino-Alto Adige', 'Umbria', 'Aosta Valley', 'Veneto'],
            'Jamaica' => ['Clarendon', 'Hanover', 'Kingston', 'Manchester', 'Portland', 'Saint Andrew', 'Saint Ann', 'Saint Catherine', 'Saint Elizabeth', 'Saint James', 'Saint Mary', 'Saint Thomas', 'Westmoreland'],
            'Japan' => ['Aichi', 'Akita', 'Aomori', 'Chiba', 'Ehime', 'Fukui', 'Fukuoka', 'Fukushima', 'Gifu', 'Gunma', 'Hiroshima', 'Hokkaido', 'Hyogo', 'Ibaraki', 'Ishikawa', 'Ishikawa', 'Kagawa', 'Kagoshima', 'Kanagawa', 'Kochi', 'Kumamoto', 'Kyoto', 'Mie', 'Miyagi', 'Miyazaki', 'Nagano', 'Nagasaki', 'Nagasaki', 'Nara', 'Niigata', 'Oita', 'Okayama', 'Osaka', 'Okinawa', 'Shiga', 'Shimane', 'Shizuoka', 'Tochigi', 'Tokushima', 'Tokyo', 'Tottori', 'Toyama', 'Wakayama', 'Yamagata', 'Yamaguchi', 'Yamanashi'],
            'Jordan' => ['Ajloun', 'Amman', 'Irbid', 'Jerash', 'Karak', 'Madaba', 'Mafraq', 'Tafilah', 'Zarqa'],
            'Kazakhstan' => ['Akmola', 'Aktobe', 'Almaty', 'Atyrau', 'East Kazakhstan', 'Karaganda', 'Kostanay', 'Kyzylorda', 'Mangystau', 'North Kazakhstan', 'Pavlodar', 'West Kazakhstan', 'Zhambyl'],
            'Kenya' => ['Bomet', 'Bungoma', 'Busia', 'Elgeyo-Marakwet', 'Embu', 'Garissa', 'Homa Bay', 'Isiolo', 'Kajiado', 'Kakamega', 'Kericho', 'Kerugoya', 'Kisii', 'Kisumu', 'Kitui', 'Kwale', 'Laikipia', 'Lamu', 'Machakos', 'Makueni', 'Mandera', 'Marsabit', 'Meru', 'Migori', 'Mombasa', 'Mont Kenya', 'Nairobi', 'Nakuru', 'Nandi', 'Narok', 'Narok', 'Nyamira', 'Nyandarua', 'Nyeri', 'Samburu', 'Siaya', 'Taita-Taveta', 'Tana River', 'Tharaka-Nithi', 'Trans-Nzoia', 'Turkana', 'Uasin Gishu', 'Vihiga', 'Wajir', 'West Pokot', 'Kericho'],
            'Kiribati' => ['Banaba', 'Gilbert Islands', 'Kiritimati', 'Line Islands', 'Phoenix Islands'],
            'South Korea' => [
                'Gyeonggi-do', 'Gangwon-do', 'Chungcheongbuk-do', 'Chungcheongnam-do', 'Jeollabuk-do', 'Jeollanam-do',
                'Gyeongsangbuk-do', 'Gyeongsangnam-do', 'Jeju-do', 'Seoul', 'Busan', 'Daegu', 'Incheon', 'Gwangju',
                'Daejeon', 'Sejong'
            ],
            'North Korea' => [
                'Pyonganbuk-do', 'Pyongannam-do', 'Hwanghaebuk-do', 'Hwanghaenam-do', 'Pyongyang', 'Kaesong', 'Rason'
            ],
            'Kuwait' => ['Al Ahmadi', 'Al Farwaniyah', 'Al Jahra', 'Hawalli', 'Kuwait City', 'Mubarak Al Kabeer'],
            'Kyrgyzstan' => ['Bishkek', 'Chui', 'Jalal-Abad', 'Naryn', 'Osh', 'Talas', 'Ysyk-Köl'],
            'Laos' => ['Attapeu', 'Bokeo', 'Bolikhamsai', 'Champasak', 'Houaphanh', 'Khammouane', 'Luang Namtha', 'Luang Prabang', 'Oudomxay', 'Phongsaly', 'Salavan', 'Savannakhet', 'Vientiane', 'Vientiane Prefecture', 'Xayaburi', 'Xaignabouli', 'Xekong', 'Xieng Khouang'],
            'Latvia' => ['Aizkraukle', 'Alūksne', 'Balvi', 'Bauska', 'Cēsis', 'Daugavpils', 'Dobele', 'Jelgava', 'Jūrmala', 'Kuldīga', 'Liepāja', 'Riga', 'Rīgas Rajons', 'Rundāle', 'Saldus', 'Valka', 'Valmiera', 'Ventspils'],
            'Lebanon' => ['Beirut', 'Bekaa', 'Mount Lebanon', 'Nabatieh', 'North Lebanon', 'South Lebanon'],
            'Lesotho' => ['Berea', 'Butha-Buthe', 'Leribe', 'Mafeteng', 'Maseru', 'Mohale\'s Hoek', 'Mokhotlong', 'Qacha\'s Nek', 'Quthing', 'Thaba-Tseka'],
            'Liberia' => ['Bong', 'Bomi', 'Bong', 'Gbarpolu', 'Grand Bassa', 'Grand Cape Mount', 'Grand Gedeh', 'Grand Kru', 'Lofa', 'Margibi', 'Maryland', 'Montserrado', 'Nimba', 'Rivercess', 'River Gee', 'Sinoe'],
            'Libya' => ['Ajdabiya', 'Al Aziziyah', 'Al Bayda', 'Al Jabal al Akhdar', 'Al Jufra', 'Al Khums', 'Al Marj', 'Al Mizdah', 'Al Wahat', 'An Nawfaliyah', 'Banghazi', 'Derna', 'Jabal al Gharbi', 'Misrata', 'Murzuq', 'Sabha', 'Surt', 'Tripoli', 'Wadi al Hayat', 'Wadi al Shatii'],
            'Liechtenstein' => ['Eschen', 'Gamprin', 'Mauren', 'Nendeln', 'Schaan', 'Schellenberg', 'Balzers', 'Planken', 'Ruggell', 'Sankt Gallen', 'Vaduz'],
            'Lithuania' => ['Alytus', 'Kaunas', 'Klaipeda', 'Marijampole', 'Panevėžys', 'Šiauliai', 'Vilnius'],
            'Luxembourg' => ['Diekirch', 'Grevenmacher', 'Luxembourg City', 'Mersch', 'Remich'],
            'Madagascar' => ['Antananarivo', 'Antananarivo-Avaradrano', 'Antsiranana', 'Fianarantsoa', 'Mahajanga', 'Toamasina', 'Toliara'],
            'Malawi' => ['Balaka', 'Blantyre', 'Chikwawa', 'Chiradzulu', 'Chitipa', 'Dowa', 'Karonga', 'Kasungu', 'Lilongwe', 'Machinga', 'Malawi', 'Mchinji', 'Mulanje', 'Mwanza', 'Mzimba', 'Mzuzu', 'Nkhata Bay', 'Nkhotakota', 'Ntcheu', 'Ntchisi', 'Phalombe', 'Rumphi', 'Salima', 'Thyolo', 'Zomba'],
            'Malaysia' => ['Johor', 'Kedah', 'Kelantan', 'Kuala Lumpur', 'Labuan', 'Malacca', 'Negeri Sembilan', 'Pahang', 'Penang', 'Perak', 'Perlis', 'Putrajaya', 'Sabah', 'Sarawak', 'Selangor', 'Terengganu'],
            'Malta' => ['Gozo and Comino', 'Malta'],
            'Marshall Islands' => ['Ailuk', 'Aur', 'Ebon', 'Enewetak', 'Jabat', 'Jaluit', 'Kili', 'Kwajalein', 'Lae', 'Majuro', 'Maloelap', 'Maloelap Atoll', 'Mili', 'Namorik', 'Rongelap', 'Takae', 'Wotho', 'Wotje'],
            'Mauritania' => ['Adrar', 'Assaba', 'Brakna', 'Gorgol', 'Guidimaka', 'Hodh Ech Chargui', 'Hodh El Gharbi', 'Inchiri', 'Nouakchott', 'Nouadhibou', 'Tagant', 'Tiris Zemmour', 'Trarza'],
            'Mauritius' => ['Black River', 'Flacq', 'Grand Port', 'Moka', 'Pamplemousses', 'Plaines Wilhems', 'Port Louis', 'Rivière du Rempart', 'Rodrigues'],
            'Mexico' => ['Aguascalientes', 'Baja California', 'Baja California Sur', 'Campeche', 'Chiapas', 'Chihuahua', 'Coahuila', 'Colima', 'Durango', 'Guanajuato', 'Guerrero', 'Hidalgo', 'Jalisco', 'Mexico', 'Mexico City', 'Michoacán', 'Morelos', 'Nayarit', 'Nuevo León', 'Oaxaca', 'Puebla', 'Querétaro', 'Quintana Roo', 'San Luis Potosí', 'Sinaloa', 'Sonora', 'Tabasco', 'Tamaulipas', 'Tlaxcala', 'Veracruz', 'Yucatán', 'Zacatecas'],
            'Micronesia' => ['Chuuk', 'Kosrae', 'Pohnpei', 'Yap'],
            'Moldova' => ['Bălți', 'Bender', 'Cahul', 'Chișinău', 'Edineț', 'Hîncești', 'Orhei', 'Soroca', 'Taraclia', 'Ungheni'],
            'Monaco' => ['Monaco'],
            'Mongolia' => ['Arkhangai', 'Bayankhongor', 'Bulgan', 'Darkhan-Uul', 'Dornod', 'Dornogovi', 'Dovd', 'Govisümber', 'Khentii', 'Khovd', 'Övörkhangai', 'Selenge', 'Sukhbaatar', 'Töv', 'Ulaanbaatar', 'Uvs', 'Zavkhan'],
            'Montenegro' => ['Andrijevica', 'Bar', 'Bijelo Polje', 'Biljane', 'Budva', 'Cetinje', 'Herceg Novi', 'Kolašin', 'Kotor', 'Nikšić', 'Pljevlja', 'Plužine', 'Rožaje', 'Tivat', 'Žabljak'],
            'Morocco' => ['Azilal', 'Béni Mellal', 'Casablanca', 'Chaouia-Ouardigha', 'Draa-Tafilalet', 'Fès-Boulemane', 'Gharb-Chrarda-Beni Hssen', 'Guelmim-Es Semara', 'Grand Casablanca', 'Kenitra', 'Marrakech-Tensift-Al Haouz', 'Meknes-Tafilalet', 'Ouarzazate', 'Oued Ed-Dahab-Lago', 'Rabat-Salé-Zemmour-Zaer', 'Souss-Massa-Draâ', 'Tangier-Tetouan'],
            'Mozambique' => ['Cabo Delgado', 'Gaza', 'Inhambane', 'Manica', 'Maputo', 'Maputo City', 'Nampula', 'Niassa', 'Sofala', 'Tete', 'Zambezia'],
            'Myanmar' => ['Chin', 'Kachin', 'Kayah', 'Kayin', 'Magway', 'Mandalay', 'Mon', 'Rakhine', 'Sagaing', 'Shan', 'Yangon'],
            'Namibia' => ['Caprivi', 'Erongo', 'Hardap', 'Karas', 'Kavango', 'Khomas', 'Omaheke', 'Omusati', 'Oshana', 'Oshikoto', 'Otjozondjupa'],
            'Nauru' => ['Aiwo', 'Anabar', 'Anetan', 'Anibare', 'Boe', 'Buada', 'Denigomodu', 'Ewa', 'Ijuw', 'Meneng', 'Nauru', 'Uaboe', 'Yaren'],
            'Nepal' => ['Bagmati', 'Bheri', 'Chandrapur', 'Dhawalagiri', 'Gandaki', 'Karnali', 'Kosi', 'Lumbini', 'Mahakali', 'Mechi', 'Narayani', 'Rapti', 'Sagarmatha', 'Seti'],
            'Netherlands' => ['Drenthe', 'Flevoland', 'Friesland', 'Gelderland', 'Groningen', 'Limburg', 'North Brabant', 'North Holland', 'Overijssel', 'South Holland', 'Utrecht', 'Zeeland'],
            'New Zealand' => ['Auckland', 'Bay of Plenty', 'Canterbury', 'Gisborne', 'Hawke\'s Bay', 'Manawatu-Wanganui', 'Marlborough', 'Nelson', 'Northland', 'Otago', 'Southland', 'Taranaki', 'Tasman', 'Wellington'],
            'Nicaragua' => ['Boaco', 'Carazo', 'Chinandega', 'Chontales', 'Granada', 'Jinotega', 'León', 'Madriz', 'Managua', 'Masaya', 'Matagalpa', 'Nueva Segovia', 'Rivas'],
            'Niger' => ['Agadez', 'Diffa', 'Dosso', 'Maradi', 'Niamey', 'Tahoua', 'Tillabéri', 'Zinder'],
            'Nigeria' => ['Abia', 'Adamawa', 'Akwa Ibom', 'Anambra', 'Bauchi', 'Bayelsa', 'Benue', 'Borno', 'Cross River', 'Delta', 'Ebonyi', 'Edo', 'Ekiti', 'Enugu', 'Gombe', 'Imo', 'Jigawa', 'Kaduna', 'Kano', 'Kogi', 'Kwara', 'Lagos', 'Nasarawa', 'Niger', 'Ogun', 'Ondo', 'Osun', 'Oyo', 'Plateau', 'Rivers', 'Sokoto', 'Taraba', 'Yobe', 'Zamfara'],
            'North Korea' => ['Chagang', 'Hamgyong', 'Hwanghae', 'Kangwon', 'Pyongan', 'Ryanggang', 'Nampo', 'Pyongyang'],
            'North Macedonia' => ['Bitola', 'Kumanovo', 'Ohrid', 'Prilep', 'Skopje', 'Tetovo', 'Veles'],
            'Norway' => ['Akershus', 'Aust-Agder', 'Buskerud', 'Finnmark', 'Hedmark', 'Hedmark', 'Hedmark', 'Hedmark', 'Hedmark', 'Hedmark', 'Hedmark', 'Hedmark', 'Hedmark', 'Hedmark', 'Hedmark', 'Hedmark', 'Hedmark', 'Hedmark', 'Hedmark', 'Hedmark', 'Hedmark', 'Hedmark', 'Hedmark', 'Hedmark', 'Hedmark', 'Hedmark', 'Hedmark', 'Hedmark', 'Hedmark', 'Hedmark', 'Hedmark', 'Hedmark', 'Hedmark', 'Hedmark', 'Hedmark', 'Hedmark', 'Hedmark', 'Hedmark', 'Hedmark'],
            'Oman' => ['Ad Dakhiliyah', 'Adh Dhahirah', 'Al Buraimi', 'Al Wusta', 'Ash Sharqiyah', 'Muscat', 'Musandam'],
            'Pakistan' => ['Azad Kashmir', 'Balochistan', 'Federally Administered Tribal Areas', 'Gilgit-Baltistan', 'Khyber Pakhtunkhwa', 'Punjab', 'Sindh'],
            'Palau' => ['Aimeliik', 'Airai', 'Angaur', 'Hatohobei', 'Kayangel', 'Koror', 'Peleliu', 'Sonsorol'],
            'Panama' => ['Bocas del Toro', 'Chiriquí', 'Colón', 'Darién', 'Herrera', 'Los Santos', 'Panamá', 'Panamá Oeste', 'Veraguas'],
            'Papua New Guinea' => ['Central', 'Chimbu', 'Eastern Highlands', 'East New Britain', 'East Sepik', 'Enga', 'Gulf', 'Hela', 'Jiwaka', 'Madang', 'Manus', 'Milne Bay', 'Morobe', 'National Capital District', 'Northern', 'Southern Highlands', 'Western', 'Western Highlands'],
            'Paraguay' => ['Alto Paraná', 'Alto Paraguay', 'Boquerón', 'Caaguazú', 'Caazapá', 'Canindeyú', 'Central', 'Concepción', 'Cordillera', 'Guairá', 'Itapúa', 'Misiones', 'Ñeembucú', 'Paraguarí', 'Presidente Hayes', 'San Pedro'],
            'Peru' => ['Amazonas', 'Áncash', 'Apurímac', 'Arequipa', 'Ayacucho', 'Cajamarca', 'Callao', 'Cusco', 'Huancavelica', 'Huánuco', 'Ica', 'Junín', 'La Libertad', 'Lambayeque', 'Lima', 'Loreto', 'Madre de Dios', 'Moquegua', 'Pasco', 'Piura', 'Puno', 'San Martín', 'Tacna', 'Tumbes', 'Ucayali'],
            'Philippines' => ['Abra', 'Agusan del Norte', 'Agusan del Sur', 'Aklan', 'Albay', 'Antique', 'Apayao', 'Aurora', 'Batangas', 'Benguet', 'Bohol', 'Bukidnon', 'Bulacan', 'Cagayan', 'Camarines Norte', 'Camarines Sur', 'Camiguin', 'Capiz', 'Catanduanes', 'Cavite', 'Cebu', 'City of Manila', 'Davao del Norte', 'Davao del Sur', 'Davao Occidental', 'Davao Oriental', 'Eastern Samar', 'Guimaras', 'Ifugao', 'Ilocos Norte', 'Ilocos Sur', 'Iloilo', 'Isabela', 'Kalinga', 'La Union', 'Laguna', 'Lanao del Norte', 'Lanao del Sur', 'Leyte', 'Maguindanao', 'Marinduque', 'Masbate', 'Metro Manila', 'Misamis Occidental', 'Misamis Oriental', 'Mountain Province', 'Negros Occidental', 'Negros Oriental', 'Northern Samar', 'Nueva Ecija', 'Nueva Vizcaya', 'Palawan', 'Pampanga', 'Pangasinan', 'Quezon', 'Quirino', 'Rizal', 'Romblon', 'Samar', 'Sarangani', 'Siquijor', 'Sorsogon', 'South Cotabato', 'Southern Leyte', 'Sultan Kudarat', 'Sulu', 'Surigao del Norte', 'Surigao del Sur', 'Tarlac', 'Tawi-Tawi', 'Zambales', 'Zamboanga del Norte', 'Zamboanga del Sur', 'Zamboanga Sibugay'],
            'Poland' => ['Greater Poland', 'Kuyavian-Pomeranian', 'Lesser Poland', 'Lubusz', 'Łódź', 'Lower Silesian', 'Masovian', 'Opole', 'Podlaskie', 'Pomeranian', 'Silesian', 'Świętokrzyskie', 'Warmian-Masurian', 'West Pomeranian'],
            'Portugal' => ['Aveiro', 'Beja', 'Braga', 'Bragança', 'Castelo Branco', 'Coimbra', 'Évora', 'Funchal', 'Lisbon', 'Portalegre', 'Porto', 'Santarém', 'Setúbal', 'Viana do Castelo', 'Vila Real', 'Viseu'],
            'Qatar' => ['Ad Dawhah', 'Al Khawr', 'Al Rayyan', 'Al Wakrah', 'Umm Salal'],
            'Romania' => ['Bacău', 'Bihor', 'Bistrița-Năsăud', 'Botoșani', 'Brașov', 'Brăila', 'Buzău', 'Călărași', 'Cluj', 'Constanța', 'Covasna', 'Dâmbovița', 'Dolj', 'Gorj', 'Harghita', 'Hunedoara', 'Ialomița', 'Iași', 'Ilfov', 'Maramureș', 'Mehedinți', 'Mureș', 'Neamț', 'Olt', 'Prahova', 'Sălaj', 'Satu Mare', 'Sibiu', 'Suceava', 'Teleorman', 'Timiș', 'Tulcea', 'Vâlcea', 'Vaslui', 'Vrancea'],
            'Russia' => ['Altai Krai', 'Altai Republic', 'Amur Oblast', 'Arkhangelsk Oblast', 'Astrakhan Oblast', 'Buryatia', 'Chechen Republic', 'Chelyabinsk Oblast', 'Chukchi Autonomous Okrug', 'Chuvash Republic', 'Dagestan', 'Ingushetia', 'Irkutsk Oblast', 'Ivanovo Oblast', 'Jewish Autonomous Oblast', 'Kabardino-Balkaria', 'Kaliningrad Oblast', 'Kaluga Oblast', 'Kamchatka Krai', 'Karachay-Cherkessia', 'Karelia', 'Kemerovo Oblast', 'Khabarovsk Krai', 'Khakassia', 'Khanty-Mansi Autonomous Okrug', 'Kirov Oblast', 'Kostroma Oblast', 'Krasnodar Krai', 'Krasnoyarsk Krai', 'Kurgan Oblast', 'Kursk Oblast', 'Leningrad Oblast', 'Lipetsk Oblast', 'Moscow', 'Moscow Oblast', 'Murmansk Oblast', 'Nizhny Novgorod Oblast', 'North Ossetia-Alania', 'Novgorod Oblast', 'Novosibirsk Oblast', 'Omsk Oblast', 'Orel Oblast', 'Orenburg Oblast', 'Penza Oblast', 'Perm Krai', 'Primorsky Krai', 'Pskov Oblast', 'Rostov Oblast', 'Ryazan Oblast', 'Saint Petersburg', 'Sakha Republic', 'Sakhalin Oblast', 'Samara Oblast', 'Saratov Oblast', 'Smolensk Oblast', 'Stavropol Krai', 'Sverdlovsk Oblast', 'Tambov Oblast', 'Tatarstan', 'Tula Oblast', 'Tver Oblast', 'Tomsk Oblast', 'Tula Oblast', 'Tuva Republic', 'Udmurt Republic', 'Ulyanovsk Oblast', 'Vladimir Oblast', 'Volgograd Oblast', 'Vologda Oblast', 'Voronezh Oblast', 'Yamalo-Nenets Autonomous Okrug', 'Yaroslavl Oblast', 'Yevreyskaya Autonomous Oblast', 'Zabaykalsky Krai'],
            'Rwanda' => ['East Province', 'Kigali', 'North Province', 'South Province', 'West Province'],
            'Saint Kitts and Nevis' => ['Saint Kitts', 'Nevis'],
            'Saint Lucia' => ['Castries', 'Choiseul', 'Dennery', 'Groesbeck', 'Micoud', 'Soufrière', 'Vieux Fort'],
            'Saint Vincent and the Grenadines' => ['Charlotte', 'Grenadines', 'Saint David', 'Saint George', 'Saint Patrick'],
            'Samoa' => ['Aiga-i-le-Tai', 'Atua', 'Fa’asaleleaga', 'Palauli', 'Satupa’itea', 'Tuamasaga'],
            'San Marino' => ['Acquaviva', 'Borgo Maggiore', 'Chiesanuova', 'Domagnano', 'Faetano', 'Fiorentino', 'Montegiardino', 'San Marino', 'Serravalle'],
            'Sao Tome and Principe' => ['Água Grande', 'Cantagalo', 'Lemba', 'Me-Zóchi', 'Príncipe', 'São Tomé'],
            'Saudi Arabia' => ['Al Bahah', 'Al Hudaydah', 'Al Jawf', 'Al Madinah', 'Al Qassim', 'Ar Riyad', 'Asir', 'Eastern Province', 'Jizan', 'Makkah', 'Najran', 'Tabuk'],
            'Senegal' => ['Dakar', 'Diourbel', 'Fatick', 'Kaolack', 'Kédougou', 'Kolda', 'Louga', 'Matam', 'Saint-Louis', 'Sédhiou', 'Tambacounda', 'Thiès', 'Ziguinchor'],
            'Serbia' => ['Belgrade', 'Bor', 'Kopaonik', 'Kragujevac', 'Kraljevo', 'Novi Sad', 'Niš', 'Senta', 'Šabac', 'Užice', 'Vranje', 'Zrenjanin'],
            'Seychelles' => ['Anse Boileau', 'Anse Royale', 'Beau Vallon', 'Grand Anse', 'La Digue', 'Port Glaud'],
            'Sierra Leone' => ['Bonthe', 'Bombali', 'Kenema', 'Koinadugu', 'Kono', 'Moyamba', 'Pujehun', 'Tonkolili', 'Western Area'],
            'Singapore' => ['Central Region', 'East Region', 'North Region', 'North-East Region', 'West Region'],
            'Slovakia' => ['Bratislava', 'Košice', 'Nitra', 'Prešov', 'Trenčín', 'Trnava', 'Žilina'],
            'Slovenia' => ['Pomurska', 'Podravska', 'Koroška', 'Savinska', 'Osrednjeslovenska', 'Primorsko-notranjska', 'Goriška', 'Posavska', 'Zasavska'],
            'Solomon Islands' => ['Central Province', 'Choiseul Province', 'Guadalcanal Province', 'Honiara', 'Isabel Province', 'Malaita Province', 'Rennell and Bellona Province', 'Temotu Province', 'Western Province'],
            'Somalia' => ['Awdal', 'Bakool', 'Banaadir', 'Bari', 'Bay', 'Galguduud', 'Gedo', 'Hiiraan', 'Jubaland', 'Mudug', 'Nugal', 'Sool', 'Sanaag', 'Shabelle', 'Shabaelleh', 'Sool', 'Upper Juba', 'Yemen'],
            'South Africa' => ['Eastern Cape', 'Free State', 'Gauteng', 'KwaZulu-Natal', 'Limpopo', 'Mpumalanga', 'Northern Cape', 'North West', 'Western Cape'],
            'South Sudan' => ['Central Equatoria', 'Eastern Equatoria', 'Jonglei', 'Lakes', 'Northern Bahr el Ghazal', 'Unity', 'Upper Nile', 'Warrap', 'Western Bahr el Ghazal', 'Western Equatoria'],
            'Spain' => ['Andalusia', 'Aragon', 'Asturias', 'Balearic Islands', 'Basque Country', 'Canary Islands', 'Cantabria', 'Castilla-La Mancha', 'Castilla y León', 'Catalonia', 'Extremadura', 'Galicia', 'Madrid', 'Murcia', 'Navarre', 'Rioja', 'Valencia'],
            'Sri Lanka' => ['Central Province', 'Eastern Province', 'Northern Province', 'North Western Province', 'Southern Province', 'Uva Province', 'Western Province'],
            'Sudan' => ['Al Jazirah', 'Al Kharţūm', 'Northern', 'North Darfur', 'North Kordofan', 'Red Sea', 'South Darfur', 'South Kordofan', 'West Darfur', 'White Nile'],
            'Suriname' => ['Brokopondo', 'Coronie', 'Commewijne', 'Para', 'Paramaribo', 'Saramacca', 'Sipaliwini', 'Marowijne', 'Nickerie'],
            'Sweden' => ['Blekinge', 'Dalarna', 'Gävleborg', 'Gotland', 'Göteborg', 'Halland', 'Jämtland', 'Jönköping', 'Kalmar', 'Kronoberg', 'Norrbotten', 'Skåne', 'Stockholm', 'Södermanland', 'Uppsala', 'Värmland', 'Västerbotten', 'Västernorrland', 'Västmanland', 'Västra Götaland'],
            'Switzerland' => ['Aargau', 'Appenzell Innerrhoden', 'Appenzell Ausserrhoden', 'Bern', 'Fribourg', 'Geneva', 'Glarus', 'Graubünden', 'Jura', 'Lucerne', 'Neuchâtel', 'Nidwalden', 'Obwalden', 'Schaffhausen', 'Schwyz', 'Solothurn', 'St. Gallen', 'Thurgau', 'Ticino', 'Uri', 'Valais', 'Vaud', 'Zug', 'Zurich'],
            'Syria' => ['Aleppo', 'Al-Hasakah', 'Damascus', 'Daraa', 'Deir ez-Zor', 'Hama', 'Homs', 'Idlib', 'Lattakia', 'Quneitra', 'Raqqa', 'Rif Dimashq', 'Suwayda', 'Tartus'],
            'Taiwan' => ['Taipei', 'New Taipei', 'Taoyuan', 'Taichung', 'Tainan', 'Kaohsiung', 'Miaoli', 'Changhua', 'Nantou', 'Hsinchu', 'Yunlin', 'Chiayi', 'Pingtung', 'Hualien', 'Taitung', 'Kinmen', 'Lienchiang'],
            'Tajikistan' => ['Gorno-Badakhshan', 'Khatlon', 'Sughd', 'Dushanbe', 'Rogun'],
            'Tanzania' => ['Dar es Salaam', 'Dodoma', 'Geita', 'Kagera', 'Kigoma', 'Kilimanjaro', 'Lindi', 'Manyara', 'Mara', 'Mbeya', 'Morogoro', 'Mtwara', 'Pwani', 'Rukwa', 'Ruvuma', 'Shinyanga', 'Singida', 'Tabora', 'Tanga', 'Zanzibar'],
            'Thailand' => ['Bangkok', 'Chiang Mai', 'Chiang Rai', 'Chonburi', 'Khon Kaen', 'Lampang', 'Loei', 'Nakhon Nayok', 'Nakhon Ratchasima', 'Nakhon Sawan', 'Nakhon Si Thammarat', 'Narathiwat', 'Nonthaburi', 'Pattani', 'Phetchabun', 'Phetchaburi', 'Phichit', 'Phitsanulok', 'Phrae', 'Phuket', 'Ratchaburi', 'Rayong', 'Roi Et', 'Sa Kaeo', 'Sakon Nakhon', 'Samut Prakan', 'Samut Sakhon', 'Samut Songkhram', 'Sara Buri', 'Saraburi', 'Singburi', 'Sukhothai', 'Suphan Buri', 'Surat Thani', 'Surin', 'Tak', 'Trang', 'Trat', 'Ubon Ratchathani', 'Udon Thani', 'Uthai Thani', 'Uttaradit', 'Yala', 'Yasothon'],
            'Timor-Leste' => ['Aileu', 'Ainaro', 'Baucau', 'Bobonaro', 'Cova Lima', 'Dili', 'Ermera', 'Laulara', 'Liquica', 'Manatuto', 'Manufahi', 'Oecusse'],
            'Togo' => ['Kara', 'Lomé', 'Savanes', 'Central', 'Plateaux', 'Maritime'],
            'Tonga' => ['Tongatapu', 'Haʻapai', 'Vavaʻu', 'ʻEua', 'Niuas'],
            'Trinidad and Tobago' => ['Port of Spain', 'San Fernando', 'Scarborough', 'Arima', 'Chaguanas', 'Point Fortin'],
            'Tunisia' => ['Tunis', 'Sfax', 'Sousse', 'Kairouan', 'Bizerte', 'Gabès', 'Le Kef', 'Mednine'],
            'Turkey' => ['Istanbul', 'Ankara', 'Izmir', 'Bursa', 'Antalya', 'Adana', 'Konya', 'Gaziantep', 'Sanliurfa', 'Mersin', 'Kayseri', 'Samsun', 'Diyarbakir', 'Malatya', 'Elazig', 'Van', 'Trabzon', 'Ordu', 'Aksaray', 'Afyonkarahisar'],
            'Turkmenistan' => ['Ashgabat', 'Balkanabat', 'Mary', 'Turkmenabat', 'Daşoguz', 'Serdar', 'Tejen', 'Gowurdak'],
            'Tuvalu' => ['Funafuti', 'Nanumanga', 'Nanumea', 'Niulakita', 'Nukufetau', 'Nukulaelae', 'Vaitupu'],
            'Uganda' => ['Kampala', 'Wakiso', 'Mbarara', 'Gulu', 'Jinja', 'Mbale', 'Kasese', 'Hoima', 'Masaka', 'Lira', 'Kabarole', 'Bushenyi'],
            'Ukraine' => ['Kyiv', 'Kharkiv', 'Odesa', 'Dnipro', 'Donetsk', 'Lviv', 'Zaporizhzhia', 'Mykolaiv', 'Kherson', 'Poltava', 'Chernihiv', 'Sumy', 'Vinnytsia', 'Rivne', 'Khmelnytskyi', 'Cherkasy', 'Ternopil', 'Zhytomyr', 'Kremenchuk', 'Ivano-Frankivsk'],
            'United Arab Emirates' => ['Abu Dhabi', 'Dubai', 'Sharjah', 'Ajman', 'Umm Al-Quwain', 'Fujairah', 'Ras Al Khaimah'],
            'United Kingdom' => ['England', 'Scotland', 'Wales', 'Northern Ireland'],
            'United States' => ['Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado', 'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii', 'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota', 'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire', 'New Jersey', 'New Mexico', 'New York', 'North Carolina', 'North Dakota', 'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island', 'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming'],
            'Uruguay' => ['Montevideo', 'Salto', 'Paysandú', 'Maldonado', 'Canelones', 'Rivera', 'Tacuarembó', 'Durazno', 'San José', 'Colonia', 'Flores', 'Lavalleja'],
            'Uzbekistan' => ['Tashkent', 'Samarkand', 'Bukhara', 'Nukus', 'Andijan', 'Namangan', 'Fergana', 'Khiva', 'Jizzakh', 'Qarshi'],
            'Vanuatu' => ['Port Vila', 'Luganville', 'Santo', 'Malekula', 'Tanna', 'Efate', 'Pentecost', 'Epi', 'Ambae', 'Sola'],
            'Vatican City' => ['Vatican City'],
            'Venezuela' => ['Caracas', 'Maracaibo', 'Valencia', 'Barquisimeto', 'Ciudad Guayana', 'San Cristóbal', 'Maturín', 'Puerto Ordaz', 'Porlamar', 'El Tigre'],
            'Vietnam' => ['Hanoi', 'Ho Chi Minh City', 'Da Nang', 'Hai Phong', 'Can Tho', 'Hue', 'Nha Trang', 'Vinh', 'Quy Nhon', 'Nam Dinh', 'Bac Ninh'],
            'Yemen' => ['Sana\'a', 'Aden', 'Taiz', 'Al Hudaydah', 'Ibb', 'Dhamar', 'Lahij', 'Al Bayda', 'Amran', 'Al Mahwit'],
            'Zambia' => ['Lusaka', 'Copperbelt', 'Southern', 'Eastern', 'Western', 'Central', 'Northern', 'Luapula', 'Muchinga', 'North-Western'],
            'Zimbabwe' => ['Harare', 'Bulawayo', 'Mutare', 'Gweru', 'Kwekwe', 'Masvingo', 'Chitungwiza', 'Kadoma', 'Gokwe', 'Rusape']

        ];

        return response()->json($states[$country] ?? []);
    }
}