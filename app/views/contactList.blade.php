@section('styles')
    <link rel="stylesheet" href="{{url('css/jquery.Jcrop.min.css')}}" type="text/css" />

    <style type="text/css">
        html, body {
            background:#FFF url(img/subtle_white_feathers.jpg);
        }

        #files img{
            width: auto;
            max-width: none;
        }

        /* Apply these styles only when #preview-pane has
           been placed within the Jcrop widget */
        .jcrop-holder #preview-pane {
            display: block;
            z-index: 2000;
            padding: 6px;
            border: 1px rgba(0,0,0,.4) solid;
            background-color: white;

            -webkit-border-radius: 6px;
            -moz-border-radius: 6px;
            border-radius: 6px;

            -webkit-box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2);
            -moz-box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2);
            box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2);
        }

        #imageContainer {
            margin: 30px 0 0;
            width: 320px;
        }

        #imageContainer.affix {
            top: 40px;
        }
        #imageContainer.affix-bottom {
            position: absolute;
            top: auto;
            bottom: 100;
        }

        /* The Javascript code will set the aspect ratio of the crop
           area based on the size of the thumbnail preview,
           specified here */
        #preview-pane .preview-container {
            width: 250px;
            height: 170px;
            overflow: hidden;
        }

        .fileinput-button {
            position: relative;
            overflow: hidden;
        }
        .fileinput-button input {
            position: absolute;
            top: 0;
            right: 0;
            margin: 0;
            opacity: 0;
            filter: alpha(opacity=0);
            transform: translate(-300px, 0) scale(4);
            font-size: 23px;
            direction: ltr;
            cursor: pointer;
        }
        .fileupload-buttonbar .btn,
        .fileupload-buttonbar .toggle {
            margin-bottom: 5px;
        }
        .progress-animated .bar {
            background: url(../img/progressbar.gif) !important;
            filter: none;
        }
        .fileupload-loading {
            float: right;
            width: 32px;
            height: 32px;
            background: url(../img/loading.gif) center no-repeat;
            background-size: contain;
            display: none;
        }
        .fileupload-processing .fileupload-loading {
            display: block;
        }

        @media (max-width: 767px) {
            .fileupload-buttonbar .toggle,
            .files .toggle,
            .files .btn span {
                display: none;
            }
            .files .name {
                width: 80px;
                word-wrap: break-word;
            }

            #imageContainer {
                width: auto;
                margin-bottom: 20px;
            }
            #imageContainer.affix {
                position: static;
                width: auto;
                top: 0;
            }

        }

        /* Desktop
        ------------------------- */
        @media (max-width: 980px) {

            #imageContainer  {
                top: 0;
                width: 218px;
                margin-top: 30px;
                margin-right: 0;
            }

        }

        @media (min-width: 768px) and (max-width: 979px) {

            /* Adjust sidenav width */
            #imageContainer {
                width: 166px;
                margin-top: 20px;
            }
            #imageContainer.affix {
                top: 0;
            }
        }

    </style>
@stop

