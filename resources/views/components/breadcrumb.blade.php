<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            @isset($route_back)
                <a href="{{ $route_back }}">Back</a>
            @endisset
            <h4 class="mb-sm-0 font-size-18">{{ $title }}</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    @isset($li_1)
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{ $li_1 }}</a></li>
                    @endisset
                    @isset($title)
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{ $title }}</a></li>
                    @endisset
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->
