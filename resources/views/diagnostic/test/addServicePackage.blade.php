@extends('app')
@section('extra-css')
    <style>
        .tt-input {
            text-align: center;
        }

        #search_container .tt-menu {
            max-height: 200px;
            overflow-y: auto;
            font-size: 14px;
        }

        .tt-suggestion {
            background-color: #3c8dbc;
            color: #ffffff;
            min-width: 200px;
        }

        .tt-suggestion:hover {
            background-color: #1b5f86;
            color: #ffffff;
        }

        .typeahead, .tt-suggestion .tt-selectable {
            height: 40px;
            font-size: 24px;
            line-height: 30px;
            border: 1px solid #ccc;
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            border-radius: 4px;
            outline: none;
        }

    </style>
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Doctor Information
            <small>Preview</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">HR</a></li>
            <li class="active">Doctor Information</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- SELECT2 EXAMPLE -->
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">

                    <a href="{{route('diagnostic-test')}}" class="btn btn-info btn-md">
                        <i class="fa fa-shopping-cart"></i>&nbsp;
                        View Service Package
                    </a>

                    <a href="{{route('diagnostic.sale-diagnotic-test')}}" class="btn btn-info btn-md">
                        <i class="fa fa-shopping-cart"></i>&nbsp;
                        Sale Diagnostic Test
                    </a>

                </h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i>
                    </button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{route('save-servicePackage.post')}}" id="myForm"
                              method="post" accept-charset="utf-8">
                            <!-- SmartWizard html -->

                            {{csrf_field()}}

                            <div class="col-md-12">

                                <div class="form-group">
                                    <label for="service_package_name" class="col-md-2">Service Package Name</label>
                                    <div class="col-md-10">
                                        {{Form::text("service_package_name",
                                           '',
                                           [
                                              "class" => "form-control",
                                              "placeholder" => "Service Package Name",
                                           ])
                                           }}

                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>

                            </div>
                            <hr>


                            <div class="col-md-1">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="service_type" value="service"
                                               checked>
                                        Service
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-1">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="service_type" value="group">
                                        Group
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-10">
                                <div class="form-group text-center">
                                    <div id="search_container">
                                        <input class="form-control typeahead text-center" id="search" name="q"
                                               type="text"
                                               placeholder="Search Service">
                                    </div>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>

                            <div class="col-md-12" style="margin-top: 10px;">
                                <div class="box box-success">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Service</h3>
                                        <!-- /.box-tools -->
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <div id="service_content"></div>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                                <!-- /.box -->
                            </div>

                            <div class="row">
                                <div id="service_total">
                                    <div class="col-md-12">
                                        <div class="table-responsive pull-right">
                                            <table class="table">
                                                <tbody>
                                                <tr>
                                                    <th>Total:</th>
                                                </tr>
                                                <tr>
                                                    <td id="stotal">0.00</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-info pull-right">Submut</button>
                                </div>
                            </div>

                            <hr>

                        </form>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                Visit <a href="https://select2.github.io/">Select2 documentation</a> for more examples and information
                about the plugin.
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script src="{{URL::to('public/assets/plugins/typeahead.bundle.js')}}"></script>

    <script>
        var service_type = $("input[name='service_type']:checked").val();
        var baseUrl = '<?php echo URL::to(''); ?>';
        $(document).ready(function () {
            var bloodhound = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.whitespace,
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                remote: {
                    url: baseUrl + '/diagnostic/search_service?q=%QUERY%&service_type=%service_type%',
                    prepare: function (query, settings) {
                        settings.url = settings.url.replace('%QUERY', query);
                        settings.url = settings.url.replace('%service_type%', $("input[name='service_type']:checked").val());
                        return settings;
                    },
                    wildcard: '%QUERY%'
                }
            });

            $('#search').typeahead({
                hint: true,
                highlight: true,
                minLength: 1
            }, {
                name: 'q',
                source: bloodhound,
                limit: 10,
                display: function (data) {
                    if (data.hasOwnProperty('diagnostic_test_name')) {
                        return data.diagnostic_test_name  //Input value to be set when you select a suggestion.
                    }
                    else {
                        return data.service_group_name  //Input value to be set when you select a suggestion.
                    }
                },
                templates: {
                    empty: [
                        '<div class="list-group search-results-dropdown"><div class="list-group-item">Nothing found.</div></div>'
                    ],
                    header: [
                        '<div class="list-group search-results-dropdown">'
                    ],
                    suggestion: function (data) {
                        if (data.hasOwnProperty('diagnostic_test_name')) {
                            return '<div style="cursor: pointer; font-weight:normal; margin-top:-10px ! important;" class="list-group-item">' + data.diagnostic_test_name + '</div></div>'
                        }
                        else {
                            return '<div style="cursor: pointer; font-weight:normal; margin-top:-10px ! important;" class="list-group-item">' + data.service_group_name + '</div></div>'
                        }
                    }
                }
            }).on('typeahead:selected', function (obj, serviceData) {

                if (serviceData.hasOwnProperty('diagnostic_test_name')) {
                    var DTID = serviceData.diagnostic_test_id;

                    $.ajax
                    ({
                        type: "GET",
                        url: baseUrl + "/diagnostic/add-service",
                        data: {
                            dtid: DTID,
                            type: 'service'
                        },
                        success: function (html) {
                            $("#service_content").append(html);
                            $("#search").val('');
                            totalCount();
                        }
                    });

                }
                else {
                    var DTID = serviceData.service_group_id;
                    $.ajax
                    ({
                        type: "GET",
                        url: "add-service",
                        data: {
                            dtid: DTID,
                            type: 'group'
                        },
                        success: function (html) {
                            $("#service_content").append(html);
                            $("#search").val('');
                            totalCount();
                        }
                    });
                }
            });

            $('#sc').change(function () { //any select change on the dropdown with id  trigger this code
                $("#ssc > option").remove(); //first of all clear select items
                var sc_id = $('#sc').val(); // here we are taking  id of the selected one.
                $.ajax({
                    type: "GET",
                    data: {id: sc_id},
                    url: "{{url('diagnostic/get-diagnostic-ssc')}}", //here we are calling our user controller and  method with the id
                    success: function (categories) //we're calling the response json array 'categories'
                    {
                        $.each(categories, function (id, category) //here we're doing a foeach loop round each cat with id as the key and cat as the value
                        {
                            var opt = $('<option />'); // here we're creating a new select option with for each cat
                            opt.val(id);
                            opt.text(category);
                            $('#ssc').append(opt); //here we will append these new select options to a dropdown with the id 'categories'
                        });
                    }
                });
            });

        });

        function totalCount() {
            var salePriceElements = $('input[name*="diagnostic_test_sale_price"]');
            var total = 0;
            for (i = 0; i < salePriceElements.length; i++) {
                total = parseInt(total) + parseInt($(salePriceElements[i]).val());
            }
            $("#stotal").html(total);
        }

        $(window).click(function () {
            $("#search").val('');
        });

    </script>

@endsection

