<x-guest-layout>
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <h3 class="text-center fw-bold mb-4">Login</h3>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" name="remember" class="form-check-input" id="remember">
                    <label class="form-check-label small text-muted" for="remember">Remember me</label>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary fw-bold">Login</button>
                </div>

                <div class="text-center mt-3">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-decoration-none small">Forgot Password?</a>
                    @endif
                    <hr>
                    <p class="small mb-0 text-muted">Don't have an account? <a href="{{ route('register') }}" class="text-decoration-none">Register</a></p>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>