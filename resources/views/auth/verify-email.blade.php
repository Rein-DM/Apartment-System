<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Thanks for signing up! Click the link to verify your email address.') }} 
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @else
        <div class="mb-4 font-medium text-sm text-gray-600">
            {{ __('Didn\'t receive the verification email?') }}
            <form method="POST" action="{{ route('verification.send') }}" class="inline">
                @csrf
                <button type="submit" class="text-blue-600 hover:underline">{{ __('Click here to request another.') }}</button>
            </form>
        </div>
    @endif
</x-guest-layout>
