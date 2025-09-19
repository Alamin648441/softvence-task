<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>softVence task </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body {
            background: linear-gradient(to right, #e0f7fa, #e1bee7);
            font-family: 'Segoe UI', sans-serif;
        }

        .card {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .form-control,
        .form-select,
        textarea {
            background-color: #f0f4f8;
            border: 1px solid #ccc;
            color: #333;
        }

        .form-control::placeholder,
        textarea::placeholder {
            color: #888;
        }

        .btn-success {
            background-color: #4caf50;
            border: none;
        }

        .btn-outline-success {
            border-color: #4caf50;
            color: #4caf50;
        }

        .btn-outline-danger {
            border-color: #f44336;
            color: #f44336;
        }

        .btn-primary {
            background-color: #2196f3;
            border: none;
        }

        .contents-wrapper {
            background-color: #f9f9f9;
            border: 1px dashed #ccc;
            padding: 10px;
            border-radius: 8px;
            margin-top: 5px;
        }
    </style>
</head>

<body>


    <div class="container my-5">


        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-success">
            {{ session('error') }}
        </div>
        @endif
        <div class="card p-4">
            <h3 class="mb-3 text-center text-primary">Create New Course</h3>

            <form action="{{ route('courses.store') }}" method="POST" id="course-form">
                @csrf
                <input type="hidden" name="form_type" value="course">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <input type="text" name="title" class="form-control" placeholder="Course Title" required>
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="category" class="form-control" placeholder="Category">
                    </div>
                </div>

                <div class="mb-3">
                    <textarea name="description" class="form-control" rows="3" placeholder="Course Description"></textarea>
                </div>
                <h5 class="text-success">Modules</h5>
                <div id="modules-wrapper"></div>
                <button type="button" id="add-module" class="btn btn-success mb-3">+ Add Module</button>

                <button type="submit" class="btn btn-primary w-100">Save Course</button>
            </form>
        </div>
    </div>
    <!-- comment -->

    <script>
        let moduleIndex = 0;


        $('#add-module').click(function() {
            let m = moduleIndex;

            let moduleHtml = `
    <div class="card p-3 mb-3 module" data-module-index="${m}">
        <div class="d-flex justify-content-between mb-2">
            <strong>Module ${m + 1}</strong>
            <button type="button" class="btn btn-sm btn-outline-danger remove-module">Remove</button>
        </div>

        <input type="text" name="modules[${m}][title]" class="form-control mb-2" placeholder="Module Title" required>
        <textarea name="modules[${m}][description]" class="form-control mb-2" placeholder="Module Description"></textarea>

        <div class="contents-wrapper">
            <div class="content-item mb-2" data-content-index="0">
                <input type="text" name="modules[${m}][contents][0][title]" class="form-control mb-1" placeholder="Content Title">
                <select name="modules[${m}][contents][0][type]" class="form-select mb-1">
                    <option value="text">Text</option>
                    <option value="image">Image URL</option>
                    <option value="video">Video URL</option>
                    <option value="link">Link</option>
                </select>
                <textarea name="modules[${m}][contents][0][body]" class="form-control mb-1" placeholder="Content Body/URL"></textarea>
                <button type="button" class="btn btn-sm btn-outline-danger remove-content">Remove Content</button>
            </div>
        </div>

        <button type="button" class="btn btn-sm btn-outline-success add-content mt-2">+ Add Content</button>
    </div>`;

            $('#modules-wrapper').append(moduleHtml);
            moduleIndex++;
        });


        $(document).on('click', '.remove-module', function() {
            $(this).closest('.module').remove();
        });

        

        $(document).on('click', '.add-content', function() {
            let moduleDiv = $(this).closest('.module');
            let m = moduleDiv.data('module-index');
            let cIndex = moduleDiv.find('.content-item').length;

            let contentHtml = `
    <div class="content-item mb-2" data-content-index="${cIndex}">
        <input type="text" name="modules[${m}][contents][${cIndex}][title]" class="form-control mb-1" placeholder="Content Title">
        <select name="modules[${m}][contents][${cIndex}][type]" class="form-select mb-1">
            <option value="text">Text</option>
            <option value="image">Image URL</option>
            <option value="video">Video URL</option>
            <option value="link">Link</option>
        </select>
        <textarea name="modules[${m}][contents][${cIndex}][body]" class="form-control mb-1" placeholder="Content Body/URL"></textarea>
        <button type="button" class="btn btn-sm btn-outline-danger remove-content">Remove Content</button>
    </div>`;

            moduleDiv.find('.contents-wrapper').append(contentHtml);
        });


        $(document).on('click', '.remove-content', function() {
            $(this).closest('.content-item').remove();
        });
    </script>

</body>

</html>