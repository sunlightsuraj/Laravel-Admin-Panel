<?php
/**
 * User: suraj
 * Date: 10/9/17
 * Time: 6:04 PM
 */
?>

@push('head')

    <!-- Add fancyBox -->
    <link rel="stylesheet" href="{{ url('fancybox/source/jquery.fancybox.css') }}" type="text/css" media="screen" />

    <!-- Optionally add helpers - button, thumbnail and/or media -->
    <link rel="stylesheet" href="{{ url('fancybox/source/helpers/jquery.fancybox-buttons.css') }}" type="text/css" media="screen" />

    <link rel="stylesheet" href="{{ url('fancybox/source/helpers/jquery.fancybox-thumbs.css') }}" type="text/css" media="screen" />
    <style type="text/css">
        .thumbnail .controls {
            position: absolute;
            right: 15px;
            display: none;
        }

        .thumbnail:hover .controls {
            display: block;
        }

        .thumbnail .controls a {
            display: block;
            padding: 10px;
            background-color: #5e5e5e;
            color: #fff;
        }
    </style>
@endpush

<section class="content-header">
    <a href="#" data-toggle="modal" data-target="#upload-image-modal" class="btn btn-primary btn-sm pull-right">Add Images</a>
    <h1>
        Images for {{ $product->product_title }}
    </h1>
</section>

<!-- Main content -->
<section class="content">
    @if(session('message'))
        <div class="alert alert-info alert-dismissible">
            <button class="close" data-dismiss="alert">&times;</button>
            {!! session('message') !!}
        </div>
    @endif

    {{-- images list --}}
        @if($productImages && $productImages->count())
            <div class="row">
                @foreach($productImages as $image)
                    <div class="col-md-3 col-sm-4">
                        <div class="thumbnail">
                            <div class="controls">
                                <a href="{{ route('admin_product_image_delete', $image->id) }}" onclick="return window.confirm('Are you sure you want to delete this image?');" class="delete-p-image" title="Delete Image"><i class="fa fa-remove"></i></a>
                            </div>
                            <a href="{{ url('uploads/product/original/' . $image->image) }}" class="fancybox" rel="product">
                                <img src="{{ url('uploads/product/thumbnail/' . $image->image) }}" alt="{{ $image->image }}"
                                     class="img-responsive">
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
</section>

<div class="modal square" id="upload-image-modal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">Upload Image</h3>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin_product_images_upload', $product->id) }}" id="upload-image-form" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="image-input" class="text-info">Select Images to Upload</label>
                        <input type="file" class="form-control" id="image-input" name="images[]"
                               title="Select images to upload" multiple>
                    </div>
                    <p class="text-warning small error"></p>
                    <div class="form-group">
                        <button class="btn btn-primary pull-right" type="submit">Upload</button>
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $("#upload-image-form").submit(function (event) {
                event.preventDefault();
                var t = $(this);
                var ok_btn = t.find('button[type="submit"]');
                var error_p = t.find(".error");
                var url = t.attr('action');
                ok_btn.html('<i class="fa fa-spinner fa-spin fa-pulse"></i> Upload').attr('disabled', true);
                error_p.html('');
                $.ajax({
                    url: url,
                    type: "POST",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'json',
                    success: function (response) {
                        ok_btn.html('Upload');
                        if(response.status == 'ok') {
                            window.location.reload();
                        } else {
                            ok_btn.removeAttr('disabled');
                            error_p.html(response.error);
                        }
                    },
                    error: function () {
                        ok_btn.html('Upload');
                        ok_btn.removeAttr('disabled');
                        error_p.html('Request failed.');
                    }
                });
            });
        });
    </script>



    <!-- Add mousewheel plugin (this is optional) -->
    <script type="text/javascript" src="{{ url('fancybox/lib/jquery.mousewheel.pack.js') }}"></script>
    <script type="text/javascript" src="{{ url('fancybox/source/jquery.fancybox.pack.js') }}"></script>
    <script type="text/javascript" src="{{ url('fancybox/source/helpers/jquery.fancybox-buttons.js') }}"></script>
    <script type="text/javascript" src="{{ url('fancybox/source/helpers/jquery.fancybox-media.js') }}"></script>
    <script type="text/javascript" src="{{ url('fancybox/source/helpers/jquery.fancybox-thumbs.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $(".fancybox").fancybox();
        });
    </script>
@endpush