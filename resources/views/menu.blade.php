<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Menu</title>
    <style>
        .container {
            padding: 5px;
        }

        th {
            text-align: left;
            border-bottom: 8px solid #ddd;
        }

        td {
            border-bottom: 1px solid #ddd;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Menu</h1>
        <table>
            <thead>
                <tr>
                    <th>Nr</th>
                    <th>Naam</th>
                    <th>Omschrijving</th>
                    <th>Soort</th>
                    <th>Prijs</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($menuItems as $item)
                <tr>
                    <td>{{  $item->menu_number }}{{ $item->addition ?? '' }}</td>
                    <td>{{  $item->dish->name }}</td>
                    <td>{{  $item->dish->description }}</td>
                    <td>{{  $item->dish->type->type }}</td>
                    <td>€{{ number_format($item->dish->price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="page-break"></div>

        <h1>Acties</h1>
        @foreach ($discounts as $discount)
        <div>
            <h2>{{$discount->title}}</h2>
            De promotie geldt voor de volgende producten:

            <table>
                @foreach ($discount->dishes as $dish)
                <tr>
                    <td>
                        {{$dish->name}}
                    </td>
                </tr>
                @endforeach
            </table>

            <p>
                {{$discount->text}}
            </p>

            <h3>Prijs: €{{$discount->price}}</h3>
            <p><i>Geldig van {{$discount->valid_from->toDateString()}} tot
                    {{  $discount->valid_till->toDateString() }}</i></p>
        </div>
        <hr>
        @endforeach
    </div>
</body>

</html>