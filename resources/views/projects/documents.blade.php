
@foreach($comments as $key => $comm)

	<tr>

        <td>{{++$key}}</td>
        <td>{{App\Models\User::where('id',$comm->user_id)->first()->name}}</td>
      	<td>
            @if (Str::endsWith($comm->document, ['.jpg', '.jpeg', '.png', '.gif']))
           <img src="{{ url('/document/'.$comm->document) }}" style="width:40px; height: 20px;">
           @else
           <img src="{{ url('/pdficon/PDF_file_icon.svg.png')}}" style="width:20px; height:20px;">
           @endif
           <a href="{{ route('image.download', ['imageFileName' => $comm->document]) }}"><i class="bi bi-arrow-down-circle-fill"></i>download</a> 
        </td>
        <td>{{ \Carbon\Carbon::parse($comm->created_at)->format('d M Y')}}</td>
        
    </tr>

@endforeach

