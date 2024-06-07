<style>
   .profile-image {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    object-position: center;
    margin: 0 auto; /* Để căn giữa */
    display: block;
    border: 2px solid #fff; /* Thêm viền trắng */
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Thêm bóng đổ nhẹ */
}

/* Tùy chỉnh input file để ẩn đi và chỉ hiển thị icon hoặc nút tải lên */
input[type="file"] {
    display: none;
}

.file-upload-label {
    background-color: #4caf50; /* Màu nền */
    color: #fff; /* Màu chữ */
    padding: 10px 15px; /* Khoảng cách nội dung */
    border-radius: 5px; /* Đường viền cong */
    cursor: pointer; /* Biểu tượng chuột */
    display: inline-block; /* Hiển thị trên cùng một hàng */
}

/* Hiển thị nút tải lên bên ngoài input */
.file-upload-label {
    margin-top: 10px; /* Khoảng cách từ input */
}

</style>

<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf

            <!-- Chọn ảnh -->
            <div class="mt-4">
                <x-jet-label for="photo" value="{{ __('Profile Photo') }}" />
                <input id="photo" type="file" class="block mt-1 w-full" name="photo" />
            </div>

            <!-- Hiển thị ảnh -->
            <div class="mt-4">
                <img id="preview-image" class="profile-image" src="#" alt="Preview Image" />
            </div>

            <!-- Các trường nhập thông tin khác -->
            <div>
                <x-jet-label for="name" value="{{ __('Name') }}" />
                <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-jet-label for="city" value="{{ __('City') }}" />
                <select id="city" name="city" class="block mt-1 w-full" required>
                    <option value="" disabled selected>Select your city</option>
                    <option value="New York">New York</option>
                    <option value="Los Angeles">Los Angeles</option>
                    <option value="Chicago">Chicago</option>
                    <option value="Houston">Houston</option>
                    <option value="Phoenix">Phoenix</option>
                    <option value="Other">Other</option> <!-- Thêm tùy chọn "Other" -->
                </select>
            </div>

            <div class="mt-4 hidden" id="otherCityInput">
                <x-jet-label for="other_city" value="{{ __('Enter your city') }}" />
                <x-jet-input id="other_city" class="block mt-1 w-full" type="text" name="other_city" />
            </div>

            <!-- Đồng ý với các điều khoản -->
            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-jet-label for="terms">
                        <div class="flex items-center">
                            <x-jet-checkbox name="terms" id="terms"/>

                            <div class="ml-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-jet-label>
                </div>
            @endif

            <!-- Nút đăng ký -->
            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-jet-button class="ml-4">
                    {{ __('Register') }}
                </x-jet-button>
            </div>
        </form>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const photoInput = document.getElementById('photo');
                const previewImage = document.getElementById('preview-image');

                photoInput.addEventListener('change', function() {
                    const file = this.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function() {
                            previewImage.src = reader.result;
                        }
                        reader.readAsDataURL(file);
                    }
                });
            });
        </script>
    </x-jet-authentication-card>
</x-guest-layout>
