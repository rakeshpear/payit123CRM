@extends('layouts.master')



@section('title')

@lang('Weekly Reports')

@endsection



@section('css')

<!-- Bootstrap CSS -->
{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> --}}
<!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">-->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<!-- select2 css -->

<link href="{{ URL::asset('build/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


<!-- bootstrap-datepicker css -->

<link href="{{ URL::asset('build/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">



<!-- DataTables -->

<link href="{{ URL::asset('build/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

<!-- Animate CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

<!-- Responsive datatable examples -->

<link href="{{ URL::asset('build/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet"

    type="text/css" />

<style type="text/css">
    .card1 {
        background-color: #FFFDEC !important;
    }

    .card2 {
        background-color: #E2F1E7 !important;
    }

    .card2 {
        background-color: #F5EFFF !important;
    }
    
    #clientModal1 .modal-dialog {
      max-width: 60% !important;
      width: 60% !important;
    }

    #clientModal1 table td{
        padding: 2px !important;
    }

    #clientModal1 th:first-child {
        width: 15%; /* Adjust as needed */
        white-space: nowrap;
    }

    #clientModal1 th:not(:first-child) {
        width: 10%; /* Adjust as needed */
        white-space: nowrap;
    }
</style>

@endsection



@section('content')

@component('components.breadcrumb')

@slot('li_1')

Reports

@endslot

@slot('title')

Weekly Reports

@endslot

@endcomponent



