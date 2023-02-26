<!doctype html>
<html lang="en">


<head>
    <!-- Required meta tags -->

    <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('public/BackEnd/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/BackEnd/fonts/font-lora/style.css') }}">
    <link rel="stylesheet" href="{{ asset('public/BackEnd/css/style.css?update=26122021') }}">
    <link rel="stylesheet" href="{{ asset('public/BackEnd/fonts/fontawesome/css/fontawesome-all.css') }}">
    <link rel="stylesheet" href="{{ asset('public/BackEnd/css/jqvmap.css') }}">
    <link rel="stylesheet" href="{{ asset('public/BackEnd/css/jquery-jvectormap-2.0.2.css') }}">
    <link rel="stylesheet" href="{{ asset('public/BackEnd/fonts/flag-icon-css/flag-icon.min.css') }}">

    <!-- Các thư viện ui css trong jquery -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <link rel="stylesheet"
        href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css">

    <meta name="author" content="Nguyễn Nhất Linh">
    @yield('link')
    <title>Concept - Bootstrap 4 Admin Dashboard Template</title>
    <style>
        .checkbox-label {
            font-size: 13px;
            color: black;
        }

        .regular-checkbox {
            -webkit-appearance: none;
            background-color: #fafafa;
            border: 2px solid #cacece;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05), inset 0px -15px 10px -12px rgba(0, 0, 0, 0.05);
            padding: 9px;
            border-radius: 3px;
            display: inline-block;
            position: relative;
            height: 18px;
            width: 18px;
            margin-right: 5px;
        }

        .regular-checkbox:active,
        .regular-checkbox:checked:active {
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05), inset 0px 1px 3px rgba(0, 0, 0, 0.1);
        }

        .regular-checkbox:checked {
            background-color: #fff;
            border: 1px solid #1fff17;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05), inset 0px -15px 10px -12px rgba(0, 0, 0, 0.05), inset 15px 10px -12px rgba(255, 255, 255, 0.1);
            color: #99a1a7;
        }

        .regular-checkbox:checked:after {
            content: '\2714';
            font-size: 13px;
            position: absolute;
            top: 0px;
            left: 3px;
            color: rgb(1, 238, 21);
        }


        label.error,
        .error-gallery {
            width: 100%;
            padding: 10px 20px 10px;
            border-radius: 5px;
            margin: 13px 0px 13px;
            color: rgba(202, 2, 2, 0.89);
            font-size: 10pt;
            background-color: rgba(255, 233, 233, 0.904);
        }
    </style>
</head>

