Click here to reset your password: <a href="{{ $link = url('backend_mps/password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a>
