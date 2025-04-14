
<form id="edit-form">


    <!-- Modal body -->
    <div class="row">

        <div class="form-group col-lg-12 mt-2">
            <label>Project Title<span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="name" value="{{ $projects->name }}" placeholder="Type Title" required />
        </div>


        <div class="form-group col-lg-6 mt-2">
            <label>Start Date <span class="text-danger"></span></label>
            <input type="date" class="form-control" name="start_date" value="{{ $projects->start_date }}" placeholder="Select Date" />
        </div>

        <div class="form-group col-lg-6 mt-2">
            <label for="designation-input" class="form-label">Deadline</label>
            <input type="date" class="form-control" placeholder="" name="deadline" value="{{ $projects->deadline }}" />
        </div>

        <div class=" col-lg-6 mt-2"> 
            <div class="form-group">
                <label>Email <span class="text-danger"></span></label>
                <select class="form-control select"  name="multi_ids[]" multiple>
                    @foreach($clients as $key => $data)
                        @if(in_array($data->id, json_decode($projects->multi_ids)))
                            <option value="{{ $data->id }}" selected>{{ $data->name }}</option>
                        @else
                            <option value="{{ $data->id }}">{{ $data->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>

        <div class=" col-lg-6 mt-2">
            <div class="form-group">
                <label>Team</label>
                <select class="form-control select"  name="team_ids[]" multiple>
                        @foreach($users as $key => $data)
                        @if(in_array($data->id, json_decode($projects->team_ids)))
                        <option value="{{ $data->id }}" selected>{{ $data->name }}</option>
                        @else
                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                        @endif
                        @endforeach
                </select>
            </div>
        </div>

        <div class="form-group col-lg-12 mt-2">
            <label>Status <span class="text-danger"></span></label>
            <div class="btn-group">
                <button style="border: 1px solid; margin-left: 3px;" type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <input type="radio" name="status" value="Open" {{$projects->status=='Open'?'checked':''}}> Open
                </button>
                <div class="dropdown-menu">
                    <label class="dropdown-item">
                        <input type="radio" name="status" value="Closed" {{$projects->status=='Closed'?'checked':''}}> Closed
                    </label>
                    <label class="dropdown-item">
                        <input type="radio" name="status" value="Progress" {{$projects->status=='Progress'?'checked':''}}> Progress
                    </label>
                </div>
            </div>
        </div>

        <div class="text-center" style="margin-top:20px">

            <button type="submit" class="btn btn-success">Update</button>

        </div>

    </div>

</form>