<body>
    <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    <div class="dashboard-main-wrapper">
        <!-- ============================================================== -->
        <!-- navbar -->
        <!-- ============================================================== -->
        <div class="dashboard-header">
            <nav class="navbar navbar-expand-lg bg-white fixed-top">
                <a class="navbar-brand" href="index.html">Concept</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse " id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto navbar-right-top">
                        <li class="nav-item">
                            <div id="custom-search" class="top-search-bar">
                                <input class="form-control" type="text" placeholder="Search..">
                            </div>
                        </li>
                        <li class="nav-item dropdown notification">
                            <a class="nav-link nav-icons" href="#" id="navbarDropdownMenuLink1"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                    class="fas fa-fw fa-bell"></i> <span class="indicator"></span></a>
                            <ul class="dropdown-menu dropdown-menu-right notification-dropdown">
                                <li>
                                    <div class="notification-title"> Notification</div>
                                    <div class="notification-list">
                                        <div class="list-group">
                                            <a href="#" class="list-group-item list-group-item-action active">
                                                <div class="notification-info">
                                                    <div class="notification-list-user-img"><img
                                                            src="assets/images/avatar-2.jpg" alt=""
                                                            class="user-avatar-md rounded-circle"></div>
                                                    <div class="notification-list-user-block"><span
                                                            class="notification-list-user-name">Jeremy
                                                            Rakestraw</span>accepted your invitation to join the team.
                                                        <div class="notification-date">2 min ago</div>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="#" class="list-group-item list-group-item-action">
                                                <div class="notification-info">
                                                    <div class="notification-list-user-img"><img
                                                            src="assets/images/avatar-3.jpg" alt=""
                                                            class="user-avatar-md rounded-circle"></div>
                                                    <div class="notification-list-user-block"><span
                                                            class="notification-list-user-name">John Abraham</span>is
                                                        now following you
                                                        <div class="notification-date">2 days ago</div>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="#" class="list-group-item list-group-item-action">
                                                <div class="notification-info">
                                                    <div class="notification-list-user-img"><img
                                                            src="assets/images/avatar-4.jpg" alt=""
                                                            class="user-avatar-md rounded-circle"></div>
                                                    <div class="notification-list-user-block"><span
                                                            class="notification-list-user-name">Monaan Pechi</span> is
                                                        watching your main repository
                                                        <div class="notification-date">2 min ago</div>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="#" class="list-group-item list-group-item-action">
                                                <div class="notification-info">
                                                    <div class="notification-list-user-img"><img
                                                            src="assets/images/avatar-5.jpg" alt=""
                                                            class="user-avatar-md rounded-circle"></div>
                                                    <div class="notification-list-user-block"><span
                                                            class="notification-list-user-name">Jessica
                                                            Caruso</span>accepted your invitation to join the team.
                                                        <div class="notification-date">2 min ago</div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="list-footer"> <a href="#">View all notifications</a></div>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown connection">
                            <a class="nav-link" href="#" id="navbarDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i
                                    class="fas fa-fw fa-th"></i> </a>
                            <ul class="dropdown-menu dropdown-menu-right connection-dropdown">
                                <li class="connection-list">
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img
                                                    src="{{ asset('public/BackEnd/images/github.png') }}"
                                                    alt="">
                                                <span>Github</span></a>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img
                                                    src="{{ asset('public/BackEnd/images/dribbble.png') }}"
                                                    alt="">
                                                <span>Dribbble</span></a>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img
                                                    src="{{ asset('public/BackEnd/images/dropbox.png') }}"
                                                    alt="">
                                                <span>Dropbox</span></a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img
                                                    src="{{ asset('public/BackEnd/images/bitbucket.png') }}"
                                                    alt="">
                                                <span>Bitbucket</span></a>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img
                                                    src="{{ asset('public/BackEnd/images/mail_chimp.png') }}"
                                                    alt=""><span>Mail chimp</span></a>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img
                                                    src="{{ asset('public/BackEnd/images/slack.png') }}"
                                                    alt="">
                                                <span>Slack</span></a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="conntection-footer"><a href="#">More</a></div>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown nav-user">
                            <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img
                                    src="assets/images/avatar-1.jpg" alt=""
                                    class="user-avatar-md rounded-circle"></a>
                            <div class="dropdown-menu dropdown-menu-right nav-user-dropdown"
                                aria-labelledby="navbarDropdownMenuLink2">
                                <div class="nav-user-info">
                                    <h5 class="mb-0 text-white nav-user-name">
                                        {{ Session::has('Admin_Name') ? Session::get('Admin_Name') : 'No Name' }}
                                    </h5>
                                    <span class="status"></span><span class="ml-2">Available</span>
                                </div>
                                <a class="dropdown-item" href="#"><i class="fas fa-user mr-2"></i>Account</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-cog mr-2"></i>Setting</a>
                                <a class="dropdown-item" href="{{ route('backend.logout_by_auth') }}"><i
                                        class="fas fa-power-off mr-2"></i>Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- ============================================================== -->
        <!-- end navbar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- left sidebar -->
        <!-- ============================================================== -->
        <div class="nav-left-sidebar sidebar-dark">
            <div class="menu-list">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="d-xl-none d-lg-none" href="#">Dashboard</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        @include('backend.include.nav-left-sidebar')
                    </div>
                </nav>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end left sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="dashboard-wrapper">

            @yield('content')

        </div>
        <!-- ============================================================== -->
        <!-- end wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- end main wrapper  -->
    <!-- ============================================================== -->

    <!-- Optional JavaScript -->
    <!-- jquery 3.3.1 js-->
    <script src="{{ asset('public/BackEnd/js/jquery-3.3.1.min.js') }}"></script>
    <!-- bootstrap bundle js-->
    <script src="{{ asset('public/BackEnd/js/bootstrap.bundle.js') }}"></script>
    <!-- slimscroll js-->
    <script src="{{ asset('public/BackEnd/js/jquery.slimscroll.js') }}"></script>
    <!-- chartjs js-->
    <script src="{{ asset('public/BackEnd/js/Chart.bundle.js') }}"></script>
    <script src="{{ asset('public/BackEnd/js/chartjs.js') }}"></script>

    <!-- main js-->
    <script src="{{ asset('public/BackEnd/js/main-js.js') }}"></script>
    {{-- <!-- jvactormap js-->
    <script src="{{asset('public/BackEnd/js/jquery-jvectormap-2.0.2.min.js')}}"></script>
    <script src="{{asset('public/BackEnd/js/jquery-jvectormap-world-mill-en.js')}}"></script> --}}
    <!-- sparkline js-->
    <script src="{{ asset('public/BackEnd/js/jquery.sparkline.js') }}"></script>
    <script src="{{ asset('public/BackEnd/js/spark-js.js') }}"></script>


    {{-- Ckeditor full package --}}
    <script src="//cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>

    <!-- https://jqueryvalidation.org/ -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>

    <!-- Auto Format Currency -->
    <script src="{{ asset('public/BackEnd/js/simple.money.format.js') }}"></script>

    <!-- Các thư viện js ui trong jquery -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    @include('frontend.index.script.active-after-selected')


    <script>
        const format_number = function(n, currency) {
            return n.toFixed().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,') + currency;
        };
    </script>

    <script>
        $('.format_price').simpleMoneyFormat();
    </script>

    <script>
        $(function() {
            $("#special_start").datepicker({
                prevText: "Tháng trước",
                nextText: "Tháng sau",
                dateFormat: "dd-mm-yy",
                todayHighlight: true,
                dayNamesMin: ["Thứ 2", "Thứ 3", "Thứ 4", "Thứ 5", "Thứ 6", "Thứ 7", "Chủ nhật"],
                duration: "slow"
            });
            $("#special_end").datepicker({
                prevText: "Tháng trước",
                nextText: "Tháng sau",
                dateFormat: "dd-mm-yy",
                todayHighlight: true,
                dayNamesMin: ["Thứ 2", "Thứ 3", "Thứ 4", "Thứ 5", "Thứ 6", "Thứ 7", "Chủ nhật"],
                duration: "slow"
            });
        });
    </script>

    <script>
        CKEDITOR.replace('Ckeditor_Desc');
        CKEDITOR.replace('Ckeditor_Content');
        CKEDITOR.replace('Ckeditor_Desc_Meta');
        CKEDITOR.replace('Ckeditor_Meta_Desc');
    </script>
    <script>
        const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

        function generateString(length) {
            let result = '';
            const charactersLength = characters.length;
            for (let i = 0; i < length; i++) {
                result += characters.charAt(Math.floor(Math.random() *
                    charactersLength));
            }
            return result;
        }
        var random_code = generateString(7);
    </script>
    <script>
        // Hàm function reset lại form validattion
        $.fn.clearValidation = function() {
            var v = $(this).validate();
            $('[name]', this).each(
                function() {
                    v.successList.push(this);
                    v.showErrors();
                });
            v.resetForm();
            v.reset();
        };
    </script>
    <script>
        $(document).ready(function() {
            get_active = [];
            $('#navbarNav .nav-link').each(function() {
                get_active.push($(this).data('active'));
            });
            new_arr = get_active.filter(item => Number.isInteger(item));

            for (i = 0; i < new_arr.length; i++) {
                $('#submenu-' + new_arr[i] + ' .nav-link').attr('data-active', new_arr[i]);
            }
        });
    </script>

    <script>
        //Accept validate
        $.validator.addMethod("accept", function(value, element, param) {
            // Split mime on commas in case we have multiple types we can accept
            var typeParam = typeof param === "string" ? param.replace(/\s/g, "") : "image/*",
                optionalValue = this.optional(element),
                i, file, regex;

            // Element is optional
            if (optionalValue) {
                return optionalValue;
            }

            if ($(element).attr("type") === "file") {

                // Escape string to be used in the regex
                // see: https://stackoverflow.com/questions/3446170/escape-string-for-use-in-javascript-regex
                // Escape also "/*" as "/.*" as a wildcard
                typeParam = typeParam
                    .replace(/[\-\[\]\/\{\}\(\)\+\?\.\\\^\$\|]/g, "\\$&")
                    .replace(/,/g, "|")
                    .replace(/\/\*/g, "/.*");

                // Check if the element has a FileList before checking each file
                if (element.files && element.files.length) {
                    regex = new RegExp(".?(" + typeParam + ")$", "i");
                    for (i = 0; i < element.files.length; i++) {
                        file = element.files[i];

                        // Grab the mimetype from the loaded file, verify it matches
                        if (!file.type.match(regex)) {
                            return false;
                        }
                    }
                }
            }
            // Either return true because we've validated each file, or because the
            // browser does not support element.files and the FileList feature
            return true;
        }, $.validator.format("Please enter a value with a valid mimetype"));

        //Extension validate
        $.validator.addMethod("extension", function(value, element, param) {
            param = typeof param === "string" ? param.replace(/,/g, "|") : "png|jpe?g|gif";
            return this.optional(element) || value.match(new RegExp("\\.(" + param + ")$", "i"));
        }, $.validator.format("Please enter a value with a valid extension."));

        //Value Not Equals validate
        $.validator.addMethod("valueNotEquals", function(value, element, arg) {
            // I use element.value instead value here, value parameter was always null
            return arg != element.value;
        }, "Value must not equal arg.");

        //Định dạng lại kiểm tra điều kiện date
        $.validator.addMethod("dateITA", function(value, element) {
            var check = false,
                // re = /^\d{1,2}\/\d{1,2}\/\d{4}$/, cho đấu cách date là /
                re = /^\d{1,2}\-\d{1,2}\-\d{4}$/, // cho đấu cách date là -
                adata, gg, mm, aaaa, xdata;
            if (re.test(value)) {
                adata = value.split("-");
                gg = parseInt(adata[0], 10);
                mm = parseInt(adata[1], 10);
                aaaa = parseInt(adata[2], 10);
                xdata = new Date(Date.UTC(aaaa, mm - 1, gg, 12, 0, 0, 0));
                if ((xdata.getUTCFullYear() === aaaa) && (xdata.getUTCMonth() === mm - 1) && (xdata.getUTCDate() ===
                        gg)) {
                    check = true;
                } else {
                    check = false;
                }
            } else {
                check = false;
            }
            return this.optional(element) || check;
        }, $.validator.messages.date);
    </script>

    @yield('script')

</body>

</html>
