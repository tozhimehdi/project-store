@extends('admin.layouts.master')
@section('title','لیست مقالات')

@section('styles')
<link rel="stylesheet" href="{{ asset('admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}">
<link rel="stylesheet" href="{{ asset('admin/vendor/libs/typeahead-js/typeahead.css') }}">
<link rel="stylesheet" href="{{ asset('admin/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('admin/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('admin/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('admin/vendor/libs/formvalidation/dist/css/formValidation.min.css') }}">
@endsection

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="d-flex align-items-center justify-content-between">
            {{-- @include('admin.partials.breadcrumps') --}}

            <div class="d-flex gap-2">
                {{-- @can('articles-create') --}}
                <a href="{{ route('articles.create') }}" class="btn btn-success text-white">
                    ایجاد مقاله جدید
                </a>
                {{-- @endcan --}}

                {{-- @can('articles-delete') --}}
                {{-- <a class="btn btn-danger text-white" href="{{ route('trashed.index') }}">
                    سطل زباله
                    <span class="badge ms-2">{{ $deletedCount }}</span>
                </a> --}}
                {{-- @endcan --}}

            </div>
        </div>

        <!-- Permission Table -->
        <div class="card">
            <div class="card-datatable table-responsive">
                <table id="rolesTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>عنوان مقاله</th>
                            <th>دسته بندی</th>
                            <th>نویسنده</th>
                            <th>وضعیت</th>
                            <th>تاریخ ایجاد</th>
                            <th>تاریخ انتشار</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($articles as $article)
                        <tr>
                            <td>{{ $article->name }}</td>
                            <td>
                                @foreach($article->categories as $category)
                                    <span class="badge bg-secondary">{{ $category->name }}</span>
                                @endforeach
                            </td>
                            <td>{{ $article->author->name }}</td>
                            <td><span class="badge bg-secondary">
                                @if ($article->status == 'draft')
                                    پیش نویس
                                    @elseif ($article->status == 'scheduled')
                                    زمانبندی شده
                                    @elseif ($article->status == 'published')
                                    منتشر شده
                                @endif
                            </span></td>
                            <td>{{ $article->created_at }}</td>
                            <td>{{ $article->published_at }}</td>
                            <td style="text-align: center !important; vertical-align: center !important;">
                                @can('articles-delete')
                                <form action="{{ route('articles.destroy',$article->id)}}" method="post"
                                      class="d-inline softDelete{{$article->id}}" onsubmit="softDelete({{$article->id}});">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="badge badge-center bg-label-warning"
                                            data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top"
                                            data-bs-html="true" style="border:none"
                                            data-bs-original-title="<i class='bx bx-trash bx-xs'></i> <span>حذف</span>">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </form>
                                @endcan
                                @can('articles-edit')
                                    <a href="{{route('articles.edit',$article)}}" class="badge badge-center
                                        bg-label-primary" data-bs-toggle="tooltip"
                                        data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true"
                                        data-bs-original-title="<i class='bx bx-edit bx-xs'></i> <span>ویرایش</span>">
                                        <i class="bx bx-edit"></i>
                                    </a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!--/ Permission Table -->

        <!-- Modals (Add/Edit Permission) -->
        <!-- ... (همون modals موجود شما بدون تغییر) ... -->

    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('admin/vendor/libs/formvalidation/dist/js/FormValidation.min.js') }}"></script>
<script src="{{ asset('admin/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js') }}"></script>
<script src="{{ asset('admin/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js') }}"></script>
<script src="{{ asset('admin/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#rolesTable').DataTable();
    });

    function softDelete($id) {
        event.preventDefault(); // prevent form submit
        var form = $('.softDelete' + $id); // storing the form
        $.alert({
            title: 'پیغام حذف',
            content: 'آیا از حذف رکورد موردنظر مطمئنید؟',
            rtl: true,
            closeIcon: true,
            buttons: {
                confirm: {
                    text: 'تایید',
                    btnClass: 'btn-blue',
                    action: function() {
                        form.submit();
                    }
                },
                cancel: {
                    text: 'انصراف',
                    action: function() {}
                }
            }
        });
    }
</script>
<link rel="stylesheet" href="{{ asset('admin/css/jquery-confirm.min.css') }}">
<script src="{{ asset('admin/js/jquery-confirm.min.js') }}"></script>
@endsection
