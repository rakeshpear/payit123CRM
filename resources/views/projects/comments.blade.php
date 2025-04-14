@foreach($comments as $key => $comm)

	<tr>
        <td><img src="https://previews.123rf.com/images/triken/triken1608/triken160800028/61320729-male-avatar-profile-picture-default-user-avatar-guest-avatar-simply-human-head-vector-illustration.jpg" height="50" width="50"></td>
      	<td>{{App\Models\User::where('id',$comm->user_id)->first()->name}} <small class="float-right">{{date("d/m/Y H:i", strtotime($comm->created_at))}}</small> <br><br> {{$comm->comments}}</td>
    </tr>

@endforeach

