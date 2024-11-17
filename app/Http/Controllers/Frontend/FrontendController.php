<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class FrontendController extends Controller
{
    //login page
    public function login_page(){
        session(['url.intended' => url()->previous()]);
        $data['categories'] = DB::table('category')->where('status', 1)->get();
        $data['subcategories'] = DB::table('subcategory')->where('status', 1)->get();
        $data['sub_title']='Log In';
        return view('frontend.login')->with($data);
    }
    //register page
    public function register_page(){
        $data['categories'] = DB::table('category')->where('status', 1)->get();
        $data['subcategories'] = DB::table('subcategory')->where('status', 1)->get();
        $data['sub_title']='register';
        return view('frontend.register')->with($data);
    }

    //customer reegistration process
    public function customer_registration(Request $request){
        DB::table('customers')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);
        return Redirect()->route('frontend.login')->with('success', 'Your registration is successfull');
    }

    //customer login process
    public function customer_login(Request $request)
    {
        $credentials = [
            'password' => $request->password
        ];

        if (filter_var($request->username, FILTER_VALIDATE_EMAIL)) {
            $credentials['email'] = $request->username;
        } else {
            $credentials['phone'] = $request->username;
        }

        if (Auth::guard('customer')->attempt($credentials)) {
            $previousUrl = session()->get('url.intended', route('home'));
            
            
            return redirect()->to($previousUrl)->with('success', 'Successfully logged in');
        }

        // Authentication failed
        return redirect()->back()->with('error', 'Invalid credentials');
    }


    public function customer_logout()
    {
        Auth::guard('customer')->logout();
        return redirect()->route('home')->with('success', 'Successfully logged out');
    }

    public function home(){
        $data['categories'] = DB::table('category')->where('status', 1)->get();
        $data['subcategories'] = DB::table('subcategory')->where('status', 1)->get();
        $data['sliders'] = DB::table('sliders')->where('status', 1)->latest()->get();

    
        $all_products = DB::table('products')->where('status', 1)->latest()->paginate(16); 

        $product_arr = [];
        foreach ($all_products as $value) {
            $product = [];
            $product['id'] = $value->id;
            $product['title'] = $value->title;
            $product['price'] = $value->price;
            $product['discount'] = $value->discount;
            $product['discount_price'] = $value->discount ? $value->price - $value->discount : $value->price;
            $product['thumbnail'] = $value->thumbnail;

            array_push($product_arr, $product);
        }

       
        $data['products'] = $product_arr;
        $data['pagination'] = $all_products;

        
        $data['sub_title'] = 'home';
    
        return view('frontend.index')->with($data);
    }
    
    
    //session data count
    public function getCartCount()
    {
        $cart = session()->get('cart', []);
        $cartCount = count($cart);
     
        return response()->json(['cart_count' => $cartCount]);
    }

    
    

    //category page view
    public function category_page($id){
        // dd($id);
        if ($id!=1) {
            if ($id==4) {
                $all_products = DB::table('products')->whereNotNull('discount')->where('status', 1)->latest()->paginate(28);
                // dd($all_products);
            } else {
                $all_products = DB::table('products')->where('category_id', $id)->where('status', 1)->latest()->paginate(28);
                // dd($all_products);
            }
            
            

            $product_arr = [];
            foreach ($all_products as $value) {
                $product = [];
                $product['id'] = $value->id;
                $product['title'] = $value->title;
                $product['price'] = $value->price;
                $product['discount'] = $value->discount;
                $product['discount_price'] = $value->discount ? $value->price - $value->discount : $value->price;
                $product['thumbnail'] = $value->thumbnail;

                array_push($product_arr, $product);
            }
            // dd($product_arr);
            $data['products'] = $product_arr;
            $data['pagination'] = $all_products; 
            $data['category'] = DB::table('category')->where('status', 1)->get();
            $data['sub_title']='category';

            return view('frontend.pages.category-page')->with($data);

        } else {
            return redirect()->route('home');
        }
        
        
    }

    //subcategory page view
    public function sub_category_page($cat_id, $sub_cat_id){
       
        $all_products = DB::table('products')->where('category_id', $cat_id)->where('sub_category', $sub_cat_id)->where('status', 1)->latest()->paginate(28);
        // dd($all_products);
        $product_arr = [];
            foreach ($all_products as $value) {
                $product = [];
                $product['id'] = $value->id;
                $product['title'] = $value->title;
                $product['price'] = $value->price;
                $product['discount'] = $value->discount;
                $product['discount_price'] = $value->discount ? $value->price - $value->discount : $value->price;
                $product['thumbnail'] = $value->thumbnail;

                array_push($product_arr, $product);
            }
            // dd($product_arr);
            $data['products'] = $product_arr;
            $data['pagination'] = $all_products; 
            $data['categories'] = DB::table('category')->where('status', 1)->get();
            $data['subcategories'] = DB::table('subcategory')->where('status', 1)->get();
            $data['sub_title']='subcategory';

            return view('frontend.pages.subcategory-page')->with($data);
        
        
    }

    
    //shop page 
    public function shop_page(){
        $all_products = DB::table('products')->where('status', 1)->latest()->paginate(28);
     
            $product_arr = [];
            foreach ($all_products as $value) {
                $product = [];
                $product['id'] = $value->id;
                $product['title'] = $value->title;
                $product['price'] = $value->price;
                $product['discount'] = $value->discount;
                $product['discount_price'] = $value->discount ? $value->price - $value->discount : $value->price;
                $product['thumbnail'] = $value->thumbnail;

                array_push($product_arr, $product);
            }
            // dd($product_arr);
            $data['products'] = $product_arr;
            $data['pagination'] = $all_products; 
            $data['categories'] = DB::table('category')->where('status', 1)->get();
            $data['subcategories'] = DB::table('subcategory')->where('status', 1)->get();
            $data['sub_title']='Shop';
            return view('frontend.pages.shop-page')->with($data);
        
        
    }

    public function updateSize(Request $request)
    {
        $cart = session()->get('cart', []);

        
        if (isset($cart[$request->id])) {
          
            $cart[$request->id]['size'] = $request->size;

          
            session()->put('cart', $cart);

            return response()->json([
                'success' => true,
                'message' => 'Size updated successfully',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Item not found in cart',
        ]);
    }


    public function single_product($id) {
        $single_product = DB::table('products')->where('status', 1)->where('id', $id)->first();
        if (!$single_product) {
            abort(404, 'Product not found');
        }
    
        $gallery_images = DB::table('gallery')->where('product_id', $single_product->id)->get();
        
        // Convert the JSON size data to an array
        $product = [
            'id' => $single_product->id,
            'product_code' => $single_product->product_code,
            'title' => $single_product->title,
            'price' => $single_product->price,
            'discount' => $single_product->discount,
            'size' => json_decode($single_product->size, true),  
            'discount_price' => $single_product->discount ? $single_product->price - $single_product->discount : $single_product->price,
            'description' => $single_product->description,
            'thumbnail' => $single_product->thumbnail,
            'gallery' => $gallery_images->pluck('image_name')->toArray(),
        ];
    
        $related_products = DB::table('products')->where('id','!=', $single_product->id)->where('category_id', $single_product->category_id)->where('status', 1)->latest()->paginate(14); 
    
        $related_products_arr = [];
        foreach ($related_products as $value) {
            $productt = [];
            $productt['id'] = $value->id;
            $productt['title'] = $value->title;
            $productt['price'] = $value->price;
            $productt['discount'] = $value->discount;
            $productt['discount_price'] = $value->discount ? $value->price - $value->discount : $value->price;
            $productt['thumbnail'] = $value->thumbnail;
    
            array_push($related_products_arr, $productt);
        }
    
        $company_info = DB::table('users')->where('role_id', 1)->first();
        $delivery_charge = DB::table('delivery_charge')->where('status', 1)->get();
        
        $data = [
            'single_product_data' => $product,
            'related_product' => $related_products_arr,
            'categories' => DB::table('category')->where('status', 1)->get(),
            'subcategories' => DB::table('subcategory')->where('status', 1)->get(),
            'sub_title' => 'Single Product',
            'company_info' => $company_info,
            'delivery_charge' => $delivery_charge,
        ];
        // dd($data);
        return view('frontend.pages.single-product', $data);
    }
    

    public function single_product_quick_view(Request $request) {
        
        $product_id = $request->input('product_id');
     
        $single_product = DB::table('products')->where('id', $product_id)->where('status', 1)->first();
       
       
        $gallery_images = DB::table('gallery')->where('product_id', $single_product->id)->get();
        
        $product = [
            'id' => $single_product->id,
            'product_code' => $single_product->product_code,
            'title' => $single_product->title,
            'price' => $single_product->price,
            'discount' => $single_product->discount,
            'discount_price' => $single_product->discount ? $single_product->price - $single_product->discount : $single_product->price,
            'description' => $single_product->description,
            'thumbnail' => $single_product->thumbnail,
            'gallery' => $gallery_images->pluck('image_name')->toArray(),
        ];
        $sub_title='register';
        // Return the view with just the product HTML
        return view('frontend.pages.quickView', compact('product','sub_title'));
    }
    

    public function shop_checkout()
    {
        // session()->flush();
        $data['categories'] = DB::table('category')->where('status', 1)->get();
        $data['subcategories'] = DB::table('subcategory')->where('status', 1)->get();
        $data['cart'] = session()->get('cart', []);
        $totalSum = 0; 
        foreach ($data['cart'] as $key => $item) {
            $totalSum += $item['total_price']; 
        }

        $data['sub_total']=$totalSum;
        return view('frontend.pages.shop-checkout')->with($data);
    }
    public function shop_checkout_old()
    {
        
        // if (!Auth::guard('customer')->check()) {
        //    return redirect()->route('frontend.login');
        // }
        // dd();
        $cart = session()->get('cart', []);
        // dd($cart);
        $subtotal = 0;
        $discount = 0;
        $shipping = 0;
        $total = 0;

        foreach ($cart as $item) {
            $subtotal += $item['qty'] * $item['price'];
        }

        $total = $subtotal - $discount + $shipping;

        $data['category'] = DB::table('category')->where('status', 1)->get();
        $data['cart'] = $cart;
        $data['subtotal'] = $subtotal;
        $data['discount'] = $discount;
        $data['shipping'] = $shipping;
        $data['total'] = $total;
        $data['sub_title']='shop checkout';

        return view('frontend.pages.shop-checkout')->with($data);
    }
  

    public function checkout(Request $request)
    {
        
        // Validate the incoming request
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
           
        ]);
        $additionalAddress = $request->input('additional_address');
       
       
        // Retrieve the last order_code
        $lastOrder = DB::table('customer_order')
            ->orderBy('order_code', 'desc')
            ->whereNotNull('order_code')
            ->first();
        
        $newOrderNumber = 1;

        if ($lastOrder) {
            $lastOrderCode = $lastOrder->order_code;
            $lastOrderNumber = (int)str_replace('BSM-', '', $lastOrderCode);
            $newOrderNumber = $lastOrderNumber + 1;
        }

        // Format the new order code 
        $newOrderCode = 'BSM-' . str_pad($newOrderNumber, 2, '0', STR_PAD_LEFT);
    
        // Flag to track whether the order insertion was successful
        $isInserted = false;
     
  
       
        //store order 
        
        $id = DB::table('customer_order')->insertGetId([
            'customer_id' => Auth::guard('customer')->user()->id ?? null,
            'total_price' => $request->input('total_price_sum'),
            'full_name' => $request->input('full_name'),
            'delivery_address' => $request->input('delivery_address'),
            'phone_number' => $request->input('phone_number'),
            'email_address' => $request->input('email_address'),
            'additional_information' => $additionalAddress, 
            'payment_method' => $request->input('shipping_method'),
            'order_code' => $newOrderCode,
            'delivery_charge' => $request->input('shipping_cost'),
        ]);
        if ($id) {
            $isInserted = true;
        }
        
        
        if ($isInserted) {
            $cart = session()->get('cart', []);
          
            foreach ($cart as $value) {
                DB::table('order_product')->insert([
                    'order_id' => $id,
                    'product_id' => $value['product_id'],
                    'price' => $value['price'],
                    'discount' => $value['discount'],
                    'qty' => $value['qty'],
                    'total_price' => $value['total_price'],
                    'size' => $value['size'],
                    'title' => $value['title'],
                ]);
            }
            $customer = Auth::guard('customer')->user();
            if ($customer) {
                // Remove all session data and log the user back in
                session()->flush();
                Auth::guard('customer')->login($customer);
                $isCustomerlogin = true;
            } else {
                // Remove all session data
                session()->flush();
                $isCustomerlogin = false;
            }
           // Get the admin email
            $admin_user = DB::table('users')->where('role_id', 1)->first();
            $admin_email = $admin_user->company_email;

            // Prepare email details
            $email_subject = "New Order Received";
            $email_body = "A new order has been placed with order code: " . $newOrderCode;

            // Send the email
            // Mail::raw($email_body, function ($message) use ($admin_email, $email_subject) {
            //     $message->to($admin_email)
            //             ->subject($email_subject);
            // });
            
            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully',
                'isCustomerlogin' => $isCustomerlogin,
                'id' => $id,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Order failed'
            ]);
        }
    }



    public function shopping_card() {
        // session()->forget('cart');
        $cart = session()->get('cart', []);
        $count=count($cart);
        $subtotal = 0;
       
        foreach ($cart as $key => $item) {
            $subtotal += $item['qty'] * $item['price'];
            
            // Fetch the thumbnail from the products table
            $product_tmnl = DB::table('products')->where('id', $item['product_id'])->select('thumbnail', 'title')->where('status', 1)->first();
            
            // Add the thumbnail to the cart item
            $cart[$key]['thumbnail'] = $product_tmnl ? $product_tmnl->thumbnail : null;
            $cart[$key]['title'] = $product_tmnl ? $product_tmnl->title : null;
        }
        session()->put('cart', $cart);
        // Get the category information
        $category = DB::table('category')->where('status', 1)->get();
        $sub_title='Shopping Card';
        // dd($subtotal);
        // Pass updated cart with thumbnails to the view
        return view('frontend.pages.shopping_cart', [
            'cart' => $cart,
            'subtotal' => $subtotal,
            'discount' => 0, 
            'shipping' => 0, 
            'total' => $count, 
            'category' => $category,
            'sub_title' => $sub_title,
        ]);

    }


    

    public function cart_add(Request $request)
    {
        $productId = $request->product_id;
        $qty = $request->qty;
        $size = $request->size;
        $total_value_hidden = $request->total_value_hidden;

       
        $product = DB::table('products')->where('id', $productId)->first();
        
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found.'
            ]);
        }

       
        $cart = session()->get('cart', []);

       
        
        if (isset($cart[$productId])) {
           
            $cart[$productId]['qty'] += $qty;
            return response()->json([
                'already_in_cart' => true
            ]);
        } else {
            
            $cart[$productId] = [
                'product_id' => $productId,
                'title' => $product->title,
                'price' => $product->price,
                'discount' => $product->discount,
                'qty' => $qty,
                'total_price' => $total_value_hidden,
                'size' => $size,
                'image' => $product->thumbnail, 
            ];
        }

       
        session()->put('cart', $cart);

     
        session()->put('cart_count', count($cart));

        return response()->json([
            'success' => true,
            'cart_count' => count($cart),
            'message' => 'Product added to cart successfully!',
        ]); 
    }

   


    public function update(Request $request)
    {
        $cart = session()->get('cart');
        $id = $request->id;
        $qty = $request->qty;
    
        // Update the quantity in the cart
        if (isset($cart[$id])) {
            $discount_price=$cart[$id]['price']-$cart[$id]['discount'];
            $cart[$id]['qty'] = $qty;
            $cart[$id]['total_price'] = $discount_price * $qty;
            session()->put('cart', $cart);
        }
    
        // Recalculate subtotal
        $sub_total = array_sum(array_column($cart, 'total_price'));
    
        // Return response with updated values
        return response()->json([
            'success' => true,
            'item_total_price' => $cart[$id]['total_price'],
            'sub_total' => $sub_total
        ]);
    }
 
    
    public function remove(Request $request)
    {
        $cart = session()->get('cart', []);
    
        // Remove the item from the cart
        unset($cart[$request->id]);
        session()->put('cart', $cart);
        
        // Calculate the new subtotal
        $sub_total = array_sum(array_column($cart, 'total_price'));
        
        // Count the remaining items in the cart
        $cart_count = count($cart);

        // Return success response with updated values
        return response()->json([
            'success' => true,
            'sub_total' => $sub_total,
            'cart_count' => $cart_count,
        ]);
    }


    //search
    public function search(Request $request)
    {
        $query = $request->input('query');
        $category = $request->input('category');
      
        // Perform your search logic here
        $results = DB::table('products')->where('status', 1);

        // if ($category) {
        //     if ($category!=1) {
        //         if ($category==4) {
        //             $results->whereNotNull('discount');
        //             // dd($all_products);
        //         } else {
        //             $results->where('category_id', $category);
        //             // dd($all_products);
        //         }
        //     } 
        // }

        if ($query) {
            
            $results->where('title', 'like', '%' . $query . '%');
        }

        $products = $results->get();
        // dd($products);
        $categories = DB::table('category')->where('status', 1)->get();
        $subcategories = DB::table('subcategory')->where('status', 1)->get();
        $sub_title='search';
        return view('frontend.pages.search_results', compact('products', 'category', 'sub_title', 'categories', 'subcategories'));
    }

    //checkout page
    public function checkout_page(){
        $cart = session()->get('cart', []);
        // dd($cart);
        $data['cart']=$cart;
        $data['delivery_charge'] = DB::table('delivery_charge')->where('status', 1)->get();
        $data['categories'] = DB::table('category')->where('status', 1)->get();
        $data['subcategories'] = DB::table('subcategory')->where('status', 1)->get();
        return view('frontend.pages.checkout_page')->with($data);
    }

    






   
}
