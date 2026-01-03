@extends('admin.layouts.master')
@section('title','ایجاد مقاله')

@section('styles')
<link rel="stylesheet" href="{{ asset('admin/vendor/libs/flatpickr/flatpickr.css') }}">
<link rel="stylesheet" href="{{ asset('admin/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}">
<link rel="stylesheet" href="{{ asset('admin/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css') }}">
<link rel="stylesheet" href="{{ asset('admin/vendor/libs/jquery-timepicker/jquery-timepicker.css') }}">
<link rel="stylesheet" href="{{ asset('admin/vendor/libs/pickr/pickr-themes.css') }}">
<link rel="stylesheet" href="{{ asset('admin/vendor/libs/select2/select2.css') }}">
<link rel="stylesheet" href="{{ asset('admin/vendor/libs/tagify/tagify.css') }}">
<link rel="stylesheet" href="{{ asset('admin/vendor/libs/bootstrap-select/bootstrap-select.css') }}">




@endsection

@section('content')
<div class="d-flex align-items-center justify-content-between">
  {{-- @section('breadcrump')
  <li class="breadcrumb-item">
    <a href="{{ route('articles.index') }}">لیست مقالات</a>
  </li>
  @endsection
  @include('admin.partials.breadcrumps') --}}

  <div class="d-flex gap-2">
      <a href="{{ route('articles.index') }}" class="btn btn-danger text-white">
          بازگشت
      </a>
  </div>
</div>
<form action="{{ route('articles.store') }}" method="post">
  @csrf
  
  <!-- Basic Layout -->
              <div class="row">
                <div class="col-xl-8">
                  <div class="card mb-4">
                    <div class="card-body">
                      {{-- @include('errors.error') --}}
                        <div class="mb-3">
                          <label class="form-label" for="basic-default-fullname">عنوان مقاله</label>
                          <input type="text" name="name" value="{{ old('name') }}" class="form-control" id="basic-default-fullname">
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="basic-default-fullname">متن مقاله</label>
                          <textarea name="body" id="editor">{!! old('body') !!}</textarea>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="basic-default-company">عنوان متا</label>
                          <input type="text" name="meta_title" value="{{ old('meta_title') }}" class="form-control" data-max="60">
                          <small class="text-muted char-counter"></small>

                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="basic-default-message">توضیحات متا</label>
                          <textarea name="meta_description" class="form-control"  data-max="160">{{ old('meta_description') }}</textarea>
                          <small class="text-muted char-counter"></small>

                        </div>
                        <button type="submit" class="btn btn-success">ثبت مقاله</button>
                    </div>
                  </div>
                </div>
                <div class="col-xl">
                  <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                      <h5 class="mb-0">اطلاعات پایه</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                          <label class="form-label" for="basic-icon-default-fullname">تاریخ انتشار</label>
                          <input type="hidden" name="published_at" class="form-control flatpickr-input" placeholder="YYYY/MM/DD - HH:MM" id="flatpickr-datetime">
                        </div>

                        <div class="form-group">
                          <label>انتخاب فایل</label>
                          <div class="input-group">
                              <span class="input-group-btn">
                                  <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary" style="color:white">
                                      <i class="fa fa-picture-o"></i> انتخاب
                                  </a>
                              </span>
                              <input id="thumbnail" class="form-control" type="text" name="image">
                          </div>
                          <div id="holder" style="margin-top:15px;max-height:100px;"></div>
                      </div>

                        <div class="mb-3">
                          <label for="select2Multiple" class="form-label">انتخاب دسته بندی</label>
                          <select id="select2Basic" name="categories[]" multiple class="select2 form-select form-select-lg" data-allow-clear="true">

                            {{-- @foreach($categories as $category)
                              @include('admin.partials.category-option', [
                                'category' => $category,
                                'level' => 0
                             ])
                            @endforeach --}}
                         </select>
                        </div>

                        <div class="mb-3">
                            <label for="TagifyCustomListSuggestion" class="form-label">برچسب ها</label>
                            <input id="TagifyCustomListSuggestion2" class="form-control" 
                             name="tags[]">
                        </div>

                        <div class="mb-3">
                            <label for="selectpickerBasic" class="form-label">وضعیت مقاله</label>
                            <select id="selectpickerBasic" class="selectpicker w-100" name="status" data-style="btn-default">
                              <option value="drafts" selected>پیش نویس</option>
                              <option value="published">منتشر شده</option>
                            </select>
                        </div>
                        <div class="mb-3">
                          <label class="me-3 switch switch-primary">
                              <input type="checkbox" class="switch-input" name="is_comment" checked>
                              <span class="switch-toggle-slider">
                                  <span class="switch-on">
                                      <i class="bx bx-check"></i>
                                  </span>
                                  <span class="switch-off">
                                      <i class="bx bx-x"></i>
                                  </span>
                              </span>
                              <span class="switch-label">امکان ثبت نظر</span>
                          </label>
                      </div>
                      
                        </div>
                        
                        <button type="submit" class="btn btn-success">ثبت مقاله</button>
                    </div>
                  </div>
                </div>
              </div>
