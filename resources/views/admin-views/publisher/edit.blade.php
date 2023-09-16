@extends('layouts.admin.app')

@section('title', 'Update publisher')

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="{{asset('public/assets/admin/img/category.png')}}" class="w--24" alt="">
                </span>
                <span>
                    Publisher Update
                </span>
            </h1>
        </div>
        <!-- End Page Header -->


        <div class="card">
            <div class="card-body">
                <form action="{{route('admin.publisher.update',[$publisher->id])}}" method="post" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    @php($data = Helpers::get_business_settings('language'))
                    @php($default_lang = Helpers::get_default_language())
                    <div class="row align-items-end g-4">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label"
                                    for="exampleFormControlSelect1">Name 
                                    <span class="input-label-secondary">*</span></label>
                                    <input type="text" name="name" value="{{$publisher->name}}" maxlength="255"  class="form-control" 
                                        placeholder="{{ translate('Name') }}" required>
                            </div>
                        </div>

                    
                        <div class="col-12">
                            <div class="btn--container justify-content-end">
                                <button type="submit" class="btn btn--primary">{{translate('update')}}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('script_2')
    <script>
        
        $(".lang_link").click(function(e){
            e.preventDefault();
            $(".lang_link").removeClass('active');
            $(".lang_form").addClass('d-none');
            $(this).addClass('active');

            let form_id = this.id;
            let lang = form_id.split("-")[0];
            console.log(lang);
            $("#"+lang+"-form").removeClass('d-none');
            if(lang == '{{$default_lang}}')
            {
                $(".from_part_2").removeClass('d-none');
            }
            else
            {
                $(".from_part_2").addClass('d-none');
            }
        });
    </script>
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileEg1").change(function () {
            readURL(this);
        });
    </script>
@endpush
