<x-guest-layout>
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <h3 class="text-center fw-bold mb-4">{{ __('Create Account') }}</h3>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label small fw-bold text-muted">{{ __('Name') }}</label>
                    <input id="name" 
                           type="text" 
                           name="name" 
                           value="{{ old('name') }}" 
                           class="form-control @error('name') is-invalid @enderror" 
                           placeholder="Enter your full name"
                           required 
                           autofocus 
                           autocomplete="name">
                    
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label small fw-bold text-muted">{{ __('Email Address') }}</label>
                    <input id="email" 
                           type="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           class="form-control @error('email') is-invalid @enderror" 
                           placeholder="name@example.com"
                           required 
                           autocomplete="username">
                    
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label small fw-bold text-muted">{{ __('Password') }}</label>
                        <input id="password" 
                               type="password" 
                               name="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               placeholder="••••••••"
                               required 
                               autocomplete="new-password">
                        
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="password_confirmation" class="form-label small fw-bold text-muted">{{ __('Confirm') }}</label>
                        <input id="password_confirmation" 
                               type="password" 
                               name="password_confirmation" 
                               class="form-control" 
                               placeholder="••••••••"
                               required 
                               autocomplete="new-password">
                    </div>
                </div>

                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-primary fw-bold py-2">
                        {{ __('Register') }}
                    </button>
                </div>

                <hr class="my-4">

                <div class="text-center">
                    <p class="small text-muted mb-0">
                        {{ __('Already registered?') }} 
                        <a class="text-decoration-none fw-bold" href="{{ route('login') }}">
                            {{ __('Log in') }}
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>