<div class="row">

    <div class="col-lg-12">

        <div class="card card2">

            <div class="card-body">

                

                {{-- <form action="{{route('exportDataSingle')}}" method="get"> --}}
                    <input type="hidden" name="regenerationToken" value="">
                    <div class="row">

                        <div class="col-lg-4 d-inline-block">
                            <h4 class="card-title mb-3">Client - Agent Commission Setup</h4>
                            <label>Select Merchant</label>

                            <select name="client_Name" id="client_name" class="form-control" required>
                                <option value="">
                                    Select Client
                                </option>
                                @foreach ($clients as $client)
                                <option value="{{ $client->name }}">
                                    {{strtoupper($client->name) }}
                                </option>
                                @endforeach
                            </select>

                            <!-- Agent Modal -->
                            <div class="modal fade" id="clientModal" tabindex="-1" aria-labelledby="clientModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="clientModalLabel"></h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                        <table class="table" id="agentDetailsTable">
                                            <thead>
                                                <tr>
                                                    <th>Agent</th>
                                                    <th>Share %</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td colspan="3">No data available</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <button class="btn btn-success" id="addRow">Add New Row</button>
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" id="saveChanges" class="btn btn-primary">Save changes</button>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="col-lg-4">
                            <h4 class="card-title mb-3">Client - PSP Commission Setup</h4>
                            <label>Select Merchant</label>

                            <select name="client_Name1" id="client_name1" class="form-control" required>
                                <option value="">
                                    Select Client
                                </option>
                                @foreach ($clients as $client)
                                <option value="{{ $client->name }}">
                                    {{strtoupper($client->name) }}
                                </option>
                                @endforeach
                            </select>

                            <!-- PSP Modal -->
                            <div class="modal fade" id="clientModal1" tabindex="-1" aria-labelledby="clientModalLabel1" >
                                <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h1 class="modal-title1 fs-5" id="clientModalLabel1"></h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                        <table class="table" id="pspDetailsTable">
                                            <thead>
                                                <tr>
                                                    <th>PSP</th>
                                                    <th>USD</th>
                                                    <th>EUR</th>
                                                    <th>AUD</th>
                                                    <th>AED</th>
                                                    <th>JPY</th>
                                                    <th>GBP</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td colspan="3">No data available</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <button class="btn btn-success" id="addRow1">Add New Row</button>
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" id="saveChanges1" class="btn btn-primary">Save changes</button>
                                    </div>
                                </div>
                                </div>
                            </div>

                        </div>

                    </div>

                {{-- </form> --}}

            </div>

        </div>

    </div>

    <div class="col-lg-12">

        <div class="card card1">

            <div class="card-body">

                <h4 class="card-title mb-3">Weekly Report Generation - Individual Client</h4>

                <form action="{{route('exportDataSingle')}}" method="get">
                    <input type="hidden" name="regenerationToken" value="">
                    <div class="row">

                        <div class="col-lg-3">

                            <label>Merchant</label>

                            <select name="clientName" class="form-control" required>
                                <option value="">
                                    Select Client
                                </option>
                                @foreach ($clients as $client)
                                <option value="{{ $client->name }}">
                                    {{strtoupper($client->name) }}
                                </option>
                                @endforeach
                            </select>

                        </div>

                        <div class="col-lg-3">

                            <label>From Date</label>
                            <input type="date" name="orderdatefrom" class="form-control from_date" required>

                        </div>

                        <div class="col-lg-3">

                            <label>To Date</label>
                            <input type="date" name="orderdateto" class="form-control to_date" required>

                        </div>

                        <div class="col-lg-3 mt-4">
                            <button type="submit" class="btn btn-success">Generate</button>
                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <!--<div class="col-lg-12">-->

    <!--    <div class="card card2">-->

    <!--        <div class="card-body">-->

    <!--            <form action="{{route('exportData')}}" method="get">-->
    <!--                <input type="hidden" name="regenerationToken" value="">-->
    <!--                <div class="row">-->

                        
    <!--                    <div class="col-md-12">-->
                            <!-- Button trigger modal -->
    <!--                        <h4 class="card-title d-inline">Manual Weekly Report Generation - Whole Clients :   </h4>-->
    <!--                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#exampleModal">-->
    <!--                             Generate-->
    <!--                        </button>-->

                            <!-- Modal -->
    <!--                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">-->
    <!--                            <div class="modal-dialog" role="document">-->
    <!--                                <div class="modal-content">-->
    <!--                                    <div class="modal-header">-->
    <!--                                        <h5 class="modal-title" id="exampleModalLabel">Weekly Report Generation</h5>-->
    <!--                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
    <!--                                            <span aria-hidden="true">&times;</span>-->
    <!--                                        </button>-->
    <!--                                    </div>-->
    <!--                                    <div class="modal-body">-->
    <!--                                        Are you sure to generate ?-->
    <!--                                        <span class="text-danger">(It will override the current reports)</span>-->
    <!--                                    </div>-->
    <!--                                    <div class="modal-footer">-->
    <!--                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
    <!--                                        <button type="submit" class="btn btn-success">Generate</button>-->
    <!--                                    </div>-->
    <!--                                </div>-->
    <!--                            </div>-->
    <!--                        </div>-->
    <!--                    </div>-->

    <!--                </div>-->

    <!--            </form>-->

    <!--        </div>-->

    <!--    </div>-->

    <!--</div>-->

    <div class="col-lg-12">

        <div class="card card3">

            <div class="card-body">

                <h4 class="card-title mb-3">Weekly Reports</h4>

                <table class="table table-striped mt-5">
                    <thead>
                        <tr>
                             <th scope="col">CLIENT</th>
                            <th scope="col">START DATE</th>
                            <th scope="col">END DATE</th>
                            <th scope="col">WEEKLY REPORT</th>
                            <th scope="col">Current Payout Balance</th>
                            <th scope="col">Net Payout Balance</th>
                            <th scope="col">STATUS</th>
                            @can('WeeklyReports.download')
                                <th scope="col">APPROVE</th>
                                <th scope="col">REGENERATE</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($reports as $report)
                        @if($report->filePath !== null)
                        <tr>
                            <td>{{strtoupper(substr($report->clientName,11)) }}</td>
                            <td>{{$report->startDate}}</td>
                            <td>{{$report->endDate}}</td>                            
                            <td>
                               @if ($report->status == 1 || auth()->user()->can('WeeklyReports.download'))
                                    <a type="button" class="btn btn-sm btn-primary" href="{{url($report->filePath)}}" target="_blank">Download <i class="bi bi-download"></i></a>
                                @else                                    
                                    <a type="button" class="btn btn-sm btn-secondary disabled">Pending<i class="bi bi-download"></i></a>
                                @endif
                            </td>                               
                            <td>${{ number_format((float) $report->payoutAmt ?? 0, 2) }}</td>
                            <td>${{ number_format(optional($report->clientDetails)->payOutBalance ?? 0, 2) }}</td>
                            <td>
                                @if($report->status == null)
                                <span class="badge bg-primary animate__animated animate__tada animate__slow">New</span>
                                @elseif($report->status == 0)
                                <span class="badge bg-success">Rejected</span>
                                @elseif($report->status == 1)
                                <span class="badge bg-success">Approved</span>
                                @endif
                            </td>
                            @can('WeeklyReports.download')
                            <td>
                                @if($report->status !== 1)
                                <form action="{{route('approveReport', $report->id)}}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success" target="_blank">Approve <i class="bi bi-check-circle-fill"></i></button>
                                </form>
                                @else
                                <form action="{{route('revertApproval', $report->id)}}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-warning" target="_blank"><i class="bi bi-arrow-left-circle-fill"></i> Revert Approval</button>
                                </form>
                                @endif
                            </td>
                            <td>
                                <form action="{{route('exportDataSingle')}}" method="get">
                                    @csrf
                                    <input type="hidden" name="orderdatefrom" value="{{$report->startDate}}">
                                    <input type="hidden" name="orderdateto" value="{{$report->endDate}}">
                                    <input type="hidden" name="clientName" value="{{$report->clientName}}">
                                    <input type="hidden" name="regenrationToken" value="Regeneration">

                                    @if($report->status !== 1)
                                    <button type="submit" class="btn btn-sm btn-info">Regenerate <i class="bi bi-arrow-clockwise"></i></button>
                                    @else
                                    <button type="submit" class="btn btn-sm btn-secondary disabled">Regenerate <i class="bi bi-arrow-clockwise"></i></button>
                                    @endif
                                </form>
                            </td>
                            @endcan
                        </tr>
                        @endif
                        @endforeach

                    </tbody>
                </table>



            </div>

        </div>

    </div>