@section('scripts')
    <script src="{{ url('js/vendor/spin.min.js')}}"></script>
    <script src="{{ url('js/vendor/jquery.ui.widget.js')}}"></script>
    <script src="{{ url('js/vendor/jquery.iframe-transport.js')}}"></script>
    <script src="{{ url('js/vendor/jquery.fileupload.js')}}"></script>
    <script src="{{ url('js/vendor/jquery.fileupload-process.js')}}"></script>
    <script src="{{ url('js/vendor/jquery.fileupload-validate.js')}}"></script>
    <script src="{{ url('js/vendor/jquery.Jcrop.min.js')}}"></script>

    <script type="text/javascript">
        jQuery(function(){
            // affix picture
            var $window = $(window);
            setTimeout(function () {
                $('#imageContainer').affix({
                    offset: {
                        //top: 300
                        top: function () { return $window.width() <= 980 ? 100 : 210 }
                        , bottom: 110
                    }
                })
            }, 100)

            $('#progress').hide();
            $('#downloadBtn').hide();

            function resetCoords()
            {
                $('#x').val('');
                $('#y').val('');
                $('#w').val('');
                $('#h').val('');
            };

            $('#fileupload').fileupload({
                url: "{{url('upload');}}",
                dataType: 'json',
                done: function (e, data) {
                    $('#progress').hide();
                    resetCoords();
                    $.each(data.result.files, function (index, file) {
                        console.log(file);
                        console.log(file.name);

                        $('#files').html($('<img/>').attr('src',file));
                        $('.jcrop-preview').attr('src',file);
                    });


                    // Create variables (in this scope) to hold the API and image size
                    var jcrop_api,
                            boundx,
                            boundy;

                    var boxSize = 300;

                    $('#files img').Jcrop({
                        onChange: updateCoords,
                        onSelect: updateCoords,
                        aspectRatio: 3/2,
                        minSize: 200,
                        maxSize: 200,
                        boxWidth: boxSize,
                        boxHeight: boxSize,
                    },function(){
                        // Use the API to get the real image size
                        var bounds = this.getBounds();
                        boundx = bounds[0];
                        boundy = bounds[1];
                        // Store the API in the jcrop_api variable
                        jcrop_api = this;
                        $(".jcrop-holder").css('margin', '0px auto');

                        // Move the preview into the jcrop container for css positioning
                        //$preview.appendTo(jcrop_api.ui.holder);
                    });

                    function updateCoords(c)
                    {
                        $('#x').val(c.x);
                        $('#y').val(c.y);
                        $('#w').val(c.w);
                        $('#h').val(c.h);
                    };
                },
                fail: function(){
                    alert('Error uploading an image');
                },
                always: function(e,data){
                    $('#progress').hide();
                },
                start: function(e,data){
                    $('#progress').show();
                },
                acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
                maxFileSize: 5000000,
                maxNumberOfFiles: 1,
                progressall: function (e, data) {
                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    $('#progress .bar').css(
                            'width',
                            progress + '%'
                    );
                }
            });

            // create spinner
            var opts = {
                lines: 13, // The number of lines to draw
                length: 20, // The length of each line
                width: 2, // The line thickness
                radius: 12, // The radius of the inner circle
                corners: 1, // Corner roundness (0..1)
                rotate: 0, // The rotation offset
                direction: 1, // 1: clockwise, -1: counterclockwise
                color: '#CCC', // #rgb or #rrggbb
                speed: 1, // Rounds per second
                trail: 67, // Afterglow percentage
                shadow: true, // Whether to render a shadow
                hwaccel: false, // Whether to use hardware acceleration
                className: 'spinner', // The CSS class to assign to the spinner
                zIndex: 2e9
            };

            ImageSpinner = new Spinner(opts).spin(document.getElementById('previewSpinner'));
            ImageSpinner.stop();

            $('#lostpetform').submit(function() {
                ImageSpinner.spin(document.getElementById('previewSpinner'));
                $.post("{{url('form')}}", $("#lostpetform").serialize())
                        .done(function(data) { $('#previewContainer').attr('src',data.image); $('#downloadBtn').fadeIn(400);})
                        .fail(function() { alert("error"); })
                        .always(function() { ImageSpinner.stop();});
                return false;
            });
        });
    </script>
@stop