</form>
@endsection

@section('scripts')

<script src="{{ asset('admin/js/forms-selects.js') }}"></script>
<script src="{{ asset('admin/vendor/libs/select2/select2.js') }}"></script>
<script src="{{ asset('admin/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>

<script src="{{ asset('admin/vendor/libs/jdate/jdate.js') }}"></script>
<script src="{{ asset('admin/vendor/libs/flatpickr/flatpickr-jdate.js') }}"></script>
<script src="{{ asset('admin/vendor/libs/flatpickr/l10n/fa-jdate.js') }}"></script>
<script src="{{ asset('admin/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('admin/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js') }}"></script>
<script src="{{ asset('admin/vendor/libs/jquery-timepicker/jquery-timepicker.js') }}"></script>
<script src="{{ asset('admin/vendor/libs/pickr/pickr.js') }}"></script>

<!-- Page JS -->
<script src="{{ asset('admin/js/forms-pickers.js') }}"></script>

<!-- For File input -->
{{-- <script src="{{ asset('/vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script> --}}


<script src="{{ asset('admin/vendor/libs/tagify/tagify.js') }}"></script>

<script src="{{ asset('admin/js/forms-tagify.js') }}"></script>


<script src="{{ asset('admin/ckeditor/ckeditor.js') }}"></script>

<script>
  // Laravel File Manager
  var options = {
      // تنظیمات اتصال به UniSharp File Manager
      filebrowserImageBrowseUrl: '/managment/laravel-filemanager?type=Images',
      filebrowserImageUploadUrl: '/managment/laravel-filemanager/upload?type=Images&_token={{csrf_token()}}',
      filebrowserBrowseUrl: '/managment/laravel-filemanager?type=Files',
      filebrowserUploadUrl: '/managment/laravel-filemanager/upload?type=Files&_token={{csrf_token()}}',
      
      // تنظیمات زبان و فونت
      language: 'fa',
      contentsLangDirection: 'rtl',
      font_defaultLabel: 'Tahoma',
      
      // اختیاری: تنظیم ارتفاع
      height: 400
  };

  // اجرا روی TextArea
  CKEDITOR.replace('editor', options);
  
</script>

{{-- <script>
$('#lfm').filemanager('image', {
    prefix: '/managment/laravel-filemanager'
});
</script> --}}

{{-- <script>
  //انتخاب والد دسته انتخاب شده بصورت اتومات
  $(document).ready(function () {
      const select = $('#select2Basic');
  
      select.select2({
          allowClear: true
      });
  
      select.on('select2:select', function (e) {
          let selectedOption = e.params.data.element;
          selectParent(selectedOption);
      });
  
      function selectParent(option) {
          let parentId = $(option).data('parent');
  
          if (parentId) {
              let parentOption = select.find('option[value="' + parentId + '"]');
  
              if (!parentOption.prop('selected')) {
                  parentOption.prop('selected', true);
                  select.trigger('change');
  
                  // بازگشتی: والدِ والد هم انتخاب شود
                  selectParent(parentOption);
              }
          }
      }
  });
  </script>


<script>
  var input = document.querySelector('#TagifyCustomListSuggestion2');

  var tagify = new Tagify(input, {
      whitelist: @json($allTags),
      dropdown: {
          maxItems: 20,
          classname: "tags-look",
          enabled: 0, // 0 یعنی با فوکوس باز میشه
          closeOnSelect: false,
          enforceWhitelist: true

      }
  });
</script> --}}
  

@endsection