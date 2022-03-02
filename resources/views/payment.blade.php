<!DOCTYPE html>
<html>

<head>
    <title>Flutterwave Payment in Laravel</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div class="row mt-5">
        <div class="col-md-10 offset-md-1">
            <h3 class="text-center mb-4">Flutterwave Payment in laravel - Demo </h3>
            <form method="post" action="{{ route('flutterwave.payment') }}">
                {{ csrf_field() }}
                <div class="form-group row">
                    <div class="col-md-6">
                        <label class="form-control-label">First name<span class="text-danger">*</span></label>
                        <input type="text" name="first_name" class="form-control" required="">
                        @if ($errors->has('first_name'))
                            <span class="text-danger help-block form-error">
                                <strong>{{ $errors->first('first_name') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <label class="form-control-label">Last name<span class="text-danger">*</span></label>
                        <input type="text" name="last_name" class="form-control" required="">
                        @if ($errors->has('last_name'))
                            <span class="text-danger help-block form-error">
                                <strong>{{ $errors->first('last_name') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <label class="form-control-label">Email<span class="text-danger">*</span></label>
                        <input type="text" name="email" class="form-control" required="">
                        @if ($errors->has('email'))
                            <span class="text-danger help-block form-error">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <label class="form-control-label">Phone No<span class="text-danger">*</span></label>
                        <input type="number" name="phone_no" class="form-control" required="">
                        @if ($errors->has('phone_no'))
                            <span class="text-danger help-block form-error">
                                <strong>{{ $errors->first('phone_no') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <label class="form-control-label">Amount<span class="text-danger">*</span></label>
                        <input type="number" name="amount" class="form-control" required="">
                        @if ($errors->has('amount'))
                            <span class="text-danger help-block form-error">
                                <strong>{{ $errors->first('amount') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <label class="form-control-label">Currency<span class="text-danger">*</span></label>
                        <input type="text" name="currency" class="form-control" required="">
                        @if ($errors->has('currency'))
                            <span class="text-danger help-block form-error">
                                <strong>{{ $errors->first('currency') }}</strong>
                            </span>
                        @endif
                    </div>
                    <button class="btn btn-block" type="submit">
                        PayNOw
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</body>

</html>
