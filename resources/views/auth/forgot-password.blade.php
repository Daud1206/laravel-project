<x-guest-layout>
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <h3 class="text-center fw-bold mb-4">Reset Password</h3>
            
            <div class="mb-4 text-sm text-secondary text-center">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link.') }}
            </div>

            @if (session('status'))
                <div class="alert alert-success mb-4 small" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label small fw-bold text-muted">{{ __('Email Address') }}</label>
                    <input id="email" 
                           type="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           class="form-control @error('email') is-invalid @enderror" 
                           placeholder="name@example.com"
                           required 
                           autofocus>

                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-primary fw-bold py-2">
                        {{ __('Email Password Reset Link') }}
                    </button>
                </div>

                <div class="text-center mt-3">
                    <a class="text-decoration-none small fw-bold" href="{{ route('login') }}">
                        {{ __('Back to Login') }}
                    </a>
                </div>
            </form>
            
        </div>
    </div>
</x-guest-layout>