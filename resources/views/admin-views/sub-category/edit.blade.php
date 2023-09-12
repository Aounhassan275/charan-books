@extends('layouts.admin.app')

@section('title', translate('Update category'))

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
                    {{ translate('Sub Category Update') }}
                </span>
            </h1>
        </div>
        <!-- End Page Header -->


        <div class="card">
            <div class="card-body">
                <form action="{{route('admin.sub-category.update',[$subCategory->id])}}" method="post" enctype="multipart/form-data">
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
                                    <input type="text" name="name" value="{{$subCategory->name}}" maxlength="255"  class="form-control" 
                                        placeholder="{{ translate('Name') }}" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label"
                                    for="exampleFormControlSelect1">{{translate('main')}} {{translate('category')}}
                                    <span class="input-label-secondary">*</span></label>
                                <select id="category_id" name="category_id" class="form-control" required>
                                    <option value="" selected>Select Category</option>
                                    @foreach(\App\Model\Category::where('parent_id',0)->get() as $category)
                                        <option {{$subCategory->category_id == $category->id ? 'selected' : ''}} value="{{$category['id']}}">{{$category['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label"
                                    for="exampleFormControlSelect1">Sub {{translate('category')}}
                                    <span class="input-label-secondary">*</span></label>
                                    <select id="sub_category_id" name="sub_category_id" class="form-control" required>
                                        @foreach(\App\Model\Category::where('parent_id',$subCategory->category_id)->get() as $category)
                                            <option {{$subCategory->sub_category_id== $category->id ? 'selected' : ''}} value="{{$category['id']}}">{{$category['name']}}</option>
                                        @endforeach
                                    </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label"
                                    for="exampleFormControlSelect1">Status
                                    <span class="input-label-secondary">*</span></label>
                                    <select id="status" name="status" class="form-control" required>
                                        <option value="">Select Status</option>
                                        <option {{$subCategory->status ? 'selected' : ''}} value="1">Active</option>
                                        <option {{!$subCategory->status ? 'selected' : ''}}  value="0">Inactive</option>
                                    </select>
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
        
        $('#category_id').change(function(){
            id = this.value;
            $.ajax({
                url: "{{route('admin.sub-category.get_sub_categories')}}",
                method: 'post',
                data: {
                    id: id,
                },
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(result){
                    categories = result.categories;
                    $('#sub_category_id').empty();
                    $('#sub_category_id').append('<option>Select Sub Categories</option>');
                    for (i=0;i<categories.length;i++){
                        $('#sub_category_id').append('<option value="'+categories[i].id+'">'+categories[i].name+'</option>');
                    }
                }
            });
        });
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
