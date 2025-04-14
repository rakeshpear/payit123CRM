<select class="selectpicker" multiple data-live-search="true" name="multi2_ids[]">
    <option class="">Select</option>
    @foreach($datas as $key => $data)
      <option class="{{ $data->id }}">{{ $data->name }}</option>
    @endforeach
</select>