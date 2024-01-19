<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        @page {
            header: page-header;
            footer: page-footer;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
        }

        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: center;
            padding: 8px;
        }

        .title {
            text-align: center;
        }
    </style>
</head>

<body>
    <h1 class="title">المخالفات</h1>

    <table>
        <tr>
            <th>العدد</th>
            <th>المخالفة</th>
            <th>العدد</th>
            <th>المخالفة</th>
        </tr>
        @foreach ($violations as $sub_array)
            {{-- This style because the data is chunked 2 elements in array in the parent array --}}
            <tr>
                @if ($sub_array->count() == 2)
                    <td>{{ $sub_array->last()->count }}</td>
                    <td>{{ $sub_array->last()->violation->title }}</td>
                @else
                    <td></td>
                    <td></td>
                @endif
                <td>{{ $sub_array->first()->count }}</td>
                <td>{{ $sub_array->first()->violation->title }}</td>
            </tr>
        @endforeach
    </table>
</body>

</html>
