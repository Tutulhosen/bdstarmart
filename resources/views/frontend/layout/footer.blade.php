<?php 
    $facebook= DB::table('social_link')->where('title', 'Facebook')->where('status', 1)->first();
    $twitter= DB::table('social_link')->where('title', 'twitter')->where('status', 1)->first();
    $youtube= DB::table('social_link')->where('title', 'Youtube')->where('status', 1)->first();
    $instagram= DB::table('social_link')->where('title', 'Instagram')->where('status', 1)->first();
    $admin= DB::table('users')->where('role_id', 1)->first();
?>
<footer>
    {{-- WhatsApp Connection --}}
    <a href="https://wa.me/{{ preg_replace('/^0/', '+880', $user->company_phone) }}" class="whatsapp-button" target="_blank" id="live_chat_btn">
        <i style="font-size: 40px; padding:10px; color:green" class="fab fa-whatsapp"></i> 
    </a>
    <div class="footer">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 text-center">
                    <div class="footer-menu">
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <a href="about-us.html">আমাদের সম্পর্কে</a>
                            </li>
                            <li class="list-inline-item">
                                <a href="delivery-policy.html">ডেলিভারি পলিসি</a>
                            </li>
                            <li class="list-inline-item">
                                <a href="return-policy.html">রিটার্ন পলিসি</a>
                            </li>
                        </ul>
                    </div>

                    <div class="social_links">
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <a  class="facebook"  target="_blank" href="{{ $facebook ? $facebook->link : '' }}"><i class="fab fa-facebook"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a class="twitter" target="_blank" href="{{ $twitter ? $twitter->link : '' }}"><i class="fab fa-twitter"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a class="instagram" target="_blank" href="{{ $instagram ? $instagram->link : '' }}"><i class="fab fa-instagram"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a class="youtube" target="_blank" href="{{ $youtube ? $youtube->link : '' }}"><i class="fab fa-youtube"></i></a>
                            </li>
                        </ul>
                    </div>

                    <div class="copyright_text">
                        <p>&copy; 2024 <a href="{{route('home')}}" target="_blank">{{ $admin->company_name }}</a> All Right Reserved. Developed By <a href="https://wa.me/8801748890748" target="_blank">Tutul</a></p>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</footer>