@section('content')
    <div class="row" style="margin-top:30px;">
        <div class="span8 offset2">
            <h1 class="text-center">T-shirt maker</h1>
            <div class="well text-center">
                <p class="lead">This tool will help you envision yourself the best T-shirt</p>
                <p>Send contact info about your needs and desires.</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="well text-center" id="previewSpinner">
            @section('styles')
                <link rel="stylesheet" href="{{url('css/jquery.Jcrop.min.css')}}" type="text/css" />

                <style type="text/css">
                    html, body {
                        background:#FFF url(img/subtle_white_feathers.jpg);
                    }

                    #files img{
                        width: auto;
                        max-width: none;
                    }

                    /* Apply these styles only when #preview-pane has
                       been placed within the Jcrop widget */
                    .jcrop-holder #preview-pane {
                        display: block;
                        z-index: 2000;
                        padding: 6px;
                        border: 1px rgba(0,0,0,.4) solid;
                        background-color: white;

                        -webkit-border-radius: 6px;
                        -moz-border-radius: 6px;
                        border-radius: 6px;

                        -webkit-box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2);
                        -moz-box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2);
                        box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2);
                    }

                    #imageContainer {
                        margin: 30px 0 0;
                        width: 320px;
                    }

                    #imageContainer.affix {
                        top: 40px;
                    }
                    #imageContainer.affix-bottom {
                        position: absolute;
                        top: auto;
                        bottom: 100;
                    }

                    /* The Javascript code will set the aspect ratio of the crop
                       area based on the size of the thumbnail preview,
                       specified here */
                    #preview-pane .preview-container {
                        width: 250px;
                        height: 170px;
                        overflow: hidden;
                    }

                    .fileinput-button {
                        position: relative;
                        overflow: hidden;
                    }
                    .fileinput-button input {
                        position: absolute;
                        top: 0;
                        right: 0;
                        margin: 0;
                        opacity: 0;
                        filter: alpha(opacity=0);
                        transform: translate(-300px, 0) scale(4);
                        font-size: 23px;
                        direction: ltr;
                        cursor: pointer;
                    }
                    .fileupload-buttonbar .btn,
                    .fileupload-buttonbar .toggle {
                        margin-bottom: 5px;
                    }
                    .progress-animated .bar {
                        background: url(../img/progressbar.gif) !important;
                        filter: none;
                    }
                    .fileupload-loading {
                        float: right;
                        width: 32px;
                        height: 32px;
                        background: url(../img/loading.gif) center no-repeat;
                        background-size: contain;
                        display: none;
                    }
                    .fileupload-processing .fileupload-loading {
                        display: block;
                    }

                    @media (max-width: 767px) {
                        .fileupload-buttonbar .toggle,
                        .files .toggle,
                        .files .btn span {
                            display: none;
                        }
                        .files .name {
                            width: 80px;
                            word-wrap: break-word;
                        }

                        #imageContainer {
                            width: auto;
                            margin-bottom: 20px;
                        }
                        #imageContainer.affix {
                            position: static;
                            width: auto;
                            top: 0;
                        }

                    }

                    /* Desktop
                    ------------------------- */
                    @media (max-width: 980px) {

                        #imageContainer  {
                            top: 0;
                            width: 218px;
                            margin-top: 30px;
                            margin-right: 0;
                        }

                    }

                    @media (min-width: 768px) and (max-width: 979px) {

                        /* Adjust sidenav width */
                        #imageContainer {
                            width: 166px;
                            margin-top: 20px;
                        }
                        #imageContainer.affix {
                            top: 0;
                        }
                    }

                </style>
            @stop

            @section('scripts')
                <script src="{{ url('js/vendor/spin.min.js')}}"></script>
                <script src="{{ url('js/vendor/jquery.ui.widget.js')}}"></script>
                <script src="{{ url('js/vendor/jquery.iframe-transport.js')}}"></script>
                <script src="{{ url('js/vendor/jquery.fileupload.js')}}"></script>
                <script src="{{ url('js/vendor/jquery.fileupload-process.js')}}"></script>
                <script src="{{ url('js/vendor/jquery.fileupload-validate.js')}}"></script>
                <script src="{{ url('js/vendor/jquery.Jcrop.min.js')}}"></script>

                <script type="text/javascript">
                    jQuery(function(){
                        // affix picture
                        var $window = $(window);
                        setTimeout(function () {
                            $('#imageContainer').affix({
                                offset: {
                                    //top: 300
                                    top: function () { return $window.width() <= 980 ? 100 : 210 }
                                    , bottom: 110
                                }
                            })
                        }, 100)

                        $('#progress').hide();
                        $('#downloadBtn').hide();

                        function resetCoords()
                        {
                            $('#x').val('');
                            $('#y').val('');
                            $('#w').val('');
                            $('#h').val('');
                        };

                        $('#fileupload').fileupload({
                            url: "{{url('upload');}}",
                            dataType: 'json',
                            done: function (e, data) {
                                $('#progress').hide();
                                resetCoords();
                                $.each(data.result.files, function (index, file) {
                                    console.log(file);
                                    console.log(file.name);

                                    $('#files').html($('<img/>').attr('src',file));
                                    $('.jcrop-preview').attr('src',file);
                                });


                                // Create variables (in this scope) to hold the API and image size
                                var jcrop_api,
                                        boundx,
                                        boundy;

                                var boxSize = 300;

                                $('#files img').Jcrop({
                                    onChange: updateCoords,
                                    onSelect: updateCoords,
                                    aspectRatio: 3/2,
                                    minSize: 200,
                                    maxSize: 200,
                                    boxWidth: boxSize,
                                    boxHeight: boxSize,
                                },function(){
                                    // Use the API to get the real image size
                                    var bounds = this.getBounds();
                                    boundx = bounds[0];
                                    boundy = bounds[1];
                                    // Store the API in the jcrop_api variable
                                    jcrop_api = this;
                                    $(".jcrop-holder").css('margin', '0px auto');

                                    // Move the preview into the jcrop container for css positioning
                                    //$preview.appendTo(jcrop_api.ui.holder);
                                });

                                function updateCoords(c)
                                {
                                    $('#x').val(c.x);
                                    $('#y').val(c.y);
                                    $('#w').val(c.w);
                                    $('#h').val(c.h);
                                };
                            },
                            fail: function(){
                                alert('Error uploading an image');
                            },
                            always: function(e,data){
                                $('#progress').hide();
                            },
                            start: function(e,data){
                                $('#progress').show();
                            },
                            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
                            maxFileSize: 5000000,
                            maxNumberOfFiles: 1,
                            progressall: function (e, data) {
                                var progress = parseInt(data.loaded / data.total * 100, 10);
                                $('#progress .bar').css(
                                        'width',
                                        progress + '%'
                                );
                            }
                        });

                        // create spinner
                        var opts = {
                            lines: 13, // The number of lines to draw
                            length: 20, // The length of each line
                            width: 2, // The line thickness
                            radius: 12, // The radius of the inner circle
                            corners: 1, // Corner roundness (0..1)
                            rotate: 0, // The rotation offset
                            direction: 1, // 1: clockwise, -1: counterclockwise
                            color: '#CCC', // #rgb or #rrggbb
                            speed: 1, // Rounds per second
                            trail: 67, // Afterglow percentage
                            shadow: true, // Whether to render a shadow
                            hwaccel: false, // Whether to use hardware acceleration
                            className: 'spinner', // The CSS class to assign to the spinner
                            zIndex: 2e9
                        };

                        ImageSpinner = new Spinner(opts).spin(document.getElementById('previewSpinner'));
                        ImageSpinner.stop();

                        $('#lostpetform').submit(function() {
                            ImageSpinner.spin(document.getElementById('previewSpinner'));
                            $.post("{{url('form')}}", $("#lostpetform").serialize())
                                    .done(function(data) { $('#previewContainer').attr('src',data.image); $('#downloadBtn').fadeIn(400);})
                                    .fail(function() { alert("error"); })
                                    .always(function() { ImageSpinner.stop();});
                            return false;
                        });
                    });
                </script>
            @stop

            @section('content')
                <div class="row" style="margin-top:30px;">
                    <div class="span8 offset2">
                        <h1 class="text-center">T-shirt maker</h1>
                        <div class="well text-center">
                            <p class="lead">This tool will help you envision yourself the best T-shirt</p>
                            <p>Send contact info about your needs and desires.</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <table>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Data</th>
                        </tr>
                        @foreach ($contacts as $contact)
                            <tr>
                                <td>{{$contact->Name}}</td>
                                <td>{{$contact->Email}}</td>
                                <td>{{$contact->Data}}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            @stop
        </div>
    </div>


@stop