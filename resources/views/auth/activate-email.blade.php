@extends('auth.layouts')

@section('content')

<div class="login-container">
        <h1>Aktywacja konta</h1>
        <div class="login-card">
            
                <form action="/resend-activate-email-sumbmit" method="post">
                    @csrf
                    <div class="repeat-password-container">

                            <div class="alert @if ($messageType == 'positive') alert-success @else alert-danger @endif text-center">
                                {{ $message }}
                            </div>

                        
                    </div>
                    
                </form>
        </div>
</div>
    
@endsection