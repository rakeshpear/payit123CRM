@if(session()->has('success'))
    <div class="alert alert-success alert-dismissible">
    <!-- <button type="button" class="close" data-dismiss="alert">&times;</button> -->
        {{ session()->get('success') }}
    </div>
@endif
@if(session()->has('error'))
<div class="alert alert-danger alert-dismissible">
<!-- <button type="button" class="close" data-dismiss="alert">&times;</button> -->
        {{ session()->get('error') }}
    </div>
@endif 
@if(session()->has('info'))
    <div class="alert alert-info alert-dismissible">
    <!-- <button type="button" class="close" data-dismiss="alert">&times;</button> -->
        {{ session()->get('info') }}
    </div>
@endif
@if(session()->has('warning'))
    <div class="alert alert-warning alert-dismissible">
    <!-- <button type="button" class="close" data-dismiss="alert">&times;</button> -->
        {{ session()->get('warning') }}
    </div>
@endif              
@if ($errors->any())
    <div class="alert alert-danger alert-dismissible">
        <!-- <button type="button" class="close" data-dismiss="alert">&times;</button> -->
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Automatically close the success and error alerts after 3 seconds
        $(".alert").fadeTo(3000, 0).slideUp(500, function(){
            $(this).remove();
        });
    });
</script>
