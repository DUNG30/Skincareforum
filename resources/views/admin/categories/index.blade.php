@extends('admin.layout')

@section('title', 'Danh mục')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Danh sách danh mục</h1>

    {{-- Nút thêm danh mục --}}
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary mb-3">+ Thêm danh mục</a>

    @if($categories->isEmpty())
        <p>Chưa có danh mục nào.</p>
    @else
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Tên danh mục</th>
                    <th>Slug</th>
                    <th>Mô tả</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->slug }}</td>
                    <td>{{ $category->description }}</td>
                    <td>
                        {{-- Nút Sửa --}}
                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-warning btn-sm">Sửa</a>

                        {{-- Form Xóa --}}
                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Bạn có chắc muốn xóa danh mục này?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
