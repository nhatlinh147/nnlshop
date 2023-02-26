<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $title_login_form }}</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('public/BackEnd/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/BackEnd/fonts/font-lora/style.css') }}">
    <link rel="stylesheet" href="{{ asset('public/BackEnd/css/style.css?update=24112021') }}">
    <link rel="stylesheet" href="{{ asset('public/BackEnd/fonts/fontawesome/css/fontawesome-all.css') }}">
    <style>
        html,
        body {
            height: 100%;
        }

        label.error {
            width: 100%;
            margin-top: 0.25rem;
            font-size: 90%;
            color: #dc3545;
        }

        input.error {
            border-color: #dc3545;
        }

        input.error:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }

        body {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
            background-image: linear-gradient(to right bottom, rgba(123, 0, 0, 0.993) 50%, rgba(125, 6, 6, 0.918) 20%);
        }
    </style>
</head>

<body>
    <!-- ============================================================== -->
    <!-- login page  -->
    <!-- ============================================================== -->

    @yield('content')

    <!-- ============================================================== -->
    <!-- end login page  -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <script src="{{ asset('public/BackEnd/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('public/BackEnd/js/bootstrap.bundle.js') }}"></script>

    <!-- https://jqueryvalidation.org/ -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <script>
        $.validator.addMethod("regex", function(value, element, regexp) {
                var re = new RegExp(regexp);
                return this.optional(element) || re.test(value);
            },
            "Please check your input."
        );
    </script>
    @yield('script')

</body>

</html>
