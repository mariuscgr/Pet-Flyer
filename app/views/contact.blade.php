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
                {{ Form::open(array('url' => 'contactSave', 'id'=>'lostpetform','method' => 'post','class' => 'contact-form leftie_contact' ))}}
                <fieldset>
                    <legend class="text-left">Fill out the form below <small>(This information will not be stored)</small></legend>
                    <div class="text-left clearfix">
                        <input type="text" name="name" class="span4" placeholder="Name" value="" autofocus>
                        @if($errors->has('name'))
                            {{$errors->first('name', '<div class="inner_error">:message</div>')}}
                        @endif
                    </div>
                    <div class="text-left clearfix">
                        <input type="text" name="email" class="span4" placeholder="Email" value="">
                        @if($errors->has('email'))
                            {{$errors->first('email', '<div>:message</div>')}}
                        @endif
                    </div>
                    <div class="text-left clearfix">
                        <textarea name="data" class="span4" placeholder="Describe issue"></textarea>
                        @if($errors->has('data'))
                            {{$errors->first('data', '<div>:message</div>')}}
                        @endif
                    </div>
                    <div class="text-left  clearfix"><button type="submit" class="btn btn-large"><i class="icon-eye"></i>Send Info</button></div>
                </fieldset>
                {{ Form::close();}}
            </div>
    </div>

@stop