</div>

<!-- end row -->

@endsection

@section('script')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

<!-- select2 -->

<script src="{{ URL::asset('build/libs/select2/js/select2.min.js') }}"></script>

<!-- bootstrap-datepicker js -->

<script src="{{ URL::asset('build/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>



<!-- Required datatable js -->

<script src="{{ URL::asset('build/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>

<script src="{{ URL::asset('build/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>



<!-- Responsive examples -->

<script src="{{ URL::asset('build/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>

<script src="{{ URL::asset('build/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>



<!-- init js -->

<script src="{{ URL::asset('build/js/pages/crypto-orders.init.js') }}"></script>



<script>
$(document).ready(function() {

    // Agents Config Portion
    
    $('#client_name').on('change', function() {
        
        var clientId = $(this).val();
        
        if (clientId) {
            $.ajax({
                url: "{{ url('get_agent_details') }}/" + clientId, 
                type: "GET",
                cache: false,
                success: function(response)     {

                    console.log(response);

                    // Ensure response is an array
                    let agents = typeof response === "string" ? JSON.parse(response) : response;

                    if (!Array.isArray(agents)) {
                        console.error("Invalid response format:", response);
                        return;
                    }

                    let tableBody = $("#agentDetailsTable tbody");
                    tableBody.empty();

                    if (agents.length > 0) {
                        agents.forEach(function(agent) {
                            tableBody.append(`
                                <tr>
                                    <td><input type="text" class="form-control" name="agent[]" value="${agent.agent}"></td>
                                    <td><input type="number" class="form-control" name="share[]" value="${agent.share}"></td>
                                    <td>
                                        <button class="btn btn-danger deleteRow">X</button>
                                    </td>
                                </tr>
                            `);
                        });
                    } else {
                        tableBody.html("<tr><td colspan='3'>No records found</td></tr>");
                    }
                    $('.modal-title').text("Agents of " + clientId);
                    $('#clientModal').modal('show');
                    
                }
                })
            };
        })
    });

    $('#addRow').on('click', function() {
        $("#agentDetailsTable tbody").append(`
            <tr>
                <td><input type="text" class="form-control" name="agent[]" required placeholder="Enter Agent Name"></td>
                <td><input type="number" class="form-control" name="share[]" required placeholder="Enter Share"></td>
                <td><button class="btn btn-danger removeRow">X</button></td>
            </tr>
        `);
    });

    // Remove a row dynamically
    $(document).on('click', '.removeRow', function() {
        $(this).closest('tr').remove();
    });
   
    // Save changes to the database
    $('#saveChanges').on('click', function() {
        var agentData = [];

        $('#agentDetailsTable tbody tr').each(function() {
            var agent = $(this).find('input[name="agent[]"]').val();
            var share = $(this).find('input[name="share[]"]').val();

            if (agent && share) {
                agentData.push({ agent: agent, share: share });
            }
        });

        $.ajax({
            url: "{{ url('updateAgentDetails') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                clientName: $('#client_name').val(),
                agents: agentData
            },
            success: function(response) {
                alert('Data updated successfully!');
                $('#clientModal').modal('hide');
            },
            error: function(xhr, status, error) {
                console.error("Update Error:", error);
            }
        });
    });

    
    $(document).on("click", ".deleteRow", function() {
    
        let row = $(this).closest("tr"); // Get the row
        let agentName = row.find("input[name='agent[]']").val(); // Get the agent's name

        $.ajax({
            url: "{{ url('deleteAgent') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}", // CSRF protection
                agent: agentName, 
                clientName: $('#client_name').val(),
            },
            success: function(response) {
                if (response.success) {
                    row.remove(); // Remove row on success
                    $('#clientModal').modal('hide');
                } else {
                    alert("Failed to delete.");
                }
            },
            error: function(xhr) {
                alert("Something went wrong!");
            }
        });
    });



    // PSP Config Portions
    $('#client_name1').on('change', function() {
        
        var clientId = $(this).val();
        
        if (clientId) {
            $.ajax({
                url: "{{ url('get_psp_details') }}/" + clientId, 
                type: "GET",
                cache:false,
                success: function(response){

                      // Ensure response is an array
                      let psps;
                        try {
                            psps = typeof response === "string" ? JSON.parse(response) : response;
                        } catch (error) {
                            psps = []; // If JSON.parse fails, assign an empty array
                        }
                        psps = psps && typeof psps === "object" ? psps : [];

                        let tableBody = $("#pspDetailsTable tbody");
                        tableBody.empty();

                        if (psps.length > 0) {
                            psps.forEach(function(psp) {
                                tableBody.append(`
                                    <tr>
                                        <td><input type="text" class="form-control" name="pspName[]" value="${psp.pspName}"></td>
                                        <td><input type="number" class="form-control" name="usd[]" value="${psp.usd}"></td>
                                        <td><input type="number" class="form-control" name="eur[]" value="${psp.eur}"></td>
                                        <td><input type="number" class="form-control" name="aud[]" value="${psp.aud}"></td>
                                        <td><input type="number" class="form-control" name="aed[]" value="${psp.aed}"></td>
                                        <td><input type="number" class="form-control" name="jpy[]" value="${psp.jpy}"></td>
                                        <td><input type="number" class="form-control" name="gbp[]" value="${psp.gbp}"></td>
                                        <td>
                                            <button class="btn btn-danger deleteRow1">X</button>
                                        </td>
                                    </tr>
                                `);
                            });
                        } else {
                            tableBody.html("<tr><td colspan='8'>No records found</td></tr>");
                        }                                                           
                    $('.modal-title1').text("PSPs of" + clientId);
                    $('#clientModal1').modal('show');
            
                }
                })
        };
    });

    $('#addRow1').on('click', function() {
        $("#pspDetailsTable tbody").append(`
            <tr>
                <td><input type="text" class="form-control" name="pspName[]" required placeholder="Enter PSP Name"></td>
                <td><input type="number" class="form-control" name="usd[]" required placeholder="USD"></td>
                <td><input type="number" class="form-control" name="eur[]" required placeholder="EUR"></td>
                <td><input type="number" class="form-control" name="aud[]" required placeholder="AUD"></td>
                <td><input type="number" class="form-control" name="aed[]" required placeholder="AED"></td>
                <td><input type="number" class="form-control" name="jpy[]" required placeholder="JPY"></td>
                <td><input type="number" class="form-control" name="gbp[]" required placeholder="GBP"></td>
                <td><button class="btn btn-danger removeRow1">X</button></td>
            </tr>
        `);
    });

    // Remove a row dynamically
    $(document).on('click', '.removeRow1', function() {
        $(this).closest('tr').remove();
    });
    
    // Save changes to the database
    $('#saveChanges1').on('click', function() {
        var pspData = [];
        
        $('#pspDetailsTable tbody tr').each(function() {
            var pspName = $(this).find('input[name="pspName[]"]').val();
            var usd = $(this).find('input[name="usd[]"]').val() || "0.00";
            var eur = $(this).find('input[name="eur[]"]').val() || "0.00";
            var aed = $(this).find('input[name="aed[]"]').val() || "0.00";
            var aud = $(this).find('input[name="aud[]"]').val() || "0.00";
            var jpy = $(this).find('input[name="jpy[]"]').val() || "0.00";
            var gbp = $(this).find('input[name="gbp[]"]').val() || "0.00";


            console.log("Hello");

            console.log("USD: " + usd);
            console.log("EUR: " + eur);
            console.log("AED: " + aed);
            console.log("AUD: " + aud);
            console.log("JPY: " + jpy);
            console.log("GBP: " + gbp);

            if (pspName && usd && eur && aed && aud && jpy && gbp) {
                pspData.push({ 
                    pspName: pspName, 
                    usd: usd,
                    eur: eur,
                    aed: aed,
                    aud: aud,
                    jpy: jpy,
                    gbp: gbp 
                });
            }
        });

        console.log(pspData);

        $.ajax({
            url: "{{ url('updatePSPDetails') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                clientName: $('#client_name1').val(),
                psps: pspData
            },
            success: function(response) {
                alert('Data updated successfully!');
                $('#clientModal1').modal('hide');
            },
            error: function(xhr, status, error) {
                console.error("Update Error:", error);
            }
        });
    });

    $(document).on("click", ".deleteRow1", function() {
    
        let row = $(this).closest("tr"); // Get the row
        let pspName = row.find("input[name='pspName[]']").val(); // Get the agent's name

        $.ajax({
            url: "{{ url('deletePSP') }}",
            type: "POST",
            cache:false,
            data: {
                _token: "{{ csrf_token() }}", // CSRF protection
                psp: pspName, 
                clientName: $('#client_name1').val(),
            },
            success: function(response) {
                if (response.success) {
                    row.remove(); // Remove row on success
                } else {
                    alert("Failed to delete.");
                }
            },
            error: function(xhr) {
                alert("Something went wrong!");
            }
        });

    });


</script>




@endsection