@extends('layouts.admin.app')

@section('title', translate('Add new sub category'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                    {{translate('sub_sub_category_setup')}}
                </span>
            </h1>
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('admin.sub-category.store')}}" method="post">
                            @csrf
                            @php($data = Helpers::get_business_settings('language'))
                            @php($default_lang = Helpers::get_default_language())

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label"
                                            for="exampleFormControlSelect1">Name 
                                            <span class="input-label-secondary">*</span></label>
                                            <input type="text" name="name" maxlength="255"  class="form-control" 
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
                                                <option value="{{$category['id']}}">{{$category['name']}}</option>
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
                                            
                                            </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label"
                                            for="exampleFormControlSelect1">Status
                                            <span class="input-label-secondary">*</span></label>
                                            <select id="status" name="status" class="form-control" required>
                                                <option value="" selected>Select Status</option>
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="btn--container justify-content-end">
                                        <button type="submit" class="btn btn--primary">{{translate('submit')}}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="card--header">
                            <h5 class="card-title">{{translate('Sub Category Table')}} <span class="badge badge-soft-secondary">{{ $categories->total() }}</span> </h5>
                            <form action="{{url()->current()}}" method="GET">
                                <div class="input-group">
                                    <input id="datatableSearch_" type="search" name="search"
                                            class="form-control pl-5"
                                           placeholder="{{translate('Search_by_Name')}}" aria-label="Search"
                                            value="{{$search}}" required autocomplete="off">
                                           <i class="tio-search tio-input-search"></i>
                                    <div class="input-group-append">
                                        <button type="submit" class="input-group-text">
                                            {{translate('search')}}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Table -->
                    <div class="table-responsive datatable-custom">
                        <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                            <thead class="thead-light">
                            <tr>
                                <th class="text-center">{{translate('#')}}</th>
                                <th>Name</th>
                                <th>{{translate('main')}} {{translate('category')}}</th>
                                <th>{{translate('sub_category')}}</th>
                                <th>{{translate('status')}}</th>
                                <th class="text-center">{{translate('action')}}</th>
                            </tr>

                            </thead>

                            <tbody id="set-rows">
                            @foreach($categories as $key=>$category)
                                <tr>
                                    <td class="text-center">{{$key+1}}</td>
                                    <td>
                                        <span class="d-block font-size-sm text-body">
                                            {{$category->name}}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="d-block font-size-sm text-body">
                                            {{@$category->category->name}}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="d-block font-size-sm text-body">
                                            {{@$category->subCategory->name}}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="d-block font-size-sm text-body">
                                            {{$category->status ? 'Active' : 'Inactive'}}
                                        </span>

                                        {{-- <label class="toggle-switch">
                                            <input type="checkbox"
                                                onclick="status_change_alert('{{ route('admin.category.status', [$category->id, $category->status ? 0 : 1]) }}', '{{ $category->status? translate('you_want_to_disable_this_category'): translate('you_want_to_active_this_category') }}', event)"
                                                class="toggle-switch-input" id="stocksCheckbox{{ $category->id }}"
                                                {{ $category->status ? 'checked' : '' }}>
                                            <span class="toggle-switch-label text">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label> --}}

                                    </td>
                                    <td>
                                        <!-- Dropdown -->
                                        <div class="btn--container justify-content-center">
                                            <a class="action-btn"
                                                href="{{route('admin.sub-category.edit',[$category->id])}}">
                                            <i class="tio-edit"></i></a>
                                            <a class="action-btn btn--danger btn-outline-danger" href="javascript:"
                                                onclick="form_alert('category-{{$category->id}}','{{ translate('Want to delete this') }}')">
                                                <i class="tio-delete-outlined"></i>
                                            </a>
                                        </div>
                                        <form action="{{route('admin.sub-category.destroy',[$category->id])}}"
                                                method="post" id="category-{{$category->id}}">
                                            @csrf @method('delete')
                                        </form>
                                        <!-- End Dropdown -->
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                         
                        @if(count($categories) == 0)
                        <div class="text-center p-4">
                            <img class="w-120px mb-3" src="{{asset('/public/assets/admin/svg/illustrations/sorry.svg')}}" alt="Image Description">
                            <p class="mb-0">{{translate('No_data_to_show')}}</p>
                        </div>
                        @endif

                        <div class="page-area">
                            <table>
                                <tfoot>
                                {!! $categories->links() !!}
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Table -->
        </div>
    </div>
@endsection

@push('script_2')
<script>

        function status_change_alert(url, message, e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: message,
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: 'default',
                confirmButtonColor: '#107980',
                cancelButtonText: 'No',
                confirmButtonText: 'Yes',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    location.href = url;
                }
            })
        }
</script>
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
        $('#search-form').on('submit', function () {
            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('admin.category.search')}}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    $('#set-rows').html(data.view);
                    $('.page-area').hide();
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        });
    </script>
@endpush
