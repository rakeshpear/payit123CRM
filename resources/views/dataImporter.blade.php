<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Excel Data Inserter</title>

    {{-- Bootstrap Inclusion --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">

    <style>
        .cf-main, .cf-cards{
            padding: 2% 7% 2% !important;  
            align-items: center !important;
            text-align: center !important;
            margin-bottom: 2% !important;
        }

        .mainHead{
            font-family: "Bebas Neue", serif;
            font-weight: 400;
            font-size: 3em !important;
            color: #344CB7 !important;
        }

        .container{
            background-color: #FFFAEC !important;
            padding-bottom: 2% !important;
        }

        .cf-main{
            background-color: #E8F9FF !important;
        }

        .card{
            margin: auto !important;
        }

        .text-bg-orange{
            background-color: orangered !important;
            color: white !important;
        }
    </style>
</head>
<body>

    <div class="container-fluid cf-main d-flex">
            <div class="col-md-12">
                <h1 class="mainHead">Excel Data Importer</h1>
            </div>
    </div>

    
                <div class="container mt-4 mb-4">
                 
                    <form action="{{route('ExcelDataImporter')}}" method="post" class="row g-3" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-5">
                            <label for="file" class="form-label">Select Excel File</label>
                            <input type="file" name="file" class="form-control" id="file">
                        </div>
                
                        <!-- Submit Button -->
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">Submit</button>
                        </div>
                
                    </form>
                    
            </div>
           

    <div class="container-fluid cf-cards">
        <div class="row">
            <div class="col-md-12 row">
                
            </div>
        </div>
    </div>




    {{-- Bootstrap JS Inclusion --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


    

</body>
</